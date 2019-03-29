<?php
require_once('../api/config.php');
require_once('header.php');
?>
<div class="row"></div>

<div class="row" style="margin-top:1em;">
    <div class="col-lg-12">
        <div class="panel panel-primary">
                        <div class="panel-heading">
                            Vehicle Service Maintenace
                        </div>
                        <div class="panel-body ">
                             <form id="Form-VehicleserviceFilter">   
                             <input type="hidden" name="action" value="AjaxSearch" id="action"/>    
                             <div class="col-lg-2"></div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Date From:</label>
                                        <input type="date" class="form-control" name="dateFrom" id="dateFrom" value="<?php echo $Today; ?>" />
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Date To:</label>
                                        <input type="date" class="form-control" name="dateTo" id="dateTo" value="<?php echo $Today; ?>" />
                                    </div>
                                </div>

                               <div class="col-lg-2"></div>
                                
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label style="margin-left:7em;">PO#</label>
                                        <input type="text" class="form-control" name="searchPO" id="searchPO"  />
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label style="margin-left:4em;">Modelname</label>
                                        <input type="text" class="form-control" name="SearchModelname" id="SearchModelname"  />
                                    </div>
                                </div>

                               

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label style="margin-left:5em;">EngineNo.</label>
                                        <input type="text" class="form-control" name="SearchEngine" id="SearchEngine"  />
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label style="margin-left:4em;">PlateNo</label>
                                        <input type="text" class="form-control" name="SearchPlateNo" id="SearchPlateNo"  />
                                    </div>
                                </div>
                                 
                                <div class="col-lg-4"></div>   
                                <div class="col-lg-4"><center> <button type="submit" class="btn btn-primary btn-lg-block">Search</button></center></div>
                                <div class="col-lg-4"></div>
                            </form>
                        </div> <!-- END OF PANEL BODY -->
                        <!-- <div class="panel-footer">
                            Panel Footer
                        </div> -->
                    </div>
    </div>
    
</div> <!-- END OF ROW FILTER -->

			<div class="row" style="margin-top:1em;">
                <div class="col-lg-12 results">
                    
        
                     
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->


<?php require_once('footer.php');?>
<script>
$(document).ready(function (e) {
$("#Form-VehicleserviceFilter").on('submit',(function(e) {
e.preventDefault();
$.ajax({
url: "../api/servicevehicle.ajax.php",
type: "POST",
data:  new FormData(this),
contentType: false,
cache: false,
processData:false,
success: function(data)
{
$(".results").html(data);
        $('#tableData').DataTable({
            'paging': true,
            'pageLength': 10,
        
        });
}
});
}));
});
AutoComplete($("#searchPO"),3,'../api/servicevehicle.ajax.php','PO_number');
AutoComplete($("#SearchModelname"),3,'../api/servicevehicle.ajax.php','ModelName');
 AutoComplete($("#SearchEngine"),3,'../api/servicevehicle.ajax.php','EngineNumber');
AutoComplete($("#SearchPlateNo"),3,'../api/servicevehicle.ajax.php','PlateNo');

function PrintReport(page){
var dateFrom=$("#dateFrom").val();
var dateTo=$("#dateTo").val();
var PO = $("#searchPO").val();
var ModelName=$("#SearchModelname").val();
var EngineNO= $("#SearchEngine").val();   
var PlateNO = $("#SearchPlateNo").val();
var printPage =page+'?datefrom=' + dateFrom+'&dateto=' +dateTo+'&po=' +PO +'&modelname='+ModelName+'&engineno='+EngineNO+'&plateno='+PlateNO;
  window.open(printPage,'_blank');

}
</script>