$(document).ready(function(){

    $('#qtable').DataTable({

        processing  : false,
        serverSide  : true,

        ajax        : tableurl,

        columns     : [

            {data   : 'sl'},
            {data   : 'question'},
            {data   : 'points'},
            {data   : 'action'},

        ]

    });




});