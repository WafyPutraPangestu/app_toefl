<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function approve(User $user): RedirectResponse
    {
        $user->update([
            'is_active' => true,
            'expires_at' => null,
        ]);

        return redirect()->back()->with('success', 'User berhasil di-approve.');
    }
}
