$(document).ready(function(){
    $('#submit').hide();
    $("#0,#1,#3").hide();
    $('#type').on ("change",function(event)

    {
        event.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#" + $(this).val()).show().siblings().hide();
        $('#submit').show();



    });
















});