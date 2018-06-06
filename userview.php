<?php
	session_start();
	$title = "Purchase History";
	$content = "See what you've bought from Aashish";
	require_once('includes/functions.php');
	require_once("includes/open_db.php");
	include('includes/header.php');
	include('includes/footer.php');
?>

<!DOCTYPE html>
<html lang="en">	
	<body>
	
		<header>
            Purchase History
		</header>
        
        <?php   include('includes/navbar.php'); ?>
		
		<main>
            <?php
                if(isset($_SESSION['current_user'])){
                    echo '<br>Welcome <b>'.$_SESSION['current_user'].'</b>!<br><br>';
                    
                    $purchases = getPurchases($_SESSION['current_user'], $db);
                    if(sizeof($purchases) > 0){
                        echo '<table border="2">';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th>Item</th>';
                        echo '<th>License Key</th>';
                        echo '<th>Date of Purchase</th>';
                        echo '<th>Price paid</th>';
                        echo '</tr>';
                        echo '</thead>';
                        for($i = 0; $i < sizeof($purchases); $i = $i + 1){
                            echo '<tr>';
                            echo '<td>'.$purchases[$i]['name'].'</td>';
                            echo '<td>'.$purchases[$i]['licenseKey'].'</td>';
                            echo '<td>'.$purchases[$i]['dateOfPurchase'].'</td>';
                            echo '<td>$'.$purchases[$i]['paid'].'</td>';
                            echo '</tr>';
                        }
                        echo '</table>';

                        echo '<br><br><br><br>';
                        
                    }
                    else{
                        echo "<i>No purchases ever made</i>.";
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