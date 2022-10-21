<?php
require_once('../config/database.php');

if (isset($_POST['register'])) {
    $username = $_POST['username'] ?? '';
	$email = $_POST['email'] ?? '';
    $password = $_POST['password'];
	$password_check = $_POST['repeatPassword'];
    $isUsernameValid = filter_var($username, FILTER_VALIDATE_REGEXP, ["options" => ["regexp" => "/^[a-zA-Z][A-Za-z0-9\d_]{5,25}$/"]]);
    $pwdLenght = mb_strlen($password);
    $result = 'Error';
	$msg = '';
	
    if (empty($username) || empty($password) || empty($email)) {
        $msg = 'Compila tutti i campi.';
    } elseif ($isUsernameValid === false) {
        $msg = 'L\'username inserito non è valido';
    } elseif ($pwdLenght < 6 || $pwdLenght > 20) {
        $msg = 'La lunghezza della password deve essere compresa tra 6 e 20 caratteri.';
    } elseif ($password !== $password_check) {
		$msg = 'le due password devono coincidere';
	}else{
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
		// controllo che l'username richiesto non sia già in uso
        $query = "
            SELECT id
            FROM users
            WHERE username = :username";

        $check = $pdo->prepare($query);
        $check->bindParam(':username', $username, PDO::PARAM_STR);
        $check->execute();
        $user_check = $check->fetchAll(PDO::FETCH_ASSOC);
		// controllo che la mail inserita non sia già presente nel database
        $query = "
			SELECT id
			FROM users
			WHERE email = :email";
		$check = $pdo->prepare($query);
		$check->bindParam(':email', $email, PDO::PARAM_STR);
		$check->execute();
		$email_check = $check->fetchAll(PDO::FETCH_ASSOC);
        if (count($user_check) > 0) {
            $msg = 'Username già in uso';
        } elseif (count($email_check) > 0) {
			$msg = 'email già in uso';
		}else {
            $query = "
                INSERT INTO users
                VALUES (0, :username, :email, :password)
            ";
        
            $check = $pdo->prepare($query);
            $check->bindParam(':username', $username, PDO::PARAM_STR);
            $check->bindParam(':email', $email, PDO::PARAM_STR);
            $check->bindParam(':password', $password_hash, PDO::PARAM_STR);
            $check->execute();
			
	    $folder = '../Data/'.$username;
            if ($check->rowCount() > 0 || mkdir($folder, 0777)) {
		mkdir($folder, 0777);
		$result = 'Success';
                $msg = 'Registrazione eseguita con successo'.$folder;
            } else {
                $msg = 'Problemi con l\'inserimento dei dati';
            }
        }
    }
    
	header("Location: ../result.php?result=".$result."&msg=".$msg);
}
?>
