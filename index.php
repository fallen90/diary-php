<?php
        session_start();

        if(empty($_SESSION) == 1){
            echo "<script>window.location.href='/login.php?need_login'</script>";
            exit(0);
        }

        require_once("common.php");

        require_once("handles.php");

        $edit = 1;

        if(isset($_GET['edit']) && $_GET['edit'] != '0'){
            $edit = 0;
        } else if(isset($_GET['edit'])) {
            header('Location: /');
        }

        $header = random_header();
        $user_id = $_SESSION['user_id'];
        $user = new User($user_id);
        $user = $user->get();
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- <?=$header[1];?> -->
        <title>Memoirs | Space | {Debug} </title>
        <!-- Bootstrap CSS -->
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
        <link href="style.css" rel="stylesheet">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style>
        <?php if(!$edit) {
            ?> .post-ctrl {
                display: block;
            }
            <?php
        }
        
        ?>
        </style>
    </head>

    <body class='main'>
        <div class="container" id="main">
            <div class="row">
                <div class="col-lg-12">
                    <div class="header">
                        <!-- <h1><?=$header[1];?><sub><?=$header[0];?></sub> <span class="pull-right text-muted logout"><a href="/?action=logout">logout</a></span></h1> -->
                        <h1>Memoirs <sub>space</sub> <span class="pull-right text-muted logout"><a href="/?action=logout">logout</a></span></h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-xs-12">
                    <div class="well">
                        <div id="form-container" class="row">
                            <div class="col-xs-2" align="center">
                                <div class="profile composer-profile" style="background-image:url('/assets/avatars/<?php echo $user['user_name'];?>.jpg');"></div>
                            </div>
                            <div class="col-xs-10">
                                <div class="composer" align="right">
                                    <form action="" method="POST">
                                        <input type="hidden" name="user_id" value="<?=$user_id;?>" />
                                        <input type="hidden" name="action" value="create_post" />
                                        <textarea class="form-control" name="body" id="post_body" placeholder="<?=placeholder();?>"></textarea>
                                        <button class="btn btn-success" name="submit" disabled>
                                            Post <span class='char_count'></span>
                                        </button>
                                    </form>
                                    <cite>HTML is accepted</cite>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 post-header">
                    <h3>Posts <!-- <a href='/?edit=<?=$edit;?>' class='edit-link'>edit</a> --><!-- <a class="btn" href="/?sort=asc">▼</a> --></h3>
                    <!-- ▲▼ -->
                    <hr>
                </div>
                <!-- start of list of posts -->
                <?php get_all_posts(); ?>
                    <!-- end of list of post -->
            </div>
            <div class="row" id="footer" align="center">
                <hr width='50%' />
                <span class='copyright text-muted'>Copyright &copy; 2015 Fallen</span>
            </div>
        </div>
        <!-- jQuery -->
        <script src="//code.jquery.com/jquery.js"></script>
        <!-- Bootstrap JavaScript -->
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        <script src="assets/js/app.js"></script>
        <?php if(isset($_GET['add_comment']) && isset($_GET['post_id']) && isset($_GET['comment_id'])) :?>
            <script>
                $(document).ready(function() {
                    $('#reply_post_<?=$_GET['post_id'];?>').trigger('click');
                    $('html, body').animate({
                        scrollTop: $('#comment_<?=$_GET['comment_id'];?>').offset().top
                    }, 1000);
                });
            </script>
        <?php endif; ?>
    </body>

    </html>
