<?php include_once 'header.php';?>

<div class="container">

    <?php if(isset($_GET['login'])) {?>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="page-header">
                    <h1>Sign In</h1>
                </div>
                <form>
                    <div class="row">
                        <div class="col-md-2">
                            <label>Username</label>
                        </div>
                        <div class="col-md-10">
                            <input type="email" name="email" class="form-control">
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

    <?php } ?>
    <?php if(isset($_GET['register'])) {?>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="page-header">
                    <h1>Register</h1>
                </div>
                <form>
                    <div class="row">
                        <div class="col-md-2">
                            <label>Name</label>
                        </div>
                        <div class="col-md-10">
                            <input type="fullname" name="fullname" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label>Username</label>
                        </div>
                        <div class="col-md-10">
                            <input type="username" name="username" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label>Email</label>
                        </div>
                        <div class="col-md-10">
                            <input type="email" name="email" class="form-control">
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

    <?php } ?>

</div>


<script src="js/bootstrap.min.js"></script>
</body>
</html>