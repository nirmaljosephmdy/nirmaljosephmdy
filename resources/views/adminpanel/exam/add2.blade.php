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
                        <li class="breadcrumb-item"><a href="{{route('exam.add')}}">Step 1 </a></li>
                        <li class="breadcrumb-item active">Step 2 </li>
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
                <label class="col-sm-2 col-form-label" >Choose Exam</label>
                <div class="col-sm-10">
                <select name="examtype" id="examtype" class="custom-select form-control ">
                    <option selected disabled>Choose</option>

                  @foreach ($examType as $key=>$exam)
                  <option data-href="" value="{{$exam['id']}}">{{$exam['title']}}</option>
                  @endforeach

                </select>
            </div>
          </div>


          <div class="card " id="table">
            <div class="card-header">
              <h3 class="card-title">Ques</h3>
              <a href="{{route('teacher.create')}}"><button class="card-title float-right btn btn-primary ">Add Staff</button></a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="examTable" class="table table-bordered table-hover">
                <caption></caption>
                <thead>
                <tr class="bg-warning">
                  <th id="">Sl.No</th>
                  <th id="">Questions</th>
                  <th id="">Mark</th>
                  <th id="">Question Type</th>
                  <th id="" colspan="2">Action</th>
                </tr>
                </thead>
                <tbody>
        
                </tbody>
              </table>
            </div>
          </div>





              
              

                
          <!-- /.card-body -->
          <div class="card-footer">
            <a href="{{route('exam.add')}}" class="btn btn-info"> Previous</a>
            <a href="#" class="btn btn-info"> Next</a>
            <button class="btn btn-default float-right"><a href="{{route('teacher.index')}}">Cancel</a></button>
          </div>
          </div>
          
            </form>
    </div>






</div>




<script>
   const examreg2url="{{route('exam.add3','')}}";
</script>

@push('js')
<script src="{{asset('asset/js/exam/examregister2.js')}}"></script>
@endpush


















    
@endsection