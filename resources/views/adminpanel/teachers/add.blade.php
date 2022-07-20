@extends('adminpanel/layouts/layout')

@section('contents')
<style>

/* Styles */

body {
  font-family: "Open Sans";
  font-size: 14px;
  
}


form {
  background: #2c3e50;
  color: #fff;
  -moz-border-radius: 4px;
  -webkit-border-radius: 4px;
  border-radius: 4px;
}
form label,
form input,
form button {
  border: 0;

  display: block;
  width: 100%;
}
form input {
  height: 25px;
  line-height: 25px;
  background: #fff;
  color: #000;
  padding: 0 6px;
  -moz-box-sizing: border-box;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
}
form button {
  height: 30px;
  line-height: 30px;
  background: #e67e22;
  color: #fff;
  margin-top: 10px;
  cursor: pointer;
}
form .error {
  color: #ff0000;
}

</style>

@php
    $usertypes= (config('options.usertype'));
    $genders  = (config('options.gender'));
@endphp

@include('sweet::alert')

@if (Session::has('sweet_alert.alert'))
<script>
  swal({!! Session::get('sweet_alert.alert') !!});
</script>
@endif

<div class="content-wrapper">
  

    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Teachers</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('teacher.index')}}">Teachers</a></li>
                <li class="breadcrumb-item active">Add </li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>



      <div class="container">

        <div class="card card-info mt-5">
            <div class="card-header">
              <h3 class="card-title">Teachers Registration Form</h3>
            </div>

            <form class="form-horizontal" id="formdata" name="formdata" method="POST" autocomplete="off" action="javascript:void(0)" enctype="multipart/form-data">
                @csrf

              <div class="card-body">

                <div class="form-group row">
                  <label for="inputEmail3" class="col-sm-2 col-form-label">Name</label> 
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="name" id="name" placeholder="Name">
                  </div>
                </div>



                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                      <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                    </div>
                  </div>


                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Profile Pic</label>
                    <div class="col-sm-10">
                      <input type="file" class="form-control" name="profilepic" id="profilepic">
                    </div>
                  </div>



                  
                      <!-- select -->
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label" >Permission</label>
                        <div class="col-sm-10">
                        <select name="usertype" class="custom-select form-control ">
                          <option selected>Choose</option>

                          @foreach ($usertypes as $key=> $usertype )
                          <option value="{{$key}}">{{$usertype}}</option>
                          @endforeach

                        </select>
                        <div>
                      </div>
                    </div>
                  </div>
                  

                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Gender</label>
                        <div class="col-sm-10">
                        <select name="gender" class="custom-select form-control" >
                          <option selected>Choose</option>

                          @foreach ($genders as $gender )
                          <option value="{{$gender}}">{{$gender}}</option>
                          @endforeach

                        </select>

                      </div>
                    </div>

              <!-- /.card-body -->
              <div class="card-footer">
                <button type="submit" id="submit" class="btn btn-info">Submit</button>
                <button class="btn btn-default float-right"><a href="{{route('teacher.index')}}">Cancel</a></button>
              </div>
              <!-- /.card-footer -->
            </form>
          </div>
          <!-- /.card -->

        </div>

</div>


@endsection
@push('js')

<script>
  const  addurl   = "{{route('teacher.store')}}";
</script>

<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script type="text/javascript" src="{{asset('asset/js/teacher/add.js')}}"></script>

@endpush