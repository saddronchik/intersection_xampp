@extends('layouts.appShow')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-2">
                <div class="nav flex-column nav-pills" aria-orientation="vertical">

                    <a class="btn btn-primary btn-sm mb-2 " href="{{ route('auto.index') }}" role="button">Назад</a>

                </div>
            </div>

            <div class="col-8">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="POST" enctype="multipart/form-data" action="{{route('auto.store')}}" id="formAdd">
                    @csrf
                    <h1> Добавление автомобилей </h1>

                    <div class="form-group">
                        <label for="id_citisen">ID Владельца</label>
                        <select name="id_citisen" id="id_citisen" class="selectpicker" data-style="btn-info"
                                data-live-search="true">
                            <option data-tokens="ketchup mustard" data-style="btn-info" value="Не определенно">Выберите
                                гражданина
                            </option>
                            @foreach($citizens as $citizen)
                                <option name="id_citisen" id="id_citisen" value="{{$citizen->full_name}}"
                                        data-subtext="{{$citizen->id}}">{{$citizen->full_name}} </option>
                            @endforeach
                        </select>


                    </div>
                    <div class="form-group">
                        <label for="brand_avto">Марка машины</label>
                        <input type="text" class="form-control" name="brand_avto" id="brand_avto" required>
                    </div>
                    <div class="form-group">
                        <label for="regis_num">Регистрационный номер</label>
                        <input type="text" class="form-control" name="regis_num" id="regis_num" required>
                    </div>
                    <div class="form-group">
                        <label for="color">Цвет</label>
                        <input type="text" class="form-control" name="color" id="color">
                    </div>
                    <div class="form-group">
                        <label for="photo">Фото</label>
                        <input type="file" class="form-control" name="photo" id="photo" aria-describedby="emailHelp">
                    </div>

                    <div class="form-group">
                        <label for="addit_inf">Доп информация</label>
                        <textarea class="form-control" name="addit_inf" id="addit_inf" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="who_noticed">Кто заметил</label>
                        <input type="text" class="form-control" name="who_noticed" id="who_noticed">
                    </div>

                    <div class="form-group">
                        <label for="where_notice">Где заметил</label>
                        <input type="text" class="form-control" name="where_notice" id="where_notice">
                    </div>

                    <div class="form-group">
                        <label for="detection_time">Время обнаружения</label>
                        <input type="datetime-local" class="form-control" name="detection_time" id="detection_time">
                    </div>
                    <div class="form-group">
                        <label for="">Доступ к просмотру записи</label>

                        <div class="form-group"
                             style="width:200px; height:100px; overflow:auto; border:solid 1px #C3E4FE;">
                            <fieldset id="shest">
                                <label><input type="checkbox" id="checkall"> Выбрать всех</label>
                                @foreach ($users as $user)
                                    <li class="list-group-item"><input type="checkbox" class="thing" name="user[]"
                                                                       id="user"
                                                                       value="{{ $user->id}}">{{' '.$user->username }}
                                    </li>
                                @endforeach
                            </fieldset>
                        </div>

                        <div class="alert alert-success messages" role="alert" style="display: none"></div>

                        <button type="submit" class="btn btn-primary">Добавить запись</button>
                </form>
            </div>

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


                // const formAdd = document.getElementById('formAdd');
                // const messageBlock = document.querySelector('.messages');

                // formAdd.addEventListener('submit' , function(e){
                //     e.preventDefault();

                //     const formData = new FormData(this);
                //     fetch('/avtos', {
                //             method: "POST",
                //             // enctype="multipart/form-data",
                //             headers: {
                //                 "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute(
                //                     'content')
                //             },
                //             body: formData
                //         })
                //         .then(function(response) {
                //             if (response.status == 200) {
                //                 messageBlock.textContent = 'Данные успешно добавленны!';
                //                 messageBlock.style.display = 'block';
                //             }
                //             if (response.status == 500) {
                //                 messageBlock.textContent = 'Ошибка данных!';
                //                 messageBlock.style.display = 'block';
                //             }
                //           })


                //             // console.log(response)
                //         //    return response.text();

                //         .then(function(text)  {
                //             console.log('Success ' + text);

                //         })
                //         .catch(function(error){
                //             console.error(error);

                //         })

                // });


            </script>
@endsection
