<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Repositories\User\UserRepositoryInterface;
use App\Traits\ImageHandler;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class UserController extends Controller
{

    use ImageHandler;

    /**
     * The name of redirect route path
     *
     * @var string
     */
    private const ROUTE_NAME = 'users.index';

    /**
     * The name of repository instance
     *
     * @var App\Repositories\UserRepository
     */
    private $userRepository;

    /**
     * Create a new repository instance.
     *
     * @return void
     */
    public function __construct(UserRepositoryInterface $userRepositoryInterface)
    {
        $this->userRepository = $userRepositoryInterface;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $role = $request->role ? $this->parsingRoleRequestToArray($request->role) : null;
        $status = strtoupper($request->status);
        $keyword = $request->keyword;

        $users = $this->userRepository->findAllUserBySearch($keyword, $status, $role)
            ->paginate(10);

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
     * @param  \App\Http\Requests\UserRequest  $request
     * @return mixed
     */
    public function store(UserRequest $request)
    {
        $data = array_merge($request->validated(), [
            'name' => preg_replace("/[^[:alnum:]\\.\\,\\_\\-\\@\\' ]/", "", $request->validated()['name']),
            'password' => bcrypt($request->username),
            'roles' => json_encode($this->parsingRoleRequestToArray($request->validated()['roles'])),
            'status' => 'ACTIVE',
            'email_verified_at' => now(),
            'remember_token' => Str::random(60),
            'created_by' => auth()->id()
        ]);

        return $this->checkProccess(
            self::ROUTE_NAME,
            'status.create_new_admin',
            function () use ($data) {
                if (!$this->userRepository->create($data)) throw new \Exception(trans('status.failed_create_new_admin'));
            }
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  string $username
     * @param  string|null $invoiceNumber
     * @return \Illuminate\Http\Response
     */
    public function show(string $username, ?string $invoiceNumber = null)
    {
        $user = $this->getOneUser($username);

        return view('pages.backend.profiles.detail', compact('user', 'invoiceNumber'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string $username
     * @return \Illuminate\Http\Response
     */
    public function edit(string $username)
    {
        $user = $this->getOneUser($username);

        $this->authorize('update', $user);

        return view('pages.backend.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  string $username
     * @return mixed
     */
    public function update(UserRequest $request, string $username)
    {
        $user = $this->getOneUser($username);

        $this->authorize('update', $user);

        $data = [
            'roles' => json_encode($this->parsingRoleRequestToArray($request->validated()['roles'], true)),
            'status' => $request->validated()['status'],
            'updated_by' => auth()->id()
        ];

        return $this->checkProccess(
            self::ROUTE_NAME,
            'status.update_user',
            function () use ($data, $user) {
                if (!$user->update($data)) throw new \Exception(trans('status.failed_update_user'));
            }
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string $username
     * @return mixed
     */
    public function destroy(string $username)
    {
        $user = $this->getOneUser($username);
        $avatarName = $user->avatar ?: null;

        $this->authorize('delete', $user);


        return $this->checkProccess(
            self::ROUTE_NAME,
            'status.delete_user',
            function () use ($user, $avatarName) {
                if (!$user->update(['deleted_by' => auth()->id(), 'avatar' => null]))
                    throw new \Exception(trans('status.failed_update_user'));

                if (!$user->delete()) throw new \Exception(trans('status.failed_delete_user'));

                if ($avatarName) $this->deleteImage($avatarName, 'avatars');
            },
            true
        );
    }

    /**
     * generate username automatically in form create
     *
     * @param  \Illuminate\Http\Request $request
     * @return mixed
     */
    public function generateUsername(Request $request)
    {
        if ($request->wantsJson()) {
            try {
                $data = [
                    'username' => preg_replace("/[^[:alnum:]\\-\\_]/", "", Str::lower(Str::of($request['name'])->replace(' ', '')))
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

    /**
     * get the spesific a user by username field
     *
     * @param  string $username
     * @return \Illuminate\Database\Eloquent\Model
     */
    private function getOneUser(string $username)
    {
        return $this->userRepository->findOneUserByUsername($username)
            ->firstOrNotFound();
    }

    /**
     * parsing role from input request to array
     *
     * @param  string|array $roles
     * @param  bool $array
     * @return array
     */
    private function parsingRoleRequestToArray(string|array $roles, ?bool $array = false)
    {
        if ($array) {
            if (!in_array("admin", $roles)) array_unshift($roles, "admin");

            foreach ($roles as $role)  $data[] = strtoupper($role);

            return $data;
        }

        $data[] = strtoupper($roles);

        return $data;
    }

    /**
     * Check one or more processes and catch them if fail
     *
     * @param  string $redirectRoute
     * @param  string $successMessage
     * @param  callable $action
     * @param  bool $dbTransaction  use database transaction for multiple queries
     * @return \Illuminate\Http\Response
     */
    private function checkProccess(string $redirectRoute, string $succesMessage, callable $action, ?bool $dbTransaction = false)
    {
        try {
            if ($dbTransaction) $this->userRepository->beginTransaction();

            $action();

            if ($dbTransaction) $this->userRepository->commitTransaction();
        } catch (\Exception $e) {
            if ($dbTransaction) $this->userRepository->rollbackTransaction();

            return redirect()->route($redirectRoute)
                ->with('failed', $e->getMessage());
        }

        return redirect()->route($redirectRoute)
            ->with('success', trans($succesMessage));
    }
}
