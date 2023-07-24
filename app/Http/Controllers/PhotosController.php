<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PhotosController extends Controller
{

    protected array $rules = [
        
        'album_id' => 'bail|required|integer|exists:albums,id',
        'name' => 'required',
        'img_path' => 'bail|required|image'
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }
    

    public function index()
    {
       return Photo::get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $req)
    {
        $photo = new Photo();

        $album = $req->album_id ? Album::findOrFail($req->album_id) : new Album();

        $albums = $this->getAlbums();

        return view('images.editimages', compact('album', 'photo', 'albums'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules);

        $photo = new Photo();

        $photo -> name = $request->input('name');
        $photo -> description = $request->input('description');
        $photo -> album_id = $request->input('album_id');

        $this->processFile($request, $photo);

         $photo -> save();

        return redirect(route('albums.images', $photo->album));
    }

    /**
     * Display the specified resource.
     */
    public function show(Photo $photo)
    {
        return $photo;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Photo $photo)
    {
        $album = $photo->album;

        $albums = $this->getAlbums();

        return view('images.editimages', compact('photo', 'album', 'albums'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Photo $photo)
    {
        unset($this->rules ['img_path']);
        $this->validate($request, $this->rules);

        $data = $request->only(['name', 'description', 'album_id']);
        $photo->name = $data['name'];
        $photo->description = $data['description'];

        $photo->album_id = $data['album_id'];

        if ($request->hasFile('img_path')) {

            $this->processFile($request, $photo);
        }
        $res = $photo->save();
        
        $message = $res ? 'Photo   ' . $photo->name . ' Updated' : 'Photo ' . $photo->name . ' was not updated';
        session()->flash('message', $message);
        return redirect()->route('albums.images', ['album' => $photo->album]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Photo $photo)
    {
        $res = $photo->delete();

        if($res && $photo->img_path)
        {
            Storage::delete($photo->img_path);
            return $res;
        }
        
        return $res;
    }

    public function processFile ( Request $request, Photo $photo)
    {
        $file = $request->file('img_path');

        $name = preg_replace('@[^a-z0-9]i@', '_', $photo->name);

        $filename= $name.'.'.$file->extension();
        $thumbnail= $file ->storeAs(config('filesystems.img_dir') . $photo->album_id, $filename );
        $photo->img_path = $thumbnail;
        //$photo->save();
    }

    public function getAlbums() : Collection
    {
        return Album::orderBy('album_name')->select(['id', 'album_name'])->get();
    }
}
