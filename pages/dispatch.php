<?php
session_start();
include('session.php');
include('../api/config.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Popcom Ticketing System</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

     <link href="../js/jquery-ui/jquery-ui.css" rel="stylesheet" type="text/css">



    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="main.php">Popcom Ticketing System</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
               
 <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            
            </ul>
            <!-- /.navbar-top-links -->

<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li class="sidebar-search">
                <div class="input-group custom-search-form">
                    <!--  <input type="text" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">
                        <i class="fa fa-search"></i>
                        </button>
                    </span> -->
                    
                </div>
                <div style="padding :0px;">
                    <center> <img class="responsive" style="height: 100px;width:100px;" src="../img/useravatar.PNG"/><br />
                    <?php echo'Welcome '.$_SESSION['userName']; ?><br />
                    
                    </center>
                </div>
            </li>
            
            
                    
                </ul>
            </li>
            
        </ul>
        <!-- /.nav-second-level -->
    </li>
</ul>
</div>
<!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->
</nav>
        <div id="page-wrapper">

            
                <div class="row"></div>
<div class="row" style="margin-top:1em;">
 <?php /*   <div class="col-lg-12">
        <div class="panel panel-primary">
                        <div class="panel-heading">
                            Schedule Task
                        </div>
                        <div class="panel-body">
                             <form id="Form-DriverFilter"> 
                             <input type="hidden" name="action" id="action" value="AjaxSearch"/>      
                             <div class="col-lg-2"></div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <!-- <label>Date From:</label>
                                        <input type="date" class="form-control" name="dateFrom" id="dateFrom" value="<?php //echo $Today; ?>" /> -->
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <!-- <label>Date To:</label>
                                        <input type="date" class="form-control" name="dateFrom" id="dateFrom" value="<?php //echo $Today; ?>" /> -->
                                    </div>
                                </div>

                                <div class="col-lg-2"></div>
                                <!--END OF DATA FILTER DIV-->   

                               
                                <div class="col-lg-6">
                                    <div class="col-lg-5"></div>
                                    <div class="form-group col-lg-7">
                                        <label>Lastname </label>
                                        <input type="text" class="form-control" name="SearchLastname" id="SearchLastname"  />
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group col-lg-7">
                                        <label >Firstname </label>
                                        <input type="text" class="form-control" name="SearchFirstname" id="SearchFirstname"  />
                                    </div>
                                    <div class="col-lg-4"></div>
                                </div>
                               
                              
                                 
                                 
                                <div class="col-lg-12"><center> <button type="submit" class="btn btn-primary btn-lg-block">Search</button></center></div>
                               
                            </form>
                        </div> <!-- END OF PANEL BODY -->
                        <!-- <div class="panel-footer">
                            Panel Footer
                        </div> -->
                    </div>
    </div> */ ?>
    
</div> <!-- END OF ROW FILTER -->



    

<div class="row" style="margin-top:1em;">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Subject to transport
                        </div>
                        <?php
                        try{
                            //get ticketNo to print
                            $mtQry = $mysql->prepare("select ticketNo from tblticket where EmployeeID='".$_SESSION['userEmployeeID']."'");
                            $mtQry->execute();

                            while($trow=$mtQry->fetch(PDO::FETCH_ASSOC)){
                                $ticket_no = $trow['ticketNo'];
                            }
                        }catch(Exception $n){
                            echo'error query failed!:'. $n->getMessage();
                        }
                        ?>
                        <div style="margin-top:1em;margin-left: 1em" >
                            <button type="button" class=" btn btn-primary" onClick="PrintData('../api/dispatch_print.php','<?php echo base64_encode($ticket_no); ?>')">Print</button></div>
                        <!-- /.panel-heading -->
                        <div class="panel-body results"> <!--TICKET LOADER CONTAINER-->
        
                            <table width="100%" class="table table-hover table-dark" id="tableData">
                                <thead>
                                    <tr>
                                        <th>TicketNo</th>
                                        <th>Driver</th>
                                        <th>Vehicle</th>
                                        <th>Destination</th>
                                        <th>Passenger</th>
                                        <th>Date</th>
                                        <th>Remarks</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
<?php
try{
    $stmts=$mysql->prepare("SELECT DISTINCT ticket.ticketNo as ticketNo,ticket.udestination as udestination,ticket.upassenger as upassenger,ticket.udate as Udate,ticket.Remarks as Remarks,concat(driver.DfirstName,' ',driver.DlastName) as driver,vehicled.Vname as Vname from tblticket as ticket inner join tblemployee as driver ON ticket.EmployeeID = driver.EmployeeID inner join tblvehicle as vehicled ON ticket.vehicleID = vehicled.vehicleID WHERE ticket.Udate = :today and ticket.EmployeeID =:uName");     
    $stmts->bindParam(':today',$Today);
    $stmts->bindParam(':uName',$_SESSION['userEmployeeID']);
    $stmts->execute();
    while($disrow = $stmts->fetch(PDO::FETCH_ASSOC))
        {
          
            $ticketNO = $disrow['ticketNo'];
            $Driver = $disrow['driver'];
            $Vehicle = $disrow['Vname'];
            $destinatioN=$disrow['udestination'];
            $passnger = $disrow['upassenger'];
            $udate = $disrow['Udate'];
            $remarkS=$disrow['Remarks'];
        
?>  
                              <tr>
                                <td><?php echo $ticketNO; ?></td>
                                <td><?php echo $Driver; ?></td>
                                <td><?php echo $Vehicle; ?></td>
                                <td><?php echo $destinatioN; ?></td>
                                <td><?php echo $passnger; ?></td>
                                <td><?php echo $udate; ?></td>
                                <td><?php echo $remarkS; ?></td>
                            </tr>





                                    

<?php           
    }//end of while loop           
        
}catch(Exception $e){

}

?>


                                </tbody>
                            </table>
     
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            
            
      </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
  
    <!-- <script src="../vendor/jquery/jquery.min.js"></script> -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../js/sweetalert.min.js"></script>
     <script src="../js/custom.js"></script>



    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="../vendor/raphael/raphael.min.js"></script>
    <!-- <script src="../vendor/morrisjs/morris.min.js"></script>
    <script src="../data/morris-data.js"></script> -->

    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
   <!--  <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script> -->
    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    <!--Jqueryui-->
    <script src="../js/jquery-ui/jquery-ui.js"></script>
    <script>
    $(document).ready(function() {
        $('#tableData').DataTable({
            'paging': true,
            'pageLength': 10,
        //     dom: 'Bfrtip',
        // buttons: [
        //     'copy', 'csv', 'excel', 'pdf', 'print'
        // ]

            
        });
    });
       
    </script>

</body>

</html>