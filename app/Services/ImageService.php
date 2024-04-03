<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Image;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Models\Photo;
use App\Models\Post;


class ImageService {

    public function getPhotosByPostId(string $postId) {
        $post = Post::findOrFail($postId);
        $photos = $post->photos;
        return $photos;
    }

    public function getPhotoPath($data) {
        $imageName = $data['photo_name'];
        $photoFullPath = asset('photos/' . $imageName);

        return response()->json(['photo_path' => $photoFullPath], 200);
    }

    public function uploadPhoto($data) {
        $userId = $data['user_id'];
        $image = $data['photo'];
        $imageName = $data['photo_name'];
        $image->storeAs('photos', $imageName, 'public');
        
        $photoFullPath = asset('photos/' . $imageName);

        $photo = Photo::create([
            'user_id' => $userId,
            'publication_time' => now(),
            'image_path' => $photoFullPath,
            'post_id' => 0,
        ]);

        return response()->json(['photo_path' => $photoFullPath], 200);
    }

    public function uploadPhotos($data, $user) {
        $postId = $data['post_id'];

        $uploadedPhotos = [];
    
        foreach ($data['photos'] as $image) {
            $imageName = $image->getClientOriginalName();
    
            $image->storeAs('photos', $imageName, 'public');
        
            $photoFullPath = asset('photos/' . $imageName);
            
            if ($user) {
                $photo = Photo::create([
                    'user_id' => $user->id,
                    'publication_time' => now(),
                    'image_path' => $photoFullPath,
                    'post_id' => $postId,
                ]);
            }
    
            $uploadedPhotos[] = [
                'photo_path' => $photoFullPath,
                'photo_id' => $photo->id,
            ];
        }
    
        return response()->json(['uploaded_photos' => $uploadedPhotos], 200);
    }
}