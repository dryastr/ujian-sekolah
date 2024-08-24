<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageHandlerController extends Controller
{
    /**
     * Store the uploaded image
     */
    public function store(Request $request)
    {
        $options = [
            'validation' => [
                'allowedExts' => ['jpeg', 'jpg', 'png', 'gif'],
                'allowedMimeTypes' => ['image/jpeg', 'image/pjpeg', 'image/png', 'image/gif']
            ]
        ];

        return FroalaEditor_Image::upload(storage_path('app/public/uploads/'), $options);
    }

    /**
     * Remove the uploaded image
     */
    public function remove(Request $request)
    {
        $search = request()->getScheme() . '://' . $_SERVER['SERVER_NAME'];
        $src = str_replace($search, '', $request->src);
        return FroalaEditor_Image::delete($src);
    }
}
