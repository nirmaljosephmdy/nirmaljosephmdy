$(document).ready(function(){

    const Type    =$('#type').val();
    $("#" +Type).show().siblings().hide();
// -------------------------------------------------------------------------------------------------------Update
    $('#submit').click(function(e){
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // $('#submit').html('Please Wait...');
        // $('#submit').attr('disabled',true);
        console.log(updateurl);

        $.ajax({


            url         : updateurl,
            type        : "post",
            data        : new FormData($('#formdata')[0]),
            contentType:false,
            processData:false,

            success     : function(response){
                // $('#submit').html('submit');
                // $('#submit').attr('disabled',false);
                const json =$.parseJSON(response);
                window.location=json.redirect_url;


            }
        });




    });
});