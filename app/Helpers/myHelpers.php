<?php

use Carbon\Carbon;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Models\TravelPackage;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Transaction\TransactionRepository;
use App\Repositories\TravelPackage\TravelPackageRepository;
use App\Repositories\User\UserRepository;


function uploadImage($request, $directoryName, $fieldImage = null)
{
    $file = $fieldImage;

    if ($request->hasFile('image')) {
        if ($fieldImage) Storage::disk('public')->delete($fieldImage);

        $fileName = explode('.', $request->file('image')->getClientOriginalName());
        $fileName = head($fileName) . rand(1, 100) . '.' . last($fileName);
        $file = Storage::disk('public')
            ->putFileAs($directoryName, $request->file('image'), $fileName);
    }

    return $file;
}

/**
 * Identify the user roles
 *
 * @param  array $availableRoles
 * @param  array $userRoles
 * @return boolean
 */
function checkRoles(array $availableRoles, array $userRoles)
{
    $totalRoles = (int) array_pop($availableRoles);

    return (count(array_intersect($availableRoles, $userRoles)) >= $totalRoles);
}

/**
 *  query a user who create or update or delete data
 *
 * @param  int $id
 * @return Illuminate\Database\Eloquent\Model
 */
function createdUpdatedDeletedBy(int $id)
{
    return (new UserRepository(new User))->select(['id', 'name'])->firstOrNotFound();
}

/**
 * format travel package duration
 *
 * @param  string $value
 * @param  string $locale
 * @return string
 */
function formatTravelPackageDuration($value, $locale)
{
    $languageFormat = ($locale == 'id')
        ? ' Hari'
        : ' Day(s)';

    return "$value $languageFormat";
}

/**
 * count of all travel packages
 *
 * @return int
 */
function countOfAllTravelPackages()
{
    return (new TravelPackageRepository(new TravelPackage))->count();
}

/**
 * count of all transactions
 *
 * @return int
 */
function countOfAllTransactions()
{
    return (new TransactionRepository(new Transaction))->count();
}

/**
 * count of all transaction status
 *
 * @param  string $status
 * @return int
 */
function countOfTransactionStatus(string $status)
{
    return (new TransactionRepository(new Transaction))->countWithStatus($status);
}

/**
 * count of all user who has member status
 *
 * @return int
 */
function countOfAllMembers()
{
    return (new UserRepository(new User()))->whereRoles('MEMBER')->count();
}

/**
 * transform Date Format
 *
 * @param  string $format
 * @param  string $data
 * @return string
 */
function transformDateFormat(string $data, string $format)
{
    return Carbon::parse($data)->translatedFormat($format);
}

/**
 * transform String To Array
 *
 * @param  string $data
 * @param  string $separator
 * @return array|string
 */
function transformStringToArray(string $data, string $separator)
{
    return Str::contains($data, $separator) ? explode($separator, $data) : $data;
}

/**
 * generate invoice number for a transaction
 *
 * @return string
 */
function generateInvoiceNumber()
{
    return "RelaxArc-" . date('djy') . Str::random(16);
}
