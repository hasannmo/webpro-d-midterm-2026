<?php

namespace App\Http\Controllers;

use App\Models\RickrollClick;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RickrollController extends Controller
{
    public const RICKROLL_URL = 'https://youtu.be/dQw4w9WgXcQ?si=uGhb4VbGscdccpz8';

    /**
     * Handle the redirect click, record click count & timestamp, then redirect to the video.
     */
    public function redirect(Request $request): RedirectResponse
    {
        $user = auth()->user();

        if ($user) {
            $record = RickrollClick::where('user_id', $user->id)->first();
            if ($record) {
                $record->increment('click_count');
                $record->update([
                    'username' => $user->username ?? $user->name,
                    'email' => $user->email,
                    'last_clicked_at' => now(),
                ]);
            } else {
                RickrollClick::create([
                    'user_id' => $user->id,
                    'username' => $user->username ?? $user->name,
                    'email' => $user->email,
                    'click_count' => 1,
                    'last_clicked_at' => now(),
                ]);
            }
        } else {
            // Anonymous guest: group by IP or guest indicator
            $guestKey = 'guest_' . $request->ip();
            $record = RickrollClick::whereNull('user_id')
                ->where('email', $guestKey)
                ->first();

            if ($record) {
                $record->increment('click_count');
                $record->update(['last_clicked_at' => now()]);
            } else {
                RickrollClick::create([
                    'user_id' => null,
                    'username' => 'Guest (' . $request->ip() . ')',
                    'email' => $guestKey,
                    'click_count' => 1,
                    'last_clicked_at' => now(),
                ]);
            }
        }

        return redirect()->away(self::RICKROLL_URL);
    }
}

