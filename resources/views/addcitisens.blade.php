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
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
      @endif
    <form method="POST" action="citisens" enctype="multipart/form-data"  id="citisAdd" >
      
        @csrf
        <div class="form-group">
          <label for="full_name">ФИО</label>
          <input type="text" class="typeahead form-control" name="full_name" id="full_name">
        </div>
        <div class="form-group">
          <label for="passport_data">Пасспортные данные</label>
          <div id="passport_data"> <input type="text" class="form-control" name="passport_data" id="passport_data" > </div>
          <input class="btn btn-primary btn-sm mt-2" type="button" value="+" id="addInputsPass" />
        </div>
        <div class="form-group">
          <label for="date_birth">Дата рождения</label>
          <input type="date" class="form-control" name="date_birth" id="date_birth" >
        </div>
        <div class="form-group">
          <label for="photo">Фото</label>
          <input type="file" class="form-control" name="photo" id="photo" aria-describedby="emailHelp" >
          {{-- accept=".jpg" --}}
        </div>
        <div class="form-group">
          <label for="place_registration">Место регистрации</label>
          <input type="text" class="form-control" name="place_registration" id="place_registration" >
        </div>
        <div class="form-group">
          <label for="place_residence">Место жительства</label>
          <input type="text" class="form-control" name="place_residence" id="place_residence" >
        </div>
        <div class="form-group">
          <label for="phone_number">Телефонный номер</label>
          <div id="phone_number"><input type="number" class="form-control" name="phone_number" id="phone_number" ></div>
          <input class="btn btn-primary btn-sm mt-2" type="button" value="+" id="addInputsPhone" />
        </div>
        
        <div class="form-group" >
          <label for="social_account">Соц аккаунт</label>
          <div id="social_account"> <input type="text" class="form-control" name="social_account" id="social_account"></div>
          <input class="btn btn-primary btn-sm mt-2" type="button" value="+" id="addInputs" />
        </div>


        <div class="form-group">
          <label for="addit_inf">Доп информация</label>         
          <textarea class="form-control" name="addit_inf" id="addit_inf" rows="3"></textarea>
        </div>
        <div class="form-group">
          <label for="who_noticed">Кто заметил</label>         
          {{-- <input type="text" class="form-control" name="who_noticed" id="who_noticed"> --}}
          <select name="who_noticed" id="who_noticed"  class="selectpicker" data-style="btn-info" data-live-search="true">
            <option data-tokens="ketchup mustard" data-style="btn-info" value="Не определенно" >Выберите человека</option>
            @foreach($peoples as $people)
            <option name="who_noticed" id="who_noticed"  value="{{$people->full_name}}" data-subtext="{{$people->id}}" >{{$people->full_name}} </option>
              @endforeach
          </select>

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

          <div class="form-group" style="width:200px; height:100px; overflow:auto; border:solid 1px #C3E4FE;">
            <fieldset id="shest">
              <label><input type="checkbox" id="checkall"> Выбрать всех</label>
              
            @foreach ( $users as $user)
            <li class="list-group-item"><input type="checkbox" class="thing" name="user[]" id="user" value="{{ $user->id}}" >{{' '.$user->username }}</li>
            @endforeach
          </fieldset>
        </div>


        <div class="alert alert-success messages" role="alert" style="display: none"></div>
        <button type="submit" class="btn btn-primary" id="add-citizen">Добавить запись</button>
      </form>
      
</div>

<script>
   const formUpdate = document.getElementById('citisAdd');
   const messageBlock = document.querySelector('.messages');

      // formUpdate.addEventListener('submit' , function(e){
      //     e.preventDefault();
      //     const formData = new FormData(this);
      //     const checkbox = document.querySelectorAll('.thing');
      //     let validateCHeckbox = false;

      //       for (let i =0; i < checkbox.length; i++) {
      //           if (checkbox[i].checked) {
      //               validateCHeckbox = true;
      //               break;}
      //               }

      //           if (!validateCHeckbox) {
      //             alert('Выберите хотя бы один доступ к просмотру записи!');
      //             return;}

      //       // fetch('/citisens', {
      //       //       method: "POST",
      //       //       headers: {"X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')},
      //       //       body: formData })
      //       //             .then(function(response) {
      //       //                 if (response.status == 200) {
      //       //                     messageBlock.textContent = 'Данные успешно добавленны!';
      //       //                     messageBlock.style.display = 'block';
      //       //                 }
      //       //                 if (response.status == 403) {
      //       //                       messageBlock.textContent = 'Ошибка доступа!';
      //       //                       messageBlock.style.display = 'block';
      //       //                   }
      //       //                 console.log(response)
      //       //                return response.text();
      //       //             })
      //       //             .then(function(text)  {
      //       //                 console.log('Success ' + text);
      //       //             }).catch(function(error){
      //       //                 console.error(error);
      //       //             })
      //           });

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
               
    let nameCounter = 1;
    $('#addInputs').click(function() {
    
        if (nameCounter < 5) {
          $('#social_account').append(`<input type="text" class="form-control" name="social_account${nameCounter++}" id="social_account${nameCounter++}" />`);
        } else {
          return;
        }
      });
    let namePhone= 1;
    $('#addInputsPhone').click(function() {
    
        if (namePhone < 3) {
          $('#phone_number').append(`<input type="text" class="form-control" name="phone_number${namePhone++}" id="phone_number" />`);
        } else {
          return;
        }
      });
                let namePass= 1;
    $('#addInputsPass').click(function() {
    
        if (namePass < 3) {
          $('#passport_data').append(`<input type="text" class="form-control" name="passport_data${namePass++}" id="passport_data" />`);
        } else {
          return;
        }
      });

</script>

                

@endsection
