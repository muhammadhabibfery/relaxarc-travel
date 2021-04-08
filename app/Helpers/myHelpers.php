<?php

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

function isAdmin($roles = null)
{
    if ($roles) return (count(array_intersect(["ADMIN"], $roles)) > 0);

    return (count(array_intersect(["ADMIN"], auth()->user()->roles)) > 0);
}

function isSuperAdmin($roles = null)
{
    if ($roles) return (count(array_intersect(["ADMIN", "SUPERADMIN"], $roles)) > 1);

    return (count(array_intersect(["ADMIN", "SUPERADMIN"], auth()->user()->roles)) > 1);
}

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
