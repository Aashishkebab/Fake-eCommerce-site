<?php
	session_start();
	if(isset($_POST['credit_card'])){
		ob_start();
	}
	$title = "Checkout";
	$content = "Give Aashish money";
	require_once('includes/functions.php');
	require_once("includes/open_db.php");
	include('includes/header.php');
	include('includes/footer.php');

	if(isset($_POST['credit_card'])){
		if(!isValidCard($_POST['credit_card'])){
			echo '<script>alert("Invalid credit card!")</script>';
			unset($_POST['credit_card']);
		}else{
			checkStuffOut($db, $_SESSION['current_user']);
			eraseCart($db, $_SESSION['current_user']);
            ob_get_clean();
			header("Location: userview.php");
			exit;
		}
	}
?>

<!DOCTYPE html>
<html lang="en">	
	<body>
	
		<header>
            Billing Information
		</header>
        
        <?php   include('includes/navbar.php'); ?>
		
		<main>
            <?php
                if(isset($_SESSION['current_user'])){
                    echo '<h1 class="large">Enter your credit card below</h1>';
                    echo '<h1 class="small">Credit Card:</h1>';
                    
                    echo '<form method="POST" action="checkout.php">';
                    echo '<input type="text" name="credit_card" />';
                    echo '<input type="submit" name="checkout" value="Drain my bank account" />';
                    echo '</form>';                    
                }else{
                    echo '<h2>You should not be here, guest!</h2>';
                    echo '<br><a href="index.php"><b>Click here to leave</b></a>';
                }
            ?>
		</main>		
	</body>
</html>