@extends('templates.admin')
@section('content')

<div class="row d-flex justify-content-center">
    <div class="col-auto col-sm-6">
        <h1>Manage User</h1>

    @if($user->id)
    <form action="{{route('users.update', $user->id)}}" method="POST">
        @method('PATCH')
        @else
            <form action="{{route('users.store')}}" method="POST">
        @endif

            <div class="form-group">
                <label for="name">NAME</label>
                <input name="name" id="name" value="{{old('name', $user->name)}}" placeholder="User's Name " class="form-control"> 

                @error('name')
                    <div class="alert alert-danger">
                        @foreach ($errors->get('name') as $error )
                            {{$error}}<br>
                        @endforeach
                    </div>
                @enderror
                
            </div>

            <div class="form-group">
                <label for="name">EMAIL</label>
                <input type="email" name="email" id="email" value="{{old('email', $user->email)}}" placeholder="User's Email " class="form-control">
                
                @error('email')
                    <div class="alert alert-danger">
                        @foreach ($errors->get('email') as $error )
                            {{$error}}<br>
                        @endforeach
                    </div>
                @enderror

            </div>

            <div class="form-group">
                <label for="name">ROLE</label>
                <select name="user_role" id="user_role" class="form-control">
                    <option value="">SELECT</option>
                    <option {{$user->user_role === 'user'? 'selected' : ""}} value="user">User</option>
                    <option {{$user->user_role === 'admin'? 'selected' : ""}} value="admin">Admin</option>
                </select> 

                @error('user_role')
                    <div class="alert alert-danger">
                        @foreach ($errors->get('user_role') as $error )
                            {{$error}}<br>
                        @endforeach
                    </div>
                @enderror

            </div>
                
            <div class="form-group justify-content-center d-flex ">
                <button class="btn btn-info m-2 w-25" type="reset">RESET</button>
                <button class="btn btn-primary m-2 w-25">SAVE</button>
            </div>

   @csrf

    </form>
    </div>
</div>




@endsection