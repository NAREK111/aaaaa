<nav id="navbar" class="navbar navbar-inverse">
    <div class="container-fluid">
        <?php if (!isset($_SESSION['user_id'])) { ?>
            <div class="navbar-header">
                <a class="navbar-brand" href="#">WebSiteName</a>
            </div>
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#">Page 1</a></li>
                <li><a href="#">Page 2</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="../register.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                <li><a href="../login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
            </ul>
            <?php } else { ?>
        <div class="navbar-header">
            <a class="navbar-brand" href="../profil.php">WebSiteName</a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="../google/google.php">Map</a></li>
            <li><a href="../google/gogle.php">Map2</a></li>
            <li><a href="../gallery.php">Gallery</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="../logout.php"><span class="glyphicon glyphicon-log-in"></span> Login out</a></li>
        </ul>
       <?php } ?>
    </div>
</nav>




<div class="container">