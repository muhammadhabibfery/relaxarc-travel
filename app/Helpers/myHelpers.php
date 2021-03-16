<?php

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

function isAdmin()
{
    return (count(array_intersect(["ADMIN"], json_decode(auth()->user()->roles))) > 0);
}

function preventUserWhoHaveCompletedTheProfile()
{
    return checkCompletenessTheProfile() ? back() : view('pages.errors.123');
}

function checkCompletenessTheProfile()
{
    return (auth()->user()->phone && auth()->user()->address);
}
