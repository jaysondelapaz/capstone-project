     <script src="../vendor/jquery/jquery.min.js"></script>
 <script src="../js/sweetalert.min.js"></script>
 <?php
session_start();
require_once('config.php');



  $username = $_POST['username'];
  $passwd =$_POST['password'];
  
  try{

  $select =  $mysql->prepare("SELECT uid,EmployeeID,uname,upasswd,uRole FROM tbluser WHERE uname=:username");
  $select->bindParam(":username", $username);
  $select->execute();

      if($select->rowCount() >0):
            $data = $select->fetch(PDO::FETCH_OBJ);
            if(password_verify($passwd,$data->upasswd)):
             // echo"success";
              $usernameSession = $data->uname;
              $uidSession  = $data->EmployeeID;
              $uRole = $data->uRole;
              $_SESSION['userName'] = $usernameSession;
              $_SESSION['userEmployeeID'] = $uidSession;
              $_SESSION['userRole'] =$uRole;
                if($_SESSION['userRole'] == '0'):
                  echo'<script> $(document).ready(function(){
                                    swal({title: "Success",text:"",icon: "success"
                                     }).then(function() {
                                        window.open("../pages/dispatch.php", "_parent");
                                     });
                        }); </script>';
                  else: echo'<script> $(document).ready(function(){
                                    swal({title: "Success",text:"",icon: "success"
                                     }).then(function() {
                                        window.open("../pages/home.php", "_parent");
                                     });
                        }); </script>';
                endif;

              //echo $_SESSION['userName'].$_SESSION['userId'];
            else: echo'<script> $(document).ready(function(){
                                  swal({title: "",text:"Invalid password",icon: "warning"
                                   }).then(function() {
                                      window.open("../index.php", "_parent");
                                   });
                      }); </script>'; 
            endif; //end of password verify
      else: echo'<script> $(document).ready(function(){
                                  swal({title: "",text:"Invalid Username",icon: "warning"
                                   }).then(function() {
                                      window.open("../index.php", "_parent");
                                   });
                      }); </script>'; 
      endif;
  }
  catch(Exception $b)
  {
    echo"ERROR: ".$b->getMessage();
  }



?>