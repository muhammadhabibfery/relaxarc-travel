<?php

use App\Models\Transaction;
use App\Models\TravelPackage;
use App\Models\User;
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
};

function preventUserWhoHaveCompletedTheProfile()
{
    return checkCompletenessTheProfile() ? back() : view('pages.errors.123');
}

function checkCompletenessTheProfile()
{
    return (auth()->user()->phone && auth()->user()->address);
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

// function formatTravelPackageDuration($value, $languageFormat = null)
// {
//     if (!$languageFormat) $languageFormat = ' Hari';

//     return (Str::contains($value, 'D')) ? str_replace('D', $languageFormat, $value) : $value;
// }

function numberOFTravelPackages()
{
    return TravelPackage::count();
}

function numberOfTransactions()
{
    return Transaction::count();
}

function numberOfSuccessfulTransactions()
{
    return Transaction::where('status', 'SUCCESS')
        ->count();
}

function numberOfPendingTransactions()
{
    return Transaction::where('status', 'PENDING')
        ->count();
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
