<?php
session_start();
require_once('config.php');

$action = isset($_POST['action']) ? $_POST['action']:'';
if($action == 'ajaxAutocomplete')
{
	if($_POST['SearchBy'] == 'ModelName'):
		$term=$_POST['term'];
		try
		{
			$AutoCompleteQry=$mysql->prepare("SELECT Vname FROM  tblvehicle where Vname like '%$term%'");
	        $AutoCompleteQry->execute();
		 	while ($row = $AutoCompleteQry->fetch(PDO::FETCH_ASSOC))
	            {
	             $resultData[] = $row['Vname'];
	            }
	            echo json_encode($resultData);
		}
		catch(Exception $s)
		{
			echo "Error Searching: ".$s->getMessage();
		}
        
    endif; 

    if($_POST['SearchBy'] == 'EngineNumber'):
		$term=$_POST['term'];
		try
		{
			$AutoCompleteQry=$mysql->prepare("SELECT VengineNo FROM  tblvehicle where VengineNo like '%$term%'");
	        $AutoCompleteQry->execute();
		 	while ($row = $AutoCompleteQry->fetch(PDO::FETCH_ASSOC))
	            {
	             $resultData[] = $row['VengineNo'];
	            }
	            echo json_encode($resultData);
		}
		catch(Exception $s)
		{
			echo "Error Searching: ".$s->getMessage();
		}
        
    endif; 

    if($_POST['SearchBy'] == 'PlateNos'):
		$term=$_POST['term'];
		try
		{
			$AutoCompleteQry=$mysql->prepare("SELECT VplateNo FROM  tblvehicle where VplateNo like '%$term%'");
	        $AutoCompleteQry->execute();
		 	while ($row = $AutoCompleteQry->fetch(PDO::FETCH_ASSOC))
	            {
	             $resultData[] = $row['VplateNo'];
	            }
	            echo json_encode($resultData);
		}
		catch(Exception $s)
		{
			echo "Error Searching: ".$s->getMessage();
		}
        
    endif; 

    
  //   if($_POST['SearchBy'] == 'PlateNo'):
		// $term=$_POST['term'];
		// try
		// {
		// 	$AutoCompleteQry=$mysql->prepare("SELECT VplateNo FROM  tblvehicle where VplateNo like '%$term%'");
	 //        $AutoCompleteQry->execute();
		//  	while ($row = $AutoCompleteQry->fetch(PDO::FETCH_ASSOC))
	 //            {
	 //             $resultData[] = $row['VplateNo'];
	 //            }
	 //            echo json_encode($resultData);
		// }
		// catch(Exception $s)
		// {
		// 	echo "Error Searching: ".json_encode($s->getMessage());
		// }
        
  //   endif;            
}//end of autocomplete action


if($action == 'createVehicle')
{
	try{
		
		$Inserstmt=$mysql->prepare("INSERT INTO tblvehicle VALUES(NULL,:vehicleName,:engineNo,:chassisNo,:plateno,:vehicleColor)");
		$Inserstmt->execute([':vehicleName'=>$_POST['Modelnametxt'],':engineNo'=>$_POST['Enginetxt'],':chassisNo'=>$_POST['Chassistxt'],':vehicleColor'=>$_POST['Colortxt'],':plateno'=>$_POST['PlateNotxt']]);
		echo"Data has been saved!";
	}catch(SQLException $e){
		echo"Insert Query failed! :".$e->getMessage();
	}
	
}		

if($action =='updateVehicle')
{
	$vi_d = base64_decode($_POST['v_id']);
	$updatestmt = $mysql->prepare("UPDATE tblvehicle SET Vname=?,VengineNo=?,VchassisNo=?,VplateNo=?,Vcolor=? WHERE vehicleID=?");
	//$updatestmt = $mysql->prepare("UPDATE tblvehicle SET Vname=?,VengineNo=?,VchassisNo=?,VplateNo=?,Vcolor=? WHERE vehicleID=?");
	$updatestmt->bindParam(1,$_POST['EditModelnametxt']);
	$updatestmt->bindParam(2,$_POST['EditEnginetxt']);
	$updatestmt->bindParam(3,$_POST['EditChassistxt']);
	$updatestmt->bindParam(4,$_POST['EditPlateNotxt']);
	$updatestmt->bindParam(5,$_POST['EditColortxt']);
	$updatestmt->bindParam(6,$vi_d);
	$updatestmt->execute();
	echo"Updated!";
}



if($action =='Delete')
{
	$stmtDeleteQry = $mysql->prepare("DELETE FROM tblvehicle WHERE vehicleID=:idd");
	$stmtDeleteQry->execute([':idd'=>$_POST['id']]);
	echo"data has been deleted!";
}

?>


<?php
if($action == 'AjaxSearch')
{
?>

<table width="100%" class="table table-hover table-dark" id="tableData">
                                <thead>
                                    <tr>
                                       <!--  <th>#</th> -->
                                        <th>Model</th>
                                        <th>EngineNo</th>
                                        <th>ChassisNo</th>
                                        <th>Color</th>
                                        <th>PlateNumber</th>
                                        <th>Action</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>

<?php	
	try{
		$ajaxQry= $mysql->prepare("select * from tblvehicle where Vname like concat('%',:model,'%') AND VengineNo like concat('%',:engine,'%') AND VplateNo like concat('%',:plateno,'%')");
		$ajaxQry->bindParam(':model',$_POST['SearchModel']);
		$ajaxQry->bindParam(':engine',$_POST['SearchEngine']);
		$ajaxQry->bindParam(':plateno',$_POST['SearchPlateno']);
		$ajaxQry->execute();
		if($ajaxQry->rowCount()>0):
			
			while($rw = $ajaxQry->fetch(PDO::FETCH_OBJ))
				{
					echo'<tr>';
					//echo'<td>100' .$rw->vehicleID.'</td>';
					echo'<td>' .$rw->Vname.'</td>';
					echo'<td>' .$rw->VengineNo.'</td>';
					echo'<td>' .$rw->VchassisNo.'</td>';
					echo'<td>' .$rw->Vcolor.'</td>';
					echo'<td>' .$rw->VplateNo.'</td>';
					
					
?>
						<td>
							<div class="btn-group">
										  <button type="button" class="btn btn-default dropdown-toggle btn-action" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										    Action <span class="caret"></span>
										  </button>
										  <ul class="dropdown-menu">
										    <li><a href="#">Action</a></li>
										    <li><a href="edit_vehicle.php?id=<?php echo base64_encode($rw->vehicleID); ?>">Edit</a></li>
										    <li><a href="#" onClick='remove("<?php echo $rw->vehicleID;?>","../api/vehicle.ajax.php","vehicle.php");'>Delete</a></li>

										  </ul>
										</div>
							</td>
						</tr>

<?php			}
		else: echo'<tr><td>No data found!</td></tr>';		
		endif;	
	}catch(Exception $n){	
		echo"error:".$n->getMessage();
	}
echo'</tbody></table>';	
}


?>