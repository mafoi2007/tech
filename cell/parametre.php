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
					
					function listMatricule(){
						var xhr = getXhr()
						// On définit ce qu'on va faire quand on aura la reponse 
						xhr.onreadystatechange = function(){
							// On ne fait klk choz que si on a tt rxu et ke le serveur est ok
							if(xhr.readyState==4 && xhr.status==200){
								leselect = xhr.responseText;
								// On se sert de l'innerHTML pour rajouter les options à la liste
								document.getElementById('resultat').innerHTML = leselect;
							}
						}
						// Ici on va voir comment faire du POST
						xhr.open("POST", "parametre/stdNoMat.ajax.php", true);
						// Ne pas oublier xa pour le POST 
						xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
						// Ne pas oublier de poster les arguments 
						// C'est-à-dire l'id de la Region par exemple
						sel = document.getElementById('clas');
						clas = sel.options[sel.selectedIndex].value;
						xhr.send("clas="+clas);
					}




					function listeUtilisateur(){
						var xhr = getXhr()
						// On définit ce qu'on va faire quand on aura la reponse 
						xhr.onreadystatechange = function(){
							// On ne fait klk choz que si on a tt rxu et ke le serveur est ok
							if(xhr.readyState==4 && xhr.status==200){
								leselect = xhr.responseText;
								// On se sert de l'innerHTML pour rajouter les options à la liste
								document.getElementById('choixPhoto').innerHTML = leselect;
							}
						}
						// Ici on va voir comment faire du POST
						xhr.open("POST", "parametre/addPictureUtilisateur.ajax.php", true);
						// Ne pas oublier xa pour le POST 
						xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
						// Ne pas oublier de poster les arguments 
						// C'est-à-dire l'id de la Region par exemple
						sel = document.getElementById('userType');
						userType = sel.options[sel.selectedIndex].value;
						xhr.send("userType="+userType);
					}





					function listeEleve(){
						var xhr = getXhr()
						// On définit ce qu'on va faire quand on aura la reponse 
						xhr.onreadystatechange = function(){
							// On ne fait klk choz que si on a tt rxu et ke le serveur est ok
							if(xhr.readyState==4 && xhr.status==200){
								leselect = xhr.responseText;
								// On se sert de l'innerHTML pour rajouter les options à la liste
								document.getElementById('choixPhoto').innerHTML = leselect;
							}
						}
						// Ici on va voir comment faire du POST
						xhr.open("POST", "parametre/addPictureEleve.ajax.php", true);
						// Ne pas oublier xa pour le POST 
						xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
						// Ne pas oublier de poster les arguments 
						// C'est-à-dire l'id de la Region par exemple
						sel = document.getElementById('clas');
						clas = sel.options[sel.selectedIndex].value;
						xhr.send("clas="+clas);
					}
					
					

					function TypePhoto(){
						var xhr = getXhr()
						// On définit ce qu'on va faire quand on aura la reponse 
						xhr.onreadystatechange = function(){
							// On ne fait klk choz que si on a tt rxu et ke le serveur est ok
							if(xhr.readyState==4 && xhr.status==200){
								leselect = xhr.responseText;
								// On se sert de l'innerHTML pour rajouter les options à la liste
								document.getElementById('resultat').innerHTML = leselect;
							}
						}
						// Ici on va voir comment faire du POST
						xhr.open("POST", "parametre/addPicture.ajax.php", true);
						// Ne pas oublier xa pour le POST 
						xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
						// Ne pas oublier de poster les arguments 
						// C'est-à-dire l'id de la Region par exemple
						sel = document.getElementById('personne');
						personne = sel.options[sel.selectedIndex].value;
						xhr.send("personne="+personne);
					}






					function passwordUsers(){
						var xhr = getXhr()
						// On définit ce qu'on va faire quand on aura la reponse 
						xhr.onreadystatechange = function(){
							// On ne fait klk choz que si on a tt rxu et ke le serveur est ok
							if(xhr.readyState==4 && xhr.status==200){
								leselect = xhr.responseText;
								// On se sert de l'innerHTML pour rajouter les options à la liste
								document.getElementById('resultat').innerHTML = leselect;
							}
						}
						// Ici on va voir comment faire du POST
						xhr.open("POST", "parametre/allpwd.ajax.php", true);
						// Ne pas oublier xa pour le POST 
						xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
						// Ne pas oublier de poster les arguments 
						// C'est-à-dire l'id de la Region par exemple
						sel = document.getElementById('userType');
						userType = sel.options[sel.selectedIndex].value;
						xhr.send("userType="+userType);
					}





					function changePwd(){
						var xhr = getXhr()
						// On définit ce qu'on va faire quand on aura la reponse 
						xhr.onreadystatechange = function(){
							// On ne fait klk choz que si on a tt rxu et ke le serveur est ok
							if(xhr.readyState==4 && xhr.status==200){
								leselect = xhr.responseText;
								// On se sert de l'innerHTML pour rajouter les options à la liste
								document.getElementById('changePwd').innerHTML = leselect;
							}
						}
						// Ici on va voir comment faire du POST
						xhr.open("POST", "parametre/userPwd.ajax.php", true);
						// Ne pas oublier xa pour le POST 
						xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
						// Ne pas oublier de poster les arguments 
						// C'est-à-dire l'id de la Region par exemple
						sel = document.getElementById('user');
						user = sel.options[sel.selectedIndex].value;
						xhr.send("user="+user);
					}
					
					

					function addSubjectClass(){
						var xhr = getXhr()
						// On définit ce qu'on va faire quand on aura la reponse 
						xhr.onreadystatechange = function(){
							// On ne fait klk choz que si on a tt rxu et ke le serveur est ok
							if(xhr.readyState==4 && xhr.status==200){
								leselect = xhr.responseText;
								// On se sert de l'innerHTML pour rajouter les options à la liste
								document.getElementById('matiere').innerHTML = leselect;
							}
						}
						// Ici on va voir comment faire du POST
						xhr.open("POST", "parametre/addmatclss.ajax.php", true);
						// Ne pas oublier xa pour le POST 
						xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
						// Ne pas oublier de poster les arguments 
						// C'est-à-dire l'id de la Region par exemple
						sel = document.getElementById('classe');
						classe = sel.options[sel.selectedIndex].value;
						xhr.send("classe="+classe);
					}





					function updSubjectClass(){
						var xhr = getXhr()
						// On définit ce qu'on va faire quand on aura la reponse 
						xhr.onreadystatechange = function(){
							// On ne fait klk choz que si on a tt rxu et ke le serveur est ok
							if(xhr.readyState==4 && xhr.status==200){
								leselect = xhr.responseText;
								// On se sert de l'innerHTML pour rajouter les options à la liste
								document.getElementById('matiere').innerHTML = leselect;
							}
						}
						// Ici on va voir comment faire du POST
						xhr.open("POST", "parametre/updMatiereClasse.ajax.php", true);
						// Ne pas oublier xa pour le POST 
						xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
						// Ne pas oublier de poster les arguments 
						// C'est-à-dire l'id de la Region par exemple
						sel = document.getElementById('classe');
						classe = sel.options[sel.selectedIndex].value;
						xhr.send("classe="+classe);
					}




					function rmSubjectClass(){
						var xhr = getXhr()
						// On définit ce qu'on va faire quand on aura la reponse 
						xhr.onreadystatechange = function(){
							// On ne fait klk choz que si on a tt rxu et ke le serveur est ok
							if(xhr.readyState==4 && xhr.status==200){
								leselect = xhr.responseText;
								// On se sert de l'innerHTML pour rajouter les options à la liste
								document.getElementById('matiere').innerHTML = leselect;
							}
						}
						// Ici on va voir comment faire du POST
						xhr.open("POST", "parametre/rmMatiereClasse.ajax.php", true);
						// Ne pas oublier xa pour le POST 
						xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
						// Ne pas oublier de poster les arguments 
						// C'est-à-dire l'id de la Region par exemple
						sel = document.getElementById('classe');
						classe = sel.options[sel.selectedIndex].value;
						xhr.send("classe="+classe);
					}




					function addUserClass(){
						var xhr = getXhr()
						// On définit ce qu'on va faire quand on aura la reponse 
						xhr.onreadystatechange = function(){
							// On ne fait klk choz que si on a tt rxu et ke le serveur est ok
							if(xhr.readyState==4 && xhr.status==200){
								leselect = xhr.responseText;
								// On se sert de l'innerHTML pour rajouter les options à la liste
								document.getElementById('matiere').innerHTML = leselect;
							}
						}
						// Ici on va voir comment faire du POST
						xhr.open("POST", "parametre/addprofcls.ajax.php", true);
						// Ne pas oublier xa pour le POST 
						xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
						// Ne pas oublier de poster les arguments 
						// C'est-à-dire l'id de la Region par exemple
						sel = document.getElementById('classe');
						classe = sel.options[sel.selectedIndex].value;
						xhr.send("classe="+classe);
					}
					
					
				</script>
				<title>Paramètres : </title>
			</head>
			<body>
				<?php
					require_once('../part/entete.php');
					require_once('../part/aside.php');
					require_once('../part/nav.php');
				?>
				<div id='body'>
				<h1>Paramètres</h1>
				
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
						
						
						
						
						
						if($action=='liste'){
							require_once('etat/liste.php');
						}elseif($action=='releve'){
							require_once('etat/releve.php');
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