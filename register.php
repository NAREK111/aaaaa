<?php
session_start();
include 'layouts/header.php';
include 'layouts/navbar.php';?>

    <div class="row">
        <div class="col-md-offset-4 col-md-4" >
            <form action="registerprocess.php" method="post">
                <div class="form-group">
                    <input type="text" placeholder="First name" name="first_name" value="<?php echo isset($_SESSION['firstname']) ? $_SESSION['firstname'] : '';?>"  class="form-control" id="usr">

                    <?php
                        if (isset( $_SESSION['error_first_name'])){
                    ?>
                             <div class="alert alert-danger">
                                <p><?php echo  $_SESSION['error_first_name']?></p>
                             </div>
                    <?php }   ?>
                </div>
                <div class="form-group">
                    <input type="text" placeholder="Last name" name="last_name" value="<?php echo isset($_SESSION['lastname']) ? $_SESSION['lastname'] : '';?>" class="form-control" id="usr">
                    <?php
                    if (isset( $_SESSION['error_last_name'])){
                        ?>
                        <div class="alert alert-danger">
                            <p><?php echo  $_SESSION['error_last_name']?></p>
                        </div>
                    <?php }   ?>
                </div>


                <div class="form-group">
                    <input  type="email" placeholder="Email" name="email"  class="form-control" id="usr" value=<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : '';?> >
                    <?php
                    if (isset( $_SESSION['error_email'])){
                        ?>
                        <div class="alert alert-danger">
                            <p><?php echo  $_SESSION['error_email']?></p>
                        </div>
                    <?php }   ?>
                    <?php
                    if (isset(  $_SESSION['error_mail1_valid'])){
                        ?>
                        <div class="alert alert-danger">
                            <p><?php echo   $_SESSION['error_mail1_valid']?></p>
                        </div>
                    <?php }   ?>
                    <?php
                    if (isset(   $_SESSION['error_mail1_repeat'])){
                        ?>
                        <div class="alert alert-danger">
                            <p><?php echo  $_SESSION['error_mail1_repeat']?></p>
                        </div>
                    <?php }   ?>
                </div>





                <div class="form-group">
                    <input type="password" placeholder="Password" name="password" class="form-control" id="pwd">
                    <?php
                    if (isset(  $_SESSION['error_nou_repeat_password'])){
                        ?>
                        <div class="alert alert-danger">
                            <p><?php echo  $_SESSION['error_nou_repeat_password']?></p>
                        </div>
                    <?php }   ?>
                    <?php
                    if (isset(  $_SESSION['error_password'])){
                        ?>
                        <div class="alert alert-danger">
                            <p><?php echo   $_SESSION['error_password']?></p>
                        </div>
                    <?php }   ?>
                </div>
                <div class="form-group">
                    <input type="password" placeholder="Confirm password" NAME="confirm_password" class="form-control" id="pwd">
                    <?php
                    if (isset(  $_SESSION['error_confirm_password'])){
                        ?>
                        <div class="alert alert-danger">
                            <p><?php echo   $_SESSION['error_confirm_password']?></p>
                        </div>
                    <?php }   ?>

                </div>
                <div class="form-group">
                    <label class="radio-inline"><input type="radio" name="gender" value="male" <?php if ( $_SESSION['gender']=="male"){ echo " checked ";} ?> >Male</label>
                    <label class="radio-inline"><input type="radio" name="gender" <?php if ( $_SESSION['gender']=="female"){ echo " checked ";} ?> value="female">Female</label>
                    <?php
                    if (isset( $_SESSION['error_gender'])){
                        ?>
                        <div class="alert alert-danger">
                            <p><?php echo  $_SESSION['error_gender']?></p>
                        </div>
                    <?php }   ?>
                </div>

        <input type="submit" name="submit">

            </form>
        </div>
    </div>

<?php
include 'layouts/footer.php';
