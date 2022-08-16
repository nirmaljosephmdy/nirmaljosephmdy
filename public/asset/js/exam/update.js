$(document).ready(function(){
    
    $(function(){
        $('#confirm').validate({

            rules   : {

                exampleFormControlInput1: {required:true},
                exampleFormControlInput2: {required:true,digits:true},

            },

            submitHandler : function(_form)
            {
                const a =document.getElementById("questionImage").getAttribute('src');
                console.log(a);


                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({

                    url         : updateurl,
                    type        : "post",
                    data        : new FormData($('#confirm')['0']),
                    processData : false,
                    contentType : false,

                    success :function(response){

                    }
                });


            }
        });

    });
});

