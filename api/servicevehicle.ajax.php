<?php
session_start();
include('../pages/session.php');
require_once('config.php');
$action = isset($_POST['action']) ? $_POST['action']:'';
if($action == 'ajaxAutocomplete')
{
	if($_POST['SearchBy'] == 'PO_number'):
		$term=$_POST['term'];
		try
		{
			$AutoCompleteQry=$mysql->prepare("SELECT PONumber FROM  tblvehicleservice where PONumber like '%$term%'");
	        $AutoCompleteQry->execute();
		 	while ($row = $AutoCompleteQry->fetch(PDO::FETCH_ASSOC))
	            {
	             $resultData[] = $row['PONumber'];
	            }
	            echo json_encode($resultData);
		}
		catch(Exception $s)
		{
			echo "Error Searching: ".$s->getMessage();
		}
        
    endif; 

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

    
    if($_POST['SearchBy'] == 'PlateNo'):
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
			echo "Error Searching: ".json_encode($s->getMessage());
		}
        
    endif;            
}//end of autocomplete action


if($action =='CreateService')
{ 
	try{
		$checkPOQry =$mysql->prepare("SELECT PONumber from tblvehicleservice where PONumber=:po");
		$checkPOQry->execute([':po'=>$_POST['PoNumber']]);
		if($checkPOQry->rowCount()>0){
			echo"PONumber exist! Please try another one..";	
		}else{
			$serviceQry=$mysql->prepare("INSERT INTO tblvehicleservice VALUES(NULL,:vid,:vdescription,:vamount,:vdate,:Po,:company,:vstamp)");
			$serviceQry->execute([':vid'=>$_POST['Vehicle'],':vdescription'=>$_POST['NatureWork'],':vamount'=>$_POST['Amount'],':vdate'=>$_POST['Datetxt'],':Po'=>$_POST['PoNumber'],':company'=>$_POST['Company'],':vstamp'=>$Today]);
			echo"success!";
		}
		
	}
	catch(Exception $e)
	{
		echo"Failed to insert: ".$e->getMessage();
	}
}

if($action =='EditService')
{
	try{
		$SID=base64_decode($_POST['sid']);
		$updateSvc = $mysql->prepare("UPDATE tblvehicleservice SET vehicleID=?,Vdescription=?,Vamount=?,Vservicedate=?,PONumber=?,Scompany=?,Vstamp=? WHERE VserviceID=?");
		$updateSvc->bindParam(1,$_POST['VehicleID']);
		$updateSvc->bindParam(2,$_POST['Particular']);
		$updateSvc->bindParam(3,$_POST['Amount']);
		$updateSvc->bindParam(4,$_POST['Datetxt']);
		$updateSvc->bindParam(5,$_POST['POnumber']);
		$updateSvc->bindParam(6,$_POST['Company']);
		$updateSvc->bindParam(7,$_POST['editstamp']);
		$updateSvc->bindParam(8,$SID);
		$updateSvc->execute();	
		echo"Updated";
	}
	catch(Exception $k){
		echo"Error : ".$k->getMessage();
	}
	
}


if($action =='Delete')
{
	$stmtDeleteQry = $mysql->prepare("DELETE FROM tblvehicleservice WHERE VserviceID=:serviceId");
	$stmtDeleteQry->execute([':serviceId'=>$_POST['id']]);
	echo"data has been deleted!";
}
?>


<?php
if($action == 'AjaxSearch')
{
?>
<div class="panel panel-default">
                        <div class="panel-heading">
                            Vehicle Service and Maintenance
                        </div>
                        <!-- /.panel-heading -->
                        <div style="padding:0.5em"><button type="button" class="btn btn-primary" onClick="PrintReport('../api/vehicleservicehistory_print.php')">Print</button></div>
                        <div class="panel-body "> <!--LOADER CONTAINER-->

<table width="100%" class="table table-hover table-dark" id="tableData">
                                <thead>
                                    <tr>
                                     <th>Model</th>
                                        <th>EngineNo</th>
                                        <th>PlateNo</th>
                                        <th>Nature of Work</th>                                                       
                                      	 <th>PO/JO# </th>
                                      	 <th>Contracted Shop</th>
                                      	 <th>ServiceDate</th>
                                      	 <!-- <th>serviceID</th> -->
                                          <th>Amount</th>         
                                      	 <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

<?php	
	try{
		$ajaxQry= $mysql->prepare("select service.VserviceID as VserviceID,service.Vdescription as Vdescription,service.Vamount as Vamount,service.Vservicedate as Vservicedate,service.PONumber as PONumber,service.Scompany as Scompany,vehicle.Vname as Vname,vehicle.VplateNo as VplateNo,vehicle.VengineNo from tblvehicleservice as service inner join tblvehicle as vehicle on service.vehicleID = vehicle.vehicleID where service.PONumber like concat('%',:PO,'%') AND vehicle.Vname like concat('%',:model,'%') AND vehicle.VengineNo like concat('%',:engine,'%') AND vehicle.VplateNo like concat('%',:plateno,'%') AND service.Vservicedate between :dFrom and :dTo");
		$ajaxQry->bindParam(':PO',$_POST['searchPO']);
		$ajaxQry->bindParam(':model',$_POST['SearchModelname']);
		$ajaxQry->bindParam(':engine',$_POST['SearchEngine']);
		$ajaxQry->bindParam(':plateno',$_POST['SearchPlateNo']);
		$ajaxQry->bindParam(':dFrom',$_POST['dateFrom']);
		$ajaxQry->bindParam(':dTo',$_POST['dateTo']);
		$ajaxQry->execute();
		if($ajaxQry->rowCount()>0):
			
			while($rw = $ajaxQry->fetch(PDO::FETCH_OBJ))
				{
					echo'<tr>';					
					echo'<td>' .$rw->Vname.'</td>';
					echo'<td>' .$rw->VengineNo.'</td>';
					echo'<td>' .$rw->VplateNo.'</td>';
					echo'<td>' .$rw->Vdescription.'</td>';
					echo'<td>' .$rw->PONumber.'</td>';
					echo'<td>' .$rw->Scompany.'</td>';
					echo'<td>' .$rw->Vservicedate.'</td>';
					// echo'<td>' .$rw->VserviceID.'</td>';
					echo'<td>' .$rw->Vamount.'</td>';
	
					
					
?>
						<td>
							<div class="btn-group">
										  <button type="button" class="btn btn-default dropdown-toggle btn-action" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										    Action <span class="caret"></span>
										  </button>
										  <ul class="dropdown-menu">
										    <li><a href="#">Action</a></li>
										    <li><a href="edit_vehicleservice.php?id=<?php echo base64_encode($rw->VserviceID); ?>">Edit</a></li>
										    <li><a href="#" onClick='remove("<?php echo $rw->VserviceID;?>","../api/servicevehicle.ajax.php","vehiclemaintenance.php");'>Delete</a></li>
										    <li><a href="#" onClick="PrintData('../api/vehicleservice_print.php','<?php echo base64_encode($rw->VserviceID); ?>')">Print</a></li>

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
echo'</tbody>
</table>
</div>
</div>

';
}


?>

  		
          
                   