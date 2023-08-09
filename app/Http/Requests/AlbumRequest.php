<?php

namespace App\Http\Requests;

use App\Models\Album;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class AlbumRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        $albumId =$this->route()->album;

        if(!$albumId){
            return 1;
        }

        $album = Album::findOrFail($albumId);
        if(Gate::denies('manage-album', $album)){
           return false;
        }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
{
    $id = $this->route('album');

    $ret = [
        'album_name' => 'bail|required|unique:albums,album_name',
        'description' => 'required',
    ];

    if ($id) {
        $ret['album_name'] = [
            'required',
            Rule::unique('albums', 'album_name')->ignore($id),
        ];
    } else {
        $ret['album_thumb'] = 'required|image';
    }

    return $ret;
}
}
