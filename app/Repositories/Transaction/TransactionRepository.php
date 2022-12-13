<?php

namespace App\Repositories\Transaction;

use App\Models\Transaction;
use App\Repositories\Transaction\TransactionRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class TransactionRepository implements TransactionRepositoryInterface
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
    public function __construct(Transaction $model)
    {
        $this->model = $model;
    }

    /**
     * query all transactions by keyword and/or status
     *
     * @param  string $keyword
     * @param  string|null $status
     * @return $this
     */
    public function findAllTransactionsByKeywordOrStatus(?string $keyword = '', ?string $status = null)
    {
        $this->modelResult = $this->model->whereHas('travelPackage', fn (Builder $query) => $query->select('id', 'title')->where('title', 'LIKE', "%$keyword%"));

        if (!empty($status) && in_array($status, ['IN CART', 'PENDING', 'SUCCESS', 'FAILED'])) $this->modelResult->where('status', $status);

        return $this;
    }

    /**
     * query a transaction by invoice number field
     *
     * @param  string|null $invoiceNumber
     * @return $this
     */
    public function findOneTransactionByInvoiceNumber(?string $invoiceNumber)
    {
        $this->modelResult = $this->model->where('invoice_number', $invoiceNumber);

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
        $this->checkDefineModelResultProperty();

        $this->modelResult->select($columns);

        return $this;
    }

    /**
     * query transaction's relations
     *
     * @param  array $relations
     * @return $this
     */
    public function withRelations(array $relations)
    {
        $this->checkDefineModelResultProperty();

        $this->modelResult->with($relations);

        return $this;
    }

    /**
     * counting a transaction(s) relations
     *
     * @param  array $relations
     * @return $this
     */
    public function loadCountRelations(array $relations)
    {
        $this->modelResult->withCount($relations);

        return $this;
    }

    /**
     * query the transaction(s) only deleted
     *
     * @return $this
     */
    public function onlyDeleted()
    {
        $this->checkDefineModelResultProperty();

        $this->modelResult->onlyTrashed();

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
     * get a transaction, if fail or not found then redirect to 404 page
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function firstOrNotFound()
    {
        return $this->modelResult->firstOrFail();
    }

    /**
     * get all transactions and add paginate with the limit
     *
     * @param int $number
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate(int $number)
    {
        return $this->modelResult->paginate($number);
    }

    /**
     * count all transactions
     *
     * @return int
     */
    public function count()
    {
        $this->checkDefineModelResultProperty();

        return $this->modelResult->count();
    }

    /**
     * count the transactions with status
     *
     * @param string $status
     * @return int
     */
    public function countWithStatus(string $status)
    {
        return $this->findAllTransactionsByKeywordOrStatus('', $status)
            ->count();
    }

    /**
     *  Updating a transaction selected
     *
     * @param  array $data
     * @return void
     */
    public function update(array $data)
    {
        return $this->model->update($data);
    }

    /**
     *  Deleting  a transaction selected
     *
     * @return void
     */
    public function delete()
    {
        return $this->model->delete();
    }

    /**
     * restoring a deleted transaction selected
     *
     * @return void
     */
    public function restore()
    {
        return $this->model->restore();
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

    /**
     * check and define modelresult property
     *
     * @return void
     */
    public function checkDefineModelResultProperty()
    {
        if (!$this->modelResult) $this->modelResult = $this->model->query();
    }
}
