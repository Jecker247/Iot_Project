<?php

session_start();
$user = $_SESSION['session_user'];

$nomefolder = $_POST["rimFolder"];
//apro la cartella user
    $Directory = __DIR__ . "/Data/" . $user . "/";
    $trovato = false;
//apertura percorso
    $folder = opendir($Directory);
    while ($fold = readdir($folder)) {
        if (is_dir($Directory . $fold)) {
            #CONTROLLO SOLO I FOLDER
            if ($fold == $nomefolder) {
                #CANCELLO IL FOLDER
                $trovato = true;
            }
        }
    }

    $folder = closedir($folder);

    if ($trovato) {
        echo "yes<br/>";
        $d = $Directory.$nomefolder."/";
        $cancellare = true;
        //impostare i poteri per le nuove cartelle
        /*$handle1 = opendir($d);
        //non cancello se contiene file/altri folder
        while ($f = readdir($d)){
            echo $f."<br/>";
            if(is_dir($d.$fold)){
                $cancellare= false;
            }
            if(is_file($d . $f)){
                $cancellare=false;
            }
        }
        echo "a";
        $handle1 = closedir($d);*/
        if($cancellare){
            rmdir($Directory.$nomefolder);
            echo "cancellato";
        }else{
            echo "non posso cancellare";
        }
        // avviso ok
    } else {
        echo "no<br/>";
        // avviso negativo
    }

//header("Location: http://serverwebuni.ns0.it:580/html/dashboard.php? ");*/
?>
