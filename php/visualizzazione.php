<?php

// GESTISCO IL PRIMO CASO VISUALIZZAZIONE HOME
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username=$_POST['username'];
    $iduser=$_POST['id'];
    $path= "/var/www/html/Data".$_POST['path'];
    #FARE CONTROLLO USERNAME ID
       /*if(!(isset($_POST['path']))){   //caso base HOME
            $path = "/var/www/html/Data/".$username;
        }else{
           $path= $_POST['path'];
       }*/
    $folder = opendir($path."/");
    # lettura file and folder presenti nella Dir e visualizzazione:
    while ($f = readdir($folder)) {
        if (is_file($path."/" . $f)) {
            $fileName = $f;
            #CONTROLLO SOLO I FILE
            echo $fileName;
            echo "/";
        }
        if(is_dir($path."/" . $f)){
            #CONTROLLO SOLO LE CARTELLE
            if($f != "." and $f != ".."){
                echo $f;
                echo "/";
            }
        }
    }//chiuso while
    $folder = closedir($folder);
}


?>