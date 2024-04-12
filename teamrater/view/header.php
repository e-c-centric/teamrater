<nav class="navbar navbar-fixed-top navbar-inverse" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse" aria-expanded="false" aria-controls="navbar1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="/teamrater/view" class="navbar-brand"><strong>Teamrater</strong></a>
        </div>
        <div class="collapse navbar-collapse" id="navbar1">
            <ul class="nav navbar-nav">
                <li><a href="index.php">Home</a></li>
                <li><a href="search.php">Search</a></li>
                <li><a href="rate.php">Rate</a></li>
            </ul>
            <div class="navbar-form navbar-right">


                <a href="loginModal.php"><button class="btn btn-default" id="loginbutton" type="submit"><i class="glyphicon glyphicon-user"></i>
                        <?php
                        session_start();
                        if (isset($_SESSION['email'])) {
                            echo "Logout";
                        } else {
                            echo "Login";
                        }
                        ?></button></a>
            </div>
        </div>
    </div>




</nav>