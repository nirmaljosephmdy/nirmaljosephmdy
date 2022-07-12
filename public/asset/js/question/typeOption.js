$(document).ready(function(){
    $('#submit').hide();
    $("#1,#2").hide();
    $('#type').on ("change",function(event)

    {
        $('#submit').html('Submit');
        $('#submit').attr('disabled',false);
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
    var Qtype=$('#type').val();
    console.log(Qtype);
    $('#submit').html('Please wait...');
    $('#submit').attr('disabled',true);
// ----------------------------------------------------------------------------------------Qtype 0
    if(Qtype==0)
    {
        $.ajax({

            url        : questionurl,
            type       : "POST",
    
    
            data        : {
                type      : $('#type').val(),
                question  : $('#question').val(),
                Optiona   : $('#optiona').val(),
                Optionb   : $('#optionb').val(),
                Optionc   : $('#optionc').val(),
                Optiond   : $('#optiond').val(),
                radio     : $("input[name='customRadio2']:checked").val(),
    
            },
            
            success     :function(_response)
            {
                $('#submit').attr('disabled',false);
                $('#submit').html('submit');
            }
    
    });


    }
// --------------------------------------------------------------------------------------------Qtype 1
    if(Qtype==1)
    {
        $.ajax({

            url        : questionurl,
            type       : "POST",
    
    
            data        : {
                type      : $('#type').val(),
                question  : $('#questionn').val(),
                Optiona   : $('#imagea').val(),
                Optionb   : $('#imageb').val(),
                Optionc   : $('#imagec').val(),
                Optiond   : $('#imaged').val(),
                radio     : $("input[name='Radio2']:checked").val(),
    
            },
            
            success     :function(_response)
            {
                $('#submit').attr('disabled',false);
                $('#submit').html('submit');
            }
    
    });

    }

    // -----------------------------------------------------------------------------------------------Qtype 2

    if(Qtype==2)
    {
        $.ajax({

            url        : questionurl,
            type       : "POST",
    
    
            data        : {
                type      : $('#type').val(),
                question  : $('#questionnn').val(),
                qimage    : $('#qimage').val(),
                Optiona   : $('#optionna').val(),
                Optionb   : $('#optionnb').val(),
                Optionc   : $('#optionnc').val(),
                Optiond   : $('#optionnd').val(),
                radio     : $("input[name='customRadio3']:checked").val(),
    
            },
            
            success     :function(_response)
            {
                $('#submit').attr('disabled',false);
                $('#submit').html('submit');
            }
    
    });

    }
    




});





});