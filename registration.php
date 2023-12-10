
<!doctype html>
<html lang="en">
<?php include_once 'head.php'; ?>
<body>
<?php include_once 'navbar.php'; ?>
<div class="container" style="min-height:500px;">
    <div class="row mt-3">
        <div class="col-12">
            <?php
            if(isset($_GET['error'])){
                ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Error in registration! Try again!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php
            }
            if(isset($_GET['error_password'])){
                ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Password isnt confirmed! Try again!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php
            }
            ?>
            <div class="col-6 mx-auto">
                <form action="toRegister.php" method="post">
                    <div class="row mt-3">
                        <div class="col-12">
                            <label>Name:</label>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <input type="text" name="name" class="form-control" required placeholder="Insert Name">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <label>Last Name:</label>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <input type="text" name="last_name" class="form-control" required placeholder="Insert Lastname">
                        </div>
                    </div>
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
                            <input type="password" name="password" class="form-control" required placeholder="Insert Username">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <label>Confirm password:</label>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <input type="password" name="confirm_password" class="form-control" required placeholder="Insert Username">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <button class="btn btn-success">register</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
