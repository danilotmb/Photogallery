<?php

namespace App\Http\Controllers;

use App\Events\NewAlbumCreated;
use App\Http\Requests\AlbumRequest;
use App\Models\Album;
use App\Models\Category;
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
        if ($request->has('category_id')) {
            $queryBuilder->whereHas('categories', fn( $q) => $q->where('category_id',$request->category_id)) ;
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
    $album = new Album();
    $selectedCategories = [];  // Inizializza l'array vuoto per le categorie selezionate
    $categories = Category::all();  // Recupera tutte le categorie

    return view('albums.createalbum', compact('album', 'categories', 'selectedCategories'));
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
        $album = new Album();
        $album->album_name = request()->input('album_name');
        $album->description = request()->input('description');
        $album->user_id = Auth::id();
        $album->album_thumb = '';
        
        $res = $album->save();
        

        if ($request->hasFile('album_thumb')) {
            $album_thumb = $this->processFile($album->id, $request, $album);
            $album->album_thumb = $album_thumb;
        }

        $res = $album->update();
    
        if ($res) {
            event(new NewAlbumCreated($album));
            if ($request->has('categories')) {
                $album->categories()->attach($request->input('categories'));
            }
        }
    
        $name = request()->input('name');
        $messaggio = $res ? 'Album   ' . $name . ' Created' : 'Album ' . $name . ' was not created';
        return redirect()->route('albums.index')->with('message', $messaggio);
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
        $categories = Category::orderBy('category_name')->get();
        $selectedCategories = $album->categories->pluck('id')->toArray();
        return view('albums.editalbum')->with(compact('categories','album', 'selectedCategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Album $album
     *
     * @return \Illuminate\Http\Response
     */
    public function update(AlbumRequest $req, Album $album)
{
    $album->album_name = $req->input('album_name');
    $album->description = $req->input('description');
    $album->user_id = Auth::id();
    
  
    if ($req->hasFile('album_thumb')) {
        if ($album->album_thumb) {
            Storage::delete($album->album_thumb);
        }
        
        $album_thumb = $this->processFile($album->id, $req, $album);
        $album->album_thumb = $album_thumb;
    }

    $res = $album->save();
    
    if ($req->has('categories')) {
        $album->categories()->sync($req->input('categories'));
    }

    $messaggio = $res ? 'Album con nome = ' . $album->album_name . ' Aggiornato' : 'Album ' . $album->album_name . ' Non aggiornato';
    session()->flash('message', $messaggio);
    
    return redirect()->route('albums.index')->with('message', $messaggio);
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


    private function processFile($id, Request $req, $album)
    {
        if (!$req->hasFile('album_thumb')) {
            return null;
        }
    
        $file = $req->file('album_thumb');
        if (!$file->isValid()) {
            return null; 
        }
    
        $extension = $file->getClientOriginalExtension();
        $filename = $id . '.' . $extension;
        $filenameWithPath = env('ALBUM_THUMB_DIR') . '/' . $filename;
    
        $file->storeAs(env('ALBUM_THUMB_DIR'), $filename);
    
        return $filenameWithPath;
    }
    

    
    
    


    public function getImages(Album $album)
    {
        $imgPerPage = config('filesystems.img_per_page');
        $images =  Photo::wherealbumId($album->id)->latest()->paginate( $imgPerPage); 
        return view('images.albumimages', compact ('album', 'images') );
    }

}