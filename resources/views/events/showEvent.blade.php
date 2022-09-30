@extends('layouts.appShow')
@section('content')

    <div class="container">

        <div class="row">
            <div class="col-md-10">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <h1>{{ $event->full_name }}</h1>
                <form action="" method="post" class="form" id="formUpdate"  enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $event->id }}">
                    <input type="hidden" name="full_name" value="{{ $event->full_name }}">
                    <table class="table table-hover">

                        <tbody>
                        <tr>
                            <th> Поле</th>
                            <th> Значение </th>
                        </tr>
                        <tr>
                            <td>Дата рождения</td>
                            <td><input type="date" id="date_birth" name="date_birth" class="form-control" style="border: none;"
                                       value="{{ $event->date_birth }}"></td>
                        </tr>

                        <tr>
                            <td>Кто заметил</td>
                            <td><textarea id="who_noticed" name="who_noticed" class="form-control"
                                          style="border: none;">{{ $event->who_noticed }}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>Где заметил</td>
                            <td><textarea id="where_noticed" name="where_noticed" class="form-control"
                                          style="border: none;">{{$event->where_noticed}}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>Время обнаружения</td>
                            <td><input id="detection_date" name="detection_date" class="form-control" type="datetime-local" style="border: none;"
                                       value="{{\Carbon\Carbon::parse($event->detection_date)->format('Y-m-d\TH:i')}}">
                            </td>
                        </tr>

                        <tr>
                            <td>Сделал запись пользователь</td>
                            <td>{{ $event->user }}</td>
                        </tr>
                        <tr>

                            <td>Доступ к просмотру записи</td>
                            <td>  <div class="form-group" style="width:200px; height:100px; overflow:auto; border:solid 1px #C3E4FE;">
                                    <fieldset id="shest">
                                        <label><input type="checkbox" id="checkall"> Выбрать всех</label>
                                        @foreach ( $users as $user)
                                            <li class="list-group-item"><input type="checkbox" class="thing" name="user[]" id="user" value="{{ $user->id}}">{{' '.$user->username }}</li>
                                        @endforeach
                                    </fieldset>
                            </td>
                        </tr>
                        </tbody>

                    </table>
                    <div class="alert alert-success messages" role="alert" style="display: none"></div>
                    <a href="{{route('home')}}" class="btn btn-primary">Назад</a>
                    <button id="update" name="update" type="submit" class="btn btn-success"> Обновить данные </button>

            </div>

            </form>

            <script>
                const formUpdate = document.getElementById('formUpdate');
                const messageBlock = document.querySelector('.messages');
                let addCitizen = document.querySelector('#citisAdd');

                var checkboxes = document.querySelectorAll('input.thing'),
                    checkall = document.getElementById('checkall');
                for(var i=0; i<checkboxes.length; i++) {
                    checkboxes[i].onclick = function() {
                        var checkedCount = document.querySelectorAll('input.thing:checked').length;
                        checkall.checked = checkedCount > 0;
                        checkall.indeterminate = checkedCount > 0 && checkedCount < checkboxes.length;
                    }
                }
                checkall.onclick = function() {
                    for(var i=0; i<checkboxes.length; i++) {
                        checkboxes[i].checked = this.checked;
                    }
                }
            </script>

@endsection
