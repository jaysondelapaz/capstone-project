<?php require_once('header.php'); require_once('../api/config.php');  ?>
<div class="row"></div>
<div class="row" style="margin-top:1em;">
<div class="col-lg-5">
  <div class="panel panel-default">
    <div class="panel-heading">
      Create User
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body">
      <div class="row">
        <div class="col-lg-12">
            <form role="form"  id="Form-User" style="">
              <input type="hidden" value="createUser" id="action" name="action"/>
              <div class="form-group">
                <select name="empID" id="empID" class="form-control">
                  <option value="" selected>Select Employee</option>
                  <?php
                  try{
                  $EmpQry =$mysql->prepare("select * from tblemployee");
                  $EmpQry->execute();
                  while($row=$EmpQry->fetch(PDO::FETCH_OBJ)){
                  echo'<option value="'.$row->EmployeeID.'">'.$row->DfirstName.' '.$row->DlastName.'</option>';
                  }
                  }catch(Exception $a){
                  echo"error :".$a->getMessage();
                  }
                  ?>
                </select>
                
              </div>
              
              <div class="form-group">
                <label for="Username">Username</label>
                <input class="form-control" name="Usernametxt" id="Usernametxt" placeholder="Prefered username" required>
              </div>
              <div class="form-group">
                <label for="Password">Password</label>
                <input  type="password" class="form-control" name="Passwordtxt" id="Passwordtxt" placeholder="Prefered password" required>
              </div>
              <div class="form-group">
                <label for="Password"> Confirm password</label>
                <input  type="password" class="form-control" name="CPasswordtxt" id="CPasswordtxt" placeholder="Prefered password" required>
              </div>

              <div class="form-group">
                                            <label>Level</label>
                                            <select name="role" id="role" class="form-control">
                                                <option value="Driver">Driver</option>
                                                <option value="Administrator">Administrator</option>
                                            </select> 
                                        </div>
              
              <button type="submit" class="btn btn-lg btn-primary btn-block">save</button>
            </form>
          </div> <!-- end of col -lg 12 -->
        </div> <!-- nested row -->
      </div>
    </div>
  </div>
  <!-- /.col-lg-5 -->
<div class="col-lg-1"></div>
  <div class="col-lg-5">
  <div class="panel panel-default">
    <div class="panel-heading">
                            <i class="fa fa-clock-o fa-fw"></i> User history timeline
                        </div>
    <!-- /.panel-heading -->
    <div class="panel-body">
        <ul class="timeline">

          <?php
                    try{
                      $us = $mysql->prepare("select * from tbluser order by user_stamp desc");
                      $us->execute();
                      while($ur = $us->fetch(PDO::FETCH_OBJ)){
                      ?>


                        <li>
                          <div class="timeline-badge"><i class="fa fa-user"></i>
                          </div>
                          <div class="timeline-panel">
                            <div class="timeline-heading">
                              <h5 class="timeline-title">Recently user added</h5>
                              <p><small class="text-muted"><i class="fa fa-clock-o"></i><?php echo $ur->user_stamp;?></small>
                              </p>
                            </div>
                            <div class="timeline-body">
                              <p><?php echo'Username: '. $ur->uname;?></p>
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
          $("#Form-User").on('submit',(function(e) { 
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
                  
                     swal({ title: data,icon: "success"});
                     $("#Usernametxt").val("");
                     $("#Passwordtxt").val("");
                     $("#CPasswordtxt").val("");
                   
                }        
             });
          }));
        });

</script>               
