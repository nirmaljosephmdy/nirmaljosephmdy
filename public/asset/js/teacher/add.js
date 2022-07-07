//-------------------------------------------------------------------------------------------------Add Teachers----------------------------------------------------------------

$(document).ready(function(){
    $('#submit').click(function(e)
    {
        e.preventDefault();


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#submit').html('Please Wait...');
        $("#submit"). attr("disabled", true);
        console.log(addurl);


        $.ajax({

            url     : addurl,
            type    : "post",
            data: new FormData($('#formdata')[0]),
            contentType: false,
            processData: false,
            // data    : $('#formdata').serialize(),
            success : function(response){  

                $('#submit').html('Submit');
                $("#submit"). attr("disabled", false);
                    window.location=response.redirect_url;
                console.log(response.redirect_url);

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




