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
















{{-- --------------------------------------------------------------------------------------------------------------------------------------------dataTable --}}
          <div class="card " id="table">
            <div class="card-header">
              <h3 class="card-title">Add Questions</h3>
              <a href="{{route('exam.add')}}" class="card-title float-right btn btn-primary">Add Exam</a>
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
                  <th id="">Action</th>
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








<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header btn btn-info">
        <h5 class="modal-title" id="exampleModalLabel">Confirm Question</h5>
        <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="row">

        <div class="col-sm-8 mb-3">
          <label for="exampleFormControlInput1" class="form-label">Question</label>
          <input type="text" class="form-control" name="exampleFormControlInput1" id="exampleFormControlInput1">
        </div>

        <div class="col-sm-4 mb-3">
          <label for="exampleFormControlInput2" class="form-label">Mark</label>
          <input type="number" class="form-control is-warning" name="exampleFormControlInput2" id="exampleFormControlInput2">
        </div>

      </div>
{{-- -------------------------------------------------------------------------------------------------------------------------------------QuestionType2 --}}
      <div id="type2">

        <div class="mb-3">
          <label for="formFileMultiple" class="form-label">Upload Ouestion</label>
          <input class="form-control" type="file" name="formFile" id="formFile">
        </div>
        <img src='' id="questionImage" width="180px;" height="120" class="mt-2  mb-3" alt="QuestionImg">


      </div>


      {{-- --------------------------------------------------------------------------------------------------------------body --}}

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-warning">Confirm</button>
      </div>
    </div>
  </div>
</div>
















</div>




<script>
   const examreg2url="{{route('exam.add3','')}}";
   const editurl="{{route('exam.edit','')}}";
</script>

@push('js')
<script src="{{asset('asset/js/exam/examregister2.js')}}"></script>
<script src="{{asset('asset/js/exam/modalAddEdit.js')}}"></script>
@endpush


















    
@endsection