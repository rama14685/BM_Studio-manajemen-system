<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Studio;
use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CustomerBookingController extends Controller
{
    /**
     * Display the availability dashboard & user booking history.
     */
    public function index()
    {
        $studios = Studio::all();
        $userBookings = Booking::with('studio')
            ->where('user_id', Auth::id())
            ->orderBy('date', 'desc')
            ->orderBy('start_time', 'desc')
            ->get();

        // Get all active bookings for the availability calendar (today onwards)
        $activeBookings = Booking::with(['studio', 'user'])
            ->where('date', '>=', now()->toDateString())
            ->whereIn('status', ['pending', 'paid'])
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();

        // Get Chat Admin data to embed directly in dashboard
        $admin = User::where('role', 'admin')->first();
        $messages = collect();
        if ($admin) {
            $messages = Message::where(function ($q) use ($admin) {
                $q->where('sender_id', Auth::id())->where('receiver_id', $admin->id);
            })->orWhere(function ($q) use ($admin) {
                $q->where('sender_id', $admin->id)->where('receiver_id', Auth::id());
            })->orderBy('created_at', 'asc')->get();

            // Mark incoming messages as read
            Message::where('sender_id', $admin->id)
                ->where('receiver_id', Auth::id())
                ->where('is_read', false)
                ->update(['is_read' => true]);
        }

        return view('customer.dashboard', compact('studios', 'userBookings', 'activeBookings', 'admin', 'messages'));
    }

    /**
     * Show the booking form.
     */
    public function create()
    {
        $studios = Studio::all();
        return view('customer.bookings.create', compact('studios'));
    }

    /**
     * Store a new booking.
     */
    public function store(Request $request)
    {
        $request->validate([
            'studio_id' => 'required|exists:studios,id',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'duration' => 'required|integer|min:1|max:12', // durasi dalam jam
        ]);

        $studio = Studio::findOrFail($request->studio_id);
        $startTime = Carbon::createFromFormat('Y-m-d H:i', $request->date . ' ' . $request->start_time);
        $endTime = (clone $startTime)->addHours((int) $request->duration);

        $startTimeStr = $startTime->format('H:i:s');
        $endTimeStr = $endTime->format('H:i:s');

        // Check overlapping bookings
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
                'start_time' => 'Studio sudah di-booking pada waktu tersebut. Silakan pilih jam atau tanggal lain.'
            ]);
        }

        $totalPrice = $studio->price_per_hour * $request->duration;

        Booking::create([
            'user_id' => Auth::id(),
            'studio_id' => $request->studio_id,
            'date' => $request->date,
            'start_time' => $startTimeStr,
            'end_time' => $endTimeStr,
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        return redirect()->route('dashboard')->with('success', 'Booking studio berhasil diajukan! Silakan lakukan pembayaran di kasir BM Studio.');
    }
}
