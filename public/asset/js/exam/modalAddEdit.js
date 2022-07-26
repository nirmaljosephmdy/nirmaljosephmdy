$(document).ready(function(){
    $(document).on('click', '.actionedit', function(e){

        let id =$(this).attr('id');
        $('#type2').hide();
        e.preventDefault();
        let BaseUrl = $('#BaseUrl').val();

    $.ajax({

        url     : editurl + '/'+id,
        type    :"get",
        dataType:"JSON",

        success :function(response){
            console.log(response);

            if(response.question_type==2)
            {
                $('#type2').show();
                $.each(response.answer_options,function(key,value){
                    console.log(value);
                    console.log(key)
                });
                
            }

            $('#exampleFormControlInput1').val(response.question);
            $('#exampleFormControlInput2').val(response.points);
            $("#questionImage").attr('src',BaseUrl+'/storage/QuestionImg/'+response.questionImage);

            $('#exampleModal').modal('show');

        }

    });




    });

});