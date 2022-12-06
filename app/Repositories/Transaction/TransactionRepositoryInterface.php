<?php

namespace App\Repositories\Transaction;

interface TransactionRepositoryInterface
{
    /**
     * query all transactions by keyword and/or status
     *
     * @param  string $keyword
     * @param  string|null $status
     * @return $this
     */
    public function findAllTransactionsByKeywordOrStatus(string $keyword = '', ?string $status = null);

    /**
     * query a transaction by invoice number field
     *
     * @param  string|null $invoiceNumber
     * @return $this
     */
    public function findOneTransactionByInvoiceNumber(?string $invoiceNumber);

    /**
     * query specified select columns
     *
     * @param  array $columns
     * @return $this
     */
    public function select(array $columns);

    /**
     * query transaction's relations
     *
     * @param  array $relations
     * @return $this
     */
    public function withRelations(array $relations);

    /**
     * counting a transaction(s) relations
     *
     * @param  array $relations
     * @return $this
     */
    public function loadCountRelations(array $relations);

    /**
     * query the transaction(s) only deleted
     *
     * @return $this
     */
    public function onlyDeleted();

    /**
     * query ordering by created_at column descending
     *
     * @return $this
     */
    public function latest();

    /**
     * get a transaction, if fail or not found then redirect to 404 page
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function firstOrNotFound();

    /**
     * get all transactions and add paginate with the limit
     *
     * @param int $number
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate(int $number);

    /**
     * count all transactions
     *
     * @return int
     */
    public function count();

    /**
     * count the transactions with status
     *
     * @return int
     */
    public function countWithStatus(string $status);

    /**
     *  Updating a transaction selected
     *
     * @param  array $data
     * @return void
     */
    public function update(array $data);

    /**
     *  Deleting  a transaction selected
     *
     * @return void
     */
    public function delete();

    /**
     * restoring a deleted transaction selected
     *
     * @return void
     */
    public function restore();

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

    /**
     * check and define modelresult property
     *
     * @return void
     */
    public function checkDefineModelResultProperty();
}
