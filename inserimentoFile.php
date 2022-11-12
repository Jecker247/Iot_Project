<?php
session_start();
// serve username + path corrente di dove si trova la pagina per effettuare inserimento
// il bottone inserisce nella pagina corrente il file se non supera il limite di file.
// cioè se entro in un folder mi aggiorna la pagina, magari sopra specifico il nome  del folder o variabile che memorizza dove mi trovo

    //controllo file sia arrivato correttamente
        echo "directory:"."<pre></pre>";
        echo __DIR__ ."<pre></pre>"; ///var/www/html/html
        $file = $_FILES["file"];
        echo "Username sessione: ".$_SESSION['session_user']."<pre></pre>";
        $user = $_SESSION['session_user'];

        // check  se il file è arrivato correttamente
        if(UPLOAD_ERR_OK == $file["error"]){
            echo "Dati File"."<pre></pre>";
            echo "Nome file: " . $file["name"] . "<pre></pre>";
            echo "Tipo file: " . $file["type"] . "<pre></pre>";
            echo "TmpName file: " . $file["tmp_name"] . "<pre></pre>";
            echo "Size file: " . $file["size"] . "<pre></pre>";
            // PARTE UPLOAD
            //TENGO CASO SENZA FOLDER
            $uploadDir = __DIR__ .DIRECTORY_SEPARATOR."Data".DIRECTORY_SEPARATOR.$user;           // /var/www/html/html
            $fileName = basename($file['name']);
            move_uploaded_file($file['tmp_name'],$uploadDir.DIRECTORY_SEPARATOR.$fileName);
            // fine upload file
            echo "File Uplodato"."<pre></pre>";
        }else{  // se errore ritorna subito nella pagina precedente
            header("Location: http://82.61.87.38/html/dashboard.php? ");
        }



    //PATH pagina
    echo "Path pagina:"."<pre></pre>";
    echo $_SERVER["PHP_SELF"];
    // serve path cartella su cui si lavora

    //query che guarda i file dentro alla cartella corrente

    $query = "";

    // per tornare nella pagina precedente
    //header("Location: http://82.61.87.38/html/dashboard.php? ");
?>