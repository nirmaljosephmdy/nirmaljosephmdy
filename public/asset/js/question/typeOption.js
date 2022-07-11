$(document).ready(function(){
    $('#submit').hide();
    $("#1,#2").hide();
    $('#type').on ("change",function(event)

    {
        event.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#" + $(this).val()).show().siblings().hide();
        console.log("#" + $(this).val());

        // $("#" + $(this).val()).validate({
            
        //     rules   : {
        
        //         question    : {
                    
        //             required    : true,
        //             lettersonly : true
        //                 },
                        
        //                 optiona,optionb,optionc,optiond :   {
        //                     required    :true
        //                 }
        //             },
        
                    
        //             message : {
        
        //                 question    : {
                            
        //                     required    : "Please Enter the question",
        //                     lettersonly : "Only Letters Allowed!"
        //                 },
        
        //                 optiona,optionb,optionc,optiond :{
        
        //                     required    : "All Options are Mandatory"
        //                 },
                        
                        
        //             }
                    
                    
                    
        //         });


        $('#submit').show();
        
        
                




    });










$('#submit').click(function(e){

    e.preventDefault();
    $('#submit').html('Please wait...');
    $('#submit').attr('disabled',true);
    
    $.ajax({

        url        : questionurl,
        type        : "POST",
        data        : {
            Optiona   : $('#optiona').val(),
            Optionb   : $('#optionb').val(),
            Optionc   : $('#optionc').val(),
            Optiond   : $('#optiond').val(),
            question  : $('#question').val(),

        },
        success     :function(_response)
        {
            $('#submit').attr('disabled',false);
            $('#submit').html('submit');
        }

});




});





});