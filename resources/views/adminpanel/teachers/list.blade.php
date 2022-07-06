@extends('adminpanel/layouts/layout')

@section('contents')



<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Teachers</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Teachers</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>




{{-- ---------------------------------------------------------------------------Table-------------------------------------------------------------------- --}}


 <div class="card ml-5 mr-5">
    <div class="card-header">
      <h3 class="card-title">Staff List</h3>
      <a href="{{route('staff.form')}}"><button class="card-title float-right btn btn-primary ">Add Staff</button></a>
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




            {{-- <script>
              $(document).ready(function(){
                $('#addstaff').click(function(e){

                  e.preventDefault();

                  $.ajax({

                    type    : 'GET',
                    url     : "{{route('staff.form')}}",
                    success : function(response){

                      console.log("Success");
                    }

                  });
                });



              });
            </script> --}}












<script>
    const  tableurl ="{{route('staff.datatable')}}";
</script>
<script type="text/javascript" src="{{asset('asset/js/teacher/add.js')}}"></script>




@endsection








@push('addTeachersFormScript')




@endpush
