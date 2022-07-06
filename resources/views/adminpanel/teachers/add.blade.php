@extends('adminpanel/layouts/layout')

@section('contents')

@php
    $usertypes= (config('options.usertype'));
    $genders  = (config('options.gender'));
@endphp


<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Teachers</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('fetch.all')}}">Home</a></li>
                <li class="breadcrumb-item active">Add Teachers</li>
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

            <form class="form-horizontal" id="formdata" method="POST" autocomplete="off" action="javascript:void(0)" enctype="multipart/form-data">
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

                  <div class="row">

                    <div class="col-sm-6">
                      <!-- select -->
                      <div class="form-group">
                        <label>Permission</label>
                        <select name="usertype" class="custom-select">
                          <option selected>Choose</option>

                          @foreach ($usertypes as $key=> $usertype )
                          <option value="{{$key}}">{{$usertype}}</option>
                          @endforeach

                        </select>
                      </div>
                    </div>

                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Gender</label>
                        <select name="gender" class="custom-select" >
                          <option selected>Choose</option>

                          @foreach ($genders as $gender )
                          <option value="{{$gender}}">{{$gender}}</option>
                          @endforeach

                        </select>
                      </div>
                    </div>

                  </div>



                <div class="form-group row">
                  <div class="offset-sm-2 col-sm-10">
                    <div class="form-check">
                      <input type="checkbox" class="form-check-input" id="exampleCheck2">
                      <label class="form-check-label" for="exampleCheck2">Remember Me</label>
                    </div>
                  </div>
                </div>


              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <button type="submit" id="submit" class="btn btn-info">Add Staff</button>
                <button class="btn btn-default float-right"><a href="{{route('fetch.all')}}">Cancel</a></button>
              </div>
              <!-- /.card-footer -->
            </form>
          </div>
          <!-- /.card -->



        </div>












</div>










<script>
        const  addurl   = "{{route('add.staff')}}";
</script>

<script type="text/javascript" src="{{asset('asset/js/teacher/add.js')}}"></script>





@endsection