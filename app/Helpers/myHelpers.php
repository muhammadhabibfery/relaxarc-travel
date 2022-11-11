<?php

use App\Models\Transaction;
use App\Models\TravelPackage;
use App\Models\User;
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
    return User::select('id', 'username')->find($id);
}

function displayEditTravelPackageDuration($value)
{
    return str_replace(' Hari', 'D', $value);
}

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
