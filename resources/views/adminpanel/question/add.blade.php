@extends('adminpanel.layouts.layout')

@section('contents')

@php
    $Qtypes=(config('options.QType'))
@endphp

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
        <!-- form start -->
        <form autocomplete="off">
          <div class="card-body">


            <div class="form-group">
                <label>Question Type</label>
                <select class="form-control select2" id="type" style="width: 100%;">

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
                        <input class="custom-control-input custom-control-input-danger custom-control-input-outline" type="radio" id="Radio1" name="customRadio2">
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
                        <input class="custom-control-input custom-control-input-danger custom-control-input-outline" type="radio" id="Radio2" name="customRadio2">
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
                        <input class="custom-control-input custom-control-input-danger custom-control-input-outline" type="radio" id="Radio3" name="customRadio2">
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
                        <input class="custom-control-input custom-control-input-danger custom-control-input-outline" type="radio" id="Radio4" name="customRadio2">
                        <label for="Radio4" class="custom-control-label">Is_Answer</label>
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
            <textarea class="form-control" name="question" id="question" rows="1" placeholder="Enter Question"></textarea>
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
                  <input type="file" id="optiona" name="optiona" class=" form-control">
                </div>
            </div>
          </div>
        </div>

        <div class="col-sm-5">
        <div class="custom-control custom-radio float-right">
            <input class="custom-control-input custom-control-input-danger custom-control-input-outline" type="radio" id="type1" name="Radio2">
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
                  <input type="file" id="optionb" name="optionb" class=" form-control">
                </div>
            </div>
          </div>
        </div>

        <div class="col-sm-5">
        <div class="custom-control custom-radio float-right">
            <input class="custom-control-input custom-control-input-danger custom-control-input-outline" type="radio" id="type2" name="Radio2">
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
                  <input type="file" id="optionc" name="optionc" class=" form-control">
                </div>
            </div>
          </div>
        </div>

        <div class="col-sm-5">
        <div class="custom-control custom-radio float-right">
            <input class="custom-control-input custom-control-input-danger custom-control-input-outline" type="radio" id="type3" name="Radio2">
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
                  <input type="file" id="optiond" name="optiond" class=" form-control">
                </div>
            </div>
          </div>
        </div>

        <div class="col-sm-5">
        <div class="custom-control custom-radio float-right">
            <input class="custom-control-input custom-control-input-danger custom-control-input-outline" type="radio" id="type4" name="Radio2">
            <label for="type4" class="custom-control-label">Is_Answer</label>
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
            <textarea class="form-control" rows="1" placeholder="Enter Question"></textarea>
          </div>
        </div>

        <div class="custom-file col-sm-5">
          <div class="form-group">
            <label><span></span></label>
              <input type="file" class=" form-control">
            </div>
        </div>
      </div>


      <div class="row">
        <div class="col-sm-7">
          <!-- textarea -->
          <div class="form-group">
            <label>Option 1</label>
            <input type="text" class="form-control" rows="1" placeholder="Enter ...">
          </div>
        </div>

        <div class="col-sm-5">
        <div class="custom-control custom-radio float-right">
            <input class="custom-control-input custom-control-input-danger custom-control-input-outline" type="radio" id="Radiotype1" name="customRadio3">
            <label for="Radiotype1" class="custom-control-label">Is_Answer</label>
          </div>
      </div>
      </div>



      <div class="row">
        <div class="col-sm-7">
          <!-- textarea -->
          <div class="form-group">
            <label>Option 2</label>
            <input type="text" class="form-control" rows="1" placeholder="Enter ...">
          </div>
        </div>

        <div class="col-sm-5">
        <div class="custom-control custom-radio float-right">
            <input class="custom-control-input custom-control-input-danger custom-control-input-outline" type="radio" id="Radiotype2" name="customRadio3">
            <label for="Radiotype2" class="custom-control-label">Is_Answer</label>
          </div>
      </div>
      </div>



      <div class="row">
        <div class="col-sm-7">
          <!-- textarea -->
          <div class="form-group">
            <label>Option 3</label>
            <input type="text" class="form-control" rows="1" placeholder="Enter ...">
          </div>
        </div>

        <div class="col-sm-5">
        <div class="custom-control custom-radio float-right">
            <input class="custom-control-input custom-control-input-danger custom-control-input-outline" type="radio" id="Radiotype3" name="customRadio3">
            <label for="Radiotype3" class="custom-control-label">Is_Answer</label>
          </div>
      </div>
      </div>




      <div class="row">
        <div class="col-sm-7">
          <!-- textarea -->
          <div class="form-group">
            <label>Option 4</label>
            <input type="text" class="form-control" rows="1" placeholder="Enter ...">
          </div>
        </div>

        <div class="col-sm-5">
        <div class="custom-control custom-radio float-right">
            <input class="custom-control-input custom-control-input-danger custom-control-input-outline" type="radio" id="Radiotype4" name="customRadio3">
            <label for="Radiotype4" class="custom-control-label">Is_Answer</label>
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