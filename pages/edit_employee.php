<?php 
require_once('header.php');
require_once('../api/config.php');
$dID = base64_decode($_GET['id']);

try{

    $statementQry = $mysql->prepare("SELECT * FROM tblemployee WHERE EmployeeID='".$dID."'");
    $statementQry->execute();
    if($statementQry->rowCount()>0):
        while($ado=$statementQry->fetch(PDO::FETCH_ASSOC))
            {
               $driverID= $ado['EmployeeID'];
               $driverLastname = $ado['DlastName'];
               $driverFirstname = $ado['DfirstName'];
               $driverMname = $ado['DmiddleName'];
               $driverBday = $ado['Dbirthday'];
               $driverAddress = $ado['Daddress'];
               $driverGender = $ado['Dgender'];
               $designation = $ado['Designation'];
            }
    else:
        echo"No Data";
    endif;    
}catch(Exception $i){
    echo"QUERY FAILED: ". $i->getMessage();
}
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
                            Edit Employee Profile
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form role="form" id="Form-editemployee">
                                        <input type="hidden" value="UpdateEmployee" id="action" name="action"/>
                                        <input type="hidden" value="<?php echo base64_encode($driverID);?>" name="driverIDD" id="driverIDD" />
                                        <div class="form-group">
                                            <label for="Lastname">Lastname</label>
                                            <input class="form-control" name="editLastnametxt" id="editLastnametxt" value="<?php echo $driverLastname;?>" />
                                        </div>

                                        <div class="form-group">
                                            <label for="Firstname">Firstname</label>
                                            <input class="form-control" name="editFirstnametxt" id="editFirstnametxt" value="<?php echo $driverFirstname;?>" />

                                        <div class="form-group">
                                            <label for="Middlename">Middlename</label>
                                            <input class="form-control" name="editMiddlenametxt" id="editMiddlenametxt" value="<?php echo $driverMname;?>" />
                                        </div>

                                        <div class="form-group">
                                            <label for="date">Birthday</label>
                                            <input type="date" name="editBdatetxt" id="editBdatetxt" class="form-control" value="<?php echo $driverBday;?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="destinion">Address</label>
                                            <input class="form-control" name="editAddresstxt" id="editAddresstxt" value="<?php echo $driverAddress;?>" />
                                        </div>


                                        <div class="form-group">

                                            <label>Gender</label>
                                            <select name="genderEdit" id="genderEdit" class="form-control">
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                            
                                        <div class="form-group">
                                            <label>Designation</label>
                                            <select name="designationtxt" id="designationtxt" class="form-control">
                                                 <option value="1">Administrative</option>
                                                <option value="0">Driver</option>
                                                <option value="2">Accounting</option>
                                                <option value="3">Marketing</option>
                                                <option value="4">IT</option>
                                                <option value="5">Auditor</option>
                                                <option value="Others">Others</option>
                                            </select>
                                        </div>

                                        <button type="submit" class="btn btn-lg btn-primary btn-block">Update</button>
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

<?php require_once('footer.php'); ?>

<script>
        $(document).ready(function (e) {
          $("#Form-editemployee").on('submit',(function(e) { 
            e.preventDefault();
            $.ajax({
              url: "../api/employee.ajax.php",
              type: "POST",
              data:  new FormData(this),
              contentType: false,
              cache: false,
              processData:false,
              success: function(data)
                { 
                    swal({
                        title: "Success",
                        text: data,
                        icon: "success"
                    }).then(function() {
                        window.location = "employee.php";
                    });
                }        
             });
          }));
        });




</script>

