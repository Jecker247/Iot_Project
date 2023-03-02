<?php
    require_once('../config/database.php');
    require_once('../config/functions.php');

    if (!isset($_POST['username'], $_POST['password'])||($_POST['username']=="")||($_POST['password']=="")) {
        exit('Please fill both the username and password fields!');
    }
    $password = $_POST['password'];
    $username = $_POST['username'];

    $query = "
    SELECT iduser, username, password
    FROM users
    WHERE username = :username";

    $check = $pdo->prepare($query);
    $check->bindParam(':username', $username, PDO::PARAM_STR);
    $check->execute();
    $user = $check->fetch(PDO::FETCH_ASSOC);

    if (!$user || password_verify($password, $user['password']) === false) {
        echo "credenziali errate, riprova";
    } else {
        echo "connessione riuscita!";
        #invio ID al client
        $sql = 'SELECT iduser
                FROM users
                WHERE username = :username';
        $check = $pdo->prepare($query);
        $check->bindParam(':username', $username, PDO::PARAM_STR);
        $id = $check->execute();
        #return ID
        echo "/".$id;
        #TEMPORANEO IL / PER EXPLODE ESPERIMENTO
    }

?>