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


        $.ajax({

            url     : addurl,
            type    : "post",
            data: new FormData($('#formdata')[0]),
            contentType: false,
            processData: false,
            // data    : $('#formdata').serialize(),
            success : function(_response){

                $('#submit').html('Submit');
                $("#submit"). attr("disabled", false);
                alert("Added");
                console.log("success");

            }

        });

    });
});




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




