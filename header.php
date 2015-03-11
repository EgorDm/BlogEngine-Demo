<?php
include_once 'BlogEngine/pageinit.php';

$isloggedin = $bea->user->is_logged_in()
?>

<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>BlogEngine Demo Blog</title>

    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">

    <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">BlogEngine</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="index.php">Home</a></li>
                <?php if(!$isloggedin) { ?>
                    <li <?php if(isset($_GET['login'])) { echo 'class="active"'; } ?>> <a href="action.php?action=login">Login</a></li>
                    <li <?php if(isset($_GET['register'])) { echo 'class="active"'; } ?>> <a href="action.php?action=register">Register</a></li>
                <?php } else { ?>
                    <li> <a href="action.php?action=logout">Logout</a></li>
                    <li> <a style="cursor: default;">Welcome <?php echo $_SESSION['username']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>