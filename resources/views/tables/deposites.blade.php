@extends('layouts.table')


@section('table.filter')

    <div class="e-tabs">
        <ul class="nav nav-tabs border-bottom-0">
            <li class="nav-item"><a
                    class="nav-link {{str_contains(request()->fullUrl(),'status=1')?'active':''}}"
                    href="@if(str_contains(request()->fullUrl(),'status=1')) {{preg_replace('/[&?](status=1)/','',request()->fullUrl())}} @else {{str_contains(request()->fullUrl(),'status=')?preg_replace('/(status=).{1}/', '${1}1',request()->fullUrl()):(str_contains(request()->fullUrl(),'=')?request()->fullUrl().'&status=1':request()->fullUrl().'?status=1')}}@endif">Обрабатывается</a>
            </li>
            <li class="nav-item"><a
                    class="nav-link {{str_contains(request()->fullUrl(),'status=2')?'active':''}}"
                    href="@if(str_contains(request()->fullUrl(),'status=2')) {{preg_replace('/[&?](status=2)/','',request()->fullUrl())}} @else {{str_contains(request()->fullUrl(),'status=')?preg_replace('/(status=).{1}/', '${1}2',request()->fullUrl()):(str_contains(request()->fullUrl(),'=')?request()->fullUrl().'&status=2':request()->fullUrl().'?status=2')}}@endif">Подтвержден</a>
            </li>
            <li class="nav-item"><a
                    class="nav-link {{str_contains(request()->fullUrl(),'status=3')?'active':''}}"
                    href="@if(str_contains(request()->fullUrl(),'status=3')) {{preg_replace('/[&?](status=3)/','',request()->fullUrl())}} @else {{
                        str_contains(request()->fullUrl(),'status=')
                        ?
                        preg_replace('/(status=).{1}/', '${1}3',request()->fullUrl())
                        :
                        (str_contains(request()->fullUrl(),'=')
                        ?
                        request()->fullUrl().'&status=3'
                        :
                        request()->fullUrl().'?status=3')
                        }}@endif">Отменен</a>
            </li>
        </ul>
    </div>

@endsection

@section('table.content')
    <thead>
    <tr>

        <th>Пользователь</th>
        <th>Статус</th>
        <th>Платежная система</th>
        <th>Сумма</th>
        <th>Дата</th>
        <th>Дата обновления</th>
        <th>Действия</th>
    </tr>
    </thead>
    <tbody class="table-body">
    @foreach($rows as $deposite)
        <tr>
            <td class="align-middle text-center position-relative">
                @if(!is_null($deposite->user))
                    <a href="{{route('users',$deposite->user->id)}}">{{$deposite->user->name}}</a>
                @endif
            </td>
            <td class="text-nowrap">
                {{$deposite->status->status}}
            </td>
            <td class="text-nowrap" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true"
                title="{{$deposite->system->data}} <br> <b>{{$deposite->system->description}}</b>">
                {{$deposite->system->name}}
            </td>
            <td class="text-nowrap">
                {{$deposite->size}}
            </td>
            <td class="text-nowrap">
                {{$deposite->created_at}}
            </td>
            <td class="text-nowrap">
                {{$deposite->updated_at}}
            </td>
            <td class="text-center">
                <div class="btn-group align-top">
                    <a class="btn btn-sm btn-success badge"
                       onclick="return confirm('Вы уверены, что хотите подтвердить пополнение?')"
                       href="{{route('deposite.accept',$deposite->id)}}"
                    ><i class="fa fa-2x fa-check"></i>
                    </a>
                    <a class="btn btn-sm btn-warning badge"
                       onclick="return confirm('Вы уверены, что хотите отклонить пополнение?')"
                       href="{{route('deposite.reject',$deposite->id)}}"
                    ><i class="fa fa-2x fa-close"></i>
                    </a>
                    <a class="btn btn-sm btn-danger badge"
                       onclick="return confirm('Вы уверены, что хотите удалить пополнение?')"
                       href="{{route('deposite.delete',$deposite->id)}}"
                    ><i
                            class="fa fa-2x fa-trash"></i>
                    </a>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
@endsection

@section('footer')
    <script>
        let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        let tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>
@endsection
