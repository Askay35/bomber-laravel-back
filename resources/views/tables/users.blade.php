@extends('layouts.table')



@section('table.content')
    <thead>
    <tr>

        <th>Имя</th>
        <th>Почта</th>
        <th>
            @if(count($rows)!==1)
            <a
                @if(isset($sort)&&$sort=='money')
                class="sortable sorted"
                href="{{str_contains(request()->fullUrl(),'page') ? str_replace('&sort=money','',request()->fullUrl()):str_replace('?sort=money','',request()->fullUrl()) }}"
                @else class="sortable"
                href="{{str_contains(request()->fullUrl(),'?') ? request()->fullUrl() . '&sort=money' : request()->fullUrl() . '?sort=money'}}" @endif >
                Счет руб.
            </a>
            @else
                Счет руб.
            @endif
        </th>
        <th>Активность</th>
        <th>Зарегистрирован</th>
        <th>Действия</th>
        <th>Инфо</th>
    </tr>
    </thead>
    <tbody class="table-body">
    @foreach($rows as $user)
        <tr id="user-edit-{{$user->id}}">
            <td class="position-relative">
                <input name="name" class="edit-input" value="{{$user->name}}" type="text">
            </td>
            <td>
                <input name="email" class="edit-input" value="{{$user->email}}" type="email">
            </td>
            <td>
                <input name="money" class="edit-input" value="{{$user->money}}" type="number">
            </td>
            <td>
                {{$user->last_activity}}
            </td>
            <td>
                {{$user->created_at}}
            </td>
            <td>
                <div class="btn-group align-top">
                    <button class="btn btn-sm btn-primary badge btn-lg"
                            data-id="{{$user->id}}"
                            data-tr="user-edit-{{$user->id}}"
                            onclick="submitEditForm(this)"
                            type="submit">Сохранить
                    </button>
                    <button class="btn btn-sm btn-danger badge"
                            type="button" data-id="{{$user->id}}" onclick="submitDeleteForm(this)"><i
                            class="fa fa-trash"></i>
                    </button>
                </div>
            </td>
            <td>
                <div class="btn-group">
                    <a href="{{route('bets', $user->id)}}" class="btn btn-sm btn-primary btn-lg badge"
                           >Ставки
                    </a>
                    <a href="{{route('deposites',$user->id)}}" class="btn btn-sm btn-primary btn-lg badge">
                        Пополнения
                    </a>
                    <a href="{{route('bets', $user->id)}}" class="btn btn-sm btn-primary btn-lg badge">
                        Выводы
                    </a>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
@endsection

@section('footer')
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"
            integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script>
        function submitEditForm(el) {
            let form = document.createElement("form"); // CREATE A NEW FORM TO DUMP ELEMENTS INTO FOR SUBMISSION
            form.method = "post"; // CHOOSE FORM SUBMISSION METHOD, "GET" OR "POST"
            form.action = "/user/edit/" + el.dataset.id; // TELL THE FORM WHAT PAGE TO SUBMIT TO
            let csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';
            form.appendChild(csrf);
            $("#" + el.dataset.tr + " .edit-input").each(function () { // GRAB ALL CHILD ELEMENTS OF <TD>'S IN THE ROW IDENTIFIED BY idRow, CLONE THEM, AND DUMP THEM IN OUR FORM
                if (this.value !== "") {
                    let input = document.createElement("input"); // CREATE AN ELEMENT TO COPY VALUES TO
                    input.type = "hidden";
                    input.name = this.name; // GIVE ELEMENT SAME NAME AS THE <SELECT>
                    input.value = this.value; // ASSIGN THE VALUE FROM THE <SELECT>
                    form.appendChild(input);
                }
            });
            document.body.appendChild(form);
            form.submit(); // NOW SUBMIT THE FORM THAT WE'VE JUST CREATED AND POPULATED
        }

        function submitDeleteForm(el) {
            let form = document.createElement("form"); // CREATE A NEW FORM TO DUMP ELEMENTS INTO FOR SUBMISSION
            form.method = "post"; // CHOOSE FORM SUBMISSION METHOD, "GET" OR "POST"
            form.action = "/user/delete/" + el.dataset.id; // TELL THE FORM WHAT PAGE TO SUBMIT TO
            let input = document.createElement('input');
            input.type = 'hidden';
            input.name = '_token';
            input.value = '{{ csrf_token() }}';
            form.appendChild(input);
            document.body.appendChild(form);
            form.submit(); // NOW SUBMIT THE FORM THAT WE'VE JUST CREATED AND POPULATED
        }
    </script>

@endsection
