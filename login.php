<?php
    session_start();
    require_once("common.php");
    require_once("handles.php");
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Bootstrap CSS -->
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
        <link href="style.css" rel="stylesheet">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body class='login'>
        <div class="container" id="login">

            <?php if(isset($_GET['do_login']) && $_GET['do_login'] =='error'):?>
                <div class="alert alert-danger">
                    Login Error!!
                </div>
            <?php endif;?>
            <?php if(isset($_GET['need_login'])):?>
                <div class="alert alert-danger">
                    You need to be loggedin to access this.
                </div>
            <?php endif;?>
            <form action="" method="POST" class="form-horizontal" role="form">
                <input type="hidden" name="action" value="do_login">
                <div class="form-group">
                    <label class="control-label col-sm-4">
                        Username
                    </label>
                    <div class="col-sm-8">
                        <input type="text" name="user_name" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">
                        Password
                    </label>
                    <div class="col-sm-8">
                        <input type="password" name="user_pass" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-8 col-sm-offset-4">
                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- jQuery -->
        <script src="//code.jquery.com/jquery.js"></script>
        <!-- Bootstrap JavaScript -->
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    </body>

    </html>
