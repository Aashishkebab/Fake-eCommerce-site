<?php
    require_once("includes/open_db.php");
    require_once('includes/functions.php');
?>

<nav>
    <div><a href="index.php">Home</a></div>
    <?php
        if(isset($_SESSION['current_user'])){
            if(getUserType($_SESSION['current_user'], $db) == "user"){
                echo '<div class="large"><a href="userview.php">Purchase History</a></div>';
                echo '<div class="small"><a href="userview.php">Purchases</a></div>';
                echo '<div><a href="cart.php">Cart</a></div>';
            }else if(getUserType($_SESSION['current_user'], $db) == "admin"){
                echo '<div><a href="adminview.php">Admin view</a></div>';
            }
        }
    
        if(isset($_SESSION['current_user'])){
            echo '<div class="large"><a href="login_files/logout.php">Log outta dodge</a></div>
            <div class="small"><a href="login_files/logout.php">Leave</a></div>';
        }else{
            echo '<div class="large"><a href="login_files/login_start.php">Log in or Create Account</a></div>
            <div class="small"><a href="login_files/login_start.php">Login</a></div>';
        }
    ?>
</nav>