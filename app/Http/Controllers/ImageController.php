<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Image;

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
}