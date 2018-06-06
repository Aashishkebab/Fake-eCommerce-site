<?php
	session_start();
	$title = "Aashish's Store";
	$content = "Buy random software from Aashish";
	require_once('includes/open_db.php');
	include('includes/header.php');
	include('includes/footer.php');
	require_once('includes/functions.php');

	createDefaultAdmin($db);
?>
<!DOCTYPE html>
<html lang="en">
	<body>
		<header>
            <?php
                if(isset($_POST['addToCart'])){
                    if(isset($_SESSION['current_user'])){
                        if(isInCart($_SESSION['current_user'], $_POST['identifier'], $db)){
                            echo getName($_POST['identifier'], $db).' was already in cart.';
                        }
                        else if(alreadyOrdered($_SESSION['current_user'], $_POST['identifier'], $db)){
                            echo 'You already own '.getName($_POST['identifier'], $db);
                        }
                        else{
                            try{
                                addToCart($_SESSION['current_user'], $_POST['identifier'], $db);
                                echo getName($_POST['identifier'], $db).' was added to cart.';
                            }catch(Exception $e){
                                echo "There was a fatal error.";
                            }
                        }
                    }
                    else{
                        echo "Please log in first";
                    }
                    unset($_POST['addToCart']);
                }
            ?>
		</header>

        <?php
            include('includes/navbar.php');
        ?>

        <form method="POST" action="index.php" id="filter">
            <label>Search:</label>
            <?php
                if(isset($_POST['search']) && $_POST['search'] != ""){
                    echo '<input name="search" type="text" value='.$_POST['search'].' />';
                }
                else{
                    echo '<input name="search" type="text" value="" />';
                }

                if(isset($_POST['sort'])){
                    if($_POST['sort'] == "name"){
                        echo '<select form="filter" name="sort">';
                        echo '<option value="name" selected>Sort by name</option>';
                        echo '<option value="price">Sort by price</option>';
                        echo '</select>';
                        $sort = 'name';
                    }else if($_POST['sort'] == "price"){
                        echo '<select form="filter" name="sort">';
                        echo '<option value="name">Sort by name</option>';
                        echo '<option value="price" selected>Sort by price</option>';
                        echo '</select>';
                        $sort = 'cost';
                    }
                }
                else{
                    echo '<select form="filter" name="sort">';
                    echo '<option value="name">Sort by name</option>';
                    echo '<option value="price">Sort by price</option>';
                    echo '</select>';
                    $sort = 'name';
                }
            ?>
            <input type="submit" />
        </form>

		<main class="products">
            <?php
                $items = getAllItems($db);

                sortStuff($items, $sort, 'pancakesort');

                if(isset($_POST['search']) && $_POST['search'] == ""){
                    unset($_POST['search']);
                }
                for($i = 0; $i < sizeof($items); $i = $i + 1){
                    if($items[$i]['hidden'] != "true" && (!isset($_POST['search']) || (isset($_POST['search']) && strpos(strtolower($items[$i]['name']), strtolower($_POST['search'])) !== false))){
                        echo '<figure><img src="images/'.$items[$i]['identifier'].'.png" alt="'.$items[$i]['name'].'">';
                        echo '<figcaption>'.$items[$i]['name'].'<br><i>'.$items[$i]['description'].'</i><br><b>$'.$items[$i]['cost'].'</b></figcaption>';

                        if(!isset($_SESSION['current_user']) || !(getUserType($_SESSION['current_user'], $db) == "admin")){ //Only show add to cart button if not an admin
                            echo '<form method="POST" action="index.php">';
                            echo '<input type="hidden" name="identifier" value="'.$items[$i]['identifier'].'"/>';
                            if(isset($_SESSION['current_user']) && isInCart($_SESSION['current_user'], $items[$i]['identifier'], $db)){ //If already added, disable button
                                echo '<input type="submit" name="addToCart" value="Already in cart!" disabled/>';
                            }
                            else{
                                echo '<input type="submit" name="addToCart" value="Add to Cart"/>';
                            }
                            echo '</form>';
                        }

                        echo '</figure>';
                    }
                }
                if(isset($_POST['search'])){
                    unset($_POST['search']);
                }
            ?>
		</main>
	</body>
</html>
