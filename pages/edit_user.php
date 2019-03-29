<?php 
require_once('header.php');
require_once('../api/config.php');
$dID = base64_decode($_GET['id']);

try{

    $statementQry = $mysql->prepare("SELECT user.*,emp.DfirstName as DfirstName,emp.EmployeeID as Employee,emp.DlastName as DlastName FROM tbluser as user inner join tblemployee as emp on user.EmployeeID=emp.EmployeeID WHERE user.uid='".$dID."'");
    $statementQry->execute();
    if($statementQry->rowCount()>0):
        while($ado=$statementQry->fetch(PDO::FETCH_OBJ))
            {
               $userID = $ado->uid;
               $userName=$ado->uname;
               $uRole=$ado->uRole;
               $Name = $ado->DfirstName;
               $LastName = $ado->DlastName;
               $Employid = $ado->Employee;
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
                            Edit user Profile
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form role="form" id="Form-edituser">
                                        <input type="hidden" value="UpdateUser" id="action" name="action"/>
                                        <input type="hidden" value="<?php echo base64_encode($userID);?>" name="userId" id="userId" />
                                        <div class="form-group">
                                            <select name="empIDs" id="empIDs" class="form-control">
                                           
                                           <?php
                                                try{
                                                    $EmpQry =$mysql->prepare("select * from tblemployee");
                                                    $EmpQry->execute();
                                                    while($row=$EmpQry->fetch(PDO::FETCH_OBJ)){
                                                        if($row->EmployeeID == $Employid){
                                                        echo'<option value="'.$row->EmployeeID.'" selected>'.$row->DfirstName.' '.$row->DlastName.'</option>';
                                                        }
                                                        else
                                                        {
                                                            echo'<option value="'.$row->EmployeeID.'">'.$row->DfirstName.' '.$row->DlastName.'</option>';
                                                        }
                                                    }
                                                }catch(Exception $a){
                                                    echo"error :".$a->getMessage();
                                                }
                                            ?>
                                          </select>
                                        </div>

                                        

                                        <div class="form-group">
                                            <label for="username">username</label>
                                            <input type="text" name="editusernametxt" id="editusernametxt" class="form-control" value="<?php echo $userName;?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="password">password</label>
                                            <input type="password" class="form-control" name="editpasswordtxt" id="editpasswordtxt" value="" placeholder="********" />
                                        </div>

                                         <div class="form-group">
                                            <label for="password">retype password</label>
                                            <input type="password" class="form-control" name="editcpasswordtxt" id="editcpasswordtxt" value="" placeholder="********" />
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Level</label>
                                            <select name="role" id="role" class="form-control">
                                                <option value="Driver">Driver</option>
                                                <option value="Administrator">Administrator</option>
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
    //alert($("#userId").val());
        $(document).ready(function (e) {
          $("#Form-edituser").on('submit',(function(e) { 
            e.preventDefault();
            $.ajax({
              url: "../api/user.ajax.php",
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
                        window.location = "user.php";
                    });
                }        
             });
          }));
        });




</script>

