@extends('layouts.default')

@section('header')
    <link rel="stylesheet" href="/css/login.css">

@endsection

@section('content')


    <form id="login-form" action="/register" method="post">
        @csrf
        <div class="mb-3">
            <label for="code-input" class="form-label">Код</label>
            <input required type="text" name="code" class="form-control @if($errors->has('code')) is-invalid @endif" id="code-input">
            @if($errors->has('code'))
                <div class="invalid-feedback">
                    {{$errors->first('code')}}
                </div>
            @endif
        </div>
        <div class="mb-3">
            <label for="login-input" class="form-label">Логин</label>
            <input required type="text" name="login" class="form-control @if($errors->has('login')) is-invalid @endif" id="login-input">
            @if($errors->has('login'))
                <div class="invalid-feedback">
                    {{$errors->first('login')}}
                </div>
            @endif
        </div>
        <div class="mb-3">
            <label for="password-input" class="form-label">Пароль</label>
            <input type="password" name="password" required class="form-control @if($errors->has('password')) is-invalid @endif" id="password-input">
            @if($errors->has('password'))
                <div class="invalid-feedback">
                    {{$errors->first('password')}}
                </div>
            @endif
        </div>
        <button type="submit" class="btn btn-primary w-100 mb-2">Зарегистрироваться</button>
        <a href="{{route('loginPage')}}" class="btn btn-outline-secondary w-100">Вход</a>
    </form>

@endsection
