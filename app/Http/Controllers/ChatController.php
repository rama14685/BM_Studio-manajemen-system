<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Display chat system based on role.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            // Admin: list all users who have sent messages or list active customers
            // We can fetch users along with their last message and unread count
            $chatUsers = User::where('role', 'user')
                ->withCount(['receivedMessages as unread_count' => function ($query) {
                    $query->where('is_read', false)->where('sender_id', '!=', Auth::id());
                }])
                ->get();

            return view('admin.chat.index', compact('chatUsers'));
        }

        // Customer: Chat directly with Admin
        $admin = User::where('role', 'admin')->first();
        if (!$admin) {
            return back()->with('error', 'Admin tidak tersedia saat ini.');
        }

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

        return view('customer.chat', compact('admin', 'messages'));
    }

    /**
     * Admin view chat with a specific user.
     */
    public function show(User $user)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $messages = Message::where(function ($q) use ($user) {
            $q->where('sender_id', Auth::id())->where('receiver_id', $user->id);
        })->orWhere(function ($q) use ($user) {
            $q->where('sender_id', $user->id)->where('receiver_id', Auth::id());
        })->orderBy('created_at', 'asc')->get();

        // Mark messages as read
        Message::where('sender_id', $user->id)
            ->where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $chatUsers = User::where('role', 'user')->get();

        return view('admin.chat.show', compact('user', 'messages', 'chatUsers'));
    }

    /**
     * Send a message.
     */
    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string|max:5000',
        ]);

        $msg = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
            'is_read' => false,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => $msg,
                'html' => view('chat.partials.message_bubble', ['msg' => $msg])->render()
            ]);
        }

        return back();
    }

    /**
     * Fetch messages via AJAX for real-time polling.
     */
    public function fetchMessages(Request $request, $otherUserId)
    {
        $messages = Message::where(function ($q) use ($otherUserId) {
            $q->where('sender_id', Auth::id())->where('receiver_id', $otherUserId);
        })->orWhere(function ($q) use ($otherUserId) {
            $q->where('sender_id', $otherUserId)->where('receiver_id', Auth::id());
        })->orderBy('created_at', 'asc')->get();

        // Mark incoming messages as read
        Message::where('sender_id', $otherUserId)
            ->where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $html = '';
        foreach ($messages as $msg) {
            $html .= view('chat.partials.message_bubble', ['msg' => $msg])->render();
        }

        return response()->json([
            'html' => $html
        ]);
    }
}
