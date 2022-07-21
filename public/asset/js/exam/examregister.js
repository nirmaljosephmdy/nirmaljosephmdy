$(document).ready(function(){
    $(function(){

        $('#formdata').validate({

            rules       : {

                title               : "required",
                instructions        : "required",
                questions           : "required",
            },

            submitHandler   :function(_form)
            {





                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });







                $.ajax({

                    url         : examurl,
                    type        : "post",
                    data        : new FormData($('#formdata')['0']),
                    processData: false,
                    contentType: false,

                    success     : function(response){

                        const json =$.parseJSON(response);
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