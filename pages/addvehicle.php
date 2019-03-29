<?php
require_once('../api/config.php');
require_once('header.php');
?>

 <div class="row">
                <!-- <div class="col-lg-12">
                    <h1 class="page-header">Ticket Reservation</h1>
                </div> -->
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row" style="margin-top:1em;">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Create Vehicle Profile
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form role="form" id="Form-vehicle">
                                        <input type="hidden" value="createVehicle" id="action" name="action"/>
                                        <div class="form-group">
                                            <label for="Modelname">Modelname</label>
                                            <input class="form-control" name="Modelnametxt" id="Modelnametxt" placeholder="eg: Toyota Innova / L300 Ban ect..">
                                        </div>

                                        <div class="form-group">
                                            <label for="Engine">Engine No. / Model</label>
                                            <input class="form-control" name="Enginetxt" id="Enginetxt" placeholder="212363">
                                        </div>

                                        <div class="form-group">
                                            <label for="Chassis">Chassis No.</label>
                                            <input class="form-control" name="Chassistxt" id="Chassistxt" placeholder="JAANKR551-J710099">
                                        </div>

                                        <div class="form-group">
                                            <label for="Color">Color</label>
                                            <input class="form-control" name="Colortxt" id="Colortxt" placeholder="White">
                                        </div>

                                        <div class="form-group">
                                            <label for="PlateNo">PlateNumber</label>
                                            <input class="form-control" name="PlateNotxt" id="PlateNotxt" placeholder="ILV 143">
                                        </div>

                                        


                                        <button type="submit" class="btn btn-lg btn-primary btn-block">save</button>
                                    </form>
                                </div>

                                
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
<?php  require_once('footer.php'); ?>

<script>
        $(document).ready(function (e) {
          $("#Form-vehicle").on('submit',(function(e) { 
            e.preventDefault();
            $.ajax({
              url: "../api/vehicle.ajax.php",
              type: "POST",
              data:  new FormData(this),
              contentType: false,
              cache: false,
              processData:false,
              success: function(data)
                { 
                     swal({ title:"success",text: data,icon: "success"});
                     $("#Modelnametxt").val("");
                     $("#Colortxt").val("");
                     $("#PlateNotxt").val("");
                     
                }        
             });
          }));
        });




</script>
