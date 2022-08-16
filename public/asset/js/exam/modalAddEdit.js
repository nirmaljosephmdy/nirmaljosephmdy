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

            if(response.question_type==2)
            {
                $('#type2').show();
                $.each(response.answer_options,function(key,value){
                    $('#OptA_'+key).val(value.OptA);
                    $('#OptB_'+key).val(value.OptB);
                    $('#OptC_'+key).val(value.OptC);
                    $('#OptD_'+key).val(value.OptD);

                    if(value.is_answer == true){
                        var id=(value.answer_option_id);
                        document.getElementById("Radio"+id).checked=true;
                    }


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





$('#modalsubmit').click(function(){
    
    

});

