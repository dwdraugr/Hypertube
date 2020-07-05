@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @isset($message)
                <div class="alert alert-primary" role="alert">
                    {{ __('settings.UpdateMessage') }}
                </div>
            @endisset
            <div class="card">
                <div class="card-header">{{ __('settings.Header') }}</div>
                <div class="card-body" style="display: flex">
                    <div style="display: inline-block; ">
                        <img src="{{ $user->icon }}" style="border-radius: 64px; width: 128px; padding: 1em" alt="user icon"/>
                    </div>
                    <div style="display: inline-block; padding-right: 2em">
                        <p><b>{{ __('settings.Nickname') }}: </b>{{ $user->name }}<span style="color: gray">#{{ $user->id }}</span></p>
                        <p><b>{{ __('settings.FullName') }}: </b>{{ $user->first_name }} {{ $user->last_name }}</p>
                        @if($user->id == Auth::id())
                            <p><b>{{ __('settings.Email') }}: </b>{{ $user->email }}</p>
                        @endif
                    </div>
                    @if($user->id == Auth::id())
                        <div style="display: inline-block">
                            <a href="/users/{{ $user->id }}/edit" class="btn btn-primary">{{ __('settings.EditButton') }}</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
