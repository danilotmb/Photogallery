<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Photo;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        return view('gallery.albums')->with('albums', Album::latest()->paginate(20));
    }

    public function showAlbumImages(Album $album)
    {
        return view ('gallery.images' , [
            'images' => Photo::whereAlbumId($album->id)->latest()->paginate(20 ),
            'album' => $album

            
        ]);
    }
}
