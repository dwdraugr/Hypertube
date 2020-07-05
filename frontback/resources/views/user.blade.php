@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @isset($message)
                <div class="alert alert-primary" role="alert">
                    Settings update successful!
                </div>
            @endisset
            <div class="card">
                <div class="card-header">User Info</div>
                <div class="card-body" style="display: flex">
                    <div style="display: inline-block; ">
                        <img src="{{ $user->icon }}" style="border-radius: 64px; width: 128px; padding: 1em" alt="user icon"/>
                    </div>
                    <div style="display: inline-block; padding-right: 2em">
                        <p><b>Nickname: </b>{{ $user->name }}<span style="color: gray">#{{ $user->id }}</span></p>
                        <p><b>Full Name: </b>{{ $user->first_name }} {{ $user->last_name }}</p>
                        @if($user->id == Auth::id())
                            <p><b>Email: </b>{{ $user->email }}</p>
                        @endif
                    </div>
                    @if($user->id == Auth::id())
                        <div style="display: inline-block">
                            <a href="/users/{{ $user->id }}/edit" class="btn btn-primary">Edit Profile</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
