@extends('adminpanel/layouts/layout')

@section('contents')

@include('sweet::alert')

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
                <li class="breadcrumb-item"><a href="{{route('teacher.index')}}">Teachers</a></li>
                <li class="breadcrumb-item active">Edit</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>



      <div class="container">

        <div class="card card-info mt-5">
            <div class="card-header">
              <h3 class="card-title">Edit Registration Form</h3>
            </div>

            <form class="form-horizontal" method="POST" autocomplete="off" action="{{route('teacher.update',)}}" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="id" value="{{$teacherDetails->id}}">
              <div class="card-body">

                <div class="form-group row">
                  <label for="inputEmail3" class="col-sm-2 col-form-label">Name</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control"  value="{{$teacherDetails->name}}" name="name" id="name" placeholder="Name">
                    @error('name')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                </div>


                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                      <input type="email" class="form-control"  value="{{$teacherDetails->email}}" name="email" id="email" placeholder="Email">
                      @error('email')
                      <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>


                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Profile Pic</label>
                    <div class="col-sm-10">
                      <input type="file" class="form-control" value="{{$teacherDetails->profilepic}}" name="profilepic" id="profilepic">
                      @error('profilepic')
                      <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>



                  
                      <!-- select -->
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label" >Permission</label>
                        <div class="col-sm-10">
                        <select name="usertype" class="custom-select form-control ">
                          <option selected disabled>Choose</option>

                          @foreach ($usertypes as $key=> $usertype )
                          <option value="{{$key}}">{{$usertype}}</option>
                          @endforeach

                        </select>
                        @error('usertype')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    
                        <div>
                      </div>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Gender</label>
                        <div class="col-sm-10">
                        <select name="gender" class="custom-select form-control" >
                          <option selected disabled>Choose</option>

                          @foreach ($genders as $gender )
                          <option value="{{$gender}}" {{$teacherDetails->gender==$gender ? 'selected':'' }}>{{$gender}}</option>
                          @endforeach

                        </select>
                        @error('gender')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <div>
                      </div>
                        </div>
                    </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <button type="submit" id="submit" class="btn btn-info">Update</button>
                <button class="btn btn-default float-right"><a href="{{route('teacher.index')}}">Cancel</a></button>
              </div>
              <!-- /.card-footer -->
            </form>
          </div>
          <!-- /.card -->

        </div>

</div>




@endsection