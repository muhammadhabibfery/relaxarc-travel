<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Traits\ImageHandler;

class ProfileController extends Controller
{

    use ImageHandler;

    /**
     * The name of user model instance
     *
     * @var \App\Models\User
     */
    public $user;

    /**
     * Create a new user model instance and implement verified middleware.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('verified')->only('frontProfile');
        $this->user = auth()->user();
    }

    /**
     * Show the form for editing the user profile (member or customer).
     *
     * @return \Illuminate\Http\Response
     */
    public function frontProfile()
    {
        return view('pages.frontend.profiles.edit-profile', ['user' => $this->user]);
    }

    /**
     * Show the form for editing the user profile (admin and super admin).
     *
     * @return \Illuminate\Http\Response
     */
    public function backProfile()
    {
        return view('pages.backend.profiles.edit-profile', ['user' => $this->user]);
    }

    /**
     * Update the user profile in storage.
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return mixed
     */
    public function updateProfile(ProfileRequest $request)
    {
        $data = array_merge(
            $request->validated(),
            ['avatar' => $this->createImage($request, $this->user->avatar, [], 'app/public/avatars')]
        );

        return $this->checkProccess(function () use ($data) {
            if (!$this->user->update($data)) throw new \Exception(trans('status.failed_update_profile'));
        });
    }

    /**
     * delete a user avatar
     *
     * @return mixed
     */
    public function deleteAvatar()
    {
        return $this->checkProccess(
            function () {
                $avatarname = $this->user->avatar;
                if ($this->user->update(['avatar' => null])) {
                    $this->deleteImage($avatarname, 'avatars');
                } else {
                    throw new \Exception(trans('status.failed_delete_avatar'));
                }
            },
            true,
            true
        );
    }

    /**
     * Show the form for change the user password (member or customer).
     *
     * @return \Illuminate\Http\Response
     */
    public function frontChangePassword()
    {
        return view('pages.frontend.profiles.password.edit-password');
    }

    /**
     * Show the form for change the user password (admin and super admin).
     *
     * @return \Illuminate\Http\Response
     */
    public function backChangePassword()
    {
        return view('pages.backend.profiles.password.edit-password');
    }

    /**
     * Update the user password in storage.
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return mixed
     */
    public function updatePassword(ProfileRequest $request)
    {
        $data = ['password' => bcrypt($request->validated()['new_password'])];

        return $this->checkProccess(
            function () use ($data) {
                if (!$this->user->update($data)) throw new \Exception(trans('status.failed_update_password'));
            },
            false
        );
    }

    /**
     * Check one or more processes and catch them if fail
     *
     * @param  callable $action
     * @param  bool $updateProfile  define for update profile
     * @param  bool $deleteAvatar  define for delete a user avatar
     * @return \Illuminate\Http\Response
     */
    private function checkProccess(callable $action, ?bool $updateProfile = true, ?bool $deleteAavatar = false)
    {
        $member = false;

        if (in_array('MEMBER', $this->user->roles)) $member = true;

        if ($updateProfile) {
            $routeName = $member ? 'front-profile' : 'back-profile';
        } else {
            $routeName = $member ? 'front-change-password' : 'back-change-password';
        }

        try {
            $action();
        } catch (\Exception $e) {
            return redirect()->route($routeName)
                ->with('failed', $e->getMessage());
        }

        if (checkRoles(["ADMIN", 1], $this->user->roles)) {
            if ($updateProfile) {
                if ($deleteAavatar) return redirect()->route($routeName)->with('success', trans('status.delete_avatar'));

                return $this->redirectAfterUpdated('dashboard', 'profile');
            }

            return $this->redirectAfterUpdated('dashboard');
        } else {
            if ($updateProfile) {

                if ($deleteAavatar) return redirect()->route($routeName)->with('success', trans('status.delete_avatar'));

                return (request()->session()->has('guest-route'))
                    ? redirect(request()->session()->pull('guest-route'))
                    : $this->redirectAfterUpdated('home', 'profile');
            }

            return $this->redirectAfterUpdated('home');
        }
    }

    /**
     * redirect a user after updating the profile or password
     *
     * @param  string $routeName
     * @param  string|null $action
     * @return \illuminate\Http\Response
     */
    private function redirectAfterUpdated(string $routeName, ?string $action = null)
    {
        return $action === 'profile'
            ? redirect()->route($routeName)
            ->with('success', trans('status.update_profile'))
            : redirect()->intended(route($routeName))
            ->with('success', trans('status.update_password'));
    }
}
