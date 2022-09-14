@extends('layouts.app')

@section('content')

    @foreach ($autos as $auto)
        <a href="{{route('auto.show', $auto->id)}}" class="btn btn-primary mb-2" style="margin-left: 10px">Назад</a>

        <table class="table table-hover">

            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Марка машины</th>
                <th scope="col">Регистрационый номер</th>
                <th scope="col">Имя водителя</th>
                <th scope="col">Паспорт</th>
                <th scope="col">Дата пересечения</th>
                <th scope="col">КПП</th>

            </tr>
            </thead>
            <tbody>
            <tr>
                <th scope="row">{{ $auto->id }}</th>
                <td class="col-md-3">{{ $auto->brand_avto }}</td>
                <td class="col-md-2">{{ $auto->regis_num  }}</td>
                <td class="col-md-2">{{ $auto->full_name }}</td>
                <td class="col-md-2">{{ $auto->passport }}</td>
                <td class="col-md-2">{{ $auto->crossing_date }}</td>
                <td class="col-md-2">{{ $auto->checkpoint }}</td>
            </tr>
            </tbody>

        </table>
    @endforeach

@endsection
