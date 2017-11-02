<?php
session_start();
include 'function/function.php';
if (!isset($_SESSION['user_id'])) {
    var_dump($_SESSION['email']);
    header('location:login.php');
    die();
}
include 'layouts/header.php';
include 'layouts/navbar.php';
$user_id = $_SESSION['user_id'];
//$arr = json_array("register.json");
$user = search("register.json", $user_id);
  $src =  $user['images']['avatar'];
?>
    <img src="<?php  echo $src ?>" width="300px" alt="">
    <!-- Button to Open the Modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
        change profile photo
    </button>

    <!-- The Modal -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">выберите фото</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div id="div">


                   <?php $arr=search("register.json",$_SESSION['user_id']);
                    $gallery = $arr['images']['gallery'];

                    foreach ($gallery as  $key => $val){

                    ?>

                    <img id="img" src="<?php echo $val ;  ?>" width="100" >

                    <?php } ?>
                    </div>
                </div>

                    <div class="modal-footer">
                        <form action="uplode.php" method="post" enctype="multipart/form-data">
                            <input type="file"  name="images">
                            <input type="submit"  name="submit">
                        </form>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                    </div>

            </div>
        </div>
    </div>

<?php
include 'layouts/footer.php';