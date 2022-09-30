@extends('layouts.appShow')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-2">
                <div class="nav flex-column nav-pills" aria-orientation="vertical">
                    <a class="btn btn-primary btn-sm mb-2 " href="{{route('home')}}" role="button">Главная</a>
                </div>
            </div>

            <div class="col-8">
                <h1 class="display-8">Добавить событие</h1>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="POST" action="{{route('events.store')}}" enctype="multipart/form-data" id="citisAdd" >

                    @csrf
                    <div class="form-group" style="display: none">
                        <label for="full_name">Гражданин</label>
                        <input type="text" class="typeahead form-control" name="id_citizen" id="id_citizen">
                    </div>
                    <div class="form-group">
                        <label for="id_citizen">Ф.И.О. гражданина</label>
                        <select name="id_citizen" id="id_citizen" class="selectpicker ml-3" data-style="btn-info"
                                data-live-search="true" data-size="10" multiple title="Выберите гражданина">

                            @foreach($citizens as $citizen)
                                <option name="id_citizen" id="id_citizen" value="{{ $citizen->id}}" data-subtext="{{$citizen->date_birth}}">{{$citizen->full_name}} </option>
                            @endforeach

                        </select>


                    </div>

{{--                    <div class="form-group">--}}
{{--                        <label for="date_birth">Дата рождения</label>--}}
{{--                        <input type="date" class="form-control" name="date_birth" id="date_birth" value="{{$citizen->date_birth}}"  >--}}
{{--                    </div>--}}
                    <div class="form-group">
                        <label for="who_noticed">Кто заметил</label>
                        <input type="text" class="typeahead form-control" name="who_noticed" id="who_noticed" value="{{old('who_noticed')}}" >
                    </div>
                    <div class="form-group">
                        <label for="where_noticed">Где заметил</label>
                        <input type="text" class="typeahead form-control" name="where_noticed" id="where_noticed" value="{{old('where_noticed')}}">
                    </div>
                    <div class="form-group">
                        <label for="detection_date">Дата обнаружения</label>
                        <input type="datetime-local" class="typeahead form-control" name="detection_date" id="detection_date" value="{{old('detection_date')}}">
                    </div>

                    <label for="">Доступ к просмотру записи</label>

                    <div class="form-group" style="width:200px; height:100px; overflow:auto; border:solid 1px #C3E4FE;">
                        <fieldset id="shest">
                            <label><input type="checkbox" id="checkall"> Выбрать всех</label>

                            @foreach ( $users as $user)
                                <li class="list-group-item"><input type="checkbox" class="thing" name="user[]" id="user" value="{{ $user->id}}" >{{' '.$user->username }}</li>
                            @endforeach
                        </fieldset>
                    </div>


                    <div class="alert alert-success messages" role="alert" style="display: none"></div>
                    <button type="submit" class="btn btn-primary" id="add-event">Добавить запись</button>

                </form>
{{--                <div class="container">--}}
{{--                    <div class="row">--}}
{{--                        <div class="panel panel-default">--}}
{{--                            <div class="panel-heading">--}}
{{--                                <h3>Гражданин</h3>--}}
{{--                            </div>--}}
{{--                            <div class="panel-body">--}}
{{--                                <div class="form-group">--}}
{{--                                    <input type="text" class="form-controller" id="search" name="search"></input>--}}
{{--                                </div>--}}
{{--                                <table class="table table-bordered table-hover">--}}
{{--                                    <thead>--}}
{{--                                    <tr>--}}
{{--                                        <th>ID</th>--}}
{{--                                        <th>Имя гражданина</th>--}}
{{--                                        <th>Дата рождения</th>--}}
{{--                                    </tr>--}}
{{--                                    </thead>--}}
{{--                                    <tbody>--}}
{{--                                    </tbody>--}}
{{--                                </table>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>

{{--            <script type="text/javascript">--}}
{{--                $('#search').on('keyup',function(){--}}
{{--                    $value=$(this).val();--}}
{{--                    $.ajax({--}}
{{--                        type : 'get',--}}
{{--                        url : '{{URL::to('search')}}',--}}
{{--                        data:{'search':$value},--}}
{{--                        success:function(data){--}}
{{--                            $('tbody').html(data);--}}
{{--                        }--}}
{{--                    });--}}
{{--                })--}}
{{--            </script>--}}
{{--            <script type="text/javascript">--}}
{{--                $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });--}}
{{--            </script>--}}

            <script>
                const formUpdate = document.getElementById('formAdd');
                const messageBlock = document.querySelector('.messages');

                let addCitizen = document.querySelector('#citisAdd');

                var checkboxes = document.querySelectorAll('input.thing'),
                    checkall = document.getElementById('checkall');
                for (var i = 0; i < checkboxes.length; i++) {
                    checkboxes[i].onclick = function () {
                        var checkedCount = document.querySelectorAll('input.thing:checked').length;
                        checkall.checked = checkedCount > 0;
                        checkall.indeterminate = checkedCount > 0 && checkedCount < checkboxes.length;
                    }
                }
                checkall.onclick = function () {
                    for (var i = 0; i < checkboxes.length; i++) {
                        checkboxes[i].checked = this.checked;
                    }
                }
                $('.selectpicker').selectpicker({
                    noneResultsText: 'Гражданин не найден <a class="btn btn-primary " href="{{ route('citizen.create') }}" role="button">Добавить гражданина</a>'
                });


            </script>



@endsection
