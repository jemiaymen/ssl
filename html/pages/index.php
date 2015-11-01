<?php
require_once "../apps/User.php";
$u = new user();
if(!$u->isauth()){
    header("Location: logout.php");
}
if (isset($_GET['ca']) && is_numeric($_GET['ca'])) {
    $file = "../sert/ca.crt";
    file_put_contents($file, $u->getCA($_GET['ca']));
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    unlink($file);
}elseif (isset($_GET['k']) && is_numeric($_GET['k'])) {
    $file = "../sert/Pkey.pem";
    file_put_contents($file, $u->getPK($_GET['k']));
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    unlink($file);
}elseif (isset($_GET['renew']) && is_numeric($_GET['renew'])){
    $u->demandeRenew($_GET['renew']);
}

$data = $u->getUser();
$certs = $u->getUserCertif();
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
                        <h1 class="page-header">Mes Certification </h1>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <?php echo $data[5] ; ?>
                            </div>

                            <?php 
                                if(empty($certs)){
                                    echo "Pas de Certification pour :" . $data[5] ;
                                }else {
                                    echo "<div class='panel-body'><div class='table-responsive'><table class='table table-striped table-bordered table-hover'> <thead><tr><th>Admin</th><th>Date Creation</th><th>Date Expiration</th><th>Hash</th><th>Key</th><th>Etat</th><th>Download</th><th>Operation</th></tr></thead><tbody>";
                                    foreach ($certs as $d) {
                                        //cert.id, admin, dtcr, dtexp, hash, len, ops, subj, cert.dtc,  ca, pkey 
                                        echo "<tr>";
                                        echo "<td>" . $d[1] . "</td>";
                                        echo "<td>" . $d[2] . "</td>";
                                        echo "<td>" . $d[3] . "</td>";
                                        echo "<td>" . $d[4] . "</td>";
                                        echo "<td>" . $d[5] . "</td>";
                                        echo "<td>" . $d[6] . "</td>";
                                        echo "<td> <a href='?ca=$d[0]'>CA</a> | <a href='?k=$d[0]'>Pkey</a></td>";
                                        if ($d[6] == 'NEW') {
                                            echo "<td> <a href='?renew=$d[0]'>Renew</a> | <a href='?rev=$d[0]'>Revoke</a></td>";
                                        }else{
                                            echo "<td> Operation En cour </td>";
                                        }
                                        
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
