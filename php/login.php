<?php
session_start();
require_once('../config/database.php');

if (isset($_SESSION['session_id'])) {
    header('Location: ../dashboard.php');
    exit;
}

if (isset($_POST['login'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $result= '';
	$msg='';
    if (empty($username) || empty($password)) {
		$result='Error';
        $msg = 'Inserisci username e password';
    } else {
        $query = "
            SELECT username, password
            FROM users
            WHERE username = :username
        ";
        
        $check = $pdo->prepare($query);
        $check->bindParam(':username', $username, PDO::PARAM_STR);
        $check->execute();
        
        $user = $check->fetch(PDO::FETCH_ASSOC);
        if (!$user || password_verify($password, $user['password']) === false) {
			$result='Error';
            $msg = 'Credenziali utente errate';
        } else {
            session_regenerate_id();
            $_SESSION['session_id'] = session_id();
            $_SESSION['session_user'] = $user['username'];
            
            header('Location: ../dashboard.php');
            exit;
        }
    }
  
	header("Location: ../result.php?result=".$result."&msg=".$msg);
}
