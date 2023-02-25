@extends('layouts.table')



@section('table.content')
    <thead>
    <tr>
        <th>Пользователь</th>
        <th>Раунд</th>
        <th>Ставка</th>
        <th>Коэф.</th>
        <th>Выигрыш</th>
        <th>Дата</th>
        <th>Действия</th>
    </tr>
    </thead>
    <tbody class="table-body">
    @foreach($rows as $bet)
        <tr>
            <td class="align-middle">
                <a href="{{route('users', $bet->user->id)}}">{{$bet->user->name}}</a>
            </td>
            <td class="align-middle">
                {{$bet->round->coef}}
            </td>
            <td class="align-middle">
                {{$bet->bet_size}}
            </td>
            <td class="align-middle">
                {{$bet->coef}}
            </td>
            <td class="align-middle">
                {{$bet->win}}
            </td>
            <td class="align-middle">
                {{$bet->date_time}}
            </td>
            <td class="align-middle">
                <a class="btn btn-sm btn-danger badge"
                   href="{{route('bet.delete',$bet->id)}}"
                ><i
                        class="fa fa-2x fa-trash"></i>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
@endsection
