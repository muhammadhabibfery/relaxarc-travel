<?php

use App\Models\Transaction;
use App\Models\TravelPackage;
use App\Models\User;
use App\Repositories\Transaction\TransactionRepository;
use App\Repositories\TravelPackage\TravelPackageRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

function uploadImage($request, $directoryName, $fieldImage = null)
{
    $file = $fieldImage;

    if ($request->hasFile('image')) {
        if ($fieldImage) Storage::disk('public')->delete($fieldImage);

        $fileName = explode('.', $request->file('image')->getClientOriginalName());
        $fileName = head($fileName) . rand(1, 20) . '.' . last($fileName);
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

function createdUpdatedDeletedBy($id)
{
    return User::select('id', 'name')->find($id);
}

function formatTravelPackageDuration($value, $locale)
{
    $languageFormat = ($locale == 'id')
        ? ' Hari'
        : ' Day(s)';

    return "$value $languageFormat";
}

function countOfAllTravelPackages()
{
    return (new TravelPackageRepository(new TravelPackage))->count();
}

function countOfAllTransactions()
{
    return (new TransactionRepository(new Transaction))->count();
}

function countOfTransactionStatus(string $status)
{
    return (new TransactionRepository(new Transaction))->countWithStatus($status);
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
