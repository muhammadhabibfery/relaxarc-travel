<?php

namespace App\Traits;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

trait ImageHandler
{

    /**
     * create image(s) and save to application directory
     *
     * @param  object $request
     * @param  string|null $fieldImage
     * @param  bool $size
     * @param  string $path
     * @return string
     */
    public function createImage(object $request, ?string $fieldImage = null, array $size = [], string ...$path)
    {
        $fileName = $fieldImage;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = $this->getFileName($image->getClientOriginalName());
            $directories = $this->createDirectory($fileName, $path);

            if (count($size)) {
                $this->usingInterventionImage($image, $directories, $size);
            } else {
                if ($fieldImage) $this->deleteImage($fieldImage, $directories);

                $this->usingStorageFacade($image, $directories, $fileName);
            }
        }

        return $fileName;
    }

    /**
     * get file name
     *
     * @param  string $fileName
     * @return string
     */
    private static function getFileName(string $fileName)
    {
        $result = explode('.', $fileName);
        $result = head($result) . rand(0, 100) . '.' . last($result);
        return $result;
    }

    /**
     * create image directory
     *
     * @param string $fileName
     * @param array $path
     * @return string|array
     */
    private function createDirectory(string $fileName, array $path)
    {
        foreach ($path as $p) {
            $directory = storage_path($p);
            if (!file_exists($directory)) mkdir($directory, 666, true);

            if (count($path) <= 1) return last(explode('/', $p));

            $result[] = $directory .= "/$fileName";
        }

        return $result;
    }

    /**
     * create image using intervention image library
     *
     * @param  object $image
     * @param  array $directories
     * @param  array $size
     * @return void
     */
    private function usingInterventionImage(object $image, array $directories, array $size)
    {
        foreach ($directories as $key => $directory) {
            Image::make($image)
                ->resize($size[$key][0], $size[$key][1])
                ->save($directory);
        }
    }

    /**
     * create image using storage facade
     *
     * @param  object $image
     * @param  string $directories
     * @param  string $size
     * @return void
     */
    private function usingStorageFacade(object $image, string $directory, string $fileName)
    {
        Storage::disk('public')
            ->putFileAs($directory, $image, $fileName);
    }

    /**
     * delete image file(s) from application directory
     *
     * @param  string $image
     * @param  string $path (the path image file)
     * @return void
     */
    private static function deleteImage(?string $image = null,  string ...$path)
    {
        foreach ($path as $p) Storage::delete("$p/$image");
    }
}
