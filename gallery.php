<?php
session_start();
include 'layouts/header.php';
include 'layouts/navbar.php';
include "function/function.php";
if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
    die();
}
$arr=search("register.json",$_SESSION['user_id']);
$gallery = $arr['images']['gallery'];

foreach ($gallery as  $key => $val) {
    ?>
<div class="imgimg" style="display: inline-block">
<img src="<?php echo "uplodes/gallery/".$val  ?>" width="200">

    <a href="" class="glyphicon glyphicon-th-list	Try it" data-toggle="modal" data-target="#myModa<?php echo $key ?>"></a>
    <!-- Modal -->
    <div id="myModa<?php echo $key ?>" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
                </div>
                <div class="modal-body">
                    <a href="update_avatar.php?href=<?php echo $val ?>">make profile photo</a>
                    <a href="delete_gallery.php?href=<?php echo $val ?>" class="glyphicon glyphicon-trash"></a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
</div>
<?php } ?>
<form action="uplode_gallerey.php" method="post" enctype="multipart/form-data">
    <input type="file" name="img_gallery">
    <input type="submit" name="submit_gallery" value="uxarkel">
</form>

<?php
include 'layouts/footer.php';