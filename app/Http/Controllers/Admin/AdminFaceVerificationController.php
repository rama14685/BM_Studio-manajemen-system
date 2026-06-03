<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminFaceVerificationController extends Controller
{
    /**
     * Show biometric scanner page.
     */
    public function show()
    {
        if (session()->get('admin_face_verified')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.verify_face');
    }

    /**
     * Verify face and shift timings.
     */
    public function verify(Request $request)
    {
        $user = Auth::user();

        // Calculate shift duration (default 8 hours)
        $durationHours = 8;
        if ($user->shift_start && $user->shift_end) {
            $start = \Carbon\Carbon::parse($user->shift_start);
            $end = \Carbon\Carbon::parse($user->shift_end);
            if ($end->greaterThan($start)) {
                $durationHours = $start->diffInHours($end);
            } else {
                $durationHours = 24 - $start->diffInHours($end); // overnight shift
            }
        }

        if ($durationHours <= 0) {
            $durationHours = 8;
        }

        // Set shift starting now and ending durationHours later
        $newStart = now();
        $newEnd = now()->addHours($durationHours);

        $user->update([
            'shift_start' => $newStart->format('H:i:s'),
            'shift_end' => $newEnd->format('H:i:s'),
        ]);

        session(['admin_face_verified' => true]);

        return response()->json([
            'status' => 'success',
            'message' => 'Presensi Berhasil! Shift Anda resmi dimulai dari ' . $newStart->format('H:i') . ' sampai ' . $newEnd->format('H:i') . '.',
            'redirect' => route('admin.dashboard')
        ]);
    }


}
