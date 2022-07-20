{{-- @dd($questions[0]['question_type']) --}}

@extends('adminpanel.layouts.layout')

@section('contents')

<div class="content-wrapper">

    
    
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Exam</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('teacher.index')}}">Exam</a></li>
                        <li class="breadcrumb-item active">Add </li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    
    
    
      <div class="card card-info mt-5 ml-5 mr-5">
        <div class="card-header">
          <h3 class="card-title">Exam Registration</h3>
        </div>

        <form class="form-horizontal" id="formdata" name="formdata" method="POST" autocomplete="off" action="javascript:void(0)">
            @csrf

          <div class="card-body">

            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-2 col-form-label">Exam Title</label> 
              <div class="col-sm-10">
                <input type="text" class="form-control" name="title" id="title" placeholder="Exam Title">
              </div>
            </div>



            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Instructions</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="rule" id="rule" placeholder="Summary">
                </div>
              </div>


              <div class="card card-default">


                <!-- /.card-header -->
                <div class="card-body">
                  <div class="row">
                    <div class="col-12">
                      <div class="form-group">
                        <label>Select Questions</label>
                        <select class="duallistbox" name="questions" id="questions" multiple="multiple">
                          @foreach ($questions as $key =>$question)

                          <option>{{$question['question']}}</option>

                          @endforeach
                          
                        </select>
                      </div>
                      <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->
                </div>
                <!-- /.card-body -->
              </div>





              
              

                
          <!-- /.card-body -->
          <div class="card-footer">
            <button type="submit" id="submit" class="btn btn-info"></button>
            <button class="btn btn-default float-right"><a href="{{route('teacher.index')}}">Cancel</a></button>
          </div>
          <!-- /.card-footer -->
        </form>
      </div>





























</div>
@push('js')
    
<script>
$('.duallistbox').bootstrapDualListbox()
</script>

@endpush

@endsection