<?php 
	session_start();
	require_once('../inc/connect.inc.php');
	$config = new config($db);
	
	if(isset($_SESSION['message'])){
		echo "<script>alert('".$_SESSION['message']."');</script>";
	}unset($_SESSION['message']);
	
	
	if($_SESSION['user']['userPost']=='cell'){ ?>
		<!DOCTYPE html>
		<html>
			<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<link rel="stylesheet" type="text/css" href="../styles/style.css" />
				<link rel ="shortcut icon" type="image/x-icon" href="../images/homme.png" />
				<link type="text/javascript" src="../javascript/js.js" />
				<script>
					function addProf(){
						var xhr = getXhr()
						// On définit ce qu'on va faire quand on aura la reponse 
						xhr.onreadystatechange = function(){
							// On ne fait klk choz que si on a tt rxu et ke le serveur est ok
							if(xhr.readyState==4 && xhr.status==200){
								leselect = xhr.responseText;
								// On se sert de l'innerHTML pour rajouter les options à la liste
								document.getElementById('valeur').innerHTML = leselect;
							}
						}
						// Ici on va voir comment faire du POST
						xhr.open("POST", "../forms/ajouterProf.ajax.php", true);
						// Ne pas oublier xa pour le POST 
						xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
						// Ne pas oublier de poster les arguments 
						// C'est-à-dire l'id de la Region par exemple
						sel = document.getElementById('userType');
						userType = sel.options[sel.selectedIndex].value;
						xhr.send("userType="+userType);
					}
					

					function findProf(){
						var xhr = getXhr()
						// On définit ce qu'on va faire quand on aura la reponse 
						xhr.onreadystatechange = function(){
							// On ne fait klk choz que si on a tt rxu et ke le serveur est ok
							if(xhr.readyState==4 && xhr.status==200){
								leinput = xhr.responseText;
								// On se sert de l'innerHTML pour rajouter les options à la liste
								document.getElementById('resultat').innerHTML = leinput;
							}
						}
						// Ici on va voir comment faire du POST
						xhr.open("POST", "enseignant/findProf.ajax.php", true);
						// Ne pas oublier xa pour le POST 
						xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
						// Ne pas oublier de poster les arguments 
						// C'est-à-dire l'id de la Classe par exemple
						sel = document.getElementById('prof');
						prof = sel.value;
						xhr.send("prof="+prof);
					}


				</script>
				<title>Menu : Enseignant  </title>
			</head>
			<body>
				<?php
					require_once('../part/entete.php');
					require_once('../part/aside.php');
					require_once('../part/nav.php');
				?>
				<div id='body'>
				<h1>enseignant</h1>
				</div>
				<?php 
					if(isset($_GET['action'])){
						$action = urldecode($_GET['action']);
						if(!empty($action)){
							$dossier = str_replace('.php', '', $pageEnCours);
							$fileAction = $dossier.'/'.$action.'.php';
							$linkFile = include($fileAction);
							if($linkFile==false){
								echo "<h4 class='alert'>L'action sollicitée n'existe pas. Si vous pensez qu'il 
								s'agit d'une erreur, contactez le concepteur de l'application.</h4>";
							}else{
								require_once($fileAction);
							}
						}else{
							
						}
					}
					require_once('../part/footer.php');
				?>
			</body>
		</html>
		
<?php 		
	}else{
		$_SESSION['message'] = 'Connexion illégale. Vous serez redirigé';
		header('Location:../index.php');
	}