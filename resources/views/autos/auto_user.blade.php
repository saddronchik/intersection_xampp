@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-2">
                <div class="nav flex-column nav-pills" aria-orientation="vertical">
                    <a class="btn btn-primary btn-sm mb-2 " role="button" data-bs-toggle="button"
                       href="{{ route('auto.index') }}"
                       role="button">Назад</a>
                </div>
            </div>

            <div class="col-10">
                <h1 class="display-8">Автомобили</h1>

                <form method="GET" action="{{ route('auto.search-by-user') }}">
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
                        <th scope="col">#</th>
                        <th scope="col">Марка автомобиля</th>
                        <th scope="col">Номер</th>
                        <th scope="col">Владелец</th>
                        <th scope="col">Кто заметил</th>
                        <th scope="col">Где заметил</th>
                        <th scope="col">Время обнаружения</th>
                        <th scope="col">Сделал запись пользователь</th>
                        <th scope="col">Доп. информация</th>
                    </tr>
                    </thead>

                    @foreach ($autos as $auto)
                        <tbody>
                        <tr>
                            <th scope="row">{{ $auto->id }}</th>
                            <td class="col-md-3"><a href="avto/{{$auto->id}}">{{ $auto->brand_avto }}</td>
                            <td class="col-md-3">{{ $auto->regis_num }}</td>
                            <td class="col-md-5">{{ $auto->id_citisen }}</td>
                            <td class="col-md-3">{{ $auto->who_noticed }}</td>
                            <td class="col-md-3">{{ $auto->where_notice }}</td>
                            <td class="col-md-3">{{ $auto->detection_time }}</td>
                            <td class="col-md-3">{{ $auto->user }}</td>
                            <td class="col-md-2">{{ Str::words($auto->addit_inf, 5) }}</td>
                            <td class="col-md-2"><a href="destroy/{{$auto->id}}" class="btn btn-danger btn-sm mb-2 ">Удалить</a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                </table>
                {{-- {{ $autos->appends(['s'=>request()->s])->links() }} --}}
            </div>



@endsection
