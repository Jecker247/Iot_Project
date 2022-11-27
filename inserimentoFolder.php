<?php
session_start();
$user = $_SESSION['session_user'];
echo "test";
        if(isset($_POST["nomeFolder"])){
            $folderName=$_POST["nomeFolder"];
            //nome inserito corretto
            // dir su cui lavoriamo
            $uploadDir = __DIR__."/Data/".$user;
            $dir =  $uploadDir.DIRECTORY_SEPARATOR.$folderName;
            //cho $dir;
            //mkdir($dir);
            echo 'alert('.mkdir($dir, 777).')';
            // creata cartella nel path $dir

            // aggiornamento nel database che è statta inserita la cartella

           /* $query = "
                INSERT INTO files
                VALUES (0, :foldername, :extension, :mime, :idusername, :percorso)      //@todo modificare i parametri
            ";
            $check = $pdo->prepare($query);
            $check->bindParam(':filename', $file["name"], PDO::PARAM_STR);
            $check->bindParam(':extension', explode(".",$file["name"])[2], PDO::PARAM_STR);
            $check->bindParam(':mime', $file["type"], PDO::PARAM_STR);
            $check->bindParam(':idusername', $idutente, PDO::PARAM_STR);
            $check->bindParam(':percorso', string($uploadDir.DIRECTORY_SEPARATOR.$file["name"]), PDO::PARAM_STR);
            $check->execute();*/

        }
        //teoricamente la cartella è stata inserita
header("Location: http://serverwebuni.ns0.it:580/html/dashboard.php? ");
?>