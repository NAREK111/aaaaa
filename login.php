<?php
session_start();
include 'layouts/header.php';
include 'layouts/navbar.php';


?>

    <div class="row">
        <div class="col-md-offset-4 col-md-4" >
            <form action="profillogin.php" method="post">

                <div class="form-group">
                    <input   type="email" placeholder="Email" name="email"  class="form-control" id="usr" value=<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : '';?>>
                </div>

                <div class="form-group">
                    <input type="password" placeholder="Password" name="password" class="form-control" id="pwd">
                </div>

                <input type="submit" name="submit">

            </form>
        </div>
    </div>

<?php
include 'layouts/footer.php';
