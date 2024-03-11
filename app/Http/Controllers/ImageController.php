<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Image;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Models\Photo;
use App\Models\Post;
use App\Models\user;


class ImageController extends Controller
{

    public function getPhotosByPostId(string $postId) {
        $post = Post::findOrFail($postId);
        $photos = $post->photos;
        return $photos;
    }

    public function getPhotoPath(Request $request)
    {
        // Получаем имя файла из запроса
        $imageName = $request->input('photo_name');
        
        // Формируем полный URL-путь к фотографии
        $photoFullPath = asset('photos/' . $imageName);
        
        // Возвращаем путь к фотографии
        return response(['photo_path' => $photoFullPath], 200)->header('Content-Type', 'application/json');
    }

    public function upload(Request $request)
    {
        $userId = $request->input('user_id');
        
        $image = $request->file('photo');
        $imageName = $request->input('photo_name');
        $image->storeAs('photos', $imageName, 'public'); // Сохраняем в папку storage/app/public/photos
        
        // Формируем полный путь к изображению
        $photoFullPath = asset('photos/' . $imageName); // Изменили путь
        
        // Сохраняем информацию о изображении в базе данных
        $photo = new Photo();
        $photo->user_id = $userId;
        $photo->publication_time = now();
        $photo->image_path = $photoFullPath;
        $photo->post_id = 0;
        $photo->save();
        
        // Возвращаем путь к сохраненному изображению
        return response(['photo_path' => $photoFullPath], 200)->header('Content-Type', 'application/json');
    }
    


    public function uploadPhotos(Request $request) {

        $postId = $request->input('post_id');
    
        $uploadedPhotos = [];
    
        foreach ($request->file('photos') as $image) {
    
            $imageName = $image->getClientOriginalName();
    
            // Сохранение оригинала
            $image->storeAs('photos', $imageName, 'public');
        
            // Полный путь к сохраненному изображению
            $photoFullPath = asset('photos/' . $imageName);
            
            $user = Auth::user();
            $photo = new Photo();
    
            if ($user) {
                $photo->user_id = $user->id;
                $photo->publication_time = now();
                $photo->image_path = $photoFullPath;
                $photo->post_id = $postId;
                $photo->save();
            }
    
            $uploadedPhotos[] = [
                'photo_path' => $photoFullPath,
                'photo_id' => $photo->id,
            ];
        }
    
        return response()->json(['uploaded_photos' => $uploadedPhotos], 200);
    }
    
}