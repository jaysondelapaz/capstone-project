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


if($action == 'createEmployee')
{
	try{
		
		$insertstmt = $mysql->prepare("INSERT INTO tblemployee VALUES(NULL,:dlastname,:dfirstname,:dmiddlename,:dbday,:daddress,:dgender,:designations,:todays)");
		$insertstmt->execute([':dlastname'=>$_POST['Lastnametxt'],
							':dfirstname'=>$_POST['Firstnametxt'],
							':dmiddlename'=>$_POST['Middlenametxt'],
							':dbday'=>$_POST['Bdatetxt'],
							':daddress'=>$_POST['Addresstxt'],
							':dgender'=>$_POST['Gendertxt'],
							':designations'=>$_POST['Designationtxt'],
							':todays'=>$Today
						]);
		echo"success";
	}
	catch(SQLException $e){
		echo"Saving failed!".$e->getMessage();
	}
}	

if($action == 'UpdateEmployee')
{
	$Driverid= base64_decode($_POST['driverIDD']);
	$editStmtQry = $mysql->prepare("UPDATE tblemployee SET DlastName=?,DfirstName=?,DmiddleName=?,Dbirthday=?,Daddress=?,Dgender=?,Designation=? WHERE EmployeeID=?");
	$editStmtQry->bindParam(1,$_POST['editLastnametxt']);
	$editStmtQry->bindParam(2,$_POST['editFirstnametxt']);
	$editStmtQry->bindParam(3,$_POST['editMiddlenametxt']);
	$editStmtQry->bindParam(4,$_POST['editBdatetxt']);
	$editStmtQry->bindParam(5,$_POST['editAddresstxt']);
	$editStmtQry->bindParam(6,$_POST['genderEdit']);
	$editStmtQry->bindParam(7,$_POST['designationtxt']);
	$editStmtQry->bindParam(8,$Driverid);
	$editStmtQry->execute();
	echo"Updated!";
}

if($action =='Delete')
{	
	//delete from tbuser
	// $tmtdelete = $mysql->prepare("delete from tbluser where EmployeeID=:ids");
	// $tmtdelete->bindParam(':ids',$_POST['id']);	
	// $tmtdelete->exceute();
	try{
	$stmtDeleteQry = $mysql->prepare("DELETE FROM tblemployee WHERE EmployeeID=:idd");
	$stmtDeleteQry->execute([':idd'=>$_POST['id']]);
	echo"data has been deleted!";
	}catch(Exception $b){
		echo"error deleting: ".$b->getMessage();
	}
}

?>


<?php
if($action =='AjaxSearch'){
?>

<table width="100%" class="table table-hover table-dark" id="tableData">
                                <thead>
                                   <tr>
                                            <th>Lastname</th>
                                            <th>Firstname</th>
                                            <th>Middlename</th>
                                            <th>Birthday</th>
                                            <th>Gender</th>
                                            <th>Designation</th>
                                            <th>Action</th>
                                            
                                         
                                           
                                        </tr>
                                </thead>
                                <tbody>

<?php
		try{
			$ajaxQry= $mysql->prepare("select * from tblemployee where DlastName like concat('%',:lastname,'%') AND DfirstName like concat('%',:firstname,'%')");
			$ajaxQry->bindParam(':lastname',$_POST['SearchLastname']);
			$ajaxQry->bindParam(':firstname',$_POST['SearchFirstname']);
			$ajaxQry->execute();
			if($ajaxQry->rowCount()>0){
				while($emrow=$ajaxQry->fetch(PDO::FETCH_OBJ)){
					?>
						
						<td><?php echo $emrow->DlastName;?></td>
						<td><?php echo $emrow->DfirstName;?></td>
						<td><?php echo $emrow->DmiddleName;?></td>
						<td><?php echo $emrow->Dbirthday;?></td>
						<td><?php echo $emrow->Daddress;?></td>
						<td><?php echo $emrow->Dgender;?></td>
						<td><?php echo $emrow->Designation;?></td>
					<?php
				}
			}else{
				echo'<tr><td>No employee found...</td></tr>'.$_POST['SearchLastname'];
			}
		}
		catch(Exception $m){
			echo"Error employee searching!: ".$m->getMessage();
		}

}  //end of AjaxSearch

?>