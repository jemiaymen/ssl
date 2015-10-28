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
                        <h1 class="page-header">User Profile</h1>
                    </div>
                    <div class='col-md-8 col-md-offset-2'>
                        <div class='login-panel panel panel-default'>
                            <div class='panel-heading'>
                                <h3 class='panel-title'>Update Profile</h3>
                            </div>
                            <div class='panel-body'>
                                <?php if(!empty($_GET['update']) && $_GET['update'] =='ok') echo "<div class='alert alert-success alert-dismissable'> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Modification avec succée . </div>
"; elseif(!empty($_GET['error']) && $_GET['error'] == 'yes') echo "<div class='alert alert-danger alert-dismissable'> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Erreur de Modification ! </div>"; ?>
                                <form role='form' method='post' action='auth.php'>
                                    <fieldset>
                                        <div class='form-group'>
                                            <input class='form-control' placeholder='E-mail' name='email' type='email'  value='<?php echo $data[7]; ?>' readonly>
                                        </div>
                                        
                                        <div class='form-group'>
                                            <input class='form-control' placeholder='Code Pays (TN)' name='c' type='text' value='<?php echo $data[1]; ?>' required>
                                        </div>
                                        <div class='form-group'>
                                            <input class='form-control' placeholder='Pays (Tunisia)' name='st' type='text' value='<?php echo $data[2]; ?>' required>
                                        </div>
                                        <div class='form-group'>
                                            <input class='form-control' placeholder='etat (Tunis)' name='l' type='text' value='<?php echo $data[3]; ?>' required>
                                        </div>
                                        <div class='form-group'>
                                            <input class='form-control' placeholder='Organisation (Internet Ltd.)' name='o' type='text' value='<?php echo $data[4]; ?>' required>
                                        </div>
                                        <div class='form-group'>
                                            <input class='form-control' placeholder='Name (Persone)' name='ou' type='text' value='<?php echo $data[5]; ?>' required>
                                        </div>
                                        <div class='form-group'>
                                            <input class='form-control' placeholder='Common Name (domain.com or id name)' name='cn' type='text' value='<?php echo $data[6]; ?>' required>
                                        </div>
                                        <div class='form-group'>
                                            <input class='form-control' placeholder='Tel : (+216)22000111' name='tel' type='text' pattern='^(+[0-9]{3})[0-9]{2}[0-9]{3}[0-9]{3}' value='<?php echo $data[9]; ?>' required>
                                        </div>


                                        <button type='submit' class='btn btn-lg btn-danger btn-block' >Update</button>
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
