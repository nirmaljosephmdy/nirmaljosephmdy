$(document).ready(function(){
    $('#examtype').on("change",function(e){
        e.preventDefault();
        let id=($(this).val());
        $('#examTable').DataTable({

            processing  :false,
            serverSide  :true,
            ajax        :examreg2url+'/'+ id,
            
    
            // columns     :[
    
            // {data   : 'name'},
            // {data   : 'email'},
            // {data   : 'permission'},
            // {data   : 'status'},
            // {data   : 'gender'},
            // {data   : 'action'},
            // ]
        });

    });

});