<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Repositories\User\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    /**
     * The name of model instance
     *
     * @var Illuminate\Database\Eloquent\Model
     */
    private $model;

    /**
     * The name of last query model
     *
     * @var Illuminate\Database\Eloquent\Model
     */
    private $modelResult;

    /**
     * Create a new Eloquent model instance.
     *
     * @param   Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * query all users by search (keyword and/or status and/or role)
     *
     * @param  string $keyword
     * @param  string|null $status
     * @param  array|null $role
     * @return $this
     */
    public function findAllUserBySearch(?string $keyword = '', ?string $status = null, ?array $role = null)
    {
        $this->modelResult = $this->model->where(function ($query) use ($keyword) {
            $query->where('name', 'LIKE', "%$keyword%")
                ->orWhere('username', 'LIKE', "%$keyword%");
        });

        if (!empty($status) && in_array($status, ['ACTIVE', 'NONE'])) $this->modelResult->where('status', $status);

        if (!empty($role) && count(array_intersect($role, ['ADMIN', 'MEMBER']))) $this->modelResult->whereJsonContains('roles', $role);

        return $this;
    }

    /**
     * query a transaction by invoice number field
     *
     * @param  string|null $invoiceNumber
     * @return $this
     */
    public function findOneUserByUsername(?string $username)
    {
        $this->modelResult = $this->model->where('username', $username);

        return $this;
    }

    /**
     * query specified select columns
     *
     * @param  array $columns
     * @return $this
     */
    public function select(array $columns)
    {
        if (!$this->modelResult) $this->modelResult = $this->model->query();

        $this->modelResult->select($columns);

        return $this;
    }

    /**
     * query a user by roles
     *
     * @param  string|null $invoiceNumber
     * @return $this
     */
    public function whereRoles(array|string $roles)
    {
        if (!$this->modelResult) $this->modelResult = $this->model->query();

        $this->modelResult->whereJsonContains('roles', $roles);

        return $this;
    }

    /**
     * query ordering by created_at column descending
     *
     * @return $this
     */
    public function latest()
    {
        $this->modelResult->latest();

        return $this;
    }

    /**
     * get a user, if fail or not found then redirect to 404 page
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function firstOrNotFound()
    {
        return $this->modelResult->firstOrFail();
    }

    /**
     * get all users and add paginate with the limit
     *
     * @param int $number
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate(int $number)
    {
        return $this->modelResult->paginate($number);
    }

    /**
     * count all travel packages
     *
     * @return int
     */
    public function count()
    {
        if (!$this->modelResult) $this->modelResult = $this->model->query();

        return $this->modelResult->count();
    }

    /**
     *  creating a new user
     *
     * @param  array $data
     * @return bool
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     *  updating  a user selected
     *
     * @param  array $data
     * @return bool
     */
    public function update(array $data)
    {
        return $this->model->update($data);
    }

    /**
     *  deleting  a user selected
     *
     * @return bool
     */
    public function delete()
    {
        return $this->model->delete();
    }

    /**
     * start multiple queries with database transaction
     *
     * @return $this
     */
    public function beginTransaction()
    {
        DB::beginTransaction();

        return $this;
    }

    /**
     * commit or save multiple queries related within database queries
     *
     * @return $this
     */
    public function commitTransaction()
    {
        DB::commit();

        return $this;
    }

    /**
     * rollback or cancel multiple queries related within database queries
     *
     * @return $this
     */
    public function rollbackTransaction()
    {
        DB::rollBack();

        return $this;
    }
}
