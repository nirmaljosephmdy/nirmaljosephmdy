//------------------------------------------------------------------------------------------Edit------------------------------------------
// $(document).ready(function(){
//     $('body').on('click', '#edit', function (event) {
//       event.preventDefault();
      
//       var editurl = $(this).data('action');
      
      
//       $.ajax({
//         type      :"GET",
//         url       : editurl,
        
//         success :function(data){
//             console.log()
        

//           $('#name').val(data.data.name);
//           $('#email').val(data.data.email);
//           $('#profile').val(data.data.profilepic);
//           $('#usertype').val(data.data.status);
//           $('#gender').val(data.data.gender);
//           $('#id').val(data.data.id);
//           $('#exampleModal').modal('show');

//           }
//       });
      


//   });
//   });

  $(document).ready(function(){

    $('#update').click(function(event){
  
      event.preventDefault();
      
        $('#update').html('Processing');
        $('update').attr("disabled",true);
  
        ajax({
  
          method    : updateurl,
          type      : "POST",
          data      : new FormData('#updatedata'[0]),
          contentType:false,
          processData:false,
  
          success   : function(_response){
  
            $('#update').html('Save Changes');
            $('$update').attr("disabled",false);
            alert('Updated');
          }
  
        });
  
      
    });
  }); 