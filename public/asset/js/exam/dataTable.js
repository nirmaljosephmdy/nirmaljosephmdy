$(document).ready(function(){

    $('#examTable').DataTable({

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