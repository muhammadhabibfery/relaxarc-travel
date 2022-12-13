<?php

namespace App\Repositories\User;

interface UserRepositoryInterface
{
    /**
     * query all users by search (keyword and/or status and/or role)
     *
     * @param  string $keyword
     * @param  string|null $status
     * @param  array|null $role
     * @return $this
     */
    public function findAllUserBySearch(?string $keyword = '', ?string $status = null, ?array $role = null);

    /**
     * query a transaction by invoice number field
     *
     * @param  string|null $invoiceNumber
     * @return $this
     */
    public function findOneUserByUsername(?string $username);

    /**
     * query specified select columns
     *
     * @param  array $columns
     * @return $this
     */
    public function select(array $columns);

    /**
     * query ordering by created_at column descending
     *
     * @return $this
     */
    public function latest();

    /**
     * get a user, if fail or not found then redirect to 404 page
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function firstOrNotFound();

    /**
     * get all users and add paginate with the limit
     *
     * @param int $number
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate(int $number);

    /**
     *  creating a new user
     *
     * @param  array $data
     * @return bool
     */
    public function create(array $data);

    /**
     *  updating  a user selected
     *
     * @param  array $data
     * @return bool
     */
    public function update(array $data);

    /**
     * start multiple queries with database transaction
     *
     * @return $this
     */

    /**
     *  deleting  a user selected
     *
     * @return bool
     */
    public function delete();

    /**
     * start multiple queries with database transaction
     *
     * @return $this
     */
    public function beginTransaction();

    /**
     * commit or save multiple queries related within database queries
     *
     * @return $this
     */
    public function commitTransaction();

    /**
     * rollback or cancel multiple queries related within database queries
     *
     * @return $this
     */
    public function rollbackTransaction();
}
