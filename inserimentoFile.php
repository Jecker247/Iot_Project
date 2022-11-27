
<?php
session_start();
    //controllo file sia arrivato correttamente

        $file = $_FILES["file"];
        $user = $_SESSION['session_user'];
        $idutente = $_SESSION['id_user'];
        // check  se il file è arrivato correttamente
        if(UPLOAD_ERR_OK == $file["error"]){
           /* echo "Dati File"."<pre></pre>";
            echo "Nome file: " . $file["name"] . "<pre></pre>";
            echo "Tipo file: " . $file["type"] . "<pre></pre>";
            echo "TmpName file: " . $file["tmp_name"] . "<pre></pre>";
            echo "Size file: " . $file["size"] . "<pre></pre>";*/
            // PARTE UPLOAD

            $uploadDir = __DIR__."/Data/".$user; // /var/www/html/html
            $fileName=  basename($file['name']);
            move_uploaded_file($file['tmp_name'], $uploadDir.DIRECTORY_SEPARATOR.$fileName);

            // eih database ho inserito questo
            /*$query = "
                INSERT INTO files
                VALUES (0, :filename, :extension, :mime, :idusername, :percorso)
            ";
            $check = $pdo->prepare($query);
            $check->bindParam(':filename', $file["name"], PDO::PARAM_STR);
            $check->bindParam(':extension', explode(".",$file["name"])[2], PDO::PARAM_STR);
            $check->bindParam(':mime', $file["type"], PDO::PARAM_STR);
            $check->bindParam(':idusername', $idutente, PDO::PARAM_STR);
            $check->bindParam(':percorso', string($uploadDir.DIRECTORY_SEPARATOR.$file["name"]), PDO::PARAM_STR);
            $check->execute();*/
            // fine upload file

        }else{  // se errore ritorna subito nella pagina precedente
            header("Location: http://serverwebuni.ns0.it:580/html/dashboard.php? ");
        }

    // per tornare nella pagina precedente
    header("Location: http://serverwebuni.ns0.it:580/html/dashboard.php? ");
?>