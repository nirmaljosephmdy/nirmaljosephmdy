$(document).ready(function(){
    $('#table').hide();
    $('#examtype').on("change",function(e){
        $('#table').show();
        e.preventDefault();
        let id=($(this).val());
        $('#examTable').DataTable({

            processing  :false,
            serverSide  :true,
            ajax        :examreg2url+'/'+ id,
            
    
            columns     :[
    
            {data   : 'sl'},
            {data   : 'question'},
            {data   : 'points'},
            {data   : 'action'},
            ]
        });

    });

});