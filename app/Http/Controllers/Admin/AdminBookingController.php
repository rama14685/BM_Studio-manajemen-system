<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Studio;
use App\Models\User;
use App\Models\Finance;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminBookingController extends Controller
{
    /**
     * Display a listing of bookings.
     */
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'studio'])->orderBy('date', 'desc')->orderBy('start_time', 'desc');

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('date') && $request->date != '') {
            $query->where('date', $request->date);
        }

        $bookings = $query->paginate(15);
        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new booking (Walk-in).
     */
    public function create()
    {
        $studios = Studio::all();
        $users = User::where('role', 'user')->get();
        return view('admin.bookings.create', compact('studios', 'users'));
    }

    /**
     * Store a newly created booking.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'studio_id' => 'required|exists:studios,id',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'duration' => 'required|integer|min:1|max:12',
            'status' => 'required|in:pending,paid,cancelled',
        ]);

        $studio = Studio::findOrFail($request->studio_id);
        $startTime = Carbon::createFromFormat('Y-m-d H:i', $request->date . ' ' . $request->start_time);
        $endTime = (clone $startTime)->addHours((int) $request->duration);

        $startTimeStr = $startTime->format('H:i:s');
        $endTimeStr = $endTime->format('H:i:s');

        // Check overlap
        $overlap = Booking::where('studio_id', $request->studio_id)
            ->where('date', $request->date)
            ->whereIn('status', ['pending', 'paid'])
            ->where(function ($query) use ($startTimeStr, $endTimeStr) {
                $query->where(function ($q) use ($startTimeStr, $endTimeStr) {
                    $q->where('start_time', '<', $endTimeStr)
                      ->where('end_time', '>', $startTimeStr);
                });
            })
            ->exists();

        if ($overlap) {
            return back()->withInput()->withErrors([
                'start_time' => 'Studio sudah di-booking pada waktu tersebut.'
            ]);
        }

        $totalPrice = $studio->price_per_hour * $request->duration;

        $booking = Booking::create([
            'user_id' => $request->user_id,
            'studio_id' => $request->studio_id,
            'date' => $request->date,
            'start_time' => $startTimeStr,
            'end_time' => $endTimeStr,
            'total_price' => $totalPrice,
            'status' => $request->status,
        ]);

        // If status is paid, record in finances
        if ($booking->status === 'paid') {
            $user = User::find($booking->user_id);
            Finance::create([
                'type' => 'income',
                'category' => 'booking',
                'amount' => $booking->total_price,
                'description' => "Pembayaran Booking #{$booking->id} oleh {$user->name} (Manual/Walk-in)",
                'date' => $booking->date,
            ]);
        }

        return redirect()->route('admin.bookings.index')->with('success', 'Booking walk-in berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified booking.
     */
    public function edit(Booking $booking)
    {
        $studios = Studio::all();
        $users = User::where('role', 'user')->get();
        
        // Calculate duration in hours
        $start = Carbon::parse($booking->start_time);
        $end = Carbon::parse($booking->end_time);
        $duration = $start->diffInHours($end);

        // format start_time for input
        $booking->start_time = Carbon::parse($booking->start_time)->format('H:i');

        return view('admin.bookings.edit', compact('booking', 'studios', 'users', 'duration'));
    }

    /**
     * Update the specified booking in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'studio_id' => 'required|exists:studios,id',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'duration' => 'required|integer|min:1|max:12',
            'status' => 'required|in:pending,paid,cancelled',
        ]);

        $studio = Studio::findOrFail($request->studio_id);
        $startTime = Carbon::createFromFormat('Y-m-d H:i', $request->date . ' ' . $request->start_time);
        $endTime = (clone $startTime)->addHours((int) $request->duration);

        $startTimeStr = $startTime->format('H:i:s');
        $endTimeStr = $endTime->format('H:i:s');

        // Check overlap (excluding current booking)
        $overlap = Booking::where('id', '!=', $booking->id)
            ->where('studio_id', $request->studio_id)
            ->where('date', $request->date)
            ->whereIn('status', ['pending', 'paid'])
            ->where(function ($query) use ($startTimeStr, $endTimeStr) {
                $query->where(function ($q) use ($startTimeStr, $endTimeStr) {
                    $q->where('start_time', '<', $endTimeStr)
                      ->where('end_time', '>', $startTimeStr);
                });
            })
            ->exists();

        if ($overlap) {
            return back()->withInput()->withErrors([
                'start_time' => 'Studio sudah di-booking pada waktu tersebut.'
            ]);
        }

        $totalPrice = $studio->price_per_hour * $request->duration;
        $oldStatus = $booking->status;

        $booking->update([
            'user_id' => $request->user_id,
            'studio_id' => $request->studio_id,
            'date' => $request->date,
            'start_time' => $startTimeStr,
            'end_time' => $endTimeStr,
            'total_price' => $totalPrice,
            'status' => $request->status,
        ]);

        // Finance entry sync
        if ($booking->status === 'paid' && $oldStatus !== 'paid') {
            // Log income
            $user = User::find($booking->user_id);
            Finance::create([
                'type' => 'income',
                'category' => 'booking',
                'amount' => $booking->total_price,
                'description' => "Pembayaran Booking #{$booking->id} oleh {$user->name}",
                'date' => $booking->date,
            ]);
        } elseif ($booking->status !== 'paid' && $oldStatus === 'paid') {
            // If status changed from paid to something else, we should remove or cancel the finance log
            Finance::where('type', 'income')
                ->where('category', 'booking')
                ->where('description', 'like', "%Booking #{$booking->id}%")
                ->delete();
        }

        return redirect()->route('admin.bookings.index')->with('success', 'Booking berhasil diperbarui.');
    }

    /**
     * Cancel a booking.
     */
    public function cancel(Booking $booking)
    {
        $oldStatus = $booking->status;
        $booking->update(['status' => 'cancelled']);

        if ($oldStatus === 'paid') {
            // Remove the finance log if it was previously marked paid
            Finance::where('type', 'income')
                ->where('category', 'booking')
                ->where('description', 'like', "%Booking #{$booking->id}%")
                ->delete();
        }

        return back()->with('success', 'Booking berhasil dibatalkan.');
    }

    /**
     * Mark a booking as paid directly.
     */
    public function markAsPaid(Booking $booking)
    {
        if ($booking->status !== 'paid') {
            $booking->update(['status' => 'paid']);
            $user = User::find($booking->user_id);
            Finance::create([
                'type' => 'income',
                'category' => 'booking',
                'amount' => $booking->total_price,
                'description' => "Pembayaran Booking #{$booking->id} oleh {$user->name}",
                'date' => $booking->date,
            ]);
        }

        return back()->with('success', 'Pembayaran booking berhasil dikonfirmasi.');
    }

    /**
     * Delete a booking from database.
     */
    public function destroy(Booking $booking)
    {
        if ($booking->status === 'paid') {
            Finance::where('type', 'income')
                ->where('category', 'booking')
                ->where('description', 'like', "%Booking #{$booking->id}%")
                ->delete();
        }
        $booking->delete();
        return redirect()->route('admin.bookings.index')->with('success', 'Booking berhasil dihapus.');
    }
}
