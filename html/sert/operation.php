<?php
require_once "../apps/User.php";
$u = new user();

if(isset($_POST['id']) && !empty($_POST['id']) && isset($_POST['comm']) && !empty($_POST['comm'])){
    $u->refuser($_POST['id'],$_POST['comm']);
}elseif(isset($_GET['accpt']) && !empty($_GET['accpt'])){
    $u->accept($_GET['accpt']);
}

$demande = $u->getDemOppNT();

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Bootstrap Admin Theme</title>

    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

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
                <a class="navbar-brand" href="index.html">SB Admin v2.0</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="profile.php"><i class="fa fa-user fa-fw"></i> User Profile</a>
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
                        <ul class="nav" id="side-menu">
                        <li >
                            <a href="#"><i class="fa fa-edit fa-fw"></i> New Certificate</a>
                        </li>
                        <li class="active">
                            <a href="#"><i class="fa fa-table fa-fw"></i> My Certificate</a>
                        </li >
                    </ul>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Demandes d'Operation Non Traiter</h1>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Demandes
                            </div>
                            <?php 
                                if(empty($demande)){
                                    echo "<p> Pas de demande !</p>";
                                }else {
                                    echo "<div class='panel-body'><div class='table-responsive'><table class='table table-striped table-bordered table-hover'> <thead><tr><th>Nature</th><th>Etat Certifica</th><th>Admin</th><th>Common Name</th><th>Date de Creation Demande</th><th>Date de creation Certifica</th><th>Date d'expiration Certifica</th><th>Action</th></tr></thead><tbody>";
                                    foreach ($demande as $d) {
                                        echo "<tr>";
                                        echo "<td> $d[2]</td>";
                                        echo "<td> $d[3] </td>";
                                        echo "<td> $d[4] </td>";
                                        echo "<td> $d[5] </td>";
                                        echo "<td> $d[6] </td>";
                                        echo "<td> $d[7] </td>";
                                        echo "<td> $d[8] </td>";
                                        echo "<td> <a href='?renew=$d[0]&cid=$d[1]' title='RENEW'><i class='fa fa-repeat'></i></a> | <a href='?rev=$d[0]&cid=$d[1]'  title='REVOKE'><i class='fa fa-power-off'></i></a> </td>";
                                        echo "</tr>";
                                    }
                                    echo "</tbody></table></div></div>";
                                }
                            ?>

                        </div>
                        <!-- /.panel -->
                    </div>

                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>


</body>

</html>
