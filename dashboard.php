<html>
    <head>
        <title>Cloud</title>
        <link rel="stylesheet" href="./style/style.css">
    </head>
    <body>
        <?php
        session_start();
        if (isset($_SESSION['session_id'])) {
	    $path = "Data/".$session_user;
            $session_user = htmlspecialchars($_SESSION['session_user'], ENT_QUOTES, 'UTF-8');
			?>
			<div class="containerDash">
				<div>
					<div id="headerDash">
						<img src="./img/icon.png" width="100px" height="100px">
						<h2>Welcome, <?php echo $session_user; ?></h2>
					</div>
					<button id="logoutButton" onclick="window.location.href='./php/logout.php';">logout</button>
					<hr>
				</div>
				<div id="gridContainer">
					<div class="gridDiv">
					    <?php
						if(isset($_GET['path'])){
						    $path = $_GET['path'];
						}
						$handler = opendir($path);
						if (false !== $handler) {
						    while ($file = readdir($handler)) {
							if($file != '.'){
							    ?>
							    <dir>
								<?php 
								    
								    echo '<a href="./dashboard.php?path=./Data/'.$file.'">'.$file.'</a>';
								?>
							    </dir>
							    <?php
							}
						    }
						}
						closedir($handler);
					    ?>
					</div>
					<div class="gridDiv" id="gridDivright">
						<div class="internalGridright" id="dimensions">grafico dimensione</div>
						<div class="internalGridright" id="insertModel">
							<form>
								<label for="UploadFile">insert file to upload in Cloud</label>
								<input type="file"></input>
							</form>
						</div>
					</div>
				</div>
			</div>
		<?php	
        } else {
            printf("Effettua il %s per accedere all'area riservata", '<a href="../login.html">login</a>');
        }
        ?>
    </body>
</html>
