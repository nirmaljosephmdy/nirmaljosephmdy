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

        
        <div class="card-body">
            <form class="form-horizontal" enctype="multipart/form-data" name="confirm" id="confirm" method="POST" autocomplete="off" action="javascript:void(0)">
                @csrf








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
                    <label for="QImage" class="form-label">Upload Ouestion</label>
                    <input class="form-control" type="file" name="QImage" id="QImage">
                  </div>

                  <div class="row">

                  <div class="col-sm-6 mb-2">
                  <img src='' id="questionImage" name="questionImage" width="180px;" height="120" class="mt-2  mb-4" alt="QuestionImg">
                </div>

                <div class="col-sm-6 mb-2">
                  <img id="preview-image-before-upload" src="https://www.riobeauty.co.uk/images/product_image_not_found.gif" alt="preview image" width="180px;" height="120">
                </div>
              </div>
          
          
          
                  <div class="row">
          
                  <div class="col-sm-8 mb-3">
                    <label for="OptA" class="form-label">Option 1</label>
                    <input type="text" class="form-control" name="OptA" id="OptA_0">
                  </div>
          
                  <div class="col-sm-4">
                    <div class="custom-control custom-radio float-right">
                        <input class="custom-control-input custom-control-input-danger custom-control-input-outline customRadio2" value="1"  type="radio" id="Radio1" name="customRadio2">
                        <label for="Radio1" class="custom-control-label">Is_Answer</label>
                      </div>
                  </div>
          
                </div>
          
          
          
          
                <div class="row">
          
                  <div class="col-sm-8 mb-3">
                    <label for="OptB" class="form-label">Option 2</label>
                    <input type="text" class="form-control" name="OptB" id="OptB_1">
                  </div>
          
                  <div class="col-sm-4">
                    <div class="custom-control custom-radio float-right">
                        <input class="custom-control-input custom-control-input-danger custom-control-input-outline customRadio2" value="2"  type="radio" id="Radio2" name="customRadio2">
                        <label for="Radio2" class="custom-control-label">Is_Answer</label>
                      </div>
                  </div>
          
                </div>
          
          
          
          
                <div class="row">
          
                  <div class="col-sm-8 mb-3">
                    <label for="OptC" class="form-label">Option 3</label>
                    <input type="text" class="form-control" name="OptC" id="OptC_2">
                  </div>
          
                  <div class="col-sm-4">
                    <div class="custom-control custom-radio float-right">
                        <input class="custom-control-input custom-control-input-danger custom-control-input-outline customRadio2" value="3"  type="radio" id="Radio3" name="customRadio2">
                        <label for="Radio3" class="custom-control-label">Is_Answer</label>
                      </div>
                  </div>
          
                </div>
          
          
                <div class="row">
          
                  <div class="col-sm-8 mb-3">
                    <label for="OptD" class="form-label">Option 4</label>
                    <input type="text" class="form-control" name="OptD" id="OptD_3">
                  </div>
          
                  <div class="col-sm-4">
                    <div class="custom-control custom-radio float-right">
                        <input class="custom-control-input custom-control-input-danger custom-control-input-outline customRadio2" value="4"  type="radio" id="Radio4" name="customRadio2">
                        <label for="Radio4" class="custom-control-label">Is_Answer</label>
                      </div>
                  </div>
          
                </div>
          
          
                </div>
          
                {{-- --------------------------------------------------------------------------------------------------------------body --}}
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" id="modalsubmit" class="btn btn-warning">Confirm</button>
                </div>
              </div>
            </div>
          </div>

        </form>
















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
          
            
    </div>








<!-- Modal -->
{{-- <form action="javascript:void(0)" method="POST" enctype="multipart/form-data" name="confirm" id="confirm"> --}}

{{-- </form> --}}
















</div>




<script>
   const examreg2url="{{route('exam.add3','')}}";
   const editurl="{{route('exam.edit','')}}";
   const updateurl="{{route('exam.update')}}";

      
      $(document).ready(function (e) {
       
         
         $('#QImage').change(function(){
                  
          let reader = new FileReader();
       
          reader.onload = (e) => { 
       
            $('#preview-image-before-upload').attr('src', e.target.result); 
          }
       
          reader.readAsDataURL(this.files[0]); 
         
         });
         
      });
       
</script>

@push('js')

<script src="{{asset('asset/js/exam/update.js')}}"></script>
<script src="{{asset('asset/js/exam/examregister2.js')}}"></script>
<script src="{{asset('asset/js/exam/modalAddEdit.js')}}"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
@endpush


















    
@endsection