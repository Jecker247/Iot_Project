<?php
// DA TESTARE
session_start();
$user = $_SESSION['session_user'];
$nomefile = $_POST["nomeFile"];
//apro la cartella user
$Directory = __DIR__."/Data/".$user;
$handle = opendir($Directory);
$trovato = false;
while(($file= readdir($handle))!= false){
    if($file["name"]==$nomefile){
        //cancello file
        $trovato = true;
        @unlink($Directory ."/". $file);
    }
}

if($trovato){
    // risultato ok
}else{
    header("Location: http://serverwebuni.ns0.it:580/html/dashboard.php? ");
}

?>