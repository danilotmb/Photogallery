<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserFormRequest;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('admin/users');
    }
    private function getUserButtons(User $user)
    {
        $id = $user->id;


        $buttonEdit= '<a class="btn btn-sm btn-secondary" style="cursor:default" disable><i  class="bi bi-pen"></i></a>&nbsp;';


        if($user->deleted_at)
        {
            $deleteRoute = route('admin.userRestore', ['user' => $id]);
            $btnClass = 'btn-success';
            $iconDelete = '<i class="bi bi-arrow-clockwise"></i>';
            $btnId = 'restore-'.$id;
            $btnTitle = 'Restore';
        }
        else{
            $buttonEdit= '<a href="'.route('users.edit', ['user'=> $id]).'" id="edit-'.$id.'" 
                            class="btn btn-sm btn-primary"><i  class="bi bi-pen"></i></a>&nbsp;';
            $deleteRoute = route('users.destroy', ['user' => $id]);
            $iconDelete = '<i class="bi bi-trash"></i>';
            $btnClass = 'btn-warning';
            $btnId = 'delete-'.$id;
            $btnTitle = 'Soft Delete';





        }
        $buttonDelete = "<a  href='$deleteRoute' title='$btnTitle' id='$btnId'
                            class=' ajax $btnClass btn btn-sm '>$iconDelete</a>&nbsp;";

        $buttonForceDelete = '<a href="'.route('users.destroy', ['user'=> $id]).'?hard=1" title="hard delete" id="forcedelete-'.$id.'" 
                            class="ajax btn btn-sm btn-danger"><i class="bi bi-exclamation-triangle"></i></i> </a>';

        return $buttonEdit.$buttonDelete.$buttonForceDelete;
    }

    public function getUsers()
    {
        
        $users =  User::select(['id','name','email','user_role','created_at','deleted_at'])->withTrashed()->orderBy('created_at', 'desc')->get();
        $result = DataTables::of($users)->addColumn('action', function ($user) {
            return  $this->getUserButtons($user);

        })->make(true);
        return $result;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new User();
        return view('admin.edituser', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserFormRequest $request)
    {
        $user = new User();
        $user->fill($request->only(['name','email','user_role']));
        $user->password = Hash::make($request->email);

        $res = $user->save();
        $message = $res ? 'User created': 'Problem creating user';
        session()->flash('message', $message);
        return  redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.editUser', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserFormRequest $request, User $user)
    {
        $user->name = $request->name;
        $user->email = $request->email;
        $user->user_role = $request->user_role;
        $res = $user->save();
        $message = $res ? 'User updated' : 'Problem updating user';
        session()->flash('message' , $message);
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $hard = \request('hard', '');
        $res = $hard?$user->forceDelete() : $user->delete();
        return ''.$res;
    }

    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $res = $user->restore();
        return ''.$res;
    }
}
