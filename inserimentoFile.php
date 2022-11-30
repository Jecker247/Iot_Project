
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
            $esito = "Successo";
            //check che non sia già presente il file
            //apertura percorso
            $esito = "Successo";
            $folder = opendir($uploadDir."/");
            while ($f = readdir($folder)) {
                if (is_file($uploadDir."/" . $f)) {
                    #CONTROLLO SOLO I FILE
                    if ($f == $file["name"]) {
                        $esito= "Errore";
                    }
                }
            }
            $folder = closedir($folder);

            echo $esito;
            if($esito == "Successo") {
                $fileName = basename($file['name']);
                move_uploaded_file($file['tmp_name'], $uploadDir . DIRECTORY_SEPARATOR . $fileName);
            }
            header("Location: http://serverwebuni.ns0.it:580/html/dashboard.php?operazione=".$esito);
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


        }else{  // se errore ritorna subito nella pagina precedente
            $esito= "Errore";
            header("Location: http://serverwebuni.ns0.it:580/html/dashboard.php?operazione=".$esito);
        }

?>