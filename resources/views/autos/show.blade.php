@extends('layouts.appShow')
@section('content')

    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            <div class="col-md-10">
                <form action="{{route('update.avto',$auto->id)}}" method="post" enctype="multipart/form-data"
                      class="form" id="formUpdate">
                    @csrf
                    <input type="hidden" name="id" value="{{ $auto->id }}">
                    <table class="table table-hover">

                        <tbody>
                        <tr>
                            <th> Поле</th>
                            <th> Значение</th>
                        </tr>
                        <tr>
                            <td>Фото</td>
                            <td><img src="{{ asset('storage/'.$auto->photo) }}" height="240px">
                                <input type="file" class="form-control mt-2" name="photo" id="photo"
                                       aria-describedby="emailHelp" style="border: none"></td>

                        </tr>
                        <tr>
                            <td>ID владельца</td>
                            <td><input id="id_citisen" name="id_citisen" class="form-control"
                                       style="border: none;" value="{{ $auto->id_citisen}}"></td>
                        </tr>
                        <tr>
                            <td>Марка автомобиля</td>
                            <td><input id="brand_avto" name="brand_avto" class="form-control" style="border: none;"
                                       value="{{ $auto->brand_avto }}"></td>
                        </tr>

                        <tr>
                            <td>Регистрационный номер</td>
                            <td><input id="regis_num" name="regis_num" class="form-control" style="border: none;"
                                       value="{{ $auto->regis_num }}"></td>

                        </tr>
                        <tr>
                            <td>Цвет</td>
                            <td><input id="color" name="color" class="form-control"
                                       style="border: none;" value="{{ $auto->color }}"></td>
                        </tr>
                        <tr>
                            <td>Доп. информация</td>
                            <td><textarea id="addit_inf" name="addit_inf" class="form-control"
                                          style="border: none;">{{ $auto->addit_inf }}</textarea></td>
                        </tr>
                        <tr>
                            <td>Кто заметил</td>
                            <td><input id="who_noticed" name="who_noticed" class="form-control"
                                       style="border: none;" value="{{ $auto->who_noticed }}">
                            </td>
                        </tr>
                        <tr>
                            <td>Где заметил</td>
                            <td><input id="where_notice" name="where_notice" class="form-control"
                                       style="border: none;" value="{{ $auto->where_notice }}">
                            </td>
                        </tr>
                        <tr>
                            <td>Время обнаружения</td>
                            <td><input type="datetime-local" id="detection_time" name="detection_time"
                                       class="form-control"
                                       style="border: none;" value="{{ $auto->detection_time }}">
                            </td>
                        </tr>

                        <tr>
                            <td>Сделал запись пользователь</td>
                            <td>{{ $auto->user }}</td>
                        </tr>
                        <tr>

                            <td>Доступ к просмотру записи</td>

                            <td>
                                <div class="form-group"
                                     style="width:200px; height:100px; overflow:auto; border:solid 1px #C3E4FE;">
                                    <fieldset id="shest">
                                        <label><input type="checkbox" id="checkall"> Выбрать всех</label>
                                        @foreach ( $users as $user)
                                            <li class="list-group-item"><input type="checkbox" class="thing"
                                                                               name="user[]" id="user"
                                                                               value="{{ $user->id}}">{{' '.$user->username }}
                                            </li>
                                        @endforeach
                                    </fieldset>
                            </td>
                        </tr>

                        </tbody>
                        <div class="alert alert-success messages" role="alert" style="display: none"></div>

                    </table>
                    <a href="{{ route('auto.index') }}" class="btn btn-primary">Назад</a>

                    <button id="update" name="update" type="submit" class="btn btn-success"> Обновить данные</button>
                    <a href="avtoBorder/{{$auto->id}}" class="btn btn-primary" style="margin-left: 50%">Пересечение
                        границ</a>
                </form>
            </div>
        </div>
    </div>
    <script>
        const formUpdate = document.getElementById('formUpdate');
        const messageBlock = document.querySelector('.messages');

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
    </script>

@endsection
