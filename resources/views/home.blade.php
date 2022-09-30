@extends('layouts.appShow')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-2">
                <div class="nav flex-column nav-pills" aria-orientation="vertical">
                    <a class="btn btn-primary btn-sm mb-2 " href="{{ route('home') }}" role="button">Главная</a>
                    <a class="btn btn-primary btn-sm mb-2 " href="{{route('citizen.list')}}" role="button">Список граждан</a>
                    <a class="btn btn-primary btn-sm mb-2 " href="{{route('citizen.citizenForUser')}}" role="button">Граждане доступные мне</a>
                    <a class="btn btn-primary btn-sm mb-2 " href="{{ route('citizen.create') }}" role="button">Добавление
                        граждан</a>
                    <a class="btn btn-primary btn-sm mb-2 " href="{{ route('auto.index') }}"
                       role="button">Автомобили</a>
                    <a class="btn btn-primary btn-sm mb-2 " href="{{route('borders.list')}}" role="button">Пересечение границы</a>
                    <a class="btn btn-success btn-sm mb-2 " href="logs" role="button">Логи</a>
                    <a class="btn btn-success btn-sm mb-2 " href="{{route('users.create')}}" role="button">Добавить пользователя</a>
                    <a class="btn btn-success btn-sm mb-2 " href="{{route('users.list')}}" role="button">Работа с пользователями</a>
                </div>
            </div>


            <div class="col-10">
                <h1 class="display-8">События</h1>
                <a class="btn btn-primary mb-2" href="{{route('events.create')}}" role="button">Добавить
                    событие</a>

                <form method="GET" action="{{ route('events.search') }}">
                    <div class="form-row">
                        <div class="form-group col-md-10">
                            <input type="text" class="form-control" id="s" name="s" placeholder="Поиск..."
                                   value="{{request()->s}}">
                        </div>
                        <div class="form-group col-md-2">
                            <button type="submit" class="btn btn-primary btn-block">Поиск</button>
                        </div>
                    </div>
                </form>

                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col-md-2">#</th>
                        <th scope="col-md-5">ФИО</a></th>
                        <th scope="col-md-2">Дата рождения</th>
                        <th scope="col-md-2">Кто заметил</th>
                        <th scope="col-md-2">Где заметил</th>
                        <th scope="col-md-2">Время обнаружения</th>
                        <th style="display: none" scope="col-md-2">id</th>
                        <th scope="col-md-2">Сделал запись пользователь</th>
                    </tr>
                    </thead>

                    @foreach ($events as $event)
                        <tbody>
                        <tr>

                            <th scope="row" id="idcitisen" name="idcitisen"
                                value="{{ $event->id }}">{{ $event->id }}</th>
                            @role('admin')
                            <td class="col-md-2"><a href="{{route('events.show',$event->id)}}">{{ $event->full_name }}</td>
                            @else
                                <td class="col-md-2">
                                    <span class="mail" style="color: blue" data-toId="{{ $event->id_user}}"
                                          data-Id="{{ $event->id }}"
                                          data-ctisenname="{{ $event->full_name }}">{{ $event->full_name }} </span>
                                </td>

                                @endrole
                                {{-- <td class="col-md-3">{{ $citisen->passport_data }}</td> --}}
                                <td class="col-md-2">{{$event->date_birth}}</td>
                                <td class="col-md-2">{{$event->who_noticed}}</td>
                                <td class="col-md-2">{{$event->where_noticed}}</td>
                                <td class="col-md-2">{{$event->detection_date}}</td>
                                <td class="col-md-2" style="display: none"></td>

                                <td class="col-md-2">{{ $event->user }}</td>
                                @role('admin')
                                <td class="col-md-2"><a href="{{route('events.destroy',$event->id)}}" class="btn btn-danger btn-sm mb-2">Удалить</a></td>
                                @endrole

                        </tr>
                        @endforeach
                        </tbody>
                </table>

                {{ $events->appends(['s'=>request()->s])->onEachSide(5)->links() }}

            </div>
            <input type="hidden" name="from" id="from" value="{{ $authUser}}">
            <input type="hidden" name="fromname" id="fromname" value="{{ $authUsername}}">

            <script>
                const links = document.querySelectorAll('.mail');

                links.forEach(function (item, i, links) {
                    let authUserId = document.querySelector('#from').value;
                    let authUsername = document.querySelector('#fromname').value;

                    item.addEventListener("click", function (event) {
                        event.preventDefault();
                        let toUserId = this.getAttribute('data-toId');
                        let citisenId = this.getAttribute('data-Id');
                        let citisenname = this.getAttribute('data-ctisenname');

                        const data = JSON.stringify({
                            from: authUserId,
                            to: toUserId,
                            message: "Пользователь " + authUsername + " пытался зайти на вашу запись события " + citisenname + " находящаяся под id " + citisenId
                        });

                        console.log(data);

                        const response = fetch('message', {
                            method: "POST",

                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: data
                        })

                            .then(function (response) {
                                return response.json()
                            })
                            .then(function (data) {
                                console.log('data', data)
                            })
                            .catch(function (error) {
                                console.log('error', error)
                            })
                    })
                })
            </script>

@endsection
