<?php 
	session_start();
	require_once('../inc/connect.inc.php');
	$config = new config($db);
	
	if(isset($_SESSION['message'])){
		echo "<script>alert('".$_SESSION['message']."');</script>";
	}unset($_SESSION['message']);
	// echo '<pre>'; print_r($_SESSION); echo '</pre>';
	
	if($_SESSION['user']['userPost']=='cell'){ ?>
		<!DOCTYPE html>
		<html>
			<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<link rel="stylesheet" type="text/css" href="../styles/style.css" />
				<link rel ="shortcut icon" type="image/x-icon" href="../images/homme.png" />
				<link type="text/javascript" src="../javascript/js.js" />
				<title>Page des téléchargements</title>
			</head>
			<body>
				<?php
					require_once('../part/entete.php');
					require_once('../part/nav.php');
				?>
				<div id='body'>
				<h1>Download Page</h1>
                <p>Liste des Fichiers à télécharger</p>
                <?php 
                $dossier = '../downloads/';
                $resultat = $config->listerFichier($dossier);
                foreach($resultat as $cle=>$valeur){
                    echo "<p> <a href='".$valeur."'>".$valeur."</a></p>";
                }
                ?>
				</div>
				<?php 
					require_once('../part/footer.php');
				?>
			</body>
		</html>

<?php 		
	}else{
		header('Location:deconnect.php');
	}