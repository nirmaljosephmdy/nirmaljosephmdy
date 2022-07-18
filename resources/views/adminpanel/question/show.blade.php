@extends('adminpanel.layouts.layout')

@section('contents')

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
          <h1>Questions</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('question.add')}}">Question</a></li>
            <li class="breadcrumb-item active">Show</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>



  <div class="card ml-5 mr-5">
    <div class="card-header">
      <h3 class="card-title">Question Bank</h3>
      <a href="{{route('question.add')}}"><button class="card-title float-right btn btn-primary ">Add Question</button></a>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        {{-- ------------------------------------------------------------------------------------------------------------Table --}}
      <table id="qtable" class="table table-bordered table-hover">
        <caption></caption>
        <thead>
        <tr class="bg-warning">
          <th id="">Sl</th>
          <th id="">Question</th>
          <th id="">Points</th>
          <th id="" colspan="2">Action</th>
        </tr>
        </thead>
        <tbody>

        </tbody>
      </table>
    </div>
  </div>









</div>












<script>
    const tableurl="{{route('question.datatable')}}";
</script>
<script src="{{asset('asset/js/question/datatable.js')}}"></script>




@endsection