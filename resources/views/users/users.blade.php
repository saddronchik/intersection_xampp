@extends('layouts.app')

@section('content')
<div class="container">
<div class="row">
    <div class="col-2">
      <div class="nav flex-column nav-pills" aria-orientation="vertical">

        <a class="btn btn-primary btn-sm mb-2 " role="button" data-bs-toggle="button" href="{{route('home')}}" role="button">Главная</a>

      </div>
    </div>

              <h1 class="display-8">Данные пользователей</h1>

            @foreach ($roles as $role)

                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th scope="col">№</th>
                      <th scope="col">Имя пользователя</th>
                      <th scope="col">Роль</th>
                      <th scope="col">Выбрать роль</th>
                    </tr>
                  </thead>
                  <tbody>

                    <tr>

                      <th scope="row">{{ $role->id }} <a href="users/{{$role->id}}" class="btn btn-primary btn-sm" style="margin-top: 170px">Редактировать</a></th>
                      <td class="col-md-3" style="font-size:19px"> {{ $role->username }}</td>
                        <td class="col-md-5" style=" border-right: 1px solid grey;height: 100px;">{{$role->role}}</td>
                        <td>
                            <form action={{route('users.update',$role->id)}} method="post" class="form" id="formUpdate" >
                                @csrf
                                <input type="hidden" name="id" value="{{ $role->id }}">
                                <table class="table table-hover">
                                    <tbody>
                                    <tr style="border: none; display: none">
                                        <td><input id="username" name="username" class="form-control"
                                                   style="border: none; display: none" value="{{ $role->username }}"></td>
                                    </tr>
                                    <tr>
                                        <td class="flex-inner" style="border: none;">
                                            <div class="mb-2">
                                                <div class="form-check form-check-inline">
                                                    <label >Граждане: </label>
                                                </div>
                                                <div class="mb-2">
                                                    <div class="form-check form-check-inline">

                                                        <label >Автомобили: </label>
                                                    </div>
                                                    <div class="mb-2">
                                                        <div class="form-check form-check-inline">
                                                            <label >Пересечение границ: </label>
                                                        </div>
                                                        <div class="mb-2">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox" name="role_admin" id="role_admin" value="admin">
                                                                <label class="form-check-label" for="inlineRadio3" style="color: rgb(13, 187, 13)">Администратор</label>
                                                            </div>
                                                        </div>

                                        <td style="border:none;">
                                            <div class="form-check form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="role_citisen" id="role_citisen" value="user_сitisen">
                                                <label class="form-check-label" for="inlineCheckbox1">Просмотр</label>
                                            </div>
                                            <div class="form-check form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="role_avto" id="role_avto" value="user_avto">
                                                <label class="form-check-label" for="inlineCheckbox1">Просмотр</label>
                                            </div>
                                            <div class="form-check form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="role_border" id="role_border" value="user_border">
                                                <label class="form-check-label" for="inlineCheckbox1">Просмотр</label>
                                            </div>
                                        </td>

                                        <td style="border: none;">
                                            <div class="form-check form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="role_citisen_add" id="role_citisen_add" value="user_сitisen_add">
                                                <label class="form-check-label" for="inlineCheckbox2">Добавление</label>
                                            </div>
                                            <div class="form-check form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="role_avto_add" id="role_avto_add" value="user_avto_add">
                                                <label class="form-check-label" for="inlineCheckbox2">Добавление</label>
                                            </div>
                                            <div class="form-check form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="role_border_add" id="role_border_add" value="user_border_add">
                                                <label class="form-check-label" for="inlineCheckbox2">Добавление</label>
                                            </div>
                                        </td>

                                        <td style="border: none;">
                                            <div class="form-check form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="role_citisen_upd" id="role_citisen_upd" value="user_сitisen_upd">
                                                <label class="form-check-label" for="inlineCheckbox3">Редактирование</label>
                                            </div>
                                            <div class="form-check form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="role_avto_upd" id="role_avto_upd" value="user_avto_upd">
                                                <label class="form-check-label" for="inlineCheckbox3">Редактирование</label>
                                            </div>
                                            <div class="form-check form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="role_border_upd" id="role_border_upd" value="user_border_upd">
                                                <label class="form-check-label" for="inlineCheckbox3">Редактирование</label>
                                            </div>
                                        </td>

                                    </tr>
                                    </tbody>

                                 </table>
                                    <button id="update" name="update" type="submit" class="btn btn-success btn-sm">Обновить роль</button>
                                    <a href="destroyuser/{{$role->id}}" class="btn btn-danger btn-sm ">Удалить</a>

                                </form>

                            </td>
                        </tr>
                    </tbody>
                  </table>


                @endforeach
    </div>


@endsection
