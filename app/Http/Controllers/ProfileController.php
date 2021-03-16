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
        $this->user = auth()->user();
    }

    public function frontProfile()
    {
        return view('pages.frontend.front-profile', ['user' => $this->user]);
    }

    public function backProfile()
    {
        return view('pages.backend.back-profile');
    }

    public function completeProfileFirst()
    {
        return preventUserWhoHaveCompletedTheProfile();
    }

    public function updateProfile(ProfileRequest $request)
    {
        $data = array_merge($request->validated(), ['avatar' => uploadImage($request, 'avatars', $this->user->avatar)]);

        $this->user
            ->update($data);

        return redirect()->intended(route('home'))
            ->with('status', trans('status.update_profile'));
    }

    public function deleteAvatar()
    {
        Storage::disk('public')
            ->delete($this->user->avatar);

        $this->user
            ->update(['avatar' => null]);

        return back()->with('status', trans('status.delete_avatar'));
    }
}
