function PrintData(page,ids)
{ 
   var printPage =page+'?id=' + ids;
  window.open(printPage,'_blank');
}






function Alertsuccess(msg)
{
      swal({
            title: "Success",
            text: msg,
            icon: "success"
          });
}           
            

function remove(id,page,openPage){

swal({
  title: "Are you sure?",
  text: "Once deleted, you will not be able to recover this data!",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {

    $.ajax({
      url:page,
      type:'POST',
      data:{action:'Delete',id:id},
      success: function(data){
        window.location = openPage; 
      }

    }); //close ajax
    
  } else {
    swal("Your data is safe!");
  }
});


  //  if (!confirm('Are you sure you want to delete this file? ')) return false;
  // $.ajax({

  //     url:page,

  //     type:'POST',

  //     data:{action:'Delete',id:id},

  //     success: function(data){
  //       swal({
  //                       title: "Success",
  //                       text: data,
  //                       icon: "success"
  //                   }).then(function() {
  //                       window.location = openPage;
  //                   });
  //      // swal(data, "Data has been deleted!", "success");
  //      // location.reload();
  //     }

  // }); 

}     

function AutoComplete(param,lengthChar,page,SearchBy){
 $(document).ready(function(){
    $(param).autocomplete({
                minLength: lengthChar,
                source: function(request, response) {
                    $.ajax({
                        global: false,
                        async: false,
                        url: page,
                        type: "POST",
                        dataType: "json",
                        data: {term: request.term,action: 'ajaxAutocomplete',SearchBy:SearchBy},
                        success: function(responseText) {
                            response(responseText);
                            }
                    });//end of ajax
                }
            });//end of autocomplete
    
  }); //end of document   
}


