@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('settingsForm.Header') }}</div>
                    <div class="card-body" style="display: flex">
                        <form action="/users/{{ $user->id }}" method="post" enctype="multipart/form-data" id="form">
                            @method('PUT')
                            @csrf
                            <h5>{{ __('settingsForm.General') }}</h5>
                            <div class="form-group">
                                <label for="usernameInput">{{ __('settingsForm.Username') }}</label>
                                <input id="usernameInput" class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}" type="text" name="username" value="{{ $user->name }}">
                                @error('username')
                                    <div class="invalid-feedback">{{ $errors->first('username') }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="usernameInput">{{ __('settingsForm.FirstName') }}</label>
                                <input id="usernameInput" class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}" type="text" name="first_name" value="{{ $user->first_name }}">
                                @error('first_name')
                                    <div class="invalid-feedback">{{ $errors->first('first_name') }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="usernameInput">{{ __('settingsForm.LastName') }}</label>
                                <input id="usernameInput" class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}" type="text" name="last_name" value="{{ $user->last_name }}">
                                @error('last_name')
                                    <div class="invalid-feedback">{{ $errors->first('last_name') }}</div>
                                @enderror
                            </div>
                            <button type="submit" name="action" value="general" class="btn btn-primary">{{ __('settingsForm.UpdateButton') }}</button>
                            <hr>
                            <h5>{{ __('settingsForm.Password') }}</h5>
                            <div class="form-group">
                                <label for="usernameInput">N{{ __('settingsForm.NewPassword') }}</label>
                                <input id="usernameInput" class="form-control {{ $errors->has('new_pass') ? 'is-invalid' : '' }}" type="password" name="new_pass" value="">
                                @error('new_pass')
                                    <div class="invalid-feedback">{{ $errors->first('new_pass') }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="usernameInput">{{ __('settingsForm.RepeatPassword') }}</label>
                                <input id="usernameInput" class="form-control {{ $errors->has('repeat_pass') ? 'is-invalid' : '' }}" type="password" name="repeat_pass" value="">
                                @error('repeat_pass')
                                    <div class="invalid-feedback">{{ $errors->first('repeat_pass') }}</div>
                                @enderror
                            </div>
                            <button type="submit" name="action" value="password" class="btn btn-primary">{{ __('settingsForm.UpdateButton') }}</button>
                            <hr>
                            <h5>{{ __('settingsForm.Icon') }}</h5>
                            <div class="form-group">
                                <label for="usernameInput">{{ __('settingsForm.UpdateIcon') }}</label>
                                <input id="usernameInput" class="form-control-file {{ $errors->has('icon') ? 'is-invalid' : '' }}" type="file" name="icon">
                                @error('icon')
                                    <div class="invalid-feedback">{{ $errors->first('icon') }}</div>
                                @enderror
                            </div>
                            <button type="submit" name="action" value="icon" class="btn btn-primary">{{ __('settingsForm.UpdateButton') }}</button>
                            <hr>
                            <h5>{{ __('settingsForm.Lang') }}</h5>
                            <div class="form-group">
                                <label for="usernameInput">{{ __('settingsForm.SelectLang') }}</label>
                                <select name="lang" form="form">
                                    <option selected>{{ __('settingsForm.LangPlaceHolder') }}</option>
                                    <option value="en">English</option>
                                    <option value="ru">русский</option>
                                </select>
                                @error('icon')
                                <div class="invalid-feedback">{{ $errors->first('icon') }}</div>
                                @enderror
                            </div>
                            <button type="submit" name="action" value="lang" class="btn btn-primary">{{ __('settingsForm.UpdateButton') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
