<?php
    require_once('pancake_sort.php');

    function createDefaultAdmin($db){   //Will fail if already exists
        $encrypt_password = password_hash("Iamadmin1", PASSWORD_DEFAULT);
        $query = 'INSERT INTO users (username, user_password, type) VALUES("admin", :encrypt_password, "admin")';
        $statement = $db->prepare($query);
        $statement->bindValue(':encrypt_password', $encrypt_password);
        $statement->execute();
        $statement->closeCursor();
    }

    function getUserType($user, $db) {
        $query = 'SELECT type FROM users WHERE username = :user';
        $statement = $db->prepare($query);
        $statement->bindValue(':user', $user);
        $statement->execute();    
        $result = $statement->fetch();
        $statement->closeCursor();
        return $result['type'];
    }

    function getAllItems($db){
        $query = 'SELECT * FROM itemsForSale';
        $statement = $db->prepare($query);
        $statement->execute();    
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    }

    function getName($identifier, $db){
        $query = 'SELECT * FROM itemsForSale WHERE identifier = :identifier';
        $statement = $db->prepare($query);
        $statement->bindValue(':identifier', $identifier);
        $statement->execute();    
        $result = $statement->fetch();
        $statement->closeCursor();
        return $result['name'];
    }

    function addToCart($username, $identifier, $db){
        $query = 'INSERT INTO cart (username, identifier) VALUES(:username, :identifier)';
        $statement = $db->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->bindValue(':identifier', $identifier);
        $statement->execute();
        $statement->closeCursor();
    }

    function getCart($username, $db){
        $query = 'SELECT name, cost, cart.identifier FROM cart INNER JOIN itemsForSale on cart.identifier = itemsForSale.identifier WHERE username = :user';
        $statement = $db->prepare($query);
        $statement->bindValue(':user', $username);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    }

    function isInCart($username, $identifier, $db){
        $query = 'SELECT identifier FROM cart WHERE username = :user AND identifier = :identifier';
        $statement = $db->prepare($query);
        $statement->bindValue(':user', $username);
        $statement->bindValue(':identifier', $identifier);
        $statement->execute();
        $result = $statement->fetch();
        return $result > 0;
    }

    function alreadyOrdered($username, $identifier, $db){
        $query = 'SELECT identifier FROM orderHistory WHERE username = :user AND identifier = :identifier';
        $statement = $db->prepare($query);
        $statement->bindValue(':user', $username);
        $statement->bindValue(':identifier', $identifier);
        $statement->execute();
        $result = $statement->fetch();
        return $result > 0;
    }

    function removeFromCart($username, $identifier, $db){
        $query = 'DELETE FROM cart WHERE username = :user AND identifier = :identifier';
        $statement = $db->prepare($query);
        $statement->bindValue(':user', $username);
        $statement->bindValue(':identifier', $identifier);
        $statement->execute();
    }

    function eraseCart($db, $username){
        $query = 'DELETE FROM cart WHERE username = :user';
        $statement = $db->prepare($query);
        $statement->bindValue(':user', $username);
        $statement->execute();
        $statement->closeCursor();
    }

    function isValidCard($card){
        return is_numeric($card) && strlen($card) == 16;
    }

    function checkStuffOut($db, $username){
        $cart = getCart($username, $db);
        for($i = 0; $i < sizeof($cart); $i = $i + 1){
            $query = 'INSERT INTO orderHistory (username, identifier, licenseKey, dateOfPurchase, paid) VALUES(:username, :identifier, :licenseKey, :dateOfPurchase, :paid)';
            $statement = $db->prepare($query);
            $statement->bindValue(':username', $username);
            $statement->bindValue(':identifier', $cart[$i]['identifier']);
            $statement->bindValue(':licenseKey', password_hash($username . $cart[$i]['identifier'], PASSWORD_DEFAULT));
            $statement->bindValue(':dateOfPurchase', date("Y/m/d"));
            $statement->bindValue(':paid', $cart[$i]['cost']);
            $statement->execute();
            $statement->closeCursor();
        }
    }

    function getPurchases($username, $db){
        $query = 'SELECT name, paid, dateOfPurchase, licenseKey FROM orderHistory INNER JOIN itemsForSale on orderHistory.identifier = itemsForSale.identifier WHERE username = :user';
        $statement = $db->prepare($query);
        $statement->bindValue(':user', $username);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    }

    function updateItem($db, $identifier, $name, $cost, $description){
        $query = 'UPDATE itemsForSale SET name = :name, cost = :cost, description = :description WHERE identifier = :identifier';
        $statement = $db->prepare($query);
        $statement->bindValue(':identifier', $identifier);
        $statement->bindValue(':name', $name);
        $statement->bindValue(':cost', $cost);
        $statement->bindValue(':description', $description);
        $statement->execute();
        $statement->closeCursor();
    }

    function addItem($db, $identifier, $name, $cost, $description){
        $query = 'INSERT INTO itemsForSale (name, cost, identifier, description) VALUES(:name, :cost, :identifier, :description)';
        $statement = $db->prepare($query);
        $statement->bindValue(':identifier', $identifier);
        $statement->bindValue(':name', $name);
        $statement->bindValue(':cost', $cost);
        $statement->bindValue(':description', $description);
        $statement->execute();
        $statement->closeCursor();
    }

    function deleteItem($db, $identifier){
        $query = 'DELETE FROM itemsForSale WHERE identifier = :identifier';
        $statement = $db->prepare($query);
        $statement->bindValue(':identifier', $identifier);
        $statement->execute();
        $statement->closeCursor();
    }


    function sortStuff(&$items, $sort, $algorithm){
        if($algorithm == 'pancakesort'){
            pancakesort($items, $sort);
        }
    }

?>