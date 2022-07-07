@extends('adminpanel/layouts/layout')

@section('contents')



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
                <li class="breadcrumb-item"><a href="#">Teachers</a></li>
                <li class="breadcrumb-item active">View</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>




{{-- ---------------------------------------------------------------------------Table-------------------------------------------------------------------- --}}


 <div class="card ml-5 mr-5">
    <div class="card-header">
      <h3 class="card-title">Staff List</h3>
      <a href="{{route('teacher.create')}}"><button class="card-title float-right btn btn-primary ">Add Staff</button></a>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <table id="example2" class="table table-bordered table-hover">
        <caption></caption>
        <thead>
        <tr class="bg-warning">
          <th id="">Name</th>
          <th id="">Email</th>
          <th id="">Permission</th>
          <th id="">Status</th>
          <th id="">Gender</th>
          <th id="" colspan="2">Action</th>
        </tr>
        </thead>
        <tbody>

        </tbody>
      </table>
    </div>
  </div>







  
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Teacher Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">



          <form class="form-horizontal" id="updatedata" method="POST" autocomplete="off" action="javascript:void(0)" enctype="multipart/form-data">
            @csrf

          <div class="card-body">

            <input type="hidden" id="id">

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
                  <span id="profile"></span>
                </div>
              </div>

              <div class="row">

                <div class="col-sm-6">
                  <!-- select -->
                  <div class="form-group">
                    <label>Permission</label>
                    <select name="usertype" id="usertype" class="custom-select">
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
                    <select name="gender" id="gender" class="custom-select" >
                      <option selected>Choose</option>

                      @foreach ($genders as $gender )
                      <option value="{{$gender}}">{{$gender}}</option>
                      @endforeach

                    </select>
                  </div>
                </div>

              </div>

          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" id="update" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>


          

<script>
    const  tableurl ="{{route('teacher.datatable')}}";
</script>
<script type="text/javascript" src="{{asset('asset/js/teacher/add.js')}}"></script>
<script type="text/javascript" src="{{asset('asset/js/teacher/editUpdate.js')}}"></script>
















@endsection


