//-------------------------------------------------------------------------------------------------Add Teachers----------------------------------------------------------------

$(document).ready(function(){
    $(function(){

        $("#formdata").validate({

            rules   : {

                name        : "required",
                email       : {required:true, email:true},
                profilepic  : "required",
                usertype    : "required",
                gender      : "required"
            },

            messages: {

                name        : "Please Enter your Full Name",
                email       : {required:"Please Enter Mail Address",email:"Enter a valid Mail"},
                profilepic  : "Upload Profile Picture",
                usertype    : "This field is Mandatory"

            },
            submitHandler   :function(_form)
            {
                
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
        
                // $('#submit').html('Please Wait...');
                // $("#submit"). attr("disabled", true);
                console.log(addurl);
        
        
                $.ajax({
        
                    url     : addurl,
                    type    : "post",
                    data    : new FormData($('#formdata')[0]),
                    contentType: false,
                    processData: false,
                    success : function(response){  
        
                        // $('#submit').html('Submit');
                        // $("#submit"). attr("disabled", false);
                        const json = $.parseJSON(response);
                            window.location=json.redirect_url;
        
                    },
                    error: function(response) {
                        $.each(response.responseJSON.errors, function(_key, value) {
                            toastr.error(value);
                        });
                    }
        
                });
            }


        });

    });
});


//------------------------------------------------------------------------------------DataTables------------------------------------------------------------------

$(document).ready(function(){

    $('#example2').DataTable({

        processing  :false,
        serverSide  :true,

        ajax        :tableurl,

        columns     :[

        {data   : 'name'},
        {data   : 'email'},
        {data   : 'permission'},
        {data   : 'status'},
        {data   : 'gender'},
        {data   : 'action'},
        ]
    });

});




