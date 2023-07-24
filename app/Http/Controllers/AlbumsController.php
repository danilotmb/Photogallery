<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlbumRequest;
use App\Models\Album;
use App\Models\Photo;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class AlbumsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $albumsPerPage = config('filesystems.album_per_page');
        $queryBuilder = Album::orderBy('id', 'DESC')
        ->withCount('photos');
        $queryBuilder->where('user_id', Auth::id());
        if ($request->has('id')) {
            $queryBuilder->where('id', '=', $request->input('id'));
        }
        if ($request->has('album_name')) {
            $queryBuilder->where('album_name', 'like', $request->input('album_name') . '%');
        }
        $albums = $queryBuilder->paginate($albumsPerPage);
    
        return view('albums.albums', ['albums' => $albums]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('albums.createalbum')->withAlbum(new Album);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(AlbumRequest $request)
    {
        $this->authorize(Album::class);
        $data = $request->only(['album_name', 'description']);
        $album = new Album();
        $album->album_name = $data['album_name'];
        $album->description = $data['description'];
        $album->user_id = Auth::id();
        $album->album_thumb = '/';
        $res = $album->save();

        if($request->hasFile('album_thumb'))
        {
            $this->processFile($request, $album);
            $res = $album->save();
        }
        
        
        $message = 'Album ' . $data['album_name'];
        $message .= $res ? ' created' : ' not created';
        session()->flash('message', $message);
        return redirect()->route('albums.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Album $album
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Album $album)
    {
        if($album->useer_id === Auth::id())
        {
        return $album;
        }
        abort(401);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Album $album
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Album $album)
    {
        $this->authorize($album);
        /*if($album->user_id !== Auth::id())
        {
            abort(401);
        }
        */

        return view('albums.editalbum')->withAlbum($album);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Album $album
     *
     * @return \Illuminate\Http\Response
     */
    public function update(AlbumRequest $request, Album $album)
    {
        $this->authorize($album);
        $data = $request->only(['album_name', 'description']);
        $album->album_name = $data['album_name'];
        $album->description = $data['description'];
        if ($request->hasFile('album_thumb')) {

            $this->processFile($request, $album);
        }
        $res = $album->save();
        
        $message = $res ? 'Album   ' . $album->album_name . ' Updated' : 'Album ' . $album->album_name . ' was not updated';
        session()->flash('message', $message);
        return redirect()->route('albums.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Album $album
     *
     * @return int
     */
    public function destroy(Album $album)
    {
        $this->authorize($album);
        $thumbnail = $album->album_thumb;
        $res = $album->delete();
        if ($thumbnail) {
            Storage::delete($thumbnail);
        }
        if (request()->ajax()) {
            return $res;
        }
        return redirect()->back();
    }


    public function processFile ( Request $request, Album $album)
    {
        $file = $request->file('album_thumb');
        $filename= $album ->id.'.'.$file->extension();
        $thumbnail= $file ->storeAs(config('filesystems.album_thumbnail_dir'), $filename );
        $album->album_thumb = $thumbnail;
        $album->save();
    }

    public function getImages(Album $album)
    {
        $imgPerPage = config('filesystems.img_per_page');
        $images =  Photo::wherealbumId($album->id)->latest()->paginate( $imgPerPage); 
        return view('images.albumimages', compact ('album', 'images') );
    }

}