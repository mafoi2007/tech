<?php 
	session_start();
	require_once('inc/connect.inc.php');
	$config = new config($db);
	$finance = new finance($db);
	$source = $_SERVER['HTTP_REFERER'];
	$_SESSION['appName'] = appName;
	$_SESSION['appVersion'] = appVersion;
	$_SESSION['appContact'] = appContact;
	$_SESSION['appSlogan'] = appSlogan;
	
	
		// echo '<pre>';print_r($_POST);echo '</pre>';
		/****************
		On initialise l'année scolaire. On peut aussi la cloturer. ;-)
		*****************/
		if(isset($_POST['setSchoolYear'])){
			if($_POST['setSchoolYear']=="Debuter l'année"){
				echo '<pre>';print_r($_POST);echo '</pre>';
				$ministereFr = $config->setNom($_POST['ministereFr']);
				$ministereEn = $config->setNom($_POST['ministereEn']);
				$region = (int)$_POST['region'];
				$departement = (int)$_POST['departement'];
				$arrondissement = $config->setNom($_POST['arrondissement']);
				$natureEts = $config->setNom($_POST['natureEts']);
				$ville = $config->setNom($_POST['ville']);
				$etablissementFr = $config->setNom($_POST['etablissementFr']);
				$etablissementEn = $config->setNom($_POST['etablissementEn']);
				$contact = (int) $_POST['contact'];
				$email = $_POST['email'];
				$bp = (int) $_POST['boitePostale'];
				$sexe = $_POST['sexe'];
				$chef = $config->setNom($_POST['chef']);
				$anneeScolaire = (int)$_POST['debut'].' - '.(int)$_POST['fin'];
				$paysFr = 'REPUBLIQUE DU CAMEROUN';
				$deviseFr = 'Paix - Travail - Patrie';
				$paysEn = 'REPUBLIC OF CAMEROON';
				$deviseEn = 'Peace - Work - Fatherland';
				if($natureEts=='cetic'){
					$typeEts = 'cetic';
					if($sexe=='M'){$signataireFr = 'Le Directeur';}
					elseif($sexe=='F'){$signataireFr = 'La Directrice';}
					$niveau = array('1annee','2annee','3annee','4annee');
					$section =array('fr');
				}
				elseif($natureEts=='cetic_bil'){
					$typeEts = 'cetic';
					if($sexe=='M'){$signataireFr = 'Le Directeur';}
					elseif($sexe=='F'){$signataireFr = 'La Directrice';}
					$niveau = array('1annee','2annee','3annee','4annee','form1','form2','form3','form4','form5');
					$section = array('fr', 'en');
				}
				elseif($natureEts=='lyceetech'){
					$typeEts = 'lyceetech';
					if($sexe=='M'){$signataireFr = 'Le Proviseur';}
					elseif($sexe=='F'){$signataireFr = 'La Proviseure';}
					$niveau = array('1annee','2annee','3annee','4annee','2nde','1ere','tle');
					$section =array('fr');
				}
				elseif($natureEts=='lyceetech_bil'){
					$typeEts = 'lyceetech';
					if($sexe=='M'){$signataireFr = 'Le Proviseur';}
					elseif($sexe=='F'){$signataireFr = 'La Proviseure';}
					$niveau = array('1annee','2annee','3annee','4annee','2nde','1ere','tle','form1','form2','form3','form4','form5','lower6','upper6');
					$section = array('fr', 'en');
				}
				elseif($natureEts=='coltech'){
					$typeEts = 'lyceetech';
					if($sexe=='M'){$signataireFr = 'Le Principal';}
					elseif($sexe=='F'){$signataireFr = 'La Principale';}
					$niveau = array('1annee','2annee','3annee','4annee','2nde','1ere','tle');
					$section = array('fr');
				}
				elseif($natureEts=='coltech_bil'){
					$typeEts = 'lycee';
					if($sexe=='M'){$signataireFr = 'Le Proviseur';}
					elseif($sexe=='F'){$signataireFr = 'La Proviseure';}
					$niveau = array('1annee','2annee','3annee','4annee','2nde','1ere','tle','form1','form2','form3','form4','form5','lower6','upper6');
					$section = array('fr', 'en');
				}
				$signataireEn = 'The Principal';
				// J'appelle le fichier de structure SQL 
				require_once('sql/structure.sql.php');
				// echo '<pre>';print_r($structure);echo '</pre>';
				// J'éxecute les réquêtes de structure.
				for($i=0;$i<count($structure);$i++){
					$config->setDatabaseStructure($structure[$i]);
				}
				// J'appelle le fichier d'insertion des données SQL 
				require_once('sql/data.sql.php');
				// echo '<pre>';print_r($data);echo '</pre>';
				for($j=0;$j<count($data);$j++){
					$config->setDatabaseData($data[$j]);
				}
				
				// Je renomme le fichier firstConnexion.php en fisrtConnexion.done.php
				rename('inc/firstConnexion.php','inc/firstConnexion.done.php');
				// Je prepare le message selon lequel tout s'est bien passé 
				$_SESSION['message'] = 'Application initialisée. Connectez-vous';
				// Je redirige vers la page d'accueil pour qu'on affiche 
				// le formulaire de connexion
				header('Location:'.$_SERVER['HTTP_REFERER']);
				
				
				
				
				
				
				
				
				
				
				
				
				
			}elseif($post['setSchoolYear']=="Cloturer l'année"){
				echo 'Fin';
			}else{
				echo 'Ne sais pas';
			}
				/* */
		}

		






		// On a choisi le formulaire de connexion 
		if(isset($_POST['connexion'])){
			echo '<pre>'; print_r($_POST); echo '</pre>';
			$config->connectUser($source, $_POST['login'], $_POST['mdp']);
		}




		// On ajoute une classe 
		if(isset($_POST['ajout_classe'])){
			echo '<pre>'; print_r($_POST); echo '</pre>';
			$classe = $_POST;
			$config->ajouterClasse($source, $classe);
		}




		// On ajoute une classe 
		if(isset($_POST['ajout_matiere'])){
			// echo '<pre>'; print_r($_POST); echo '</pre>';
			$matiere = $_POST;
			$config->ajouterMatiere($source, $matiere);
		}


		// On ajoute un élève 
		if(isset($_POST['ajout_eleve'])){
			// echo '<pre>'; print_r($_POST); echo '</pre>';
			$eleve = $_POST;
			$config->ajouterEleve($source, $eleve);
		}



		// On ajoute un utilisateur 
		if(isset($_POST['ajout_utilisateur'])){
			echo '<pre>'; print_r($_POST); echo '</pre>';
			$user = $_POST;
			$config->ajouterUtilisateur($source, $user);
		}








		// On met à jour une classe 
		if(isset($_POST['upd_classe'])){
			// echo '<pre>'; print_r($_POST); echo '</pre>';
			$classe = $_POST;
			$var1 = '?action=update&';
			$var2 = 'id='.$_POST['classId'];
			$source = str_replace($var1,'',$source);
			$source = str_replace($var2,'',$source);
			$config->updateClasse($source, $classe);
		}







		if(isset($_POST['updAbsence'])){
			// echo '<pre>';print_r($_POST);echo '</pre>';
			$info = $_POST;
			$config->updateAbsenceEleve($source, $info);
				/*if(!empty($_POST['idAbsence'])){
					for($i=0;$i<count($_POST['idAbsence']);$i++){
						$ligne = $_POST['idAbsence'][$i];
						$config->updateAbsenceEleve($source, $ligne);
					}
				}else{
					$_SESSION['message'] = 'Aucune Valeur Transmise.';
					header('Location:'.$source);
				}*/
			
		}







		if(isset($_POST['delAbsence'])){
		echo '<pre>';
			print_r($_POST);
			for($i=0;$i<count($_POST['eleve']);$i++){
				$eleve = $_POST['eleve'][$i];
				$config->deleteAbsenceEleve($source, $eleve);
			}
		echo '</pre>';
	}


		
		// On met à jour un utilisateur 
		if(isset($_POST['upd_utilisateur'])){
			echo '<pre>'; print_r($_POST); echo '</pre>';
			$utilisateur = $_POST;
			$var1 = '?action=update&';
			$var2 = 'id='.$_POST['userId'];
			$source = str_replace($var1,'',$source);
			$source = str_replace($var2,'',$source);
			$config->updateUtilisateur($source, $utilisateur);
		}


		


		// On met à jour un élève 
		if(isset($_POST['updEleve'])){
			// echo '<pre>'; print_r($_POST); echo '</pre>';
			$eleve = $_POST;
			$var1 = '?action=updEleve&';
			$var2 = 'id='.$_POST['idEleve'];
			$source = str_replace($var1,'',$source);
			$source = str_replace($var2,'',$source);
			$config->updateEleve($source, $eleve);
		}



		// On met à jour une matière 
		if(isset($_POST['upd_matiere'])){
			echo '<pre>'; print_r($_POST); echo '</pre>';
			$matiere = $_POST;
			$var1 = '?action=editMatiere&';
			$var2 = 'id='.$_POST['idMatiere'];
			$source = str_replace($var1,'',$source);
			$source = str_replace($var2,'',$source);
			$config->updateMatiere($source, $matiere);
		}




		// On met à jour les coef et les groupes des matières
		if(isset($_POST['updmatclss'])){
			echo '<pre>'; print_r($_POST); echo '</pre>';
			for($i=0;$i<count($_POST['refTable']);$i++){
				$info['id'] = $_POST['refTable'][$i];
				$info['coef'] = $_POST['coef'][$i];
				$info['groupe'] = $_POST['groupe'][$i];
				$config->updateSubjectClass($source, $info);
			}
		}










		// On retire une matière de classe
		if(isset($_POST['rmmatclss'])){
			$info = $_POST['matiere'];
			$config->removeSubjectClasse($source, $info);
		}






		




		// On active une séquence
		if(isset($_POST['openSeq'])){
			echo '<pre>'; print_r($_POST); echo '</pre>';
			$valeur = $_POST;
			if($_POST['sequence']=='null'){
				$_SESSION['message'] = 'Vous devez choisir une séquence';
				header('Location:'.$source);
			}else{
				$config->openSequence($source, $valeur);
			}
		}





		// On verouille une séquence
		if(isset($_POST['closeSeq'])){
			echo '<pre>'; print_r($_POST); echo '</pre>';
			$valeur = $_POST;
			if($_POST['sequence']=='null'){
				$_SESSION['message'] = 'Vous devez choisir une séquence';
				header('Location:'.$source);
			}else{
				$config->closeSequence($source, $valeur);
			}
		}

		
		
		
		
		
		
		// On modifie le mot de passe
		if(isset($_POST['changer_mdp'])){
			echo '<pre>'; print_r($_POST); echo '</pre>';
			$mdpAncien = $_POST['mdp_ancien'];
			$mdpNouveau = $_POST['nouveau_mdp'];
			$mdpConfirm = $_POST['mdp_confirm'];
			$userId = $_SESSION['user']['id'];
			$info['ancien'] = $mdpAncien;
			$info['nouveau'] = $mdpNouveau;
			$info['confirm'] = $mdpConfirm;
			$info['id'] = $userId;
			$config->changePassword($source, $info);
		}
		
		
		
		
		
		
		// On réinitialise le mot de passe d'un utilisateur 
		if(isset($_POST['resetPwd'])){
			// echo '<pre>'; print_r($_POST); echo '</pre>';
			$info = $_POST;
			$config->resetPassword($source, $info);
		}






		// Ajouter UNE matière à la classe 
		if(isset($_POST['addmatcls'])){
			echo '<pre>'; print_r($_POST); echo '</pre>';
			$info = $_POST;
			$config->addSubjectClass($source, $info);
		}



		// Ajouter PLUSIEURS matières à la classe 
		if(isset($_POST['addmatclss'])){
			// echo '<pre>'; print_r($_POST); echo '</pre>';
			for($i=0;$i<count($_POST['matiere']);$i++){
				if($_POST['coef'][$i]=='' or $_POST['groupe'][$i]=='null'){
					// Nothing to do here
				}else{
					echo "<p>La Matiere ".$_POST['matiere'][$i]." a pour 
					coef ".$_POST['coef'][$i]." dans le groupe ".$_POST['groupe'][$i]."</p>";
					$info['classe'] = $_POST['classe'];
					$info['matiere'] = $_POST['matiere'][$i];
					$info['coef'] = $_POST['coef'][$i];
					$info['groupe'] = $_POST['groupe'][$i];
					$config->addSubjectClass($source, $info);
				}
			}
			header('Location:'.$source);
		}





		// On ajoute un utilisateur à la classe
		if(isset($_POST['addprofcls'])){
			// echo '<pre>'; print_r($_POST); echo '</pre>';
			for($i=0;$i<count($_POST['enseignant']);$i++){
				if($_POST['enseignant'][$i]=='null'){

				}else{
					$info['classe'] = $_POST['classe'];
					$info['matiere'] = $_POST['matiere'][$i];
					$info['enseignant'] = $_POST['enseignant'][$i];
					// echo "<p>La Matière ".$info['matiere']." a pour enseignant ".$info['enseignant'].".</p>";
					$config->ajouterUtilisateurClasse($info);
				}
				if(!isset($_SESSION['message'])){
					$_SESSION['message'] = 'Erreur survenue ou aucun ajout effectué.';
				}
				header('Location:'.$source);
			}
		}








		// On ajoute un professeur principal 
		if(isset($_POST['addpp'])){
			// echo '<pre>'; print_r($_POST); echo '</pre>';
			for($i=0;$i<count($_POST['prof']);$i++){
				if($_POST['prof'][$i]=='null'){

				}else{
					// echo "<p>La Classe ".$_POST['classe'][$i]." a pour titulaire ".$_POST['prof'][$i].".</p>";
					$info['classe'] = $_POST['classe'][$i];
					$info['prof'] = $_POST['prof'][$i];
					$config->addProfPrincipal($info);
				}

				if(!isset($_SESSION['message'])){
					$_SESSION['message'] = 'Erreur survenue ou aucun ajout effectué.';
				}
				header('Location:'.$source);
			}
		}


		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		// On supprime un élève 
		if(isset($_POST['delEleve'])){
			// echo '<pre>'; print_r($_POST); echo '</pre>';
			$eleve = $_POST;
			$var1 = '?action=deleteEleve&';
			$var2 = 'id='.$eleve['eleve'];
			$source = str_replace($var1,'',$source);
			$source = str_replace($var2,'',$source);
			if($eleve['delEleve']=='non'){
				$_SESSION['message'] = 'L élève ne sera pas supprimé';
				header('Location:'.$source);
			}elseif($eleve['delEleve']=='oui'){
				$config->deleteEleve($source, $eleve['eleve']);
			}
		}
		
		
		
		
		
		
		
		
		
		
		// On supprime un utilisateur 
		if(isset($_POST['delUser'])){
			echo '<pre>'; print_r($_POST); echo '</pre>';
			$utilisateur = $_POST;
			$var1 = '?action=delete&';
			$var2 = 'id='.$utilisateur['user'];
			$source = str_replace($var1,'',$source);
			$source = str_replace($var2,'',$source);
			if($utilisateur['delUser']=='non'){
				$_SESSION['message'] = 'L utilisateur ne sera pas supprimé';
				header('Location:'.$source);
			}elseif($utilisateur['delUser']=='oui'){
				$config->deleteUser($source, $utilisateur['user']);
			}
			
		}
		
		
		
		
		
		
		
		
		
		// On supprime une classe 
		if(isset($_POST['delClasse'])){
			echo '<pre>'; print_r($_POST); echo '</pre>';
			$classe = $_POST;
			$var1 = '?action=delete&';
			$var2 = 'id='.$classe['classe'];
			$source = str_replace($var1,'',$source);
			$source = str_replace($var2,'',$source); 
			if($classe['delClasse']=='non'){
				$_SESSION['message'] = 'La Classe ne sera pas supprimée';
				header('Location:'.$source);
			}elseif($classe['delClasse']=='oui'){
				$config->deleteClasse($source, $classe['classe']);
			}
		}




		// On restaure une classe 
		if(isset($_POST['restaureClasse'])){
			echo '<pre>'; print_r($_POST); echo '</pre>';
			$classe = $_POST;
			$var1 = '?action=restaure&';
			$var2 = 'id='.$classe['classe'];
			$source = str_replace($var1,'',$source);
			$source = str_replace($var2,'',$source); 
			if($classe['restaureClasse']=='non'){
				$_SESSION['message'] = 'La Classe ne sera pas restaurée';
				header('Location:'.$source);
			}elseif($classe['restaureClasse']=='oui'){
				$config->restaureClasse($source, $classe['classe']);
			}
		}








		// On restaure un utilisateur 
		if(isset($_POST['restaureUser'])){
			echo '<pre>'; print_r($_POST); echo '</pre>';
			$user = $_POST;
			$var1 = '?action=restaure&';
			$var2 = 'id='.$user['user'];
			$source = str_replace($var1,'',$source);
			$source = str_replace($var2,'',$source); 
			if($user['restaureUser']=='non'){
				$_SESSION['message'] = 'L utilisateur ne sera pas restauré.';
				header('Location:'.$source);
			}elseif($user['restaureUser']=='oui'){
				$config->restaureUser($source, $classe['user']);
			}
		}
		
		
		
		
		
		
		
		
		
		if(isset($_POST['restaureEleve'])){
			echo '<pre>'; print_r($_POST); echo '</pre>';
			$eleve = $_POST;
			$var1 = '?action=restaureEleve&';
			$var2 = 'id='.$eleve['eleve'];
			$source = str_replace($var1,'',$source);
			$source = str_replace($var2,'',$source);
			if($eleve['restaureEleve']=='non'){
				$_SESSION['message'] = 'L élève ne sera pas retabli';
				header('Location:'.$source);
			}elseif($eleve['restaureEleve']=='oui'){
				$config->restaureEleve($source, $eleve['eleve']);
			}
		}








		// On insère les matricules nationaux
		if(isset($_POST['addMatricule'])){
			echo '<pre>'; print_r($_POST); echo '</pre>';
			$informations = $_POST;
			$config->addMatriculeNational($source, $informations);
		}
		
		
		
		
		
		
		
		
		/*
		//On ajoute la photo des élèves 
		if(isset($_POST['ajout_photo_eleve'])){
			// echo '<h1>Les Eleves</h1>';
			// echo '<pre>'; print_r($_POST); echo '</pre>';
			// echo '<h1>Les Photos</h1>';
			// echo '<pre>'; print_r($_FILES); echo '</pre>';
			$config->enregistrerImageEleve($source, $_POST['eleve'], 'images/student/',$_FILES['photo']);
		}
		*/
		
		
		
		/**
		 * 		G
		 * 			E
		 * 				N	E	R	A	T	I	O	N
		 * 
		 * 		D
		 * 			E
		 * 				S
		 * 	
		 * 		P	D	F
		 */
		
		
		if(isset($_POST['print'])){
			echo '<pre>'; print_r($_POST); echo '</pre>';
			$print = $_POST['to_print'];
			$as = $config->getCurrentYear();  // Année Scolaire en Cours
			
			
			// On édite le certificat de scolarité 
			if($print==='certificatScol'){
				if(!$_POST['eleve']){
					$_SESSION['message'] = 'Vous devez choisir un élève';
					header('Location:'.$source);
				}else{
					$eleve = $config->getEleve($_POST['eleve']);
					$section = $config->getSectionclasse($eleve['classe']);
					$_SESSION['eleve'] = $eleve;
					$_SESSION['classe']['section'] = $section;
					$_SESSION['print'] = 'certificatScolarite';
					header('Location:print_pdf.php');
				}
			}
			

			// On imprime la liste des élèves 
			if($print==='listeEleve'){
				$classe = $_POST['classe'];
				if($classe=='null'){
					$_SESSION['message'] = 'Vous devez choisir une classe.';
					header('Location:'.$source);
				}else{
					$listeEleve = $config->listeEleve($_POST['classe'], 'non_supprime', $as );
					$nbValue = count($listeEleve); // Si ça vaut 0, y'a pas d'élèves dans la classe.
					if($nbValue===0){
						$_SESSION['message'] = 'Classe sans élèves.';
						header('Location:'.$source);
					}else{
						$section = $config->getSectionClasse($classe);
						$_SESSION['classe']['information'] = $_SESSION['information'];
						$_SESSION['classe']['eleve'] = $listeEleve;
						$_SESSION['classe']['section'] = $section;
						$_SESSION['classe']['stat'] = $config->listeEleveStat($_POST['classe'], 'non_supprime', $as);
						$_SESSION['print'] = 'listeEleve';
						header('Location:print_pdf.php');
					}
				}
			}
			
			
			// La Vue d'ensemble des effectifs 
			if($print==='vueEffectif'){
				$listeNiveau = $config->listeNiveaux();
				for($a=0;$a<count($listeNiveau);$a++){
					$listeClasse = $config->getClasseByNiveau($listeNiveau[$a]['id']);
					$myClasse[$a] = $listeClasse;
					for($b=0;$b<count($listeClasse);$b++){
						$statClasse = $config->listeEleveStat($listeClasse[$b]['id'],'non_supprime', $as);
						$myStat[$a][$b] = $statClasse;
					}
					$statNiveau = $config->statEleveNiveau($listeNiveau[$a]['id'], 'non_supprime', $as);
					$stat[$a] = $statNiveau;
					// echo '<pre>'; print_r($statNiveau); echo '</pre>';
				}

				$_SESSION['classe']['niveau'] = $listeNiveau;
				$_SESSION['classe']['liste'] = $myClasse;
				$_SESSION['classe']['effectif'] = $myStat;
				$_SESSION['classe']['stat'] = $stat;
				// echo '<pre>'; print_r($myStat); echo '</pre>';
				$_SESSION['print'] = 'vueEffectif';
				header('Location:print_pdf.php');
			}
			

			// On imprime le releve de notes 
			elseif($print==='releveNote'){
				$classe = $_POST['classe'];
				if($classe=='null'){
					$_SESSION['message'] = 'Vous devez choisir une classe.';
					header('Location:'.$source);
				}else{
					$listeEleve = $config->listeEleve($_POST['classe'], 'non_supprime', $as );
					$nbValue = count($listeEleve); // Si ça vaut 0, y'a pas d'élèves dans la classe.
					if($nbValue===0){
						$_SESSION['message'] = 'Classe sans élèves.';
						header('Location:'.$source);
					}else{
						$section = $config->getSectionClasse($classe);
						$_SESSION['classe']['information'] = $_SESSION['information'];
						$_SESSION['classe']['eleve'] = $listeEleve;
						$_SESSION['classe']['section'] = $section;
						$_SESSION['classe']['stat'] = $config->listeEleveStat($_POST['classe'], 'non_supprime', $as);
						$_SESSION['print'] = 'releveNote';
						header('Location:print_pdf.php');
					}
				}
			}





			// La liste des professeurs principaux 
			elseif($print==='ProfesseursPrincipaux'){
				$prof = $config->classePrincipale();
				if(empty($prof)){
					$_SESSION['message'] = 'Aucun professeur principal désigné';
					header('Location:'.$source);
				}else{
					echo '<pre>'; print_r($prof); echo '</pre>';
					$_SESSION['prof'] = $prof;
					$_SESSION['print'] = 'professeursPrincipaux';
					header('Location:print_pdf.php');
				}
			}


			


			// Le Conseil de Classe 
			elseif($print==='ConseilClasse'){
				$classe = $_POST['classe'];
				if($classe=='null'){
					$_SESSION['message'] = 'Vous devez choisir une classe';
					header('Location:'.$source);
				}else{
					$council = $config->classCouncil($classe);
					if(empty($council)){
						$_SESSION['message'] = 'La Classe n a pas encore d enseignants.';
						header('Location:'.$source);
					}else{
						$_SESSION['conseil'] = $council;
						// echo '<pre>'; print_r($council);
						$_SESSION['print'] = 'conseilClasse';
						header('Location:print_pdf.php');
					}
				}
				/*$prof = $config->classePrincipale();
				if(empty($prof)){
					$_SESSION['message'] = 'Aucun professeur principal désigné';
					header('Location:'.$source);
				}else{
					echo '<pre>'; print_r($prof); echo '</pre>';
					$_SESSION['prof'] = $prof;
					$_SESSION['print'] = 'professeursPrincipaux';
					header('Location:print_pdf.php');
				}*/
			}




			// Vue des Notes Séquentielles
			elseif($print==='VisualiserNoteSequentielle'){
				// On veut visualiser les notes séquentielles 
				$classe = (int) $_POST['classe'];
				$sequence = (int) $_POST['sequence'];
				if(empty($classe)){
					$_SESSION['message']  = 'Valeur de Classe incorrecte';
					header('Location:'.$source);
				}else{
					if(empty($sequence)){
						$_SESSION['message'] = 'Valeur de Séquence incorrecte';
						header('Location:'.$source);
					}else{
						$config->viewNoteSequentielle($_POST['sequence'], $_POST['classe']);
						$info = $config->exportNoteSequence($_POST['sequence'], $_POST['classe']);
						$infoClasse = $config->getClasse($_POST['classe']);
						$listeMatiere = $config->getMatiereClasse($classe);

						// echo '<pre>'; print_r($listeMatiere); echo '</pre>';
						$_SESSION['print'] = $print;
						$_SESSION['eleve'] = $info;
						$_SESSION['classe'] = $infoClasse;
						$_SESSION['matiere'] = $listeMatiere;
						header('Location:print_pdf_landscape.php');
					}
				}
			}
			
			
			
			
			elseif($_POST['to_print']=='BulletinSequentiel'){
			$_SESSION['print'] ='BullSeq';
			// echo $_SESSION['print'];
			$_SESSION['sequence'] = $_POST['sekence'];
			$_SESSION['classe'] = $_POST['classe'];
			$_SESSION['nomClasse'] = $config->viewNomClasse($_POST['classe']);
			$section = $config->verifSectionClasse($_POST['classe']);
			$_SESSION['section'] = $section;
			$eleve = $config->moySequenceClasse($_POST['sekence'], 
												$_POST['classe']);
			$eleve2 = $config->moySequenceClasseMerite($_POST['sekence'], 
												$_POST['classe']);
			$tableBulletin = $config->sequenceClasse($_POST['sekence'],
												$_POST['classe']);
			$tableStat = $config->statSequence($_POST['sekence'], 
												$_POST['classe']);
			$nbGroupe = $config->afficheGroupe($_POST['classe']);
			for($w=0;$w<count($nbGroupe);$w++){
				$nomGpe = $nbGroupe[$w]['groupe'];
				$matiereGroupe[$nomGpe] = $config->getmatiereGroupe($nbGroupe[$w]['groupe'],
														$_POST['classe']);
			}
			$groupes = $config->getGroupeClasse($_POST['classe']);
			for($x=0;$x<count($groupes);$x++){
				$gpCode = $groupes[$x]['code_groupe'];
				$listeMatiere = $config->getMatiereGroupe($gpCode,
														$_SESSION['classe']);
				$j=0;
				while($j<count($listeMatiere)){
					$codeMatiere[$gpCode][] = $listeMatiere[$j]['id_matiere'];
					$nomMatiere[$gpCode][] = $listeMatiere[$j]['nom_matiere'];
					$j++;
				}
			}
			$_SESSION['code_matiere'] = $codeMatiere;
			$_SESSION['nom_matiere'] = $nomMatiere;
			
			$_SESSION['eleve'] = $eleve;
			$_SESSION['eleve2'] = $eleve2;
			$_SESSION['bulletin'] = $tableBulletin;
			$_SESSION['statistique'] = $tableStat;
			$_SESSION['matiereGroupe'] = $matiereGroupe;
			$nom_classe = $config->getClasse($_POST['classe']);
			$_SESSION['nom_classe'] = $nom_classe['nom_classe'];
			$_SESSION['groupe'] = $config->getGroupeClasse($_POST['classe']);
			
				// On extrait le Prof Principal de la Classe
				$classePrincipale = $config->classePrincipale();
				// echo '<pre>';print_r($classePrincipale); echo '</pre>';
				for($a=0;$a<count($classePrincipale);$a++){
					if($classePrincipale[$a]['code_classe']==$_SESSION['classe']){
						$_SESSION['professeurPrincipal'] = $classePrincipale[$a]['sexe'].' ';
						$_SESSION['professeurPrincipal'] .= strtoupper($classePrincipale[$a]['nom']).' ';
						$_SESSION['professeurPrincipal'] .= ucwords($classePrincipale[$a]['prenom']).' ';
					}
				}
			header('Location:print_pdf.php');
		}









		elseif($_POST['to_print']=='BulletinTrimestriel'){
			echo '<pre>';print_r($_POST);echo '</pre>';
			$_SESSION['print'] ='BulletinTrimestriel';
			// echo $_SESSION['print'];
			$_SESSION['trimestre'] = $_POST['trimestre'];
			$_SESSION['classe'] = $_POST['classe'];
			$_SESSION['nomClasse'] = $config->viewNomClasse($_POST['classe']);
			$section = $config->verifSectionClasse($_POST['classe']);
			$_SESSION['section'] = $section;
			$eleve = $config->moyTrimestreClasse($_POST['trimestre'], 
												$_POST['classe']);
			$eleve2 = $config->moyTrimestreClasseMerite($_POST['trimestre'], 
												$_POST['classe']);
			$tableBulletin = $config->trimestreClasse($_POST['trimestre'],
												$_POST['classe']);
			$tableStat = $config->statTrimestre($_POST['trimestre'], 
												$_POST['classe']);
			$nbGroupe = $config->afficheGroupe($_POST['classe']);
			for($w=0;$w<count($nbGroupe);$w++){
				$nomGpe = $nbGroupe[$w]['groupe'];
				$matiereGroupe[$nomGpe] = $config->getmatiereGroupe($nbGroupe[$w]['groupe'],
														$_POST['classe']);
			}
			$groupes = $config->getGroupeClasse($_POST['classe']);
			for($x=0;$x<count($groupes);$x++){
				$gpCode = $groupes[$x]['code_groupe'];
				$listeMatiere = $config->getMatiereGroupe($gpCode,
														$_SESSION['classe']);
				$j=0;
				while($j<count($listeMatiere)){
					$codeMatiere[$gpCode][] = $listeMatiere[$j]['id_matiere'];
					$nomMatiere[$gpCode][] = $listeMatiere[$j]['nom_matiere'];
					$j++;
				}
			}
			$_SESSION['code_matiere'] = $codeMatiere;
			$_SESSION['nom_matiere'] = $nomMatiere;
			
			$_SESSION['eleve'] = $eleve;
			$_SESSION['eleve2'] = $eleve2;
			$_SESSION['bulletin'] = $tableBulletin;
			$_SESSION['statistique'] = $tableStat;
			$_SESSION['matiereGroupe'] = $matiereGroupe;
			$nom_classe = $config->getClasse($_POST['classe']);
			$_SESSION['nom_classe'] = $nom_classe['nom_classe'];
			$_SESSION['groupe'] = $config->getGroupeClasse($_POST['classe']);
			// echo '<pre>';print_r($section);
			// echo '<pre>';print_r($matiereGroupe);
			// echo '<pre>'; print_r($_SESSION);
			// echo $_SESSION['professeurPrincipal'];

			header('Location:print_pdf.php');


			// $_SESSION['trimestre'] = $_POST['trimestre'];
			// $_SESSION['code_classe'] = $_POST['classe'];
			// $nom_classe = $config->viewNomClasse($_POST['classe']);
			// $_SESSION['nom_classe'] = $nom_classe['nom_classe'];
			// $_SESSION['print'] = 'BullTrimestriel';
			// $section = $config->verifSectionClasse($_POST['classe']);
			// $_SESSION['section'] = $section;
			// $_SESSION['eleve'] = $note->tableTrimestre($_POST['trimestre'],$_POST['classe']);
			// $_SESSION['eleve2'] = $note->tableTrimestreMerite($_POST['trimestre'],$_POST['classe']);
			// $_SESSION['statistique'] = $note->statTrimestre($_POST['trimestre'], $_POST['classe']);
			// $_SESSION['groupe'] = $note->getGroupeClasse($_POST['classe']);
			// // $_SESSION['rang'] = $note->showRangEleve($_POST['periode'],$_POST['classe']);
			// for($x=0;$x<count($_SESSION['groupe']);$x++){
			// 	$gpCode = $_SESSION['groupe'][$x];
			// 	$listeMatiere = $note->getMatiereGroupe($gpCode,
			// 											$_SESSION['code_classe']);
			// 	$j=0;
			// 	while($j<count($listeMatiere)){
			// 		$codeMatiere[$gpCode][] = $listeMatiere[$j]['id_matiere'];
			// 		$nomMatiere[$gpCode][] = $listeMatiere[$j]['nom_matiere'];
			// 		$j++;
			// 	}
			// }
			// $_SESSION['code_matiere'] = $codeMatiere;
			// $_SESSION['nom_matiere'] = $nomMatiere;
			
			// // On extrait le Prof Principal de la Classe
			// $classePrincipale = $config->classePrincipale();
			// for($a=0;$a<count($classePrincipale);$a++){
			// 	if($classePrincipale[$a]['code_classe']==$_SESSION['code_classe']){
			// 		$_SESSION['professeurPrincipal'] = $classePrincipale[$a]['sexe'].' ';
			// 		$_SESSION['professeurPrincipal'] .= strtoupper($classePrincipale[$a]['nom']).' ';
			// 		$_SESSION['professeurPrincipal'] .= ucwords($classePrincipale[$a]['prenom']).' ';
			// 	}
			// }
			
			
			// // echo '<pre>';print_r($_SESSION['eleve']);echo '</pre>';
			// // echo '<pre>';print_r($_SESSION['eleve']);echo '</pre>';
			// // echo '<pre>';print_r($_SESSION['eleve']);echo '</pre>';
			// header('Location:print_pdf.php');
		}








		elseif($_POST['to_print']=='RapportTrimestriel'){
			// echo "<pre>"; print_r($_POST); echo "</pre>";
			$infoClasse = $config->getClasse($_POST['classe']);
			$listeMatiere = $config->listeMatiereClasse($_POST['classe']);
			$contenu = $config->moyTrimestreClasse($_POST['trimestre'], $_POST['classe']);
			$tableStat = $config->statTrimestre($_POST['trimestre'], $_POST['classe']);
			$_SESSION['classe']['periode'] = $_POST['trimestre'];
			$_SESSION['classe']['stat'] = $tableStat;
			$_SESSION['classe']['eleve'] = $contenu;
			$_SESSION['classe']['matiere'] = $listeMatiere;
			$_SESSION['classe']['classe'] = $infoClasse;
			$_SESSION['print'] = $_POST['to_print'];
			header('Location:print_pdf_landscape.php');
		}








		elseif($_POST['to_print']=='RecapMatiere'){
			/*echo '<pre>';
			print_r($_REQUEST);
			echo '</pre>';*/
			$matiere = $_POST['matiere'];
			$trimestre = $_POST['trimestre'];
			/*Avant de générer les stats, quelques règles simples s'imposent: 
			-->D'abord, il faut que toutes les classes aient été évaluées 
			-->Ensuite, le bulletin trimestriel de toutes les classes doit avoir été généré
			-->Enfin, les classes sans élèves, on doit leur retirer les matières. */
			// Première Etape : On vérifie que toutes les classes ont produit le bulletin.
			$classeIntervention = $config->listeClasseMatiere($matiere);
			$nbClasseVoulue = count($classeIntervention);
			for($i=0;$i<count($classeIntervention);$i++){
				$idClasse = $classeIntervention[$i]['id_classe'];
				$classeTraitee = $config->classesTraiteesTrim();
				// echo '<pre>';print_r($classeTraitee);
				for($j=0;$j<count($classeTraitee);$j++){
					if($classeIntervention[$i]['id_classe']==$classeTraitee[$j]['classe']){
						$compte[] = 1;
					}
				}
			}
			if($compte){$countTraitees = count($compte);}else{$countTraitees = NULL;}
			
			$difference = $nbClasseVoulue - $countTraitees;
			if($difference>0){
				$_SESSION['message'] = 'Il ya encore '.$difference.' classes à traiter pour générer ';
				$_SESSION['message'] .= ' ces statistiques.';
				header('Location:'.$source);
			}else{
				$infoMatiere = $config->getMatiere($matiere);
				$listeClasse = $config->listeClasseMatiere($matiere);
				for($i=0;$i<count($listeClasse);$i++){
					$idClasse = $listeClasse[$i]['id_classe'];
					$codeClasse = $listeClasse[$i]['code_classe'];
					$statClasse[$codeClasse] = $config->StatClasse($matiere, $trimestre, $idClasse);
				}
				$_SESSION['matiere'] = $infoMatiere;
				$_SESSION['matiere']['trimestre'] = $trimestre;
				$_SESSION['classe'] = $listeClasse;
				$_SESSION['stat'] = $statClasse;
				$_SESSION['print'] = 'RecapMatiere';
				// echo '<pre>'; print_r($_SESSION['stat']); echo '</pre>';
				header('Location:print_pdf_landscape.php');
			}
			
			

			/*
			
			
			
			
			
			
			
			// */

			
			/*if($matiere=='null' or $trimestre=='null'){*/
				// $_SESSION['message'] = 'Valeurs Nulles Transmises';
				// header('Location:'.$source);
			/*}else{*/
				// $nomMatiere = $config->getMatiereInfo($matiere);
				// $listeClasse = $config->listeClasseMatiere($matiere);
				// // print_r($listeClasse);
				
				// $_SESSION['codeMatiere'] = $nomMatiere['code_matiere'];
				// $_SESSION['nomMatiere'] = $nomMatiere['nom_matiere'];
				// $_SESSION['trimestre'] = $trimestre;
				// for($i=0;$i<count($listeClasse);$i++){
				// 	$codeClasse[] = $listeClasse[$i]['id_classe'];
				// 	$nomClasse[] = $listeClasse[$i]['nom_classe'];
				// 	$coefClasse[] = $listeClasse[$i]['coef'];
				// 	$statClasse[] = $note->StatClasse($matiere, $trimestre, $listeClasse[$i]['id_classe']);
					
				// }
				
				
				
				// $_SESSION['codeClasse'] = $codeClasse;
				// $_SESSION['nomClasse'] = $nomClasse;
				// $_SESSION['coefClasse'] = $coefClasse;
				// $_SESSION['stat'] = $statClasse;
				// $_SESSION['print'] = 'statMatiere';
				
				// // print_r($_SESSION['stat']);
				// header('Location:print_pdf_landscape.php');
			/*}*/
		}

















		
			// On imprime la fiche individuelle de l'élève 
			/*elseif($print==='ficheEleve'){
				$reponse = $_POST['fEleve'];
				$var1 = 'action=view&';
				$var2 = 'id='.$_POST['eleve'];
				$source = str_replace($var1,'',$source);
				$source = str_replace($var2,'',$source);
				if($reponse=='non'){
					$_SESSION['message'] = 'Fiche non générée';
					header('Location:'.$source);
				}elseif($reponse==='oui'){
					$eleve = $config->getEleve($_POST['eleve']);
					$_SESSION['eleve']['identification'] = $eleve;
					$_SESSION['eleve']['information'] = $_SESSION['information'];
					$_SESSION['print'] = 'ficheEleve';
					// echo '<pre>'; print_r($_SESSION['eleve']); echo '</pre>';
					header('Location:print_pdf.php');
				}
			}*/
			
			
			// On imprime le bulletin Mensuel des élèves de la classe 
			/*elseif($print ==='bulletinMensuel'){
				$print = $_POST['to_print'];
				$classe = $_POST['clas'];
				$mois = $_POST['mois'];
				if($classe=='null'){
					$_SESSION['message'] = 'Vous devez choisir une classe.';
					header('Location:'.$source);
				}else{
					if($mois=='null'){
						$_SESSION['message'] = 'Vous devez choisir un mois.';
						header('Location:'.$source);
					}else{
						
						// echo '<pre>'; print_r($bulletin); echo '</pre>';
						// $_SESSION['print'] = $print;
						// header('Location:print_pdf.php');
					}
				}
			}*/
			
			
		}














		/**********************************************************************
		 * ********************************************************************
		 *  GESTION DES NOTES, DES STATS ET DES BULLETINS 
		 * ********************************************************************
		 *********************************************************************/

		// On veut enregistrer ses notes 
		if(isset($_POST['saveNote'])){
			echo '<pre>'; print_r($_POST); echo '</pre>';
			$notes = $_POST;
			// Avant d'enregistrer, on s'assure que depuis un autre onglet, la tâche n'avait pas déjà été validée.
			$verification = $config->verifNoteSaisie($_POST['classe'],
													$_POST['matiere'], 
													$_POST['sequence']);
			if($verification==false){
				$config->ajouterNote($source, $notes);
			}else{
                $_SESSION['message'] = "Les Notes de cette matière ont été saisies le ";
                $_SESSION['message'] .= $verification['date_fr'];
                $_SESSION['message'] .= " à ";
                $_SESSION['message'] .= $verification['heure_fr'];
                $_SESSION['message'] .= ". Reportez-vous au menu Modifier des Notes ";
                $_SESSION['message'] .= "pour des éventuels changements de notes.";
				header('Location:'.$source);
			}
		}
		
		
		
		
		
		
		// On veut mettre à jour ses notes 
		if(isset($_POST['updateNote'])){
			$notes = $_POST;
			$config->modifierNote($source, $notes);
		}
		
		
		
		
		
		
		// On veut supprimer ses notes 
		if(isset($_POST['deleteNote'])){
			$reponse = $_POST['deleteNote'];
			if($reponse==='Non'){
				$_SESSION['message'] = 'Les notes de cette matière ne seront pas supprimées.';
				header('Location:'.$source);
			}elseif($reponse=='Oui'){
				$periode = $_POST['sequence'];
				$matiere = $_POST['matiere'];
				$classe = $_POST['classe'];
				$config->deleteNote($source, $periode, $matiere, $classe);
			}
		}
		
		
		
		
		
		
		
		
		// On lance le traitement mensuel des notes 
		if(isset($_POST['traitementMensuel'])){
			// echo '<pre>'; print_r($_POST); echo '</pre>';
			$classe = $_POST['clas'];
			$mois = $_POST['mois'];
			if($classe=='null'){
				$_SESSION['message'] = 'Aucune classe n a été choisie.';
				header('Location:'.$source);
			}else{
				if($mois=='null'){
					$_SESSION['message'] = 'Vous devez sélectionner un mois précis.';
					header('Location:'.$source);
				}else{
					// On vérifie que toutes les notes ont été saisies. Sinon on refuse
					// de lancer le traitement 
					$listeMatiere = $config->listeMatiereClasse($classe);
					$matiereSaisie = $config->getNoteSaisieMois($classe, $mois);
					$nombre = count($listeMatiere);
					$nombreMatiereSaisie = count($matiereSaisie);
					if($nombreMatiereSaisie<$nombre){
						$nb = $nombre - $nombreMatiereSaisie;
						$_SESSION['message'] = 'Il reste encore '.$nb.' matières';
						$_SESSION['message'] .= ' non saisies pour le mois que vous avez choisi.';
						header('Location:'.$source);
					}elseif($nombreMatiereSaisie==$nombre){
						$config->traiterNoteMensuelle($source, $classe, $mois);
					}else{
						$_SESSION['message'] = 'une erreur fatale s est produite et le traitement ';
						$_SESSION['message'] .= ' ne peut se poursuivre. Contactez le concepteur du logicel';
						header('Location:'.$source);
					}
					
					
					// Le code commenté suivant sera utilisé pour générer le bulletin mensuel
					/*if($nombreMatiereSaisie<$nombre){
						
						
						
						
					}elseif(){
						
						
						$_SESSION['classe']['eleve'] = $bulletin['eleve'];
						$_SESSION['classe']['section'] = $bulletin['section'];
						$_SESSION['classe']['effectif'] = $bulletin['effectif'];
						$_SESSION['classe']['moisCourant'] = $bulletin['moisCourant'];
						$_SESSION['classe']['listeMatiere'] = $bulletin['listeMatiere'];
						$_SESSION['classe']['listeSousMatiere'] = $bulletin['listeSousMatiere'];
						$_SESSION['classe']['noteEleve'] = $bulletin['noteEleve'];
						
						// echo '<pre>'; print_r($_SESSION['classe']['noteEleve']); echo '</pre>';
						
					}else{
						
						
						
					}*/
				}
			}
		}
		
		
		
		if(isset($_REQUEST['TraiterNoteSequentielle'])){
			$source = $_SERVER['HTTP_REFERER'];
			$info = $_POST;
			$config->traiterNoteSequence($source, $info);
		}
		
		
		if(isset($_REQUEST['TraiterMoyenneSequentielle'])){
			echo '<pre>';
			print_r($_REQUEST);
			$config->traiterMoyenneSequence($source,
										$_POST['sekence'],
										$_POST['classe']);
		}









		if(isset($_REQUEST['TraiterNoteTrimestrielle'])){
		/*echo '<pre>';
		print_r($_REQUEST);	*/
		$trimestre = $_POST['trimestre'];
		$classe = $_POST['classe'];
		if($classe=='null' or $trimestre=='null'){
			$_SESSION['message'] = 'La Classe et/ou le Trimestre doivent être renseignés.';
			header('Location:'.$source);
		}else{
			$config->traiterNoteTrimestre($source, $trimestre, $classe);
		}
	}









	if(isset($_REQUEST['TraiterMoyenneTrimestrielle'])){
		$trimestre = $_POST['trimestre'];
		$classe = $_POST['classe'];
		echo '<pre>';
		// print_r($_REQUEST);
		$config->traiterMoyenneTrimestre($source, $trimestre, $classe);
		echo '</pre>';
	}
	
	
		
		
		
		
		
		
			
	if(isset($_POST['finance'])){
		$nature = $_POST['nature'];
		$post = $_POST;
		echo '<pre>';
		print_r($_POST);
		echo '</pre>';
		/**
		 * On crée une rubrique 
		 */
		if($nature=='addRubrique'){
			$finance->ajouterRubrique($source, $post);
		}

		elseif($nature=='editRubrique'){
			$idRubrique = (int) $_POST['idRubrique'];
			$nomRubrique = str_replace(' ','_',$_POST['nomRubrique']);
			$codeRubrique = str_replace(' ','_',$_POST['codeRubrique']);
			$rubrique['id'] = $idRubrique;
			$rubrique['nom'] = $nomRubrique;
			$rubrique['code'] = $codeRubrique;
			if($idRubrique==0 or $idRubrique<1){
				$_SESSION['message'] = 'Une erreur est survenue lors du traitement.';
				header('Location:'.$source);
			}else{
				$finance->editRubrique($source, $rubrique);
			}
		}

		elseif($nature=='deleteRubrique'){
			$reponse = $_POST['finance'];
			if($reponse=='Oui'){
				$idRubrique = (int) $_POST['idRubrique'];
				if($idRubrique==0 or $idRubrique<1){
					$_SESSION['message'] = 'Une erreur est survenue lors du traitement.';
					header('Location:'.$source);
				}else{
					$finance->deleteRubrique($source, $idRubrique);
				}
			}elseif($reponse=='Non'){
				$_SESSION['message'] = 'La Rubrique ne sera pas supprimée.';
				header('Location:'.$source);
			}
		}



		elseif($nature=='updateRubrique'){
			$reponse = $_POST['finance'];
			if($reponse=='Oui'){
				$idRubrique = (int) $_POST['idRubrique'];
				if($idRubrique==0 or $idRubrique<1){
					$_SESSION['message'] = 'Une erreur est survenue lors du traitement.';
					header('Location:'.$source);
				}else{
					$finance->updateRubrique($source, $idRubrique);
				}
			}elseif($reponse=='Non'){
				$_SESSION['message'] = 'La Rubrique ne sera pas restaurée.';
				header('Location:'.$source);
			}else{}
		}


		elseif($nature=='addRubClass'){
			$rubrique = (int) $_POST['rubrique'];
			$montant = (int) $_POST['montant'];
			$classe = (int) $_POST['classe'];
			if($rubrique==0){
				$_SESSION['message'] = 'Vous devez choisir une rubrique pour la classe.';
				header('Location:'.$source);
			}else{
				if($montant<=0){
					$_SESSION['message'] = 'Le montant de la rubrique doit être supérieure à 0 Frs';
					header('Location:'.$source);
				}else{
					$finance->ajouterRubriqueClasse($source, $classe, $rubrique, $montant);
				}
			}
		}


		elseif($nature=='rmRubClass'){
			$rubrique = $_POST['rubrique'];
			for($i=0;$i<count($rubrique);$i++){
				$finance->supprimerRubriqueClasse($source, $rubrique[$i]);
			}
			$_SESSION['message'] = 'Rubrique(s) supprimée(s).';
			header('Location:'.$source);
		}

	}







	if(isset($_POST['addAbsence'])){
		// echo '<pre>'; print_r($_POST); echo '</pre>';
		$info = $_POST;
		$config->addAbsence($source, $info);
	}
		
		
		
		
		