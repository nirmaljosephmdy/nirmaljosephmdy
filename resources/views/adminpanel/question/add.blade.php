@extends('adminpanel.layouts.layout')

@section('contents')
<style>
  body {
  font-family: "Open Sans";
  font-size: 14px;
}


</style>

@php
    $Qtypes=(config('options.QType'))
@endphp

@if (Session::has('sweet_alert.alert'))
<script>
  swal({!! Session::get('sweet_alert.alert') !!});
</script>
@endif

<div class="content-wrapper">

  
<!-- form start -->
<form id="formdata" autocomplete="off">
  @csrf
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Questions</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('question.show')}}">Question</a></li>
                <li class="breadcrumb-item active">Add</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>


      <div class="container">
          <!-- left column -->


      <div class="card card-info">
        <div class="card-header">
          <h3 class="card-title">Question Type</h3>
        </div>
        <!-- /.card-header -->
        
          <div class="card-body">


            <div class="form-group">
                <label>Question Type</label>
                <select class="form-control select2" name="type" id="type" style="width: 100%;">

                  @foreach ($Qtypes as $key=> $Qtype )
                  <option value="{{$key}}">{{$Qtype}}</option>
                  @endforeach

                </select>
              </div>
            </div>
        </div>





              {{-- -=-------------------------------------------------------------------------------Qt At------------------------------------------------ --}}
              <div class="card card-warning mt-5">
                <div class="card-header">
                  <h3 class="card-title">Add Question</h3>
                </div>
                <div class="card-body">


              <div id="0">


                <div class="row">
                    <div class="col-sm-12">
                      <!-- textarea -->
                      <div class="form-group">
                        <label>Question</label>
                        <textarea class="form-control" name="question" id="question" rows="1" placeholder="Enter Question"></textarea>
                      </div>

                      @error('question')
                      <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                  @enderror
                    </div>
                  </div>





                  <div class="row">
                    <div class="col-sm-7">
                      <!-- textarea -->
                      <div class="form-group">
                        <label>Option 1</label>
                        <textarea class="form-control" name="optiona" id="optiona" rows="1" placeholder="Option 1"></textarea>
                      </div>
                    </div>

                    <div class="col-sm-5">
                    <div class="custom-control custom-radio float-right">
                        <input class="custom-control-input custom-control-input-danger custom-control-input-outline" value="1"  type="radio" id="Radio1" name="customRadio2">
                        <label for="Radio1" class="custom-control-label">Is_Answer</label>
                      </div>
                  </div>
                  </div>




                  <div class="row">
                    <div class="col-sm-7">
                      <!-- textarea -->
                      <div class="form-group">
                        <label>Option 2</label>
                        <textarea class="form-control" name="optionb" id="optionb" rows="1" placeholder="Option 2"></textarea>
                      </div>
                    </div>

                    <div class="col-sm-5">
                    <div class="custom-control custom-radio float-right">
                        <input class="custom-control-input custom-control-input-danger custom-control-input-outline" value="2"  type="radio" id="Radio2" name="customRadio2">
                        <label for="Radio2" class="custom-control-label">Is_Answer</label>
                      </div>
                  </div>
                  </div>




                  <div class="row">
                    <div class="col-sm-7">
                      <!-- textarea -->
                      <div class="form-group">
                        <label>Option 3</label>
                        <textarea class="form-control" name="optionc" id="optionc" rows="1" placeholder="Option 3"></textarea>
                      </div>
                    </div>

                    <div class="col-sm-5">
                    <div class="custom-control custom-radio float-right">
                        <input class="custom-control-input custom-control-input-danger custom-control-input-outline" value="3" type="radio" id="Radio3" name="customRadio2">
                        <label for="Radio3" class="custom-control-label">Is_Answer</label>
                      </div>
                  </div>
                  </div>




                  <div class="row">
                    <div class="col-sm-7">
                      <!-- textarea -->
                      <div class="form-group">
                        <label>Option 4</label>
                        <textarea class="form-control" name="optiond" id="optiond" rows="1" placeholder="Option 4"></textarea>
                      </div>
                    </div>

                    <div class="col-sm-5">
                    <div class="custom-control custom-radio float-right">
                        <input class="custom-control-input custom-control-input-danger custom-control-input-outline" value="4" type="radio"  id="Radio4" name="customRadio2">
                        <label for="Radio4" class="custom-control-label">Is_Answer</label>
                      </div>
                  </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-3">
                  <div class="form-group">
                    <label class="col-form-label" for="inputWarning">Maximum Marks</label>
                    <input type="text" class="form-control is-warning" id="points" placeholder="Enter Mark">
                  </div>
                </div>
                </div>
                  

              </div>

{{-- ------------------------------------------------------------------------------------------------End Qt At-------------------------------------------------- --}}




{{-- ----------------------------------------------------------------------------------------------------Start Qt AI-------------------------------------------- --}}



<div id="1">


    <div class="row">
        <div class="col-sm-12">
          <!-- textarea -->
          <div class="form-group">
            <label>Question</label>
            <textarea class="form-control" name="questionn" id="questionn" rows="1" placeholder="Enter Question"></textarea>
          </div>
        </div>
      </div>



      <div class="row">
        <div class="col-sm-7">
          <!-- textarea -->
          <div class="form-group">
            <label>Option 1</label>
            <div class="custom-file col-sm-7">
              <div class="form-group">
                  <input type="file" id="opta" name="opta" class=" form-control">
                </div>
            </div>
          </div>
        </div>

        <div class="col-sm-5">
        <div class="custom-control custom-radio float-right">
            <input class="custom-control-input custom-control-input-danger custom-control-input-outline" value="1" type="radio" id="type1" name="Radio2">
            <label for="type1" class="custom-control-label">Is_Answer</label>
          </div>
      </div>
      </div>



      <div class="row">
        <div class="col-sm-7">
          <!-- textarea -->
          <div class="form-group">
            <label>Option 2</label>
            <div class="custom-file col-sm-7">
              <div class="form-group">
                  <input type="file" id="optb" name="optb" class=" form-control">
                </div>
            </div>
          </div>
        </div>

        <div class="col-sm-5">
        <div class="custom-control custom-radio float-right">
            <input class="custom-control-input custom-control-input-danger custom-control-input-outline" value="2" type="radio" id="type2" name="Radio2">
            <label for="type2" class="custom-control-label">Is_Answer</label>
          </div>
      </div>
      </div>


      <div class="row">
        <div class="col-sm-7">
          <!-- textarea -->
          <div class="form-group">
            <label>Option 3</label>
            <div class="custom-file col-sm-7">
              <div class="form-group">
                  <input type="file" id="optc" name="optc" class=" form-control">
                </div>
            </div>
          </div>
        </div>

        <div class="col-sm-5">
        <div class="custom-control custom-radio float-right">
            <input class="custom-control-input custom-control-input-danger custom-control-input-outline" value="3" type="radio" id="type3" name="Radio2">
            <label for="type3" class="custom-control-label">Is_Answer</label>
          </div>
      </div>
      </div>



      <div class="row">
        <div class="col-sm-7">
          <!-- textarea -->
          <div class="form-group">
            <label>Option 4</label>
            <div class="custom-file col-sm-7">
              <div class="form-group">
                  <input type="file" id="optd" name="optd" class=" form-control">
                </div>
            </div>
          </div>
        </div>

        <div class="col-sm-5">
        <div class="custom-control custom-radio float-right">
            <input class="custom-control-input custom-control-input-danger custom-control-input-outline" value="4" type="radio" id="type4" name="Radio2">
            <label for="type4" class="custom-control-label">Is_Answer</label>
          </div>
      </div>
      </div>

      <div class="row">
        <div class="col-sm-3">
      <div class="form-group">
        <label class="col-form-label" for="inputWarning">Maximum Marks</label>
        <input type="text" class="form-control is-warning" id="points2" name="points2" placeholder="Enter Mark">
      </div>
    </div>
    </div>

</div>
{{-- ---------------------------------------------------------------End---------------------------------------------------------------------------- --}}




{{-- ---------------------------------------------------------------QT$I AI---------------------------------------------------------------------------- --}}

<div id="2">


    <div class="row">
        <div class="col-sm-7">
          <!-- textarea -->
          <div class="form-group">
            <label>Question</label>
            <textarea class="form-control" id="questionnn" name="questionnn" rows="1" placeholder="Enter Question"></textarea>
          </div>
        </div>

        <div class="custom-file col-sm-5">
          <div class="form-group">
            <label><span></span></label>
              <input type="file" id="qimage" name="qimage" class=" form-control">
            </div>
        </div>
      </div>


      <div class="row">
        <div class="col-sm-7">
          <!-- textarea -->
          <div class="form-group">
            <label>Option 1</label>
            <input type="text" class="form-control" id="optionna" name="optionna" rows="1" placeholder="Enter Question">
          </div>
        </div>

        <div class="col-sm-5">
        <div class="custom-control custom-radio float-right">
            <input class="custom-control-input custom-control-input-danger custom-control-input-outline" type="radio" id="Radiotype1" value="1" name="customRadio3">
            <label for="Radiotype1" class="custom-control-label">Is_Answer</label>
          </div>
      </div>
      </div>



      <div class="row">
        <div class="col-sm-7">
          <!-- textarea -->
          <div class="form-group">
            <label>Option 2</label>
            <input type="text" class="form-control" name="optionnb" id="optionnb" rows="1" placeholder="Enter ...">
          </div>
        </div>

        <div class="col-sm-5">
        <div class="custom-control custom-radio float-right">
            <input class="custom-control-input custom-control-input-danger custom-control-input-outline" type="radio" id="Radiotype2" value="2" name="customRadio3">
            <label for="Radiotype2" class="custom-control-label">Is_Answer</label>
          </div>
      </div>
      </div>



      <div class="row">
        <div class="col-sm-7">
          <!-- textarea -->
          <div class="form-group">
            <label>Option 3</label>
            <input type="text" class="form-control" rows="1" name="optionnc" id="optionnc" placeholder="Enter ...">
          </div>
        </div>

        <div class="col-sm-5">
        <div class="custom-control custom-radio float-right">
            <input class="custom-control-input custom-control-input-danger custom-control-input-outline" type="radio" id="Radiotype3" value="3" name="customRadio3">
            <label for="Radiotype3" class="custom-control-label">Is_Answer</label>
          </div>
      </div>
      </div>




      <div class="row">
        <div class="col-sm-7">
          <!-- textarea -->
          <div class="form-group">
            <label>Option 4</label>
            <input type="text" class="form-control" rows="1" name="optionnd" id="optionnd" placeholder="Enter ...">
          </div>
        </div>

        <div class="col-sm-5">
        <div class="custom-control custom-radio float-right">
            <input class="custom-control-input custom-control-input-danger custom-control-input-outline" type="radio" id="Radiotype4" value="4" name="customRadio3">
            <label for="Radiotype4" class="custom-control-label">Is_Answer</label>
          </div>
      </div>
      </div>


      <div class="row">
        <div class="col-sm-3">
      <div class="form-group">
        <label class="col-form-label" for="inputWarning">Maximum Marks</label>
        <input type="text" class="form-control is-warning" name="points3" id="points3" placeholder="Enter Mark">
      </div>
    </div>
    </div>





</div>



                </div>

              </div>



          <div class="card-footer">
            <button type="submit" id="submit" class="btn btn-info">Submit</button>
          </div>
        </form>
      
      <!-- /.card -->
      </div>



</div>



<script>
  const questionurl="{{route('question.store')}}";
</script>

<script type="text/javascript" src="{{asset('asset/js/question/typeOption.js')}}"></script>





























@endsection