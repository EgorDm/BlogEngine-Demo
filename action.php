<?php
include_once 'header.php';

$registermessage = '';
$registersuccess = 0;

$loginmessage = '';
$loginsuccess = 0;
if(isset($_GET['action'])) {
    if($_GET['action'] == 'logout') {
        $bea->user->logout();
        header("Location: index.php?action=2");
        die();
    } else if($_GET['action'] == 'viewpost') {
        if(isset($_GET['post'])) {
            $post_data = $bea->get_post($_GET['post']);
            if (BEDatabase::get_instance()->rowCount() < 1) {
                $post_data['post_title'] = 'Post not found';
                $post_data['post_owner'] = '';
                $post_data['post_date'] = '';
                $post_data['post_cont'] = '';
            }
            if ($isloggedin) {
                $can_delete = $bea->user->has_permission($_SESSION['user_id'], 'perm_deletepost');
                $can_edit = $bea->user->has_permission($_SESSION['user_id'], 'perm_editpost');
            }
        }
    } else if($_GET['action'] == 'deletepost') {
        if(isset($_GET['post']) && $isloggedin) {
            $post_data = $bea->get_post($_GET['post']);
            if($_SESSION['user_id'] == $post_data['post_owner']) {
                $bea->delete_post($_GET['post']);
                header("Location: index.php?action=3");
            } else {
                header("Location: index.php?action=4");
            }
        } else {
            header("Location: index.php?action=4");
        }
    } else if($_GET['action'] == 'editpost') {
        if(isset($_GET['post']) && $isloggedin) {
            $post_data = $bea->get_post($_GET['post']);
            if (BEDatabase::get_instance()->rowCount() > 0) {
                if($_SESSION['user_id'] == $post_data['post_owner']) {

                } else {
                    header("Location: index.php?action=4");
                }
            } else {
                header("Location: index.php?action=5");
            }
        } else {
            header("Location: index.php?action=4");
        }
    }
}

if(!empty($_POST['register'])) {
    if(isset($_POST['fullname'], $_POST['username'], $_POST['email'], $_POST['password'])) {
        $fullname = filter_input(INPUT_POST, 'fullname', FILTER_SANITIZE_STRING);
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $email = 	filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $email = 	filter_var($email, FILTER_VALIDATE_EMAIL);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $registermessage = '<p class="error">Please enter a valid email adress.</p>';
            $registersuccess = -1;
        } else if (strlen($fullname)<4||strlen($fullname)>64) {
            $registermessage = '<p class="error">Please enter a valid name.</p>';
            $registersuccess = -1;
        } else if (strlen($username)<6||strlen($username)>32) {
            $registermessage = '<p class="error">Your username must be between 6 and 32 characters</p>';
            $registersuccess = -1;
        } else if (strlen($email)<4||strlen($email)>64) {
            $registermessage = '<p class="error">Please enter a valid email adress.</p>';
            $registersuccess = -1;
        } else if (strlen($password)<6||strlen($password)>16) {
            $registermessage = '<p class="error">Your password must be between 6 and 16 characters.</p>';
            $registersuccess = -1;
        } else {
            $registerresult = $bea->user->register($fullname, $email, $username, $password, 1);
            if($registerresult == -1) {
                $registermessage = '<p class="error">Account with specified email adress already exists.</p>';
                $registersuccess = -1;
            } else if($registerresult == -3) {
                $registermessage = '<p class="error">Account with specified username already exists.</p>';
                $registersuccess = -1;
            } else if($registerresult == -2) {
                $registermessage = '<p class="error">Server error please contact the admin for help.</p>';
                $registersuccess = -1;
            } else {
                $registermessage = '<p class="success">Registered succesfully</p>';
                $registersuccess = 1;
                header("Location: action.php?action=login&registersuccess");
                die();
            }
        }
    } else {
        $registermessage = '<p class="error">Please fill in everything correctly.</p>';
    }
}
if(!empty($_POST['login'])) {
    if(isset($_POST['username'], $_POST['password'])) {
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

        if (strlen($username)<6||strlen($username)>32) {
            $loginmessage = '<p class="error">Please enter a valid username.</p>';
            $loginsuccess = -1;
        } else if (strlen($password)<6||strlen($password)>16) {
            $loginmessage = '<p class="error">Please enter a valid password.</p>';
            $loginsuccess = -1;
        } else {
            $loginresult = $bea->user->login($username, $password);
            if($loginresult == -1) {
                $loginmessage = '<p class="error">Username or password does not exist.</p>';
                $loginsuccess = -1;
            } else {
                header("Location: index.php?action=1");
                die();
            }
        }
    } else {
        $loginmessage = '<p class="error">Please fill in everything correctly.</p>';
    }
}
if(!empty($_POST['editpost'])) {
    $can_edit = $bea->user->has_permission($_SESSION['user_id'], 'perm_editpost');
    if($isloggedin && $can_edit) {
        if(isset($_GET['post'])) {
            if($_SESSION['user_id'] == $post_data['post_owner']) {
                $bea->edit_post($_GET['post'], $_POST['ptitle'], $_POST['pdesc'], $_POST['pcont'], $_SESSION['user_id']);
                header("Location: action.php?action=viewpost&post=" . $_GET['post']);
            } else {
                header("Location: index.php?action=4");
            }
        }
    } else {
        header("Location: index.php?action=5");
    }
}

if(!empty($_POST['newpost'])) {
    $can_create = $bea->user->has_permission($_SESSION['user_id'], 'perm_createpost');
    if($isloggedin && $can_create) {
        $bea->add_post($_POST['ptitle'], $_POST['pdesc'], $_POST['pcont'], $_SESSION['user_id']);
        header("Location: action.php?action=viewpost&post=" . BEDatabase::get_instance()->lastInsertId());
    } else {
        header("Location: index.php?action=5");
    }
}

?>
<div class="container">
    <div style="margin-top: 50px"></div>
    <?php if(isset($_GET['registersuccess'])) { ?>
        <div class="alert alert-success" role="alert">Registered succesfully!</div>
    <?php } ?>

    <?php if(isset($_GET['action'])) { if($_GET['action'] == 'login' && !$isloggedin) {?>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="page-header">
                    <h1>Sign In</h1>
                    <p><?php echo $loginmessage; ?></p>
                </div>
                <form method="post">
                    <div class="row">
                        <div class="col-md-2">
                            <label>Username</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="username" class="form-control" value="<?php if($loginsuccess == -1) { echo $_POST['username'];}?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label>Password</label>
                        </div>
                        <div class="col-md-10">
                            <input type="password" name="password" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 col-md-offset-2">
                            <input type="submit" name="login" value="Sign in" class="btn btn-default">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php } else if($_GET['action'] == 'register' && !$isloggedin) {?>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="page-header">
                    <h1>Register</h1>
                    <p><?php echo $registermessage; ?></p>
                </div>
                <form method="post">
                    <div class="row">
                        <div class="col-md-2">
                            <label>Name</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="fullname" class="form-control" value="<?php if($registersuccess == -1) { echo $_POST['fullname'];} ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label>Username</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="username" class="form-control" value="<?php if($registersuccess == -1) { echo $_POST['username'];} ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label>Email</label>
                        </div>
                        <div class="col-md-10">
                            <input type="email" name="email" class="form-control" value="<?php if($registersuccess == -1) { echo $_POST['email'];} ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label>Password</label>
                        </div>
                        <div class="col-md-10">
                            <input type="password" name="password" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 col-md-offset-2">
                            <input type="submit" name="register" value="Register" class="btn btn-default">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php } else if($_GET['action'] == 'viewpost') {?>
        <div class="row">
            <div class="col-md-8">
                <div class="post">
                    <?php if($isloggedin && ($can_delete || $can_edit)) { ?>
                        <div class="btn-group post-action">
                            <button type="button" class="btn btn-success dropdown-toggle " data-toggle="dropdown" aria-expanded="false">
                                Action <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <?php if($can_edit) { ?><li><a href="action.php?action=editpost&post=<?php echo $post_data['post_id']; ?>">Edit</a></li><?php } ?>
                                <?php if($can_edit) { ?><li><a href="action.php?action=deletepost&post=<?php echo $post_data['post_id']; ?>">Delete</a></li><?php } ?>
                            </ul>
                        </div>
                    <?php } ?>
                    <h2 class="headline"><?php echo $post_data['post_title']; ?></h2>
                    <p class="headline-meta">by <?php echo $bea->user->get_username($post_data['post_owner']) . ' on ' . date_format(date_create($post_data['post_date']), 'd F Y'); ?></p>
                    <div class="post-content">
                        <p>
                            <?php echo $post_data['post_cont']; ?>
                        </p>
                    </div>
                </div>
            </div>
            <?php include 'widgets.php' ?>
        </div>
    <?php } else if($_GET['action'] == 'editpost') {?>
        <div class="row">
            <div class="col-md-12">
                <form method="post">
                    <div class="row">
                        <div class="col-md-2">
                            <label>Title</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="ptitle" class="form-control" value="<?php echo $post_data['post_title']; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label>Desc</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="pdesc" class="form-control" value="<?php echo $post_data['post_desc']; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label>Content</label>
                        </div>
                        <div class="col-md-12">
                            <textarea type="text" name="pcont" class="form-control"><?php echo $post_data['post_cont']; ?></textarea>
                            <script>
                                CKEDITOR.replace('pcont');
                            </script>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 col-md-offset-2">
                            <input type="submit" name="editpost" value="Submit" class="btn btn-default">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php } else if($_GET['action'] == 'newpost') {?>
        <div class="row">
            <div class="col-md-12">
                <form method="post">
                    <div class="row">
                        <div class="col-md-2">
                            <label>Title</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="ptitle" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label>Desc</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="pdesc" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label>Content</label>
                        </div>
                        <div class="col-md-12">
                            <textarea type="text" name="pcont" class="form-control"></textarea>
                            <script>
                                CKEDITOR.replace('pcont');
                            </script>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 col-md-offset-2">
                            <input type="submit" name="newpost" value="Submit" class="btn btn-default">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php }} ?>

</div>


<script src="js/bootstrap.min.js"></script>
</body>
</html>