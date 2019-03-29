<?php
session_start();
require_once('footer.php');
unset($_SESSION['userName']);
unset($_SESSION['userId']);
session_destroy();
echo'<script> 
		
		 swal({
                    title: "Thank you for login!"    
                    }).then(function() {
                        window.location = "../index.php";
         });
 </script>';


?>