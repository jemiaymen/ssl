<?php
require_once "../apps/User.php";
$u = new user();
if(!$u->isauth()){
    header("Location: logout.php");
}
$data = $u->getUser();
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
                        <h1 class="page-header">Demande Certification</h1>
                    </div>
                    <div class='col-md-8 col-md-offset-2'>
                        <div class='login-panel panel panel-info'>
                            <div class='panel-heading'>
                                <h3 class='panel-title'>Demande</h3>
                            </div>
                            <div class='panel-body'>
                                <?php if(!empty($_GET['add']) && $_GET['add'] =='ok') echo "<div class='alert alert-success alert-dismissable'> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Demande Envoyer avec succée . </div>
"; elseif(!empty($_GET['error']) && $_GET['error'] == 'yes') echo "<div class='alert alert-danger alert-dismissable'> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Erreur :  impossible envoyer la Demande ! </div>"; ?>
                                <form role='form' method='post' action='auth.php'>
                                    <fieldset>
                                        <div class='form-group'>
                                            <label>Hash methode</label>
                                            <select class='form-control' name='hash'   required>
                                                <option value="md5">MD5</option>
                                                <option value="sha1">SHA1</option>
                                            </select>
                                        </div>

                                        <div class='form-group'>
                                            <label>Private Key Lenth</label>
                                            <select class='form-control' name='len'   required>
                                                <option value="512">512</option>
                                                <option value="1024">1024</option>
                                                <option value="2048">2048</option>
                                                <option value="4096">4096</option>
                                            </select>
                                        </div>

                                        <div class='form-group'>
                                            <label>Type</label>
                                            <select class='form-control' name='type'   required>
                                                <option value="Personelle">Certifica Personelle</option>
                                                <option value="Societe">Certifica de Société</option>
                                            </select>
                                        </div>

                                        <div class='form-group'>
                                            <label>Days</label>
                                            <select class='form-control' name='d'   required>
                                                <option value="365">1 an (365j)</option>
                                                <option value="730">2 ans (730j)</option>
                                                <option value="1095">3 ans (1095j)</option>
                                            </select>
                                        </div>

                                        
                                        <div class='form-group'>
                                        <label>Subject</label>
                                            <textarea  class='form-control'  name='subj' required readonly><?php echo "/C=$data[1]/ST=$data[2]/L=$data[3]/O=$data[4]/OU=$data[5]/CN=$data[6]/emailAddress=$data[7]" ; ?></textarea>
                                        </div>
                                        


                                        <button type='submit' class='btn btn-lg btn-info btn-block' >OK</button>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
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
