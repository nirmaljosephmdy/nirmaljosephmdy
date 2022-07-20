$(document).ready(function(){
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

        
        
                




    });










$('#submit').click(function(e){

    e.preventDefault();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    const Qtype=$('#type').val();
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
                points    : $('#points').val(),
                question  : $('#question').val(),
                Optiona   : $('#optiona').val(),
                Optionb   : $('#optionb').val(),
                Optionc   : $('#optionc').val(),
                Optiond   : $('#optiond').val(),
                radio     : $("input[name='customRadio2']:checked").val(),
    
            },
            
            success     :function(response)
            {
                const jsonn = $.parseJSON(response);
                $('#submit').attr('disabled',false);
                $('#submit').html('submit');
                window.location=jsonn.redirect_url;
                window.location.reload();

            }
    
    });


    }
// --------------------------------------------------------------------------------------------Qtype 1


    // -----------------------------------------------------------------------------------------------Qtype 2

    if(Qtype==2 || Qtype==1)
    {
        $.ajax({
            

            url        : questionurl,
            type       : "POST",
            data       : new FormData($('#formdata')[0]),
            contentType: false,
            processData: false,
    
            
            success     :function(response)
            {
                const json = $.parseJSON(response);
                $('#submit').attr('disabled',false);
                $('#submit').html('submit');
                window.location=json.redirect_url;
                window.location.reload();
            }
    
    });

    }
    




});





});