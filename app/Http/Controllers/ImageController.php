<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Image;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Services\ImageService;
use App\Http\Requests\ImageRequest;
use App\Models\Photo;
use App\Models\Post;
use App\Models\user;


class ImageController extends Controller
{
    protected $imageService;

    public function __construct()
    {
        
        $this->imageService = new ImageService();
    }
    
    public function getPhotosByPostId(string $postId) {   
        $photos = $this->imageService->getPhotosByPostId($postId);
        return $photos;
    }

    public function getPhotoPath(ImageRequest $request)
    {
        $data = $request->all();
        $photoPath = $this->imageService->getPhotoPath($data);
        return $photoPath;
    }

    public function upload(ImageRequest $request)
    {
        $data = $request->all();
        $photoPath = $this->imageService->upload($data);
        return $photoPath;
    }


    public function uploadPhotos(ImageRequest $request) {
        $user = Auth::user();
        $uploadedPhotos = $this->imageService->uploadPhotos($request->all(), $user);
        return $uploadedPhotos;
    }
}