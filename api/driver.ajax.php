<?php
session_start();
include('../pages/session.php');
require_once('config.php');

$action = isset($_POST['action']) ? $_POST['action']:'';
if($action == 'ajaxAutocomplete')
{

	if($_POST['SearchBy'] == 'DriverLastname'):
		$term=$_POST['term'];
		try
		{
			$AutoCompleteQry=$mysql->prepare("SELECT DlastName FROM  tblemployee where DlastName like '%$term%'");
	        $AutoCompleteQry->execute();
		 	while ($row = $AutoCompleteQry->fetch(PDO::FETCH_ASSOC))
	            {
	             $resultData[] = $row['DlastName'];
	            }
	            echo json_encode($resultData);
		}
		catch(Exception $s)
		{
			echo "Error Searching: ".$s->getMessage();
		}
        
    endif; 
    
    if($_POST['SearchBy'] == 'DriverFirstname'):
		$term=$_POST['term'];
		try
		{
			$AutoCompleteQry=$mysql->prepare("SELECT DfirstName FROM  tblemployee where DfirstName like '%$term%'");
	        $AutoCompleteQry->execute();
		 	while ($row = $AutoCompleteQry->fetch(PDO::FETCH_ASSOC))
	            {
	             $resultData[] = $row['DfirstName'];
	            }
	            echo json_encode($resultData);
		}
		catch(Exception $s)
		{
			echo "Error Searching: ".json_encode($s->getMessage());
		}
        
    endif;            
}//end of autocomplete action

if($action == 'createDriver')
{
	try{
		// $DriverID = $mysql->prepare("SELECT Did FROM tbldriver ORDER BY Did DESC LIMIT 1");
		// $DriverID->execute();
		// if($DriverID->rowCount() > 0):
		// while($d=$DriverID->fetch(PDO::FETCH_OBJ))
		// 	{
		// 		 $did =$d->Did + 1;
		// 	}
		// else:	
		// 		$did = 1;
		// endif;	
		$insertstmt = $mysql->prepare("INSERT INTO tblemployee VALUES(NULL,:dlastname,:dfirstname,:dmiddlename,:dbday,:daddress,:dgender)");
		$insertstmt->execute([':dlastname'=>$_POST['Lastnametxt'],':dfirstname'=>$_POST['Firstnametxt'],':dmiddlename'=>$_POST['Middlenametxt'],':dbday'=>$_POST['Bdatetxt'],':daddress'=>$_POST['Addresstxt'],':dgender'=>$_POST['Gendertxt']]);
		echo"success";
	}
	catch(SQLException $e){
		echo"Saving failed!".$e->getMessage();
	}
}	


// if($action == 'UpdateDriver')
// {
// 	$Driverid= base64_decode($_POST['driverIDD']);
// 	$editStmtQry = $mysql->prepare("UPDATE tbldriver SET DlastName=?,DfirstName=?,DmiddleName=?,Dbirthday=?,Daddress=?,Dgender=? WHERE Did=?");
// 	$editStmtQry->bindParam(1,$_POST['editLastnametxt']);
// 	$editStmtQry->bindParam(2,$_POST['editFirstnametxt']);
// 	$editStmtQry->bindParam(3,$_POST['editMiddlenametxt']);
// 	$editStmtQry->bindParam(4,$_POST['editBdatetxt']);
// 	$editStmtQry->bindParam(5,$_POST['editAddresstxt']);
// 	$editStmtQry->bindParam(6,$_POST['genderEdit']);
// 	$editStmtQry->bindParam(7,$Driverid);
// 	$editStmtQry->execute();
// 	echo"Updated!";
// }


// if($action =='Delete')
// {
// 	$stmtDeleteQry = $mysql->prepare("DELETE FROM tbldriver WHERE Did=:idd");
// 	$stmtDeleteQry->execute([':idd'=>$_POST['id']]);
// 	echo"data has been deleted!";
// }
?>

<?php
if($action == 'AjaxSearch')
{
?>
<table width="100%" class="table table-hover table-dark" id="tableData">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Lastname</th>
                                        <th>Firstname</th>
                                        <th>Middlename</th>
                                        <th>Birthday</th>
                                        <th>Gender</th>
                                        <th>Address</th>
                                      	
                                    </tr>
                                </thead>
                                <tbody>

<?php	
	try{
		$ajaxQry= $mysql->prepare("select * from tblemployee where DlastName like concat('%',:lastname,'%') AND DfirstName like concat('%',:firstname,'%')");
		$ajaxQry->bindParam(':lastname',$_POST['SearchLastname']);
		$ajaxQry->bindParam(':firstname',$_POST['SearchFirstname']);
		$ajaxQry->execute();
		if($ajaxQry->rowCount()>0):
			
			while($rw = $ajaxQry->fetch(PDO::FETCH_OBJ))
				{
					echo'<tr>';
					echo'<td>00' .$rw->EmployeeID.'</td>';
					echo'<td>' .$rw->DlastName.'</td>';
					echo'<td>' .$rw->DfirstName.'</td>';
					echo'<td>' .$rw->DmiddleName.'</td>';
					echo'<td>' .$rw->Dbirthday.'</td>';
					echo'<td>' .$rw->Dgender.'</td>';
					echo'<td>' .$rw->Daddress.'</td>';
					
?>
<?php /*
						<td>
							<div class="btn-group">
										  <button type="button" class="btn btn-default dropdown-toggle btn-action" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										    Action <span class="caret"></span>
										  </button>
										  <ul class="dropdown-menu">
										    <li><a href="#">Action</a></li>
										    <li><a href="edit_driver.php?id=<?php echo base64_encode($rw->Did); ?>">Edit</a></li>
										    <li><a href="#" onClick='remove("<?php echo $rw->Did;?>","../api/driver.ajax.php","driverprofile.php");'>Delete</a></li>

										  </ul>
										</div>
							</td>
						</tr>
*/?>
<?php			}
		else: echo'<tr><td>No data found!</td></tr>';		
		endif;	
	}catch(Exception $n){	
		echo"error:".$n->getMessage();
	}
echo'</tbody></table>';	
}

if($action == 'ajaxAutocomplete')
{
	if($_POST['SearchBy'] == 'Lastname'):
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


?>




