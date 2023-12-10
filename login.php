<!doctype html>
<html lang="en">
<?php include_once 'head.php';

?>
<body>
<?php include_once 'navbar.php'; ?>
<div class="container" style="min-height:500px;">
    <div class="row mt-3">
        <div class="col-12">
            <?php
            if(isset($_GET['login_fail'])){
                ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Error!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php
            }
            if(isset($_GET['reg_success'])){
                ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Registration Success!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php
            }
            ?>
            <div class="col-6 mx-auto">
                <form action="toLogin.php" method="post">
                    <div class="row mt-3">
                        <div class="col-12">
                            <label>Username:</label>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <input type="text" name="username" class="form-control" required placeholder="Insert Username">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <label>Password:</label>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <input type="password" name="password" class="form-control" required placeholder="Insert password">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <button class="btn btn-success">Login</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
