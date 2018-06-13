<?php
	session_start();
	echo '<script>alert('.$_SESSION['current_user'].')</script>';
	$title = "Admin page";
	$content = "Be a boss!";
	require_once('includes/functions.php');
	require_once("includes/open_db.php");
	include('includes/header.php');
	include('includes/footer.php');

	if(isset($_POST['save'])){
		updateItem($db, $_POST['identifier'], $_POST['name'], $_POST['cost'], $_POST['description']);
		unset($_POST['save']);
	}
	if(isset($_POST['delete'])){
		deleteItem($db, $_POST['identifier']);
		unset($_POST['delete']);
	}
	if(isset($_POST['undelete'])){
		undeleteItem($db, $_POST['identifier']);
		unset($_POST['undelete']);
	}

	if(isset($_POST['add'])){
		addItem($db, $_POST['identifier'], $_POST['name'], $_POST['cost'], $_POST['description']);
		echo '<script>alert("Add '.$_POST['identifier'].'.png to images folder!")</script>';
		unset($_POST['add']);
	}
?>
	
<!DOCTYPE html>
<html lang="en">
	<body>
		<header>
            Only for the boss!
		</header>

        <?php
			include('includes/navbar.php');
		?>

        <main class="products">
        <?php
            if(isset($_SESSION['current_user']) && getUserType($_SESSION['current_user'], $db) == "admin"){
                echo '
                    <figure class="editable">
                        <form method="POST" action="adminview.php">
                            <h2>Add new item</h2>
                            <input type="text" name="name" maxlength="44" placeholder="Enter name" />
                            <input type="number" step="0.01" name="cost" placeholder="0.00" />
                            <input type="text" name="description" maxlength="333" placeholder="Enter description" />
                            <input type="text" name="identifier" placeholder="Enter identifier" />
                            <input type="submit" name="add" value="Add"/>
                        </form>
                    </figure>';

				$items = getAllItems($db);

				for($i = 0; $i < sizeof($items); $i = $i + 1){
					echo '<figure class="editable"><img src="images/'.$items[$i]['identifier'].'.png" alt="'.$items[$i]['name'].'">';
					echo '<form method="POST" action="adminview.php">';
					echo '<input type="text" name="name" maxlength="44" value="'.$items[$i]['name'].'" />';
					/*echo '<br>';*/    //This <br> is extremely important!
					echo '<input type="number" step="0.01" name="cost" value="'.$items[$i]['cost'].'" />';
					echo '<input type="text" name="description" maxlength="333" value="'.$items[$i]['description'].'" />';

					echo '<input type="hidden" name="identifier" value="'.$items[$i]['identifier'].'"/>';
					if($items[$i]['hidden'] == "false"){
					   echo '<input type="submit" name="delete" value="Hide"/>';
					}else if($items[$i]['hidden'] == "true"){
					   echo '<input type="submit" name="undelete" value="Show"/>';
					}
					echo '<input type="submit" name="save" value="Save"/>';
					echo '</form>';
					echo '</figure>';
				}
			}
			else{
				echo 'You are not authorized to view this page.';
				echo '<br><a href="index.php"><b>Click here to leave</b></a>';
			}
		?>
		</main>

		<footer>
			Aashish Bharadwaj - CS3800 assignment # - Spring 2018
		</footer>

	</body>
</html>
