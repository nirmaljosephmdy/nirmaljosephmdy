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
                <select name="usertype" class="custom-select form-control ">
                    <option selected disabled>Choose</option>

                  @foreach ($examType as $key=>$exam)
                  <option value="{{$exam['id']}}">{{$exam['title']}}</option>
                  @endforeach

                </select>
            </div>
          </div>





              
              

                
          <!-- /.card-body -->
          <div class="card-footer">
            <button type="submit" id="submit" class="btn btn-info">Previous</button>
            <button type="submit" id="submit" class="btn btn-info">Next</button>
            <button class="btn btn-default float-right"><a href="{{route('teacher.index')}}">Cancel</a></button>
          </div>
          </div>
          
            </form>
    </div>






















</div>
























    
@endsection