<?php
	session_start();
	$title = "Cart";
	$content = "Checkout random software from Aashish";
	require_once('includes/functions.php');
	require_once("includes/open_db.php");
	include('includes/header.php');
	include('includes/footer.php');

	if(isset($_POST['removeFromCart'])){
		removeFromCart($_SESSION['current_user'], $_POST['identifier'], $db);
		unset($_POST['removeFromCart']);
	}
?>

<!DOCTYPE html>
<html lang="en">

	<body>

		<header>
            Cart
		</header>

        <?php   include('includes/navbar.php'); ?>

		<main>
            <?php
                if(isset($_SESSION['current_user'])){
                    echo '<br>Welcome <b>'.$_SESSION['current_user'].'</b>!<br><br>';

                    $cart = getCart($_SESSION['current_user'], $db);
                    if(sizeof($cart) > 0){
                        echo '<table border="2">';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th>Item</th>';
                        echo '<th>Price</th>';
                        echo '</tr>';
                        echo '</thead>';
                        for($i = 0; $i < sizeof($cart); $i = $i + 1){
                            if($cart[$i]['hidden'] == "true"){
                               removeFromCart($_SESSION['current_user'], $cart[$i]['identifier'], $db);
                            }else{
                               echo '<tr>';
                               echo '<td>'.$cart[$i]['name'].'</td>';
                               echo '<td>$'.$cart[$i]['cost'].'</td>';
                               echo '<td><form method="POST" action="cart.php"><input type="hidden" name="identifier" value="'.$cart[$i]['identifier'].'" /><input type="submit" name="removeFromCart" value="Remove"/></form></td>';
                               echo '</tr>';
                            }
                        }
                        echo '</table>';

                        echo '<br><br>';
                        echo '<form action="checkout.php">';
                        echo '<input type="submit" name="checkout" value="Take my money!" />';
                        echo '</form>';

                    }
                    else{
                        echo "<i>Cart is empty</i>.";
                    }
                }
                else{
                    echo '<h2>You are not authorized to view this page.</h2>';
                    echo '<br><a href="index.php"><b>Click here to leave</b></a>';
                }
            ?>
		</main>
	</body>
</html>
