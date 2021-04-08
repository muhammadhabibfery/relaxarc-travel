<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $role = $request->role ? $this->parsingRoleRequestToArray($request->role) : null;
        $status = strtoupper($request->status);
        $keyword = $request->keyword;

        $users = $this->getUsersWithParams($status, $keyword, $role);

        return view('pages.backend.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.backend.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $roles = $this->parsingRoleRequestToArray($request->validated()['roles']);

        $data = array_merge($request->validated(), [
            'name' => preg_replace("/[^[:alnum:]\\.\\,\\_\\-\\'\\@\\ ]/", "", $request->validated()['name']),
            'password' => bcrypt($request->username),
            'roles' => json_encode($roles),
            'status' => 'ACTIVE',
            'email_verified_at' => now(),
            'remember_token' => Str::random(60)
        ]);

        User::create($data);

        return redirect()->route('users.index')
            ->with('status', trans('status.create_new_admin'));
    }

    /**
     * Display the specified resource.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('pages.backend.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $data = [
            'status' => $request->validated()['status']
        ];

        if (count($request->validated()) > 1) {
            $roles = json_encode($this->parsingRoleRequestToArray($request->validated()['roles'], true));
            $data = array_merge($data, [
                'roles' => $roles
            ]);
        };

        $user->update($data);

        return redirect()->route('users.index')
            ->with('status', trans('status.update_user', ['name' => $user->name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        if ($user->avatar) Storage::disk('public')->delete($user->avatar);

        $name = $user->name;
        $user->delete();

        return redirect()->route('users.index')
            ->with('status', trans('status.delete_user', ['Name' => $name]));
    }

    private function parsingRoleRequestToArray($roles, $array = false)
    {
        if ($array) {
            if (!in_array("admin", $roles)) array_push($roles, "admin");

            foreach ($roles as $role) {
                $data[] = strtoupper($role);
            }

            return $data;
        }

        $roles = strtoupper($roles);
        $data[] = $roles;

        return $data;
    }

    private function getUsersWithParams($status, $keyword, $role)
    {
        $data = User::where('status', 'LIKE', "%$status%")
            ->where(function ($query) use ($keyword) {
                $query->where('name', 'LIKE', "%$keyword%")
                    ->orWhere('username', 'LIKE', "%$keyword%")
                    ->orWhere('email', 'LIKE', "%$keyword%");
            })
            ->paginate(10);

        if ($role) {
            $data = User::whereJsonContains('roles', $role)
                ->where('status', 'LIKE', "%$status%")
                ->where(function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', "%$keyword%")
                        ->orWhere('username', 'LIKE', "%$keyword%")
                        ->orWhere('email', 'LIKE', "%$keyword%");
                })
                ->paginate(10);
        }

        return $data;
    }

    public function generateUsername(Request $request)
    {
        if ($request->wantsJson()) {
            try {
                $data = [
                    'username' => preg_replace("/[^[:alnum:]\\-\\_]/", "", Str::lower(Str::of($request['name'])->replace(' ', ''))) . rand(1, 99)
                ];

                return response()->json($data);
            } catch (\Exception $e) {
                return response()->json([
                    'message' => "500 internal server error, refresh the page",
                ], 500);
            }
        }

        return abort(404);
    }
}
