@extends('adminpanel.layouts.layout')

@php
    $Qtypes=(config('options.QType'))
@endphp

@section('contents')

<style>

select[readonly]
{
    pointer-events: none;
}

</style>

<div class="content-wrapper">

<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Questions</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('question.show')}}">Question</a></li>
            <li class="breadcrumb-item active">Edit</li>
          </ol>
        </div>
      </div>
    </div>
  </section>


  <div class="container">
    <form id="formdata" autocomplete="off">

    <div class="card card-info">
        <div class="card-header">
          <h3 class="card-title">Question Type</h3>
        </div>
        <!-- /.card-header -->
        
          <div class="card-body">

                @csrf
            <div class="form-group">
                <label>Question Type</label>
                <input type="hidden" name="id" value="{{$QuestionDetails['id']}}">
                <select class="form-control select2" name="type" id="type" style="width: 100%;" readonly >

                  @foreach ($Qtypes as $key=> $Qtype )
                  <option value="{{$key}}" {{$QuestionDetails->question_type==$key ? 'selected' : '' }}>{{$Qtype}}</option>
                  @endforeach

                </select>
              </div>
            </div>
        </div>



        {{-- --------------------------------------------------------------------------------------------Form----------------------------- --}}


  
  
  
  
  
  
                {{-- -=-------------------------------------------------------------------------------Qt At------------------------------------------------ --}}
                <div class="card card-warning mt-5">
                  <div class="card-header">
                    <h3 class="card-title">Edit Question</h3>
                  </div>
                  <div class="card-body">
  
  
                    @if ($QuestionDetails['question_type']==0)



                    <div id="0">
  
  
                      <div class="row">
                          <div class="col-sm-12">
                            <!-- textarea -->
                            <div class="form-group">
                              <label>Question</label>
                              <textarea class="form-control" name="question" id="question" rows="1" placeholder="Enter Question">{{$QuestionDetails->question}} </textarea>
                            </div>
      
                            @error('question')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            
                        @enderror
                          </div>
                        </div>
      
      
      @foreach ($QuestionDetails->answer_options as $key=>$option )
    
      <div class="row">
        <div class="col-sm-7">
          <!-- textarea -->
          <div class="form-group">
            <label>Option {{$loop->iteration}}</label>
            <textarea class="form-control" name="option{{$key}}" id="option{{$key}}" rows="1">{{$option['Opt'.chr(64+ $loop->iteration)]}}</textarea>
          </div>
        </div>
    
         <div class="col-sm-5">
        <div class="custom-control custom-radio float-right">
          <input type="radio" name="customRadio2" id="Radio2{{$key}}"  value="{{$loop->iteration}}" {{ $option['is_answer'] == true ? 'checked' : ''}}>
            {{-- <input class="custom-control-input custom-control-input-danger custom-control-input-outline" value="{{$loop->iteration}}" {{ $option['is_answer'] == true ? 'checked' : ''}}  type="radio" id="Radio{{$key}}" name="customRadio2"> --}}
            <label for="Radio2{{$key}}" class="">Is_Answer</label>
          </div>
      </div> 
      </div>
      
    
      @endforeach

      <div class="row">
        <div class="col-sm-3">
      <div class="form-group">
        <label class="col-form-label" for="inputWarning">Maximum Marks</label>
        <input type="text" value="{{$QuestionDetails['points']}}" class="form-control is-warning" name="points3" id="points3" placeholder="Enter Mark">
      </div>
    </div>
    </div>
                    </div>
                        
                    @endif





  {{-- ------------------------------------------------------------------------------------------------End Qt At-------------------------------------------------- --}}
  
  
  
  {{-- ----------------------------------------------------------------------------------------------------Start Qt AI-------------------------------------------- --}}
  
@if ($QuestionDetails['question_type']==1)

<div id="1">
  
  
  <div class="row">
      <div class="col-sm-12">
        <!-- textarea -->
        <div class="form-group">
          <label>Question</label>
          <textarea class="form-control" name="questionn" id="questionn" rows="1" placeholder="Enter Question">{{$QuestionDetails['question']}}</textarea>
        </div>
      </div>
    </div>



    @foreach ($QuestionDetails->answer_options as $key=> $options )

    <div class="row">
      <div class="col-sm-7">
        <!-- textarea -->
        <div class="form-group">
          <label>Option 1</label>
          <div class="custom-file col-sm-7">
            <div class="form-group">
                <input type="file" id="opta{{$key}}" name="opta{{$key}}" class=" form-control">
                <caption>{{$options['Opt'.chr(64+ $loop->iteration)]}}</caption>
              </div>
          </div>
        </div>
      </div>

      <div class="col-sm-5">
      <div class="custom-control custom-radio float-right">
          <input class="custom-control-input custom-control-input-danger custom-control-input-outline" value="{{$loop->iteration}}" {{$options['is_answer']==true ? 'checked' : ''}} type="radio" id="radi{{$key}}" name="Radio2">
          <label for="radi{{$key}}" class="custom-control-label">Is_Answer</label>
        </div>
    </div>
    </div>
      
    @endforeach

   


    

    <div class="row">
      <div class="col-sm-3">
    <div class="form-group">
      <label class="col-form-label" for="inputWarning">Maximum Marks</label>
      <input type="text" class="form-control is-warning" value="{{$QuestionDetails['points']}}" id="points2" name="points2" placeholder="Enter Mark">
    </div>
  </div>
  </div>

</div>


  
@endif
  {{-- ---------------------------------------------------------------End---------------------------------------------------------------------------- --}}
  
  
  
  
  {{-- ---------------------------------------------------------------QT$I AI---------------------------------------------------------------------------- --}}
  
  @if ($QuestionDetails['question_type']==2)

  <div id="2">

  
    <div class="row">
        <div class="col-sm-7">
          <!-- textarea -->
          <div class="form-group">
            <label>Question</label>
            <textarea class="form-control" id="questionnn" name="questionnn" rows="1" placeholder="Enter Question">{{$QuestionDetails['question']}}</textarea>
          </div>
        </div>

        <div class="custom-file col-sm-5">
          <div class="form-group">
            <label><span></span></label>
              <input type="file" id="qimage" name="qimage" class=" form-control">{{$QuestionDetails['questionImage']}}
            </div>
        </div>
      </div>



      @foreach ($QuestionDetails->answer_options as $key=>$options )

      <div class="row">
        <div class="col-sm-7">
          <!-- textarea -->
          <div class="form-group">
            <label>Option {{$loop->iteration}}</label>
            <input type="text" class="form-control" value="{{$options['Opt'.chr(64+ $loop->iteration)]}}" id="optionna{{$key}}" name="optionna{{$key}}" rows="1">
          </div>
        </div>

        <div class="col-sm-5">
        <div class="custom-control custom-radio float-right">
            <input class="custom-control-input custom-control-input-danger custom-control-input-outline"  type="radio" id="Radiotype{{$key}}" value="{{$loop->iteration}}" {{ $options['is_answer'] == true ? 'checked' : ''}} name="customRadio3">
            <label for="Radiotype{{$key}}" class="custom-control-label">Is_Answer</label>
          </div>
      </div>
      </div>
        
      @endforeach

      <div class="row">
        <div class="col-sm-3">
      <div class="form-group">
        <label class="col-form-label" for="inputWarning">Maximum Marks</label>
        <input type="text" value="{{$QuestionDetails['points']}}" class="form-control is-warning" name="points1" id="points1" placeholder="Enter Mark">
      </div>
    </div>
    </div>





</div>

      
  @endif

  
  
  
                  </div>
  
                </div>
  
  
  
            <div class="card-footer">
              <button type="submit" id="submit" class="btn btn-info">Submit</button>
            </div>
          </form>





  </div>




</div>



<script>
  const updateurl="{{route('question.update')}}";
</script>

<script src="{{asset('asset/js/question/editUpdate.js')}}"></script>


@endsection