<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->middleware('verified')->only('frontProfile');
        $this->user = auth()->user();
    }

    public function frontProfile()
    {
        return view('pages.frontend.profiles.edit-profile', ['user' => $this->user]);
    }

    public function backProfile()
    {
        return view('pages.backend.profiles.edit-profile', ['user' => $this->user]);
    }

    public function updateProfile(ProfileRequest $request)
    {
        $data = array_merge($request->validated(), ['avatar' => uploadImage($request, 'avatars', $this->user->avatar)]);

        $this->user
            ->update($data);

        if (checkRoles(["ADMIN", 1], $this->user->roles)) return $this->redirectAfterUpdated('dashboard', 'profile');

        return ($request->session()->has('guest-route'))
            ? redirect($request->session()->pull('guest-route'))
            : $this->redirectAfterUpdated('home', 'profile');
        // return checkRoles(["ADMIN", 1], $this->user->roles)
        //     ? $this->redirectAfterUpdated('dashboard', 'profile')
        //     : $this->redirectAfterUpdated('home', 'profile');
    }

    public function completeProfileFirst()
    {
        return preventUserWhoHaveCompletedTheProfile();
    }

    public function deleteAvatar()
    {
        Storage::disk('public')
            ->delete($this->user->avatar);

        $this->user
            ->update(['avatar' => null]);

        return back()->with('status', trans('status.delete_avatar'));
    }

    public function frontChangePassword()
    {
        return view('pages.frontend.profiles.password.edit-password');
    }

    public function backChangePassword()
    {
        return view('pages.backend.profiles.password.edit-password');
    }

    public function updatePassword(ProfileRequest $request)
    {
        $data = ['password' => bcrypt($request->validated()['new_password'])];

        $this->user
            ->update($data);

        return checkRoles(["ADMIN", 1], $this->user->roles)
            ? $this->redirectAfterUpdated('dashboard')
            : $this->redirectAfterUpdated('home');
    }

    public function redirectAfterUpdated($routeName, $action = null)
    {
        return $action === 'profile'
            ? redirect()->intended(route($routeName))
            ->with('status', trans('status.update_profile'))
            : redirect()->intended(route($routeName))
            ->with('status', trans('status.update_password'));
    }
}
