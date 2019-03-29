<?php
//session_start();
require_once('config.php');

try{
	$get = $mysql->prepare("SELECT * FROM tblmainmoduleaccess WHERE uid=:uid AND uname=:uname");
	//$get->bindParam(1,$_SESSION['userId']);
	$get->execute([':uid' => $_SESSION['userId'], ':uname' => $_SESSION['userName']]);

	if($get->rowCount() >0):
		//while($row=$get->fetch()){
		while($row=$get->fetch(PDO::FETCH_OBJ))
		{
?>			


		<li class="parent "><a data-toggle="collapse" href="#sub-item-1">
				<?php echo $row->ModuleCode; ?> 
				<span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><em class="fa fa-plus"></em></span>
				</a> 
				<ul class="children collapse" id="sub-item-1">
					<li><a class="active" href="<?php echo $row->page; ?>">
						<span class="fa fa-arrow-right">&nbsp;</span> Tickets
					</a></li>
					<li><a class="" href="addticket.php">
						<span class="fa fa-arrow-right">&nbsp;</span> Add Tickets
					</a></li>

					
				</ul>
			</li>

			

			 



<?php			
		}
	else: echo"You have no access!";	
	endif;
	

}
catch(Exception $e)
{
	echo"QueryFailed! ".$e->getMessage();
}

