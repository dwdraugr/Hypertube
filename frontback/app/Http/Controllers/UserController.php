<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function show(User $user)
    {
        return view('user', [
            'user' => $user
        ]);
    }

    public function edit(User $user)
    {
        if ($user->id == Auth::id()) {
            return view('userForm', [
                'user' => $user
            ]);
        }
        return abort(403, 'Unauthorized action.');
    }

    public function update(User $user)
    {
        $request = request();
        switch ($request->input('action')) {
            case 'general':
                $this->updateGeneral($request);
                break;
            case 'password':
                $this->updatePassword($request);
                break;
            case 'icon':
                $this->updateIcon($request);
                break;
            default:
                return abort(400, 'Incorrect params.');
        }
        return view('user', [
            'user' => Auth::user(),
            'message' => true,
        ]);
    }

    private function updateGeneral(Request $request)
    {
        $validated = $request->validate([
            'username' => 'nullable|max:60',
            'first_name' => 'nullable|max:60',
            'last_name' => 'nullable|max:60',
        ]);
        $user = Auth::user();
        $user->name = $validated['username'] ?? $user->name;
        $user->first_name = $validated['first_name'] ?? $user->first_name;
        $user->last_name = $validated['last_name'] ?? $user->last_name;
        $user->save();
    }

    private function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'new_pass' => 'required',
            'repeat_pass' => 'required|same:new_pass',
        ]);
        $user = Auth::user();
        $user->password = Hash::make($validated['new_pass']);
        $user->save();
    }

    private function updateIcon(Request $request)
    {
        $request->validate([
            'icon' => 'image'
        ]);
        $user = Auth::user();
        $user->icon = 'data:image/' . $request->file('icon')->extension() . ';base64,' . base64_encode(file_get_contents($request->file('icon')->getPathname()));
        $user->save();
    }
}
