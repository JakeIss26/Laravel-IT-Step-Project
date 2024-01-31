<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Image;
use Illuminate\Support\Facades\Input;

class ImageController extends Controller
{
        /**
     * Store a newly created resource in storage.
     */
    public function upload(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        $image = $request->file('photo');
        $imageName = time().'.'.$image->extension();
    
        // Сохранение оригинала
        $image->storeAs('photos', $imageName, 'public');
    
        // Полный путь к сохраненному изображению
        $photoFullPath = storage_path('app/public/photos/' . $imageName);
    
        // Замена обратных слешей на прямые
        $photoFullPath = str_replace('\\', '/', $photoFullPath);
    
        // Возвращаем ассоциативный массив вместо JSON-кодированной строки
        return response(['photo_path' => $photoFullPath], 200)->header('Content-Type', 'application/json');
    }


    public function uploadPhotos(Request $request) {
        $photos = $request->file('photos');
        // dd($photos);
        $paths = [];
    
        foreach ($photos as $photo) {
            // Валидация каждого изображения
            $photo->validate([
                'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
    
            $imageName = time().'.'.$photo->extension();
    
            // Сохранение оригинала
            $photo->storeAs('photos', $imageName, 'public');
    
            // Полный путь к сохраненному изображению
            $photoFullPath = realpath(storage_path('app/public/photos/' . $imageName));
    
            // Замена прямых слешей на обратные
            $photoFullPath = str_replace('\\', '/', $photoFullPath);
    
            $paths[] = $photoFullPath;
        }


        return response(['photos_list' => $paths], 200)->header('Content-Type', 'application/json');
    }
}