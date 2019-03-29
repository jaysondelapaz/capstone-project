<?php
session_start();
require_once('config.php');
require_once('function.php');
$action = isset($_POST['action']) ? $_POST['action']:'';
if($action == 'ajaxAutocomplete')
{
	if($_POST['SearchBy'] == 'DriverLastname'):
		$term=$_POST['term'];
		try
		{
			$AutoCompleteQry=$mysql->prepare("SELECT uname FROM  tbluser where uname like '%$term%'");
	        $AutoCompleteQry->execute();
		 	while ($row = $AutoCompleteQry->fetch(PDO::FETCH_ASSOC))
	            {
	             $resultData[] = $row['uname'];
	            }
	            echo json_encode($resultData);
		}
		catch(Exception $s)
		{
			echo "Error Searching: ".$s->getMessage();
		}
        
    endif; 
    
}//end of autocomplete action

if($action == 'createUser')
{
	if($_POST['Passwordtxt'] == $_POST['CPasswordtxt']):
	try{
		
		$uRole = "";
	$role = $_POST['role'];
	switch ($role) {
		case 'Driver':
			$uRole = 0;
			break;
		case 'Administrator';
			$uRole=1;
			break;
		default:
			$uRole=3;
			break;
	}
	
		$Upasswd = password_hash($_POST['Passwordtxt'], PASSWORD_DEFAULT);
		$createQry=$mysql->prepare("insert into tbluser values(NULL,:EmpID,:username,:password,:u_role,:toDay)");
		$createQry->bindParam(':EmpID',$_POST['empID']);
		$createQry->bindParam(':username',$_POST['Usernametxt']);
		$createQry->bindParam(':password',$Upasswd);
		$createQry->bindParam(':u_role',$uRole);
		$createQry->bindParam(':toDay',$Today);
		$createQry->execute();
		echo"success";
	}catch(Exception $u){
		echo"user creation failed: ".$u->getMessage();
	}
	else:echo'Password did not match!';
	endif;
}

if($action == 'UpdateUser')
{
	$uRole = "";
	$role = $_POST['role'];
	switch ($role) {
		case 'Driver':
			$uRole = 0;
			break;
		case 'Administrator';
			$uRole=1;
			break;
		default:
			$uRole=3;
			break;
	}
	$uid = base64_decode($_POST['userId']);
	if($_POST['editpasswordtxt'] == ''){
		try{$stmtUpdate=$mysql->prepare("UPDATE tbluser SET EmployeeID=?,uname=?,uRole=? WHERE uid=?");
			 //$stmtUpdate=$mysql->prepare(" tbluser set Ufirst_Name=? ,Ulast_Name=? ,Umiddle_Name=?, uname=?,uRole=? where uid=? ");
			 $stmtUpdate->bindParam(1,$_POST['empIDs']);
			 $stmtUpdate->bindParam(2,$_POST['editusernametxt']);
			 $stmtUpdate->bindParam(3,$uRole);
			 $stmtUpdate->bindParam(4,$uid);
			 $stmtUpdate->execute();
			 echo'success';
		}catch(Exception $e){
			echo"changing failed!". $e->getMessage();
		}	
	}else{
		try{
			$newpassword = password_hash($_POST['editpasswordtxt'], PASSWORD_DEFAULT);
			 $stmt=$mysql->prepare("update tbluser set EmployeeID=?, uname=?,upasswd=?,uRole=? where uid=? ");
			 $stmt->bindParam(1,$_POST['empIDs']);
			 $stmt->bindParam(2,$_POST['editusernametxt']);
			 $stmt->bindParam(3,$newpassword);
			 $stmt->bindParam(4,$uRole);
			 $stmt->bindParam(5,$uid);
			 $stmt->execute();
			 echo'success';
		}catch(Exception $e){
			echo"changing failed!". $e->getMessage();
		}	
	}
}


if($action =='Delete')
{
	$stmtDeleteQry = $mysql->prepare("DELETE FROM tbluser WHERE uid=:idd");
	$stmtDeleteQry->execute([':idd'=>$_POST['id']]);
	echo"data has been deleted!";
}

?>



<?php
if($action =='AjaxSearch'){
?>

<table width="100%" class="table table-hover table-dark" id="tableData">
                                <thead>
                                   <tr>
                                           
                                            <th>Firstname</th>
                                             <th>Lastname</th>
                                            <th>Middlename</th>
                                            <th>Username</th>
                                            <th>Password</th>
                                            <th>Userrole</th>
                                            <th>Action</th>
                                            
                                         
                                           
                                        </tr>
                                </thead>
                                <tbody>

<?php
		try{
			$ajaxQry= $mysql->prepare("select user.uid as uid,user.uname as uname, user.upasswd as upasswd, user.uRole as role , emp.DlastName as DlastName, emp.DfirstName as DfirstName,emp.DmiddleName as DmiddleName, emp.Designation as design from tbluser as user inner join tblemployee as emp ON user.EmployeeID = emp.EmployeeID  where uname like concat('%',:unametxt,'%')");
			$ajaxQry->bindParam(':unametxt',$_POST['SearchLastname']);
			$ajaxQry->execute();
			if($ajaxQry->rowCount()>0){
				while($emrow=$ajaxQry->fetch(PDO::FETCH_OBJ)){
					?>
					<tr>
					<td><?php echo $emrow->DfirstName;?></td>
					<td><?php echo $emrow->DlastName;?></td>

					<td><?php echo $emrow->DmiddleName;?></td>
					<td><?php echo $emrow->uname;?></td>
					<td><?php echo'******';?></td>
                        
                                         <?php Designation($emrow->design) ?>
                                       
										<td>
                                        <div class="btn-group">
                                        <button type="button" class="btn btn-default dropdown-toggle btn-action" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action <span class="caret"></span>
                                          </button>
                                          <ul class="dropdown-menu">
                                            <li><a href="#">Action</a></li>
                                            <li><a href="edit_user.php?id=<?php echo base64_encode($emrow->uid); ?>">Edit</a></li>
                                            <li><a href="#" onClick='remove("<?php echo $emrow->uid;?>","../api/user.ajax.php","user.php");'>Delete</a></li>
                                            
                                          </ul>
                                        </div>
                                        </td>
							
					</tr>
					<?php
				}
			}else{
				echo'<tr><td>No employee found...</td></tr>';
			}
		}
		catch(Exception $m){
			echo"Error employee searching!: ".$m->getMessage();
		}

}  //end of AjaxSearch

?>