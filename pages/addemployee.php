<?php 
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
                            Create Employee Profile
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form role="form" id="Form-employee">
                                        <input type="hidden" value="createEmployee" id="action" name="action"/>
                                        <div class="form-group">
                                            <label for="Lastname">Lastname</label>
                                            <input class="form-control" name="Lastnametxt" id="Lastnametxt" placeholder="Lastname" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="Firstname">Firstname</label>
                                            <input class="form-control" name="Firstnametxt" id="Firstnametxt" placeholder="Fistname" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="Middlename">Middlename</label>
                                            <input class="form-control" name="Middlenametxt" id="Middlenametxt" placeholder="Middlename" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="date">Birthday</label>
                                            <input type="date" name="Bdatetxt" id="Bdatetxt" class="form-control" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="destinion">Address</label>
                                            <input class="form-control" name="Addresstxt" id="Addresstxt" placeholder="address" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Gender</label>
                                            <select name="Gendertxt" id="Gendertxt" class="form-control" >
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>

                                         <div class="form-group">
                                            <label>Designation</label>
                                            <select name="Designationtxt" id="Designationtxt" class="form-control" required>
                                                 <option value="1">Administrative</option>
                                                <option value="0">Driver</option>
                                               <!--  <option value="2">Accounting</option>
                                                <option value="3">Marketing</option>
                                                <option value="4">IT</option>
                                                <option value="5">Auditor</option>
                                                <option value="Others">Others</option> -->
                                            </select>
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
                <!-- /.col-lg-12z -->

                <div class="col-lg-1"></div>
  <div class="col-lg-5">
  <div class="panel panel-default">
    <div class="panel-heading">
                            <i class="fa fa-clock-o fa-fw"></i> Employee history timeline
                        </div>
    <!-- /.panel-heading -->
    <div class="panel-body">
        <ul class="timeline">

          <?php
                    try{
                      $us = $mysql->prepare("select * from tblemployee order by emp_stamp desc");
                      $us->execute();
                      while($ur = $us->fetch(PDO::FETCH_OBJ)){
                      ?>


                        <li>
                          <div class="timeline-badge"><i class="fa fa-user"></i>
                          </div>
                          <div class="timeline-panel">
                            <div class="timeline-heading">
                              <h5 class="timeline-title">Recently user added</h5>
                              <p><small class="text-muted"><i class="fa fa-clock-o"></i><?php echo $ur->emp_stamp;?></small>
                              </p>
                            </div>
                            <div class="timeline-body">
                              <p><?php echo $ur->DfirstName.' '.$ur->DlastName;?></p>
                              <p>Position: <?php 
                                            if($ur->Designation == '0'){
                                              echo'Driver';
                                            }elseif($ur->Designation == '1'){
                                              echo'Administrator';
                                            }else{
                                              echo'Other Position';
                                            }
                               ?></p>
                            </div>
                          </div>
                        </li>

                     


                      
                      

                      <?php  
                      }
                    }catch(Exception $usr){
                      echo"error getting user timeline".$usr->getMessage();
                    }
                 ?>

         
               
               
         
        </ul>
    </div>
  </div>
  <!-- /.col-lg-5 -->

            </div>
            <!-- /.row -->

<?php require_once('footer.php'); ?>

<script>
        $(document).ready(function (e) {
          $("#Form-employee").on('submit',(function(e) { 
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
                     swal({ title: data,icon: "success"});
                     $("#Lastnametxt").val("");
                     $("#Firstnametxt").val("");
                     $("#Middlenametxt").val("");
                     $("#Bdatetxt").val("");
                     $("#Addresstxt").val("");
                }        
             });
          }));
        });




</script>

