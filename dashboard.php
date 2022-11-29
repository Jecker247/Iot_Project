<!DOCTYPE html>
<?php
include("./config/dimensions.php");
session_start();
if(isset($_SESSION['session_id'])){
    $session_user = $_SESSION['session_user'];
    $data = DimensionsUser($session_user);
}
?>

<html lang="en-US">
<head>
    <title>Cloud</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="This page contains the user interface that allow users to upload and download file from our Cloud Storage">
    <link rel="stylesheet" href="./style/style.css">
    <script>
        window.onload = function () {
            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                backgroundColor: "#F9F9FF",
                theme: "light1",
                title:{
                    text: "Space Usage's Diagram ( 5GB )"
                },
                data: [{
                    type: "pie",
                    explodeOnClick: true,
                    startAngle:  -45,
                    indexLabelFontSize: 15,
                    indexLabel: "{label} - #percent%",
                    yValueFormatString: "###.##### MB",
                    dataPoints: <?php echo json_encode($data, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();
        }
    </script>
</head>
<body>
<?php
if (isset($_SESSION['session_id'])) {
    ?>
    <div class="header">
        <div class="inner-header">
        </div>
        <div>
            <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
                <defs>
                    <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
                </defs>
                <g class="parallax">
                    <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(255,255,255,0.7" />
                    <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(255,255,255,0.5)" />
                    <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(255,255,255,0.3)" />
                    <use xlink:href="#gentle-wave" x="48" y="7" fill="#fff" />
                </g>
            </svg>
        </div>
    </div>
    <div class="containerDash">
        <div>
            <div id="headerDash">
                <img src="./img/icon.png" width="100px" height="100px">
                <h2>Welcome, <?php echo $session_user; ?> </h2>
            </div>
            <button id="logoutButton" onclick="window.location.href='./php/logout.php';">logout</button>
            <hr>
        </div>
        <div id="gridContainer">
            <div class="gridDiv">
                <div id="folderContainer">
                    <div class="folderRow">
                        <?php
                        /* creazione cartelle dell'utente */
                        /*
                        $query="SELECT
                        FROM users
                        WHERE users=$session_user";

                        $files_folders = $pdo->prepare($query);
                        $rows = $files_folders->fetchAll(PDO::FETCH_ASSOC);
                        foreach($rows as $row) {
                            printf("{$row['email']}\n");
                        }
                        */
                        /* visone cartelle e files dell'utente */
                        /*
                        $query="SELECT files.percorso_file, files.nome_file
                        FROM users
                        INNER JOIN users ON users.id=files.idutente
                        WHERE users=$session_user";
                        $files_folders = $pdo->prepare($query);
                        //$files_folders->bindParam(':username', $session_user, PDO::PARAM_STR);
                        //$files_folders->execute();
                        $rows = $files_folders->fetchAll(PDO::FETCH_ASSOC);
                        foreach($rows as $row) {
                            printf("{$row['email']}\n");
                        }
                        */
                        ?>


                    </div>
                </div>
            </div>
            <div class="gridDiv" id="gridDivright">
                <div class="internalGridright" id="dimensions">
                    <div id="chartContainer" style=" width: 100%; height: 300px;"></div>
                    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
                </div>
                <div class="internalGridright" id="insertModel">
                    <div id="barraGridRight" style="overflow-y: scroll; height: 280px;overflow-x:hidden;">
                        <form action="inserimentoFile.php". method="post" enctype="multipart/form-data">
                            <label for="UploadFile" style="font-weight: bold;">Insert file to upload in Cloud</label><br>
                            <input type="file" name="file" style="height:30px; width:350px"></input>
                            <input type="submit" value="Submit" style="height:20px; width:120px"></input>
                        </form><br>

                        <form action="rimozioneFile.php" method="post">
                            <label for="RemoveFile" style="font-weight: bold;"  >Remove file in Cloud</label><br>
                            <input type="text" name="nomeFile" placeholder="name file to remove" style="height:20px; width:150px"></input><input type="text" style="visibility:hidden;height:20px; width:184px"/>
                            <input type="submit" value="Remove File"  style="height:20px; width:120px"></input>
                        </form><br>

                        <form action="inserimentoFolder.php" method="post">
                            <label for="InsertFolder" style="font-weight: bold;">Insert folder in Cloud</label><br>
                            <input type="text" name="nomeFolder" placeholder="name folder to insert" style="height:20px; width:150px"></input><input type="text" style="visibility:hidden;height:20px; width:184px"/>
                            <input type="submit" value="New Folder"  style="height:20px; width:120px"></input>
                        </form><br>

                        <form action="dashboard.php">
                            <label for="ModifyFolder" style="font-weight: bold;">Modify folder in Cloud</label><br>
                            <input type="text" placeholder="new name folder" style="height:20px; width:150px"></input><input type="text" style="visibility:hidden;height:20px; width:184px"/>
                            <input type="submit" value="Modify Folder"  style="height:20px; width:120px"></input>
                        </form><br>

                        <form action="rimozioneFolder.php" method="post">
                            <label for="RemoveFolder" style="font-weight: bold;">Remove folder in Cloud</label><br>
                            <input type="text" name="rimFolder" placeholder="name folder to remove"  style="height:20px; width:150px"></input><input type="text" style="visibility:hidden;height:20px; width:184px"/>
                            <input type="submit" value="Remove Folder"  style="height:20px; width:120px"></input>
                        </form><br>

                        <form action="dashboard.php">
                            <label for="DownloadFile" style="font-weight: bold;">Download file</label><br>
                            <input type="text" placeholder="name file to download"  style="height:20px; width:150px"></input><input type="text" style="visibility:hidden;height:20px; width:184px"/>
                            <input type="submit" value="Download File"  style="height:20px; width:120px"></input>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}else{
    echo "Errore di Login";
}
?>
</body>
</html>

