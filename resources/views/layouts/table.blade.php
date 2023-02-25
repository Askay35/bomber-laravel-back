@extends('layouts.default')

@section('header')
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/table.css">
@endsection

@section('content')


    <div class="container table-container">
        <div class="row flex-lg-nowrap">
            <div class="col-12 col-lg-auto mb-3" style="width:max-content;position:fixed;left: 0;z-index: 100;">
                <div class="card p-2">
                    <div class="e-navlist e-navlist--active-bg">
                        <ul class="nav">
                            <li class="nav-item"><a class="nav-link p-0"
                                                    href="{{route('logout')}}"
                                                    target="__blank"><i
                                        class="fa fa-fw fa-cog mr-1"></i><span>Выход</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col mt-5 p-0">


                <div class="col flex-lg-nowrap align-items-end d-flex flex-column">
                    <div class="d-flex w-100 justify-content-between">
                        <div>@yield('table.filter')</div>

                        <div class="e-tabs">
                            <ul class="nav nav-tabs border-bottom-0">
                                <li class="nav-item"><a
                                        class="nav-link {{str_contains(\Illuminate\Support\Facades\Route::currentRouteName(),'user')?'active':''}}"
                                        href="{{route('users')}}">Пользователи</a></li>
                                <li class="nav-item"><a
                                        class="nav-link {{str_contains(\Illuminate\Support\Facades\Route::currentRouteName(),'deposite')?'active':''}}"
                                        href="{{route('deposites')}}">Пополнения</a></li>
                                <li class="nav-item"><a
                                        class="nav-link {{str_contains(\Illuminate\Support\Facades\Route::currentRouteName(),'withdraw')?'active':''}}"
                                        href="{{route('withdraws')}}">Выводы</a></li>
                                <li class="nav-item"><a
                                        class="nav-link {{str_contains(\Illuminate\Support\Facades\Route::currentRouteName(),'bet')?'active':''}}"
                                        href="{{route('bets')}}">Ставки</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="row w-100 mb-3 mx-0">
                        <div class="e-panel card">
                            <div class="card-body">
                                <div class="e-table">
                                    <div class="table-responsive table-lg mt-3">
                                        <table class="table table-bordered">
                                            @yield('table.content')
                                        </table>
                                    </div>
                                    @if($rows instanceof \Illuminate\Pagination\LengthAwarePaginator)
                                        <div class="d-flex justify-content-center">
                                            {{$rows->appends(request()->input())->links()}}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>


@endsection

