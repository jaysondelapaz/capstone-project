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
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0;background-color: #131215;">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Popcom Ticketing System</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
               <?php
                 $stmtDriver = $mysql->prepare("SELECT EmployeeID,DfirstName,DlastName FROM tblemployee WHERE EmployeeID NOT IN (SELECT distinct EmployeeID FROM tblticket WHERE udate='$Today'  AND Status <> 'Posted') AND Designation='0' ");
                    $stmtDriver->execute();


               ?>

                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                       <i class="fa fa-male fa-fw"></i> 
                       <!-- <span style="background-color:red;color:#fff;border:1px solid #ffff;padding:8px;border-radius: 55em 55em;"><?php echo $stmtDriver->rowCount();?></span> --><i class="fa fa-caret-down"></i>
                    </a> 
                    <ul class="dropdown-menu dropdown-alerts">
                         <?php
                               
                                 echo'<strong style="margin-left:10px;">Available Driver</strong>';
                                if($stmtDriver->rowCount()>0)
                                {
                                    while($drow=$stmtDriver->fetch(PDO::FETCH_OBJ))
                                        {
                                
                                ?>
                                
                                        <li>
                                            <a href="#">
                                                <div>
                                                    <i class="fa fa-male fa-fw"></i> <?php echo $drow->DfirstName.' '.$drow->DlastName;?>
                                                    <span class="pull-right text-muted small"></span>
                                                </div>
                                            </a>
                                        </li>

                                <?php            
                                            
                                        }
                                }
                                else
                                {
                                    echo"No Driver Available";
                                }
                                ?>
                        
                    </ul>
                    <!-- /.dropdown-alerts -->
                </li>



                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-truck fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <?php
                                $stmtvehicle = $mysql->prepare("select Vname,VplateNo from tblvehicle where vehicleID not in (select distinct vehicleID from tblticket WHERE udate='$Today' and Status <> 'Posted')");
                                $stmtvehicle->execute();
                                 echo'<strong style="margin-left:10px;">Available Vehicle</strong>';
                                if($stmtvehicle->rowCount()>0)
                                {
                                    while($vrow=$stmtvehicle->fetch(PDO::FETCH_OBJ))
                                        {
                                ?>
                                
                                <li>
                                    <a href="#">
                                        <div>
                                            <i class="fa fa-truck fa-fw"></i> <?php echo $vrow->Vname;?>
                                            <span class="pull-right text-muted small"><?php echo$vrow->VplateNo; ?></span>
                                        </div>
                                    </a>
                                </li>

                                <?php            
                                            
                                        }
                                }
                                else
                                {
                                    echo"No Vehicle Available";
                                }
                                ?>
                        
                    </ul>
                    <!-- /.dropdown-alerts -->
                </li>
                <!-- /.dropdown -->
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

<div class="navbar-default sidebar" role="navigation" style="background-color: #ffff;">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li class="sidebar-search">
                <div class="input-group custom-search-form">
                  
                </div>
                <div style="padding :0px;">
                    <center> <img class="responsive" style="height: 100px;width:100px;" src="../img/useravatar2.PNG"/><br />
                    <?php echo'Welcome '.$_SESSION['userName']; ?><br />
                    
                    </center>
                </div>
            </li>
            
            <li>
                <a href="#"><i class="fa fa-ticket fa-fw" style="background-color:blue; ;color:#ffff;"></i> Schedule<span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">
                    
                    <li>
                        <a href="home.php">Ticket</a>
                    </li>
                    <li>
                        <a href="addticket.php" >Create ticket</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-male fa-fw" style="background-color: green;color:#ffff;"></i> Driver<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    
                    <li>
                        <a href="driverprofile.php">Driver Profile</a>
                    </li>

                    <li>
                        <a href="drivertask.php">Driver Task</a>
                    </li>
                  
                </ul>
                
            </li>
            <li>
                <a href="#"><i class="fa fa-truck fa-fw" style="background-color: red;color:#ffff;"></i> Vehicle<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="vehicle.php">Vehicle Profile</a></li>
                    <li><a href="addvehicle.php">Create Vehicle Profile</a></li>
                    <li><a href="vehiclemaintenance.php">Service & Maintenance</a></li>
                    <li><a href="addvehicleservice.php">Create Service</a></li>
                </ul>
            </li>
            <li>
                <a href="summaryreport.php"><i class="fa fa-history fa-fw" style="background-color: orange;color:#ffff;"></i> Report</a>
            </li>
            <li>
                <a href="#"><i class="fa fa-wrench fa-fw" style="background-color:blueviolet;color:#ffff;"></i> Dashboard<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                     <li><a href="employee.php">Employee</a></li>
                     <li><a href="addemployee.php">Create Employee</a></li>
                    <li><a href="user.php">User</a></li>
                     <li><a href="adduser.php">Create User</a></li>
                     
                  
                    
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
