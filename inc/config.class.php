<?php 
	class Config{
		private $_db;
		
		public function __construct($db){
			$this->setDb($db);
		}
		
		public function setDb(PDO $db){
			$this->_db = $db;
		}
		
		const TOTAL_POINT_CLASSE = 320;

		/*******************************************************
		 * ******************************************************
		 *  							LES SETTERS 
		 * ******************************************************
		 *******************************************************/
		
		// On veut initialiser les données de l'application avec ses tables  
		public function setDatabaseStructure($requete){
			$execution = $this->_db->query($requete);
			return $execution;
		}


		// On veut introduire les données issues des tables 
		public function setDatabaseData($requete){
			$execution = $this->_db->query($requete);
		}
		
		
		// On ne blague pas avec les clés primaires et etrangères qui sont des Id,
		// donc des entiers naturels 
		protected function setUserId($id){
			$this->_id = (int) $id;
			if($this->_id==0){
				$this->_id = NULL;
			}
			return $this->_id;
		}




		private function setMatricule($id){
			$this->_id = (string) $id;
			if(empty($this->_id) or $this->_id==0){
				$this->_id = '';
			}
			return $this->_id;
		}
		
		// Les mots de passe utilisent le système de hachage sha1 
		private function setPassword($pwd){
			$this->_pwd = sha1($pwd);
			return $this->_pwd;
		}
		
		
		// On configure l'enregistrement du nom 
		public function setNom($nom){
			// On convertit d'abord les A 
			$this->nom = $this->replaceA($nom);
			// On convertit ensuite les E 
			$this->nom =$this->replaceE($this->nom);
			// On covertit les I 
			$this->nom =$this->replaceI($this->nom);
			$this->nom =$this->replaceC($this->nom);
			$this->nom = addslashes($this->nom);
			return $this->nom;
		}




		// On configure l'enregistrement de la compétence 
		public function setCompetence($nom){
			// On convertit d'abord les A 
			$this->nom = $this->replaceA($nom);
			// On convertit ensuite les E 
			$this->nom =$this->replaceE($this->nom);
			// On convertit les I 
			$this->nom =$this->replaceI($this->nom);
			$this->nom =$this->replaceC($this->nom);
			$this->nom = addslashes($this->nom);
			return $this->nom;
		}

		// On choisit un sexe pour l'utilisateur 
		public function setSexe($sexe){
			if($sexe=='M'){
				$this->sexe = $sexe;
			}elseif($sexe=='F'){
				$this->sexe = $sexe;
			}else{
				$this->sexe = 'M';
			}
			return $this->sexe;
		}
		
		// On configure l'enregistrement du login 
		private function setLogin($login){
			$this->login = str_replace(' ','',strtolower($login));
			$this->login = $this->replaceA($this->login);
			$this->login =$this->replaceE($this->login);
			$this->login =$this->replaceI($this->login);
			$this->login =$this->replaceApos($this->login);
			return $this->login;
		}
		
		private function setNote($note){
			$this->_note = str_replace(',', '.', $note);
			if($this->_note <= 0){
				$this->_note = NULL;
			}elseif($this->_note > 20){
				$this->_note = NULL;
			}elseif($this->_note==''){
				$this->_note = NULL;
			}elseif($this->_note>0 and $this->_note<=20){
				$this->_note = (float) $this->_note;
			}
			return $this->_note;
		}





		protected function replaceA($text){
			$txt = str_replace('à','a',$text);
			return $txt;
		}
		
		
		protected function replaceE($text){
			$txt = str_replace('é','e',$text);
			$txt = str_replace('è','e',$txt);
			$txt = str_replace('ê','e',$txt);
			return $txt;
		}
		
		
		protected function replaceI($text){
			$txt = str_replace('î','i',$text);
			$txt = str_replace('ï','i',$txt);
			return $txt;
		}
		
		
		protected function replaceApos($text){
			$txt = str_replace("'","",$text);
			return $txt;
		}



		protected function replaceC($text){
			$txt = str_replace("ç","c",$text);
			return $txt;
		}



		


		/*************************************************************
		 * *******************************************************
		 * 			LES GETTERS 
		 * *******************************************************
		 *******************************************************/
		public function getRegion(){
			$sql = "SELECT *
					FROM region";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}


		public function getDepartement($region){
			$sql = "SELECT *
					FROM departement
					WHERE id_region='$region'";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}


		// Je veux afficher les différents types utilisateurs 
		public function userType(){
			$sql = "SELECT id, code_poste, libelle_poste
					FROM poste
					ORDER BY id";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}


		// Je veux pouvoir afficher la liste des enseignants selon leurs postes respectifs
		public function getUtilisateurType($type){
			$sql = "SELECT nom, sexe, login, enseignant.id as idEnseignant, 
							libelle_poste
					FROM enseignant, poste
					WHERE poste.id='$type' 
						AND enseignant.poste = poste.id
						AND etat = 'actif'
						ORDER BY nom";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}




		/*Ma fonction doit pouvoir afficher : 
		--> Le nombre de Sections définies
		-->La liste de ces sections 
		--Leur Full Name pour s'en sortir. */
		public function getNbSection(){
			$sql = "SELECT COUNT(code_section) as nbSection FROM section";
			$req = $this->_db->query($sql);
			$res = $req->fetch(PDO::FETCH_ASSOC);
			$nbSection = $res['nbSection'];
			return $nbSection;
		}

		public function getSection(){
			$sql = "SELECT * FROM section";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}

		// On transforme la section de la classe en titre : Francophone ou Anglophone
		public function transformSection($section){
			if($section=='fr'){
				$this->section = 'Francophone';
			}elseif($section=='en'){
				$this->section = 'Anglophone';
			}else{
				$this->section = 'Francophone';
			}
			return $this->section;
		}


		// On affiche tout sur une classe donnée 
		public function getClasse($classe){
			$sql = "SELECT classe.id as id, section, nom_classe, code_classe, niveau_classe, 
							etat_classe, nom_niveau
					FROM classe, niveau_classe
					WHERE classe.id = '$classe' 
						AND niveau_classe = niveau_classe.id";
			$req = $this->_db->query($sql);
			$res = $req->fetch(PDO::FETCH_ASSOC);
			return $res;
		}



		// On affiche tout sur un élève donné 
		public function getEleve($eleve){
			$this->_eleve = $this->setUserId($eleve);
			$sql = "SELECT nom_complet, eleve.sexe as sexe, 
						eleve.statut, date_naissance,
						DATE_FORMAT(date_naissance, '%d / %m / %Y') as date_fr,
						lieu_naissance, classe, nom_classe,
						nom_pere, nom_mere, photo, rne,
						adresse_parent, matricule, eleve.etat as etat, 
						a_s, libelle_annee, eleve.id as id, 
						DATE_FORMAT(add_date, '%d/%m/%Y at %H:%i:%s') as add_date,
						enseignant.nom as add_by
					FROM eleve, classe, annee_scolaire, enseignant 
					WHERE eleve.id = '$this->_eleve'
						AND classe = classe.id
						AND enseignant.id = add_by
						AND a_s = annee_scolaire.id";
			$req = $this->_db->query($sql);
			$res = $req->fetch(PDO::FETCH_ASSOC);
			return $res;
		}





		// On affiche tout sur un utilisateur donné 
		public function getUser($utilisateur){
			$sql = "SELECT enseignant.id as id, nom, sexe, poste, login, mdp, etat, image,
							libelle_poste
					FROM enseignant, poste 
					WHERE enseignant.id = '$utilisateur' 
						AND poste.id = poste";
			$req = $this->_db->query($sql);
			$res = $req->fetch(PDO::FETCH_ASSOC);
			if($res['sexe']=='F'){$valeurSexe='Feminin';}
			elseif($res['sexe']=='M'){$valeurSexe='Masculin';}
			$res['valeurSexe'] = $valeurSexe;
			return $res;
		}

		


		// On vérifie si la classe appartient à la section Francophone ou Anglophone
		public function getSectionClasse($classe){
			$this->_classe = $this->setUserId($classe);
			$sql = "SELECT section 
					FROM classe 
					WHERE id='$this->_classe'";
			$req = $this->_db->query($sql);
			$res = $req->fetch(PDO::FETCH_ASSOC);
			$resultat = $res['section'];
			return $resultat;
		}

		
		// Les Classes appartenant à un même niveau 
		public function getClasseByNiveau($niveau){
			$sql = "SELECT id, section, nom_classe 
					FROM classe
					WHERE niveau_classe='$niveau'
						AND etat_classe='actif'";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}


		/*
		
		public function getMoisAll(){
			$sql = "SELECT * FROM periode ORDER BY libelle_periode";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}
		
		
		public function getAppreciation($note, $total){
			if(empty($note)){
				$this->_appreciation = NULL;
			}elseif($note==0){
				$this->_appreciation = 'D';
			}else{
				$noteAppr = $note * 20 / $total;
				$sql = "SELECT * FROM appreciation 
						WHERE $noteAppr BETWEEN interv_ouvert 
							AND interv_fermet";
				$req = $this->_db->query($sql);
				$res = $req->fetch(PDO::FETCH_ASSOC);
				$this->_appreciation = $res['cote'];
			}
			return $this->_appreciation;
		}
		
		
		
		// A partir de la côte, on ressort l'appreciation d'une note
		public function getLibelleAppreciation($cote, $section){
			$nomChamp = 'libelle_appreciation_'.$section;
			$sql = "SELECT $nomChamp as appr
					FROM appreciation 
					WHERE cote = '$cote'";
			$req = $this->_db->query($sql);
			$res = $req->fetch(PDO::FETCH_ASSOC);
			$this->_appreciation = $res['appr'];
			return $this->_appreciation;
		}
		
		*/
		
		
		public function getSequenceCourante($id){
			$sql = "SELECT * FROM periode WHERE id = '$id'";
			$req = $this->_db->query($sql);
			$res = $req->fetch(PDO::FETCH_ASSOC);
			return $res;
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		// La fonction qui gère le formulaire de connexion 
		public function connectUser($source, $login, $mdp){
			$this->_login = $this->setUserId($login);
			$this->_mdp = $this->setPassword($mdp);
			$sql = "SELECT enseignant.id as id, nom, sexe, poste,
							login, mdp, image, etat, code_poste, libelle_poste, poste
					FROM enseignant, poste
					WHERE enseignant.id = '$this->_login'
						AND mdp='$this->_mdp'
						AND poste.id = poste";
			$req = $this->_db->query($sql);
			$reponse = $req->fetch(PDO::FETCH_ASSOC);
			if($reponse==false){
				$_SESSION['message'] = 'Le mot de passe entré est incorrect.';
				header('Location:'.$source);
			}else{
				if($reponse['etat']=='inactif'){
					$_SESSION['message'] = 'Votre compte a été désactivé.';
					$_SESSION['message'] .= ' Contactez un administrateur.';
					header('Location:'.$source);
				}else{
					// On commence par inscrire la connexion dans un journal.
					$adresse = $_SERVER['REMOTE_ADDR'];
					$periode = DATE('Y-m-d H:i:s');
					$navigateur = $this->getNavigateur();
					$journal = $this->_db->prepare('INSERT INTO journal_connexion
												SET 
												utilisateur=:login,
												adresse_ip = :adresse,
												periode_de_connexion=:periode, 
												navigateur = :machine, 
												os = :type');
					$journal->bindValue(':login', $this->_login);
					$journal->bindValue(':adresse', $adresse);
					$journal->bindValue(':periode', $periode);
					$journal->bindValue(':machine', $navigateur['navigateur']);
					$journal->bindValue(':type', $navigateur['os']);
					$journal->execute();
					// On charge les informations de l'établissement 
					$information = $this->chargerInformation();
					$_SESSION['information']['annee_scolaire'] = $information['annee_scolaire'];
					$_SESSION['information']['pays_fr'] = $information['nom_pays_fr'];
					$_SESSION['information']['pays_en'] = $information['nom_pays_en'];
					$_SESSION['information']['devise_fr'] = $information['nom_devise_fr']; 
					$_SESSION['information']['devise_en'] = $information['nom_devise_en'];
					$_SESSION['information']['ministere_fr'] = $information['nom_ministere_fr'];
					$_SESSION['information']['ministere_en'] = $information['nom_ministere_en'];
					$_SESSION['information']['region_fr'] = $information['libelle_region_fr'];
					$_SESSION['information']['region_en'] = $information['libelle_region_en'];
					$_SESSION['information']['departement_fr'] = $information['libelle_departement_fr'];
					$_SESSION['information']['departement_en'] = $information['libelle_departement_en'];
					$_SESSION['information']['nom_etablissement_fr'] = $information['nom_etablissement_fr'];
					$_SESSION['information']['nom_etablissement_en'] = $information['nom_etablissement_en'];
					$_SESSION['information']['typeEts'] = $information['type_ets'];
					$_SESSION['information']['chefEts'] = $information['chef_ets'];
					$_SESSION['information']['signataire_fr'] = $information['signataire_fr'];
					$_SESSION['information']['signataire_en'] = $information['signataire_en'];
					$_SESSION['information']['arrondissement'] = $information['arrondissement'];
					$_SESSION['information']['ville'] = $information['ville'];
					$_SESSION['information']['sexeSignataire'] = $information['sexe_signataire'];
					$_SESSION['information']['titreSignataire'] = $this->getTitre($information['sexe_signataire']);
					$_SESSION['information']['contact'] = $information['contact'];
					$_SESSION['information']['email'] = $information['email'];
					$_SESSION['information']['bp'] = $information['bp'];
					// On crée des variables de session de l'utilisateur
					$_SESSION['user']['id'] = $reponse['id'];
					$_SESSION['user']['nom'] = stripslashes($reponse['nom']);
					$_SESSION['user']['sexe'] = $reponse['sexe'];
					$_SESSION['user']['titre'] = $this->getTitre($reponse['sexe']);
					$_SESSION['user']['typeUtilisateur'] = $reponse['poste'];
					$_SESSION['user']['login'] = $reponse['login'];
					$_SESSION['user']['password'] = $reponse['mdp'];
					$_SESSION['user']['image'] = $reponse['image'];
					$_SESSION['user']['codePoste'] = $reponse['code_poste'];
					$_SESSION['user']['userPost'] = $reponse['code_poste'];
					$_SESSION['user']['libellePoste'] = $reponse['libelle_poste'];
					// La redirection 
					$_SESSION['connected'] = true;;
					$_SESSION['message'] = 'Welcome '.$_SESSION['user']['nom'];
					header('Location:'.$source);
				}
			}
		}
		
		
		function str_contains($haystack, $needle){
			return $needle !=='' && mb_strpos($haystack,$needle)!== false;
		}
		
		// On veut connaitre le navigateur et le Système d'exploitation utilisé
		public function getNavigateur(){
			if($this->str_contains($_SERVER['HTTP_USER_AGENT'], 'Chrome')){
				$navigateur = 'Chrome';
			}elseif($this->str_contains($_SERVER['HTTP_USER_AGENT'], 'Firefox')){
				$navigateur = 'Firefox';
			}
			if($this->str_contains($_SERVER['HTTP_USER_AGENT'], 'Windows')){
				$os = 'Windows';
			}elseif($this->str_contains($_SERVER['HTTP_USER_AGENT'], 'Android')){
				$os = 'Android';
			}
			$information = array("navigateur"=>$navigateur,
								"os"=>$os);
			return $information;
		}
		
		
		
		// Obtenir l'id de l'année scolaire en cours 
		public function getCurrentYear(){
			$sql = "SELECT id
					FROM annee_scolaire 
					WHERE statut='actif'";
			$req = $this->_db->query($sql);
			$res = $req->fetch(PDO::FETCH_ASSOC);
			return $res['id'];
		}
		
		
		
		
		
		// On charge les informations sur l'établissement au complet. 
		public function chargerInformation(){
			$sql = "SELECT annee_scolaire, nom_pays_fr, nom_pays_en, nom_devise_fr, nom_devise_en,
							nom_ministere_fr, nom_ministere_en,libelle_region_fr, libelle_region_en,
							libelle_departement_fr,libelle_departement_en,nom_etablissement_fr,
							nom_etablissement_en,type_ets, chef_ets, signataire_fr, signataire_en,
							arrondissement, ville, sexe_signataire, contact, email, bp
					FROM information, region, departement  
					WHERE region.id = region
						AND departement.id = departement";
			$req = $this->_db->query($sql);
			$res = $req->fetch(PDO::FETCH_ASSOC);
			return $res;
		}
		
		
		// On verifie si un matricule existe déjà.
		private function checkMatricule($matricule){
			$sql = "SELECT matricule 
					FROM eleve 
					WHERE matricule='$matricule'";
			$req = $this->_db->query($sql);
			$res = $req->fetch(PDO::FETCH_ASSOC);
			return $res['matricule'];
		}
		
		
		
		/**
		 * on vérifie dans un table qu'une information n'existe pas déjà pour éviter les doublons
		 * @$nom : la valeur du champs
		 * @$table : La table dans laquelle chercher
		 * @$champ : le libelle du champs
		 **/
		protected function checkInfo($nom, $table, $champ){
			$sql = "SELECT $champ 
					FROM $table 
					WHERE $champ = '$nom'";
			$req = $this->_db->query($sql);
			$res = $req->fetch(PDO::FETCH_ASSOC);
			return $res;
		}


 
		/**
		 * On vérifie la présence d'une matière pour une classe dans la table Prof_Classe
		 * @param int $classe La valeur de la Classe en Idclasse
		 * @param int $matiere La valeur de l'idMatiere
		 * @return array le resultat de la requête
		 */
		private function checkSubjectClass($classe, $matiere){
			$sql = "SELECT * 
					FROM prof_classe
					WHERE id_classe = '$classe'
						AND id_matiere = '$matiere'";
			$req = $this->_db->query($sql);
			$res = $req->fetch(PDO::FETCH_ASSOC);
			return $res;
		}





		// On veut verifier l'integrité d'une information avant de modifier
		private function checkIdSubjectClass($id){
			$sql = "SELECT coef, groupe
					FROM prof_classe
					WHERE id='$id'";
			$req = $this->_db->query($sql);
			$res = $req->fetch(PDO::FETCH_ASSOC);
			return $res;
		}
		
		
		
		
		
		
		// On transforme le sexe de l'usager en titre : Monsieur ou Madame
		public function getTitre($sexe){
			if($sexe=='M'){
				$this->titre = 'Monsieur ';
			}elseif($sexe=='F'){
				$this->titre = 'Madame ';
			}else{
				$this->titre = '';
			}
			return $this->titre;
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		/*
		
		*/
		
		
		
		
		
		
		
		
		// On définit les sections 
		public function setSection($section){
			if($section=='fr'){
				$this->section = $section;
			}elseif($section=='en'){
				$this->section = $section;
			}else{
				$this->section = 'fr';
			}
			return $this->section;
		}
		
		
		
		
		
		
		
		
		// On choisit un statut pour l'élève 
		public function setStatut($statut){
			if($statut=='N'){
				$this->statut = $statut;
			}elseif($statut=='R'){
				$this->statut = $statut;
			}else{
				$this->statut = 'N';
			}
			return $this->statut;
		}
		
		
		
		
		
		
		
		
		
		// On veut connaitre la page sur laquelle on se trouve
		public function pageEnCours(){
			$page = $_SERVER['PHP_SELF'];
			$explosion = explode('/',$page);
			$nbVal = count($explosion);
			$indice = $nbVal - 1;
			$nomPage = $explosion[$indice];
			return $nomPage;
		}
		
		
		
		
		
		
		
		
		// Deconnecter l'utilisateur courant.
		public function deconnect(){
			unset($_SESSION['information']);
			unset($_SESSION['user']);
			unset($_SESSION['connected']);
			$_SESSION['message'] = 'Vous avez été déconnecté. A bientôt';
		}
		
		
		
		
		
		
		
		
		
		// L'utilisateur courant modifie son mot de passe  
		public function changePassword($source, $pass){
			echo '<pre>'; print_r($pass); echo '</pre>';
			echo '5560b02172d75d6bb3240b69c5f9c7140598b17c <br />';
			$this->_user = $this->setUserId($pass['id']);
			$this->_ancien = $this->setPassword($pass['ancien']);
			$this->_nouveau = $this->setPassword($pass['nouveau']);
			$this->_confirm = $this->setPassword($pass['confirm']);
			$this->_verification = $this->getPassword($this->_user);
			echo $this->_verification;
			// On vérifie d'abord que le mot de passe ancien est bien celui qui y était avant.
			if($this->_verification==$this->_ancien){
				// On s'assure que les mots de passe nouveau et confirm sont identiques.
				if($this->_ancien==$this->_nouveau){
					$_SESSION['message'] = 'L ancien mot de passe correspond au nouveau.';
					header('Location:'.$source);
				}else{
					if($this->_nouveau==$this->_confirm){
						$sql = $this->_db->prepare("UPDATE enseignant 
												SET mdp =:mdp
												WHERE id=:id");
						$sql->bindValue(':mdp',$this->_nouveau);
						$sql->bindValue(':id',$this->_user);
						$sql->execute();
						$_SESSION['message'] = 'Mot de Passe modifié. Deconnectez-vous pour continuer.';
						header('Location:'.$source);
					}else{
						$_SESSION['message'] = 'La confirmation ne correspond pas.';
						header('Location:'.$source);
					}
				}
			}else{
				$_SESSION['message'] = 'L ancien mot de passe entré n est pas correct.';
				header('Location:'.$source);
			}

			/*$this->_id = $this->setUserId($id);
			$this->_ancien = $this->setPassword($ancien);
			$this->_nouveau = $this->setPassword($nouveau);
			$this->_confirm = $this->setPassword($confirm);
			// On vérifie d'abord que le mot de passe ancien est bien celui qui y était avant.
			$verif = $this->getPassword($this->_id);
			if($this->_ancien!=$verif){
				$_SESSION['message'] = 'L ancien mot de passe entré n est pas correct.'; 
				header('Location:'.$source);
			}else{
				// On s'assure que les mots de passe nouveau et confirm sont identiques. 
				if($this->_ancien==$this->_nouveau){
					$_SESSION['message'] = 'L ancien mot de passe correspond au nouveau.';
					header('Location:'.$source);
				}else{
					if($this->_nouveau!=$this->_confirm){
						$_SESSION['message'] = 'Vous n avez pas pu confirmer votre Nouveau mot de passe.';
						header('Location:'.$source);
					}else{
						$sql = "UPDATE enseignant 
								SET mdp='$this->_nouveau'
								WHERE id='$this->_id'";
						$exec = $this->_db->query($sql);
						$_SESSION['message'] = 'Mot de Passe modifié. Deconnectez-vous pour continuer.';
						header('Location:'.$source);
					}
				}
			}*/
		}
		
		
		
		
		
		
		
		
		
		
		// On réinitialise le mot de passe de l'utilisateur donné 
		public function resetPassword($source, $user){
			echo '<pre>'; print_r($user); echo '</pre>';
			$this->_user = $this->setUserId($user['user']);
			$this->_password = $this->setPassword($user['userPwd']);
			$this->_passwordConfirm = $this->setPassword($user['userPwdCfm']);

			// Premier Cas : L'utilisateur n'est pas défini.
			if(empty($this->_user)){
				$_SESSION['message'] = 'Vous devez definir un utilisateur pour modifier son mot de passe.';
				header('Location:'.$source);
			}else{
				// Deuxième Cas : Les mots de passe doivent correspondre 
				if($this->_password != $this->_passwordConfirm){
					$_SESSION['message'] = 'Les mots de passe ne corespondent pas';
					header('Location:'.$source);
				}else{
					$req = $this->_db->prepare("UPDATE enseignant SET mdp =:pwd 
												WHERE id =:id");
					$req->execute(array('pwd'=>$this->_password, 
										'id'=>$this->_user));
					$_SESSION['message'] = 'Mise à jour effectuée.';
					header('Location:'.$source);
				}
			}
		}
		
		
		
		
		
		
		
		
		// Obtenir le mot de passe de l'utilisateur courant 
		protected function getPassword($user){
			$sql = "SELECT mdp 
					FROM enseignant 
					WHERE id = '$user'";
			$req = $this->_db->query($sql);
			$res = $req->fetch(PDO::FETCH_ASSOC);
			return $res['mdp'];
		}
		
		
		
		
		
		
		
		
		// Fonction utile pour aider à la génération du Matricule Elève
		public function getCode(){
			$sql = "SELECT num_rand
					FROM eleve
					ORDER BY num_rand DESC";
			$req = $this->_db->query($sql);
			$reponse = $req->fetch(PDO::FETCH_ASSOC);
			$resultat = $reponse['num_rand'];
			return $resultat;
		}
		
		
		
		
		
		
		
		
		// On liste les classes selon leurs sections
		public function viewClasseSection($etat, $section){
			$sql = "SELECT classe.id as id, section, nom_classe, code_classe, niveau_classe, 
							etat_classe
						FROM classe 
						WHERE etat_classe='".$etat."'
							AND section='".$section."'
						ORDER BY niveau_classe";
			$req = $this->_db->query($sql);
			$res=$req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		 }



		// On liste les classes au complet et on trie par section
		public function viewClasseAll($etat){
			$sql = "SELECT classe.id as id, section, nom_classe, code_classe, niveau_classe, 
							etat_classe, nom_niveau
						FROM classe , niveau_classe
						WHERE etat_classe='".$etat."'
							AND niveau_classe = niveau_classe.id
						ORDER BY section, niveau_classe, nom_classe";
			$req = $this->_db->query($sql);
			$res=$req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		 }





		 // On liste les utilisateurs au complet et on trie par nom
		public function viewUserAll($etat){
			$sql = "SELECT enseignant.id as id, nom, sexe, poste, login, etat,
							libelle_poste
						FROM enseignant, poste
						WHERE enseignant.etat = '$etat'
							AND poste.id = enseignant.poste
						ORDER BY enseignant.nom";
			$req = $this->_db->query($sql);
			$res=$req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		 }




		//  On liste les classes qui ont déjà les élèves 
		public function viewClasseStudent(){
			$sql = "SELECT  classe, nom_classe, section
					FROM eleve, classe
					WHERE classe = classe.id
					GROUP BY classe 
						";
			$req = $this->_db->query($sql);
			$res=$req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}
		 
		 
		  /*Les niveaux de l'application */
		public function listeNiveaux(){
			$sql = "SELECT *
					FROM niveau_classe
					ORDER BY id;
					";
			$req = $this->_db->query($sql);
			$res=$req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}




		// Les differentes séquences de l'application 
		public function listePeriodeAll(){
			$sql = "SELECT *
					FROM periode
					ORDER BY nom_periode;
					";
			$req = $this->_db->query($sql);
			$res=$req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}





		// Activer une séquence 
		public function openSequence($source, $valeur){
			$this->_sequence = $this->setUserId($valeur['sequence']);
			$this->_duree = $this->setUserId($valeur['nbjour']);
			$open = DATE('Y-m-d');
			$close = DATE('Y-m-d',time()+$this->_duree*3600*24);
			
			$action = $this->_db->prepare("UPDATE periode SET 
								date_ouvert =:open,
								date_fermet =:close 
								WHERE id =:sequence");
			$action->execute(array('open'=>$open,
									'close'=>$close,
									 'sequence'=>$this->_sequence));
			$_SESSION['message'] = 'Séquence '.$this->_sequence.' activée pour '.$this->_duree.' jour(s)';
			header('Location:'.$source);
		}






		// Verouiller une séquence 
		public function closeSequence($source, $valeur){
			$this->_sequence = $this->setUserId($valeur['sequence']);
			$close = DATE('Y-m-d',time()-1*3600*24);
			
			$action = $this->_db->prepare("UPDATE periode SET 
								date_fermet =:close 
								WHERE id =:sequence");
			$action->execute(array(
									'close'=>$close,
									 'sequence'=>$this->_sequence));
			$_SESSION['message'] = 'Séquence '.$this->_sequence.' verouillée.';
			header('Location:'.$source);
		}






		// Les séquences activées 
		public function periodeCourante(){
			$today = DATE('Y-m-d');
			$sql = "SELECT id, nom_periode, date_ouvert, DATE_FORMAT(date_ouvert, '%d / %m / %Y') as ouvert,
							date_fermet, DATE_FORMAT(date_fermet, '%d / %m / %Y') as fermet
					FROM periode
					WHERE date_ouvert <='$today'
						AND date_fermet >='$today'
					ORDER BY nom_periode";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}
		 
		 
		 
		 
		 
		 // On liste les enseignants intervenant dans les classes
		public function viewEnseignantClasse($etat, $section){
			$sql = "SELECT classe.id as id, section, libelle_classe, code_classe, niveau_classe, 
							etat_classe, enseignant, nom
						FROM classe, enseignant 
						WHERE etat_classe='".$etat."'
							AND section='".$section."'
							AND enseignant.id = enseignant
						ORDER BY niveau_classe";
			$req = $this->_db->query($sql);
			$res=$req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		 }








		 // On visualise les élèves d'une classe qui ont les absences dans la Table ABSENCE 
		public function viewEleveAbsence($classe){
			$sql = "SELECT DISTINCT id_eleve as id, nom_complet
					FROM absence, eleve
					WHERE id_eleve = eleve.id
						AND classe='$classe'
					ORDER BY nom_complet";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
			
			
		}








		// Visualiser les absences d'un élève en particulier
		public function viewAbsenceEleve($eleve){
			$sql = "SELECT id_eleve, date_absence, nombre_heure, justification,
							nom_complet, classe, nom_classe, absence.id as id,
							DATE_FORMAT(date_absence, '%d / %m / %Y') as date_abs
					FROM absence, eleve, classe
					WHERE id_eleve = '$eleve'
						AND eleve.id = id_eleve
						AND classe = classe.id";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}







		// Visualiser les absences selon qu'elles sont justifiées (ANJ) ou non(AJ)
		public function viewAbsenceJustif($etat){
			$sql = "SELECT absence.id as id, id_eleve, date_absence, nombre_heure, justification,
						nom_complet, classe, nom_classe, 
						DATE_FORMAT(date_absence, '%d / %m / %Y') as date_abs
					FROM absence, eleve, classe 
					WHERE eleve.id = id_eleve
						AND eleve.classe = classe.id
					ORDER BY nom_complet";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
			/*$sql = "SELECT id_eleve, date_absence, nombre_heure, justification,
							nom, prenom, classe, nom_classe, absence.id as id,
							DATE_FORMAT(date_absence, '%d / %m / %Y') as date_abs
					FROM absence, eleve, classe
					WHERE eleve.id = id_eleve
						AND classe = code_classe
						AND justification='$etat'";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			return $res;*/
		}
		
		
		
		
		
		
		
		
		// On ajoute un élève à la Base de Données
		public function ajouterEleve($source,$eleve){
			echo '<pre>'; print_r($eleve); echo '</pre>';
			$this->_rne = $this->setMatricule($eleve['rne']);
			$this->_nom = strtoupper($this->setNom($eleve['nom']));
			$this->_nom .= ' ';
			$this->_nom .= ucwords($this->setNom($eleve['prenom']));
			$this->_sexe = $this->setSexe($eleve['sexe']);
			$this->_dateNaissance = $eleve['date_naissance'];
			$this->_lieuNaissance = strtoupper($this->setNom($eleve['lieu_naiss']));
			$this->_matricule = $eleve['matricule'];
			$this->_classe = $this->setUserId($eleve['clas']);
			$this->_contactParent = $eleve['adresse'];
			$this->_statut = $eleve['statut'];
			$this->_numero = $this->setUserId($eleve['numero']);
			$this->_etat = 'non_supprime';
			$this->_nomPere = strtoupper($this->setNom($eleve['nom_pere']));
			$this->_nomMere = strtoupper($this->setNom($eleve['nom_mere']));
			$this->_addingPerson = $_SESSION['user']['id'];
			$this->_addDate = DATE('Y-m-d H:i:s');
			$this->_as = $this->getCurrentYear();
			// On vérifie l'existence du matricule en base une première fois 
			$matricule = $this->checkInfo($this->_matricule, 'eleve', 'matricule');
			if($matricule==false){
				//  On vérifie l'existence du nom en base une première fois
				$nom = $this->checkInfo($this->_nom, 'eleve', 'nom_complet');
				if($nom==false){
					// On procède à l'insertion du nom dans la BD 
					$add = $this->_db->prepare('INSERT INTO eleve SET 
													rne =:rne,
													nom_complet =:nom,
													sexe =:sexe,
													date_naissance =:dateN,
													lieu_naissance =:lieuN,
													matricule =:matricule,
													classe =:classe,
													adresse_parent =:adresse,
													statut =:statut,
													num_rand =:numero,
													etat =:etat,
													nom_pere =:pere,
													nom_mere =:mere,
													add_by =:utilisateur,
													add_date =:addingDate,
													a_s =:schoolY');
					$add->bindValue(':rne', $this->_rne);
					$add->bindValue(':nom', $this->_nom);
					$add->bindValue(':sexe', $this->_sexe);
					$add->bindValue(':dateN', $this->_dateNaissance);
					$add->bindValue(':lieuN', $this->_lieuNaissance);
					$add->bindValue(':matricule', $this->_matricule);
					$add->bindValue(':classe', $this->_classe);
					$add->bindValue(':adresse', $this->_contactParent);
					$add->bindValue(':statut', $this->_statut);
					$add->bindValue(':numero', $this->_numero);
					$add->bindValue(':etat', $this->_etat);
					$add->bindValue(':pere', $this->_nomPere);
					$add->bindValue(':mere', $this->_nomMere);
					$add->bindValue(':utilisateur', $this->_addingPerson);
					$add->bindValue('addingDate', $this->_addDate);
					$add->bindValue(':schoolY', $this->_as);
					$add->execute();
					$_SESSION['message'] = strtoupper($this->_nom).' a été ajouté(e) aux listes.';
					header('Location:'.$source);
				}else{
					$_SESSION['message'] = 'Cet élève est déjà positionné dans une classe.';
					header('Location:'.$source);
				}
			}else{
				// echo var_dump($this->_matricule);
				// echo '<p>'.$this->_matricule;
				$_SESSION['message'] = 'Un problème est survenu. Relancez la tâche svp.';
				header('Location:'.$source);
			}
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			/*
			// On vérifie l'existence du matricule en base une première fois 
			$matricule = $this->checkMatricule($this->_matricule);
			if($matricule==NULL){
				$nom = $this->checkNom($this->_nom, 'eleve', 'nom_complet');
				// On vérifie l'existence du nom en base une première fois 
				if($nom==NULL){
					// On procède à l'insertion 
					$add = $this->_db->prepare('INSERT INTO eleve SET
											nom_complet =:nom,
											sexe =:sexe,
											date_naissance=:dateN,
											lieu_naissance =:lieuN,
											classe=:classe,
											nom_pere =:pere,
											nom_mere =:mere,
											contact_parent=:contact,
											matricule =:matricule,
											etat =:etat,
											statut =:statut,
											annee_scolaire=:as,
											num_rand=:numero');
					$add->bindValue(':nom', $this->_nom);
					$add->bindValue(':sexe', $this->_sexe);
					$add->bindValue(':statut', $this->_statut);
					$add->bindValue(':dateN', $this->_dateNaissance);
					$add->bindValue(':lieuN', $this->_lieuNaissance);
					$add->bindValue(':classe', $this->_classe);
					$add->bindValue(':pere', $this->_nomPere);
					$add->bindValue(':mere', $this->_nomMere);
					$add->bindValue(':contact', $this->_contactParent);
					$add->bindValue(':matricule', $this->_matricule);
					$add->bindValue(':etat', $this->_etat);
					$add->bindValue(':as', $this->_as);
					$add->bindValue(':numero', $this->_numero);
					$add->execute();
					 
					
				}else{
					
					
				}
			}else{
				
				
			}*/
		}
		
		
		
		
		
		
		
		
		
		
		// On ajoute une classe à la Base de Données
		public function ajouterClasse($source,$classe){
			echo '<pre>'; print_r($classe); echo '</pre>';
			$niveauClasse = $this->setUserId($classe['niveau']);
			$libelleClasse = strtoupper($this->setNom($classe['nomClasse']));
			$codeClasse = $this->setLogin($classe['codeClasse']);
			$section = $this->setSection($classe['section']);
			$etatClasse = 'actif';
			
			// On vérifie que le nom de la classe n'existe pas déjà 
			$checkNom = $this->checkInfo($libelleClasse,'classe', 'nom_classe');
			if($checkNom==false){
				// On vérifie que le code de la classe n'existe pas déjà
				$checkCode = $this->checkInfo($codeClasse,'classe', 'code_classe');
				if($checkCode==false){
					// On procède à l'insertion
					$add = $this->_db->prepare('INSERT INTO classe SET
												section =:section,
												nom_classe =:nom,
												code_classe =:code,
												niveau_classe =:niveau,
												etat_classe=:etat');
					$add->bindValue(':section', $section);
					$add->bindValue(':nom', $libelleClasse);
					$add->bindValue(':code', $codeClasse);
					$add->bindValue(':niveau', $niveauClasse);
					$add->bindValue(':etat', $etatClasse);
					$add->execute();
					$_SESSION['message'] = 'La Classe '.strtoupper($libelleClasse).' a été ajoutée.';
					header('Location:'.$source);
				}else{
					$_SESSION['message'] = 'Ce code est déjà utilisé comme code de classe.';
					header('Location:'.$source);
				}
			}else{
				$_SESSION['message'] = 'Ce nom est déjà utilisé comme nom de classe.';
				header('Location:'.$source);
			}
		}





		// On ajoute une matière à la Base de Données
		public function ajouterMatiere($source,$matiere){
			echo '<pre>'; print_r($matiere); echo '</pre>';
			for($x=0;$x<count($matiere['nom_matiere']);$x++){
				$nomMatiere = strtoupper($this->setNom($matiere['nom_matiere'][$x]));
				$codeMatiere = $this->setLogin($matiere['code_matiere'][$x]);
				$etatMatiere = 'actif';
				$checkNom = $this->checkInfo($nomMatiere,'matiere', 'nom_matiere');
				if($checkNom==false){
					$checkCode = $this->checkInfo($codeMatiere,'matiere', 'code_matiere');
					if($checkCode==false){
						$add = $this->_db->prepare('INSERT INTO matiere SET
											nom_matiere =:nomMatiere,
											code_matiere =:codeMatiere,
											etat =:etatMatiere');
						$add->bindValue(':nomMatiere', $nomMatiere);
						$add->bindValue(':codeMatiere', $codeMatiere);
						$add->bindValue(':etatMatiere', $etatMatiere);
						$add->execute();
						$_SESSION['message'] = 'Les Matières  ont été ajoutées.';
					}
				}
			}
			header('Location:'.$source);
			/*$nomMatiere = 
			$codeMatiere = $this->setLogin($matiere['code_matiere']);
			$etatMatiere = 'actif';*/
			// On vérifie que le nom de la classe n'existe pas déjà
			/*$checkNom = $this->checkInfo($nomMatiere,'matiere', 'nom_matiere');*/
			/*if($checkNom==false){
				// On vérifie que le code de la classe n'existe pas déjà
				$checkCode = $this->checkInfo($codeMatiere,'matiere', 'code_matiere');
				if($checkCode==false){
					// On procède à l'insertion
					$add = $this->_db->prepare('INSERT INTO matiere SET
											nom_matiere =:nomMatiere,
											code_matiere =:codeMatiere,
											etat =:etatMatiere');
					$add->bindValue(':nomMatiere', $nomMatiere);
					$add->bindValue(':codeMatiere', $codeMatiere);
					$add->bindValue(':etatMatiere', $etatMatiere);
					$add->execute();
					$_SESSION['message'] = 'La Matière '.strtoupper($nomMatiere).' a été ajoutée.';
					header('Location:'.$source);
				}else{
					$_SESSION['message'] = 'Ce code est déjà utilisé comme code de matière.';
					header('Location:'.$source);
				}
			}*//*else{
				$_SESSION['message'] = 'Ce nom est déjà utilisé comme nom de matière.';
				header('Location:'.$source);
			}*/
		}
		
		
		
		
		
		
		
		
		
		// On met à jour l'élève 
		public function updateEleve($source, $eleve){
			// echo '<pre>'; print_r($eleve); echo '</pre>';
			$idEleve = $this->setUserId($eleve['idEleve']);
			$infoEleve = $this->getEleve($idEleve);
			// echo '<pre>';print_r($infoEleve);echo '</pre>';
			
			$nom = $this->setNom($eleve['nomEleve']);
			$classe = $this->setUserId($eleve['classeEleve']);
			$matricule = $eleve['matriculeEleve'];
			$rne = $eleve['rneEleve'];
			$sexe = $this->setSexe($eleve['sexeEleve']);
			$statut = $this->setStatut($eleve['statutEleve']);
			$dateNaiss = $eleve['dateNaissEleve'];
			$lieuNaiss = $this->setNom($eleve['lieuNaissEleve']);
			$nomPere = $this->setNom($eleve['nomPereEleve']);
			$nomMere = $this->setNom($eleve['nomMereEleve']);
			$contactParent = $eleve['contactParentEleve'];
			
			
			if(!empty($nom)){
				if($nom!=$infoEleve['nom_complet']){
					$champ[] = 'nom_complet';
					$valeur[] = $nom;
				}
			}
			if(!empty($sexe)){
				if($sexe!=$infoEleve['sexe']){
					$champ[] = 'sexe';
					$valeur[] = $sexe;
				}
			}
			if(!empty($statut)){
				if($statut!=$infoEleve['statut']){
					$champ[] = 'statut';
					$valeur[] = $statut;
				}
			}
			if(!empty($dateNaiss)){
				if($dateNaiss!=$infoEleve['date_naissance']){
					$champ[] = 'date_naissance';
					$valeur[] = $dateNaiss;
				}
			}
			if(!empty($lieuNaiss)){
				if($lieuNaiss!=$infoEleve['lieu_naissance']){
					$champ[] = 'lieu_naissance';
					$valeur[] = $lieuNaiss;
				}
			}
			if(!empty($classe)){
				if($classe!=$infoEleve['classe']){
					$champ[] = 'classe';
					$valeur[] = $classe;
				}
			}
			if(!empty($nomPere)){
				if($nomPere!=$infoEleve['nom_pere']){
					$champ[] = 'nom_pere';
					$valeur[] = $nomPere;
				}
			}
			if(!empty($nomMere)){
				if($nomMere!=$infoEleve['nom_mere']){
					$champ[] = 'nom_mere';
					$valeur[] = $nomMere;
				}
			}
			if(!empty($contactParent)){
				if($contactParent!=$infoEleve['adresse_parent']){
					$champ[] = 'adresse_parent';
					$valeur[] = $contactParent;
				}
			}
			if(!empty($matricule)){
				if($matricule!=$infoEleve['matricule']){
					$champ[] = 'matricule';
					$valeur[] = $matricule;
				}
			}

			if(!empty($rne)){
				if($rne!=$infoEleve['rne']){
					$champ[] = 'rne';
					$valeur[] = $rne;
				}
			}
			
			// Si au moins une modification est effectuée, alors $champ ne sera pas null 
			if(!empty($champ)){
				$iteration = count($champ);
				$sql = "UPDATE eleve SET ";
				for($i=0;$i<$iteration-1;$i++){
					$sql .= $champ[$i]." = '".$valeur[$i]."', ";
				}
				$valeurFinaleArray = $iteration - 1;
				$sql .= $champ[$valeurFinaleArray]." = '".$valeur[$valeurFinaleArray]."' ";
				$sql .= "WHERE id = '".$idEleve."'";
				$this->_db->query($sql);
				$_SESSION['message'] = 'Informations Elève Mises à jour.';
				header('Location:'.$source);
			}else{
				$_SESSION['message'] = 'Aucune information n a été modifiée.';
				header('Location:'.$source);
			}
		}
		
		
		
		
		
		
		
		
		
		
		
		// On met à jour l'utilisateur 
		public function updateUtilisateur($source, $utilisateur){
			echo '<pre>'; print_r($utilisateur); echo '</pre>';
			$userName = $this->setNom($utilisateur['userName']);
			$userSexe = $this->setSexe($utilisateur['userSex']);
			$userPoste = $this->setUserId($utilisateur['userPost']);
			$userLogin = $this->setLogin($utilisateur['userLogin']);
			$userId = $this->setUserId($utilisateur['userId']);
			
			$infoUtilisateur = $this->getUser($userId);
			
			echo '<pre>';print_r($infoUtilisateur);echo '</pre>';
			if(!empty($userName)){
				if($userName!=$infoUtilisateur['nom']){
					$champ[] = 'nom';
					$valeur[] = $userName;
				}
			}
			
			if(!empty($userLogin)){
				if($userLogin!=$infoUtilisateur['login']){
					$champ[] = 'login';
					$valeur[] = $userLogin;
				}
			}
			
			if(!empty($userSexe)){
				if($userSexe!=$infoUtilisateur['sexe']){
					$champ[] = 'sexe';
					$valeur[] = $userSexe;
				}
			}


			if(!empty($userPoste)){
				if($userPoste!=$infoUtilisateur['poste']){
					$champ[] = 'poste';
					$valeur[] = $userPoste;
				}
			}

			
			if(!empty($champ)){
				$iteration = count($champ);
				$sql = "UPDATE enseignant SET ";
				for($i=0;$i<$iteration-1;$i++){
					$sql .= $champ[$i]." = '".$valeur[$i]."', ";
				}
				$valeurFinaleArray = $iteration - 1;
				$sql .= $champ[$valeurFinaleArray]." = '".$valeur[$valeurFinaleArray]."' ";
				$sql .= "WHERE id = '".$userId."'";
				$this->_db->query($sql);
				$_SESSION['message'] = 'Informations Utilisateur Mises à jour.';
				header('Location:'.$source);
			}else{
				$_SESSION['message'] = 'Aucune information modifiée.';
				header('Location:'.$source);
			}
		}
		
		
		
		
		
		
		
		
		
		
		// On met à jour la classe 
		public function updateClasse($source, $classe){
			echo '<pre>'; print_r($classe); echo '</pre>';
			$classNom = $this->setNom($classe['nomClasse']);
			$classCode = $this->setLogin($classe['codeClasse']);
			$classNiveau = $this->setUserId($classe['niveau']);
			$classId = $this->setUserId($classe['classId']);
			$classSection = $this->setSection($classe['section']);

			$infoClasse = $this->getClasse($classId);
			echo '<pre>';print_r($infoClasse); echo '</pre>';
			
			
			// 
			if(!empty($classNom)){
				if($classNom!=$infoClasse['nom_classe']){
					$champ[] = 'nom_classe';
					$valeur[] = $classNom;
				}
			}
			if(!empty($classCode)){
				if($classCode!=$infoClasse['code_classe']){
					$champ[] = 'code_classe';
					$valeur[] = $classCode;
				}
			}
			if(!empty($classNiveau)){
				if($classNiveau!=$infoClasse['niveau_classe']){
					$champ[] = 'niveau_classe';
					$valeur[] = $classNiveau;
				}
			}
			if(!empty($classSection)){
				if($classSection!=$infoClasse['section']){
					$champ[] = 'section';
					$valeur[] = $classSection;
				}
			}
			$iteration = count($champ);
			$sql = "UPDATE classe SET ";
			for($i=0;$i<$iteration-1;$i++){
				$sql .= $champ[$i]." = '".$valeur[$i]."', ";
			}
			$valeurFinaleArray = $iteration - 1;
			$sql .= $champ[$valeurFinaleArray]." = '".$valeur[$valeurFinaleArray]."' ";
			$sql .= "WHERE id = '".$classId."'";
			$this->_db->query($sql);
			$_SESSION['message'] = 'Classe Mise à jour.';
			header('Location:'.$source);
		}






		// On met à jour la classe 
		public function updateMatiere($source, $matiere){
			echo '<pre>'; print_r($matiere); echo '</pre>';
			$action = $matiere['upd_matiere'];
			$this->_nomMatiere = $this->setNom($matiere['nom_matiere']);
			$this->_codeMatiere = $this->setLogin($matiere['code_matiere']);
			$this->_idMatiere = $this->setUserId($matiere['idMatiere']);
			if($action=='Supprimer'){
				$this->deleteMatiere($this->_idMatiere,'inactif');
				$_SESSION['message'] = 'Matière Supprimée';
			}
			elseif($action=='Mettre a jour'){
				$this->majMatiere($this->_idMatiere, $this->_nomMatiere, $this->_codeMatiere);
			}
			elseif($action=='ReActiver'){
				$this->deleteMatiere($this->_idMatiere,'actif');
				$_SESSION['message'] = 'Matière Retablie';
			}
			header('Location:'.$source);
		}







		public function updateSubjectClass($source, $info){
			echo '<pre>'; print_r($info); echo '</pre>';
			$this->_coef = $this->setNote($info['coef']);
			$this->_groupe = $this->setUserId($info['groupe']);
			$this->_idClasse = $this->setUserId($info['id']);
			$verification = $this->checkIdSubjectClass($this->_idClasse);

			if($verification['coef']!=$this->_coef){
				$champ[] = 'coef';
				$valeur[] = $this->_coef;
			}

			if($verification['groupe']!=$this->_groupe){
				$champ[] = 'groupe';
				$valeur[] = $this->_groupe;
			}

			if(!empty($champ)){
				$iteration = count($champ);
				$sql = "UPDATE prof_classe SET ";
				for($i=0;$i<$iteration-1;$i++){
					$sql .= $champ[$i]." = '".$valeur[$i]."', ";
				}
				$valeurFinaleArray = $iteration - 1;
				$sql .= $champ[$valeurFinaleArray]." = '".$valeur[$valeurFinaleArray]."' ";
				$sql .= "WHERE id = '".$this->_idClasse."'";
				$this->_db->query($sql);
				$_SESSION['message'] = 'Mises à jour effectuées.';
				header('Location:'.$source);
			}else{
				$_SESSION['message'] = 'Aucune modification effectuée.';
				header('Location:'.$source);
			}
		}








		public function removeSubjectClasse($source, $info){
			// echo '<pre>'; print_r($info); echo '</pre>';
			for($i=0;$i<count($info);$i++){
				$this->_matiere = $this->setUserId($info[$i]);
				$retrait = $this->_db->prepare("DELETE FROM prof_classe 
											WHERE id = :matiere");
				$retrait->bindValue(':matiere', $this->_matiere);
				$retrait->execute();
				$_SESSION['message'] = 'Matière retirée de la classe.';
				header('Location:'.$source);
			}
		}
		
		
		
		
		private function deleteMatiere($matiere, $action){
			$sql = "UPDATE matiere SET etat='$action' WHERE id='$matiere'";
			$this->_db->query($sql);
		}



		private function majMatiere($id, $nom, $code){
			$infoMatiere = $this->getMatiere($id);
			if(!empty($nom)){
				if($nom!=$infoMatiere['nom_matiere']){
					$champ[] = 'nom_matiere';
					$valeur[] = $nom;
				}
			}

			if(!empty($code)){
				if($code!=$infoMatiere['code_matiere']){
					$champ[] = 'code_matiere';
					$valeur[] = $code;
				}
			}

			$iteration = count($champ);
			$sql = "UPDATE matiere SET ";
			for($i=0;$i<$iteration-1;$i++){
				$sql .= $champ[$i]." = '".$valeur[$i]."', ";
			}
			$valeurFinaleArray = $iteration - 1;
			$sql .= $champ[$valeurFinaleArray]." = '".$valeur[$valeurFinaleArray]."' ";
			$sql .= "WHERE id = '".$id."'";
			$this->_db->query($sql);
			$_SESSION['message'] = 'Matière Mise à jour.';
		}
		
		
		
		
		
		// On supprime un élève 
		public function deleteEleve($source, $eleve){
			$sql = "UPDATE eleve SET etat= 'supprime' WHERE id='$eleve'";
			$this->_db->query($sql);
			$_SESSION['message'] = 'Eleve supprimé';
			header('Location:'.$source);
		}
		
		
		
		
		
		
		
		
		
		// On supprime un utilisateur 
		public function deleteUser($source, $user){
			$sql = "UPDATE enseignant SET etat= 'inactif' WHERE id='$user'";
			$this->_db->query($sql);
			$_SESSION['message'] = 'Utilisateur supprimé';
			header('Location:'.$source);
		}
		
		
		
		
		
		
		
		
		
		// On supprime une classe 
		public function deleteClasse($source, $classe){
			$sql = "UPDATE classe SET etat_classe = 'inactif' WHERE id='$classe'";
			$this->_db->query($sql);
			$_SESSION['message'] = 'Classe supprimée';
			header('Location:'.$source);
		}




		// On restaure une classe supprimée
		public function restaureClasse($source, $classe){
			$sql = "UPDATE classe SET etat_classe = 'actif' WHERE id='$classe'";
			$this->_db->query($sql);
			$_SESSION['message'] = 'Classe restaurée';
			header('Location:'.$source);
		}





		// On restaure un utilisateur supprimé
		public function restaureUser($source, $user){
			$sql = "UPDATE enseignant SET etat = 'actif' WHERE id='$user'";
			$this->_db->query($sql);
			$_SESSION['message'] = 'Utilisateur restauré.';
			header('Location:'.$source);
		}
		
		
		
		
		
		
		
		
		// On restaure un élève supprimé
		public function restaureEleve($source, $eleve){
			$sql = "UPDATE eleve SET etat= 'non_supprime' WHERE id='$eleve'";
			$this->_db->query($sql);
			$_SESSION['message'] = 'Eleve retabli';
			header('Location:'.$source);
		}
		
		
		
		
		
		
		// On ajoute un utilisateur(Enseignant, Cellule) à la Base de Données
		public function ajouterUtilisateur($source,$user){
			echo '<pre>'; print_r($user); echo '</pre>';
			$this->_nom = strtoupper($this->setNom($user['nom']));
			$this->_nom .= ' ';
			$this->_nom .= ucwords($this->setNom($user['prenom']));
			$this->_sexe = $this->setSexe($user['sexe']);
			$this->_type = $this->setUserId($user['userType']);
			$this->_login = $this->setLogin($user['login']);
			$this->_password = $this->setPassword($this->_login);
			$this->_etat = 'actif';
			// On vérifie que le nom complet et/ou le login n'existent pas déjà 
			$nom = $this->checkInfo($this->_nom,'enseignant','nom');
			if($nom==false){
				$login = $this->checkInfo($this->_login,'enseignant','login');
				if($login==false){
					$add = $this->_db->prepare('INSERT INTO enseignant SET
											nom=:nomUser,
											sexe=:sexeUser,
											poste =:typeUser,
											login=:loginUser,
											mdp=:passwordUser,
											etat=:etatUser');
					$add->bindValue(':nomUser', $this->_nom);
					$add->bindValue(':sexeUser', $this->_sexe);
					$add->bindValue(':typeUser', $this->_type);
					$add->bindValue(':loginUser', $this->_login);
					$add->bindValue(':passwordUser', $this->_password);
					$add->bindValue(':etatUser', $this->_etat);
					$add->execute();
					$_SESSION['message'] = $this->_nom.' a été ajouté(e).'; 
					$_SESSION['message'] .= ' Son login correspond au mot de passe en minuscule.'; 
					header('Location:'.$source);
				}else{
					$_SESSION['message'] = 'Le login existe déjà. Aucun ajout effectué';
					header('Location:'.$source);
				}
			}else{
				$_SESSION['message'] = 'L utilisateur existe déjà. Aucun ajout effectué';
				header('Location:'.$source);
			}
		}
		
		
		
		
		
		
		
		
		
		
		// On ajoute un utilisateur(Enseignant) à la Classe
		public function ajouterUtilisateurClasse($user){
			// echo '<pre>'; print_r($user); echo '</pre>';
			$this->_matiere = $this->setUserId($user['matiere']);
			$this->_prof = $this->setUserId($user['enseignant']);
			// echo $this->_matiere." a pour enseignant : ".$this->_prof."<br />";
			$req = $this->_db->prepare("UPDATE prof_classe
										SET id_prof =:prof
										WHERE id =:id");
			$req->execute(array('prof'=>$this->_prof,
								'id'=>$this->_matiere));
			$_SESSION['message'] = 'Enseignant(s) ajouté(s) à la classe';
		}








		/***
		 * Insérer une absence pour un élève
		 */
		public function addAbsence($source, $info){
			// echo '<pre>'; print_r($info); echo '</pre>';
			$eleve = $info['eleve'];
			$absence = $info['absence'];
			$dateAbsence = $info['dateAbsence'];
			for($i=0;$i<count($absence);$i++){
				if(!empty($absence[$i])){
					$this->_eleve = $eleve[$i];
					$this->_date = $dateAbsence;
					$this->_nbHeure = $absence[$i];
					$requete = $this->_db->prepare("INSERT INTO absence SET 
											id_eleve =:eleve,
											date_absence =:date,
											nombre_heure =:heure");
					$requete->bindValue(':eleve', $this->_eleve);
					$requete->bindValue(':date', $this->_date);
					$requete->bindValue(':heure', $this->_nbHeure);
					$requete->execute();
					$_SESSION['message'] = 'Absences insérées';
				}
			}
			header('Location:'.$source);
		}











		// On Supprime définitivement les absences d'un élève de la Base de Données 
		public function deleteAbsenceEleve($source, $id){
			$sql = "DELETE FROM absence WHERE id='$id'";
			$req = $this->_db->query($sql);
			$_SESSION['message'] = 'Absence(s) supprimée(s).';
			header('Location:'.$source);
		}






		// On insère les matricules Nationaux 
		public function addMatriculeNational($source, $information){
			echo '<pre>'; print_r($information); echo '</pre>';
			$this->_classe = $this->setUserId($information['clas']);
			$eleve = $information['eleve'];
			$matricule = $information['rne'];
			for($i=0;$i<count($eleve);$i++){
				$this->_eleve = $this->setUserId($eleve[$i]);
				$this->_matricule = $this->setUserId($matricule[$i]);
				$upd = $this->_db->prepare("UPDATE eleve SET rne =:rne 
											WHERE id =:id");
				$upd->execute(array('rne'=>$this->_matricule, 'id'=>$this->_eleve));
			}
			$_SESSION['message'] = 'Matricules nationaux insérés';
			header('Location:'.$source);
		}
		
		
		
		
		// La liste des élèves d'une classe 
		public function listeEleve($classe, $etat, $as){
			$sql = "SELECT nom_complet, eleve.sexe as sexe, date_naissance, lieu_naissance,
							DATE_FORMAT(date_naissance, '%d / %m / %Y') as date_fr,
							nom_classe, nom_pere, nom_mere, photo, adresse_parent, 
							matricule, etat, libelle_annee, eleve.statut as statut, 
							eleve.id as id, rne
					FROM eleve, classe, annee_scolaire
					WHERE etat='$etat'
						AND classe='$classe'
						AND classe = classe.id
						AND a_s = annee_scolaire.id
					ORDER BY nom_complet";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}








		// La liste des élèves sans matricule d'une classe 
		public function listeEleveSansMatricule($classe, $etat){
			$sql = "SELECT eleve.id as id, nom_complet, statut, classe, nom_classe
					FROM eleve, classe
					WHERE classe='$classe'
						AND etat='$etat'
						AND classe.id = classe
						AND rne='0'
					ORDER BY nom_complet";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		// Les statistiques de liste d'une classe donnée 
		public function listeEleveStat($classe, $etat, $as){
			$table = 'eleve';
			$effFilleRed = $this->statSexeStatut($table, $classe, 'F','R');
			$effFilleNv = $this->statSexeStatut($table, $classe, 'F','N');
			$effGarRed = $this->statSexeStatut($table, $classe, 'M','R');
			$effGarNv = $this->statSexeStatut($table, $classe, 'M','N');
			$stat['FR'] = $effFilleRed;
			$stat['FN'] = $effFilleNv;
			$stat['GR'] = $effGarRed;
			$stat['GN'] = $effGarNv;
			$stat['F'] = $effFilleRed + $effFilleNv;
			$stat['G'] = $effGarRed + $effGarNv;
			$stat['R'] = $effFilleRed + $effGarRed;
			$stat['N'] = $effFilleNv + $effGarNv;
			$stat['T'] = $stat['F'] + $stat['G'];
			return $stat;
		}








		public function listeEleveAbsence(){
			$sql = "SELECT DISTINCT nom_complet, absence.id as id, id_eleve 
					FROM absence, eleve 
					WHERE id_eleve = eleve.id
					GROUP BY nom_complet 
					ORDER BY nom_complet";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}




		// Les statistiques des élèves par niveau 
		public function statEleveNiveau($niveau, $etat, $as){
			$sqlM = "SELECT count(*) as masculin
					FROM eleve, classe 
					WHERE niveau_classe = '$niveau'
						AND classe = classe.id
						AND eleve.etat = '$etat'
						AND sexe = 'M'";
			$reqM = $this->_db->query($sqlM);
			$resM = $reqM->fetch(PDO::FETCH_ASSOC);
			$masculin = $resM['masculin'];
			
			$sqlF = "SELECT count(*) as feminin
					FROM eleve, classe 
					WHERE niveau_classe = '$niveau'
						AND classe = classe.id
						AND eleve.etat = '$etat'
						AND sexe = 'F'";
			$reqF = $this->_db->query($sqlF);
			$resF = $reqF->fetch(PDO::FETCH_ASSOC);
			$feminin = $resF['feminin'];

			$sql = "SELECT count(*) as total
					FROM eleve, classe 
					WHERE niveau_classe = '$niveau'
						AND classe = classe.id
						AND eleve.etat = '$etat'";
			$req = $this->_db->query($sql);
			$res = $req->fetch(PDO::FETCH_ASSOC);
			$total = $res['total'];
			
			$stat = array('M'=>$masculin,
							'F'=>$feminin,
							'T'=>$total);
			return $stat;
		}
		
		
		
		
		private function statSexeStatut($table, $classe, $sexe, $statut){
			$sql = "SELECT count(*) as nombre
					FROM $table 
					WHERE sexe='$sexe'
						AND statut='$statut'
						AND classe='$classe'
						AND etat = 'non_supprime'";
			$req = $this->_db->query($sql);
			$res = $req->fetch(PDO::FETCH_ASSOC);
			return $res['nombre'];
		}
		
		
		
		
		
		
		
		
		
		
		
		/***************************************************************************
		 * ***************************  TABLE MATIERE ******************************
		 * *************************************************************************
		 */
		
		// Je veux les informations complètes de la table matière suivant un id 
		public function getMatiere($id){
			$sql = "SELECT *
					FROM matiere 
					WHERE id='$id'
					ORDER BY nom_matiere";
			$req = $this->_db->query($sql);
			$res = $req->fetch(PDO::FETCH_ASSOC);
			return $res;
		}
		








		// Liste des Matières actives ou non 
		public function getMatiereAll($etat){
			$sql = "SELECT *
					FROM matiere 
					WHERE etat = '$etat'
					ORDER BY nom_matiere";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}




		// On recherche une matière
		public function findMatiere($nom){
			$sql = "SELECT matiere.id as id, nom_matiere, code_matiere, etat
					 FROM matiere
					WHERE nom_matiere LIKE '%$nom%'
									OR code_matiere LIKE '%$nom%'
					ORDER BY nom_matiere";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}












		// On liste les Classes dont l'id_matiere correspond au parmètre passé
		public function listeClasseMatiere($matiere){
			$this->_matiere = $this->setLogin($matiere);
			$sql = "SELECT id_classe, nom_classe, code_classe, coef 
					FROM prof_classe, classe, niveau_classe
					WHERE classe.id = id_classe
						AND id_matiere = '$this->_matiere'
						AND niveau_classe.id = classe.niveau_classe
					ORDER BY niveau_classe.code_niveau, nom_classe DESC";
			$req = $this->_db->query($sql);
			$res=$req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}
		
		
		
		
		
		
		
		
		
		



		/****************************************************************************
		 * ***************************   TABLE PROF_CLASSE **************************
		 * **************************************************************************
		 */

		// Liste des Matières qui interviennent dans une classe 
		public function getMatiereClasse($classe){
			$sql = "SELECT prof_classe.id as id, id_classe, nom_classe, code_matiere, id_matiere, nom_matiere, 
								coef, groupe, nom_groupe
					FROM prof_classe, classe, matiere, groupe
					WHERE id_classe='$classe'
						AND classe.id = id_classe
						AND matiere.id = id_matiere
						AND groupe = groupe.id
					ORDER BY nom_matiere";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}




		/**
		 * Les enseignants qui interviennent dans une classe
		 * @param int $classe paramètre unique de la classe
		 * @return array $resultat La liste des enseignants 
		 */
		public function getProfClasse($classe){
			$sql = "SELECT id_prof, nom
					FROM prof_classe, enseignant
					WHERE id_classe='$classe'
						AND id_prof = enseignant.id";
			$req = $this->_db->query($sql);
			$resultat = $req->fetchAll(PDO::FETCH_ASSOC);
			return $resultat;
		}



		
		/**
		 * Le Conseil de classe
		 * @param int $classe La classe pour laquelle generer le conseil
		 * @return array $resultat les enseignants, coef et groupe de la classe
		 */
		public function classCouncil($classe){
			$this->_classe = $this->setUserId($classe);
			$sql = "SELECT prof_classe.id as id, id_prof, nom, sexe
							id_classe, nom_classe, code_classe, section, id_matiere, nom_matiere, 
							code_matiere, coef, groupe
					FROM prof_classe, matiere, classe, enseignant
					WHERE id_classe = '$this->_classe'
						AND matiere.id = id_matiere
						AND classe.id = id_classe
						AND enseignant.id = id_prof
					ORDER BY groupe, nom_matiere";
			$req = $this->_db->query($sql);
			$resultat = $req->fetchAll(PDO::FETCH_ASSOC);
			return $resultat;
		}









		// Liste des Matières issues de la table Prof_classe
		public function listeMatiereProfClasse(){
			$sql = "SELECT id_matiere, nom_matiere
					FROM prof_classe, matiere
					WHERE id_matiere = matiere.id
					GROUP BY id_matiere ORDER BY nom_matiere";
			$req = $this->_db->query($sql);
			while($reponse = $req->fetch(PDO::FETCH_ASSOC)){
				$resultat[] = $reponse;
			}
			return $resultat;
		}




		





		





		// On ajoute un professeur principal 
		public function addProfPrincipal($info){
			// echo '<pre>'; print_r($info); echo '</pre>';
			$this->_classe = $this->setUserId($info['classe']);
			$this->_prof = $this->setUserId($info['prof']);

			$delete = $this->_db->prepare("DELETE FROM classe_principale
											WHERE classe =:classe");
			$delete->execute(array('classe'=>$this->_classe));

			$insert = $this->_db->prepare("INSERT INTO classe_principale SET 
											prof =:prof,
											classe =:classe");
			$insert->bindValue(':prof',$this->_prof);
			$insert->bindValue(':classe', $this->_classe);
			$insert->execute();
			$_SESSION['message'] = 'Professeur(s) princip(al)aux désigné(s)';
		}









		// Liste des Professeurs Principaux 
		public function classePrincipale(){
			$sql = "SELECT classe_principale.id as id, prof, enseignant.nom as nom, classe, nom_classe 
					FROM classe_principale, enseignant, classe
					WHERE enseignant.id = prof
						AND classe.id = classe
					ORDER BY section, niveau_classe, nom_classe";
			$req = $this->_db->query($sql);
			$resultat = $req->fetchAll(PDO::FETCH_ASSOC);
			return $resultat;
		}
		
		
		
		
		public function findEleve($eleve){
			$sql = "SELECT *
					FROM eleve 
					WHERE nom_complet LIKE '%$eleve%' 
					ORDER BY nom_complet
					";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}
		
		
		// On recherche une classe
		public function findClasse($nom){
			$sql = "SELECT classe.id as id, section, nom_classe, code_classe, etat_classe
					 FROM classe
					WHERE nom_classe LIKE '%$nom%'
									OR code_classe LIKE '%$nom%'
					ORDER BY nom_classe";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}




		




		// On recherche un prof
		public function findProf($nom){
			$sql = "SELECT enseignant.id as id, nom, sexe, poste, login, etat
					FROM enseignant
					WHERE nom LIKE '%$nom%'
						OR login LIKE '%$nom%'";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}







		// Liste des Groupes définis dans la Base de Données 
		public function listGroup(){
			$sql = "SELECT *
					FROM groupe
					ORDER BY nom_groupe";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}
		
		
		
		
		
		// On sauvegarde une image à la fois 
		public function saveImage($photo, $dossier, $nom){
			$this->image = $photo;
			$erreur = $this->image['error'];
			if($erreur==8){
				$message = "Une erreur a stoppé l envoi de l image."; 
			}elseif($erreur==7){
				$message = "Le disque semble protégé en écriture."; 
			}elseif($erreur==6){
				$message = "Le dossier temporaire que vous voulez utiliser est manquant."; 
			}elseif($erreur==4){
				$message = "Aucune image n a été téléchargée."; 
			}elseif($erreur==3){
				$message = "Image partiellement envoyé."; 
			}elseif($erreur==2){
				$message = "L image dépasse la taille maximale autorisée par HTML."; 
			}elseif($erreur==1){
				$message = "L image depasse la taille maximale autorisée."; 
			}elseif($erreur==0){
				$extensionAutorisee = array('jpg', 'jpeg', 'png', 'gif');
				$extension = strtolower(pathinfo($this->image['name'], PATHINFO_EXTENSION));
				if(in_array($extension,$extensionAutorisee)){
					$nomFichier = $nom.'.'.$extension;
					if(move_uploaded_file($this->image['tmp_name'], $dossier.$nomFichier)){
						$message = "Image enregistrée sous ".$dossier.$nomFichier;
					}else{
						$message = $message = "Image non enregistree pour raison inconnue.";
					}
				}else{
					$message='Format d image non autorisé';
				}
			}else{
				$message = "Erreur Inconnue";
			}
			$infoImage['message'] = $message;
			$infoImage['nomFichier'] = $dossier.$nomFichier;
			return $infoImage;
		}
		
		
		
		
		
		
		
		
		
		public function listeSexe(){
			$sexe['libelle'] = array('-Choisir Sexe-','Féminin', 'Masculin');
			$sexe['code'] = array('null','F','M');
			return $sexe;
		}
		
		
		
		
		
		
		
		
		
		public function listeStatut(){
			$sexe['libelle'] = array('-Choisir Statut-','Nouveau', 'Redoublant');
			$sexe['code'] = array('null','N','R');
			return $sexe;
		}
		
		
		
		
		
		
		
		
		// On sauvegarde les photos des élèves 
		public function enregistrerImageEleve($source, $eleve, $dossier, $photo){
			$this->eleve = $eleve; 
			// echo '<h1>Before</h1>';
			// echo '<pre>';print_r($photo);echo '</pre>';
			for($i=0;$i<count($this->eleve);$i++){
				$image['name'] = $photo['name'][$i];
				$image['full_path'] = $photo['full_path'][$i];
				$image['type'] = $photo['type'][$i];
				$image['tmp_name'] = $photo['tmp_name'][$i];
				$image['error'] = $photo['error'][$i];
				$image['size'] = $photo['size'][$i];
				$info[] = $this->saveImage($image, $dossier, $this->eleve[$i]);
				$this->_eleve[] = $this->eleve[$i];
			}
			
			for($j=0;$j<count($info);$j++){
				$sql = "UPDATE eleve 
						SET photo = '".$info[$j]['nomFichier']."' 
						WHERE id='".$this->_eleve[$j]."'";
				$this->_db->query($sql);
			}
			$_SESSION['message'] = 'Les images ont été enregisstrées';
			header('Location:'.$source);
			// echo '<pre>'; print_r($info); echo '</pre>';
		}
		
		
		
		
		
		
		
		
		
		
		
		// Afficher le journal des Connexions d'un utilisateur 
		public function journalConnexion($user){
			$sql = "SELECT journal_connexion.id as id, utilisateur, adresse_ip, periode, 
						DATE_FORMAT(periode, '%d / %m / %Y %H:%i:%s') as periode_fr, 
						type_machine as os, nom_machine as navigateur, nom
					FROM journal_connexion, enseignant
					WHERE utilisateur = '$user'
						AND enseignant.id = utilisateur
					ORDER BY periode DESC
					";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}
		
		
		
		
		// On enregistre une matière dans la classe 
		public function addSubjectClass($source, $matiere){
			echo '<pre>'; print_r($matiere); echo '</pre>';
			$this->_classe = $this->setUserId($matiere['classe']);
			$this->_matiere = $this->setUserId($matiere['matiere']);
			$this->_coef = $this->setNote($matiere['coef']);
			$this->_groupe = $this->setUserId($matiere['groupe']);
			if(empty($this->_classe)){
				$_SESSION['message'] = 'La valeur de classe ne doit pas être nulle';
				header('Location:'.$source);
			}else{
				if(empty($this->_matiere)){
					$_SESSION['message'] = 'La valeur de matière ne doit pas être nulle';
					header('Location:'.$source);
				}else{
					// on vérifie que la matière n'est pas déjà enregistrée 
					$verif = $this->checkSubjectClass($this->_classe, $this->_matiere);
					if($verif==false){
						$add = $this->_db->prepare("INSERT INTO prof_classe SET 
													id_classe =:classe,
													id_matiere =:matiere,
													coef =:coef,
													groupe =:groupe");
						$add->bindValue(':classe', $this->_classe);
						$add->bindValue(':matiere', $this->_matiere);
						$add->bindValue(':coef', $this->_coef);
						$add->bindValue(':groupe', $this->_groupe);
						$add->execute();
						$_SESSION['message'] = 'Matière insérée dans la classe';
						header('Location:'.$source);
					}else{
						$_SESSION['message'] = 'La matière existe déjà pour la classe.';
						header('Location:'.$source);
					}
				}
			}
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		/********************************************************************
		*
		*		G 
		*			E 
		*				S 
		*					T 
		*						I 
		*							O 
		*  								N 
		*		
		*		D 
		*			E 
		*				S 
		*
		*
		*
		*			N 
		*				O 
		*					T 
		*						E 
		*							S 
		********************************************************************/
		
		
		/**
		 * Les Classes dans lesquelles un enseignant intervient.
		 * @param int $enseignant qui est le seul paramètre 
		 * @return array $res qui renvoit la liste des classes
		 */
		public function listClassProf($enseignant){
			$this->_enseignant = $this->setUserId($enseignant);
			$sql = "SELECT prof_classe.id as id, id_classe, nom_classe
					FROM prof_classe, classe
					WHERE id_prof = '$this->_enseignant'
						AND classe.id = id_classe
					GROUP BY id_classe
					ORDER BY section, niveau_classe, nom_classe";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}





		/**
		 * Les Classes dans lesquelles un enseignant intervient et a déjà saisi ses notes.
		 * @param int $enseignant qui est le seul paramètre 
		 * @return array $res qui renvoit la liste des classes
		 */
		public function listClassSaisieProf($enseignant){
			$this->_enseignant = $this->setUserId($enseignant);
			$sql = "SELECT id_classe, id_enseignant, nom_classe, nom
					FROM note_saisie, classe, enseignant
					WHERE id_enseignant = '$this->_enseignant'
						AND classe.id = id_classe
						AND enseignant.id = id_enseignant
					GROUP BY id_classe
					ORDER BY section, niveau_classe, nom_classe";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}






		/**
		 * Les matières que l'enseignant tient dans une classe
		 * @param int $enseignant
		 * @param int $classe
		 * @return array $matiere
		 */
		public function getMatiereProf($enseignant, $classe){
			$this->_enseignant = $this->setUserId($enseignant);
			$this->_classe = $this->setUserId($classe);
			$sql = "SELECT id_matiere, nom_matiere
					FROM prof_classe, matiere
					WHERE id_prof = '$this->_enseignant'
						AND id_classe = $this->_classe
						AND id_matiere = matiere.id";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}





		/**
		 * Les matières que l'enseignant tient dans une classe et pour lesquelles il a déjà saisi les notes
		 * @param int $enseignant
		 * @param int $classe
		 * @return array $matiere
		 */
		public function getMatiereSaisieProf($enseignant, $classe){
			$this->_enseignant = $this->setUserId($enseignant);
			$this->_classe = $this->setUserId($classe);
			$sql = "SELECT id_matiere, nom_matiere
					FROM note_saisie, matiere
					WHERE id_enseignant = '$this->_enseignant'
						AND id_classe = $this->_classe
						AND id_matiere = matiere.id";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}






		
		//  
		/**
		 * On ajoute les notes à la base de donnéees
		 * @param string  $source qui est le HTTP_REFERER
		 * @param array $note qui contient toutes les notes saisies
		 * @return void car c'est une procédure.
		 */
		public function ajouterNote($source, $note){
			// echo '<pre>'; print_r($note); echo '</pre>';
			// echo '<pre>'; print_r($_SESSION); echo '</pre>';
			$classe = $this->setUserId($note['classe']);
			$matiere = $this->setUserId($note['matiere']);
			$enseignant = $_SESSION['user']['id'];
			$sequence = $this->setUserId($note['sequence']);
			$competence = $this->setCompetence($note['competence']);
			$eleve = $note['eleve'];
			$notes = $note['note'];
			for($i=0;$i<count($eleve);$i++){
				$this->_eleve = $this->setUserId($eleve[$i]);
				$this->_note = $this->setNote($notes[$i]);
				// echo "<p>".$this->_eleve." a obtenu ".$this->_note.".</p>";
				$insertion = $this->_db->prepare("INSERT INTO note
													SET 
													id_eleve =:eleve,
													id_matiere =:matiere,
													id_classe =:classe,
													id_periode =:periode,
													note =:note"); 
				$insertion->bindValue(':eleve', $this->_eleve);
				$insertion->bindValue(':matiere', $matiere);
				$insertion->bindValue(':classe', $classe);
				$insertion->bindValue(':periode', $sequence);
				$insertion->bindValue(':note', $this->_note);
				$insertion->execute();
			}
			$this->journalSaisieNote($classe, $matiere, $sequence, $enseignant, $competence);
			$_SESSION['message'] = 'Les notes ont été enregistrées.';
			header('Location:'.$source);
		}
		
		
		
		
		
		/**
		 * On modifie les notes saisies dans une classe pour une séquence précise
		 * @param string $source qui est la page de provenance de la requête 
		 * @param array $note qui contient : la classe, la matière, la séquence et les notes modifiées
		 * @return void car c'est nue procédure 
		*/ 
		public function modifierNote($source, $note){
			// echo '<pre>'; print_r($note); echo '</pre>';
			$this->_classe = $this->setUserId($note['classe']);
			$this->_matiere = $this->setUserId($note['matiere']);
			$this->_sequence = $this->setUserId($note['sequence']);
			$this->_competence = $this->setCompetence($note['competence']);
			$eleve = $note['eleve'];
			$notes = $note['note'];
			$annuler = $note['annuler'];
			$this->_date = DATE('Y-m-d H:i:s');

			for($i=0;$i<count($eleve);$i++){
				$this->_eleve = $this->setUserId($eleve[$i]);
				if(!empty($notes[$i])){
					$countValue[] = $notes[$i]; 
					$this->_note = $this->setNote($notes[$i]);
					echo "<p> L'élève ".$this->_eleve." obtient ".$this->_note.".</p>";
					$update = $this->_db->prepare("UPDATE note
													SET note =:note
													WHERE id_eleve=:eleve
														AND id_matiere=:matiere
														AND id_classe=:classe
														AND id_periode=:sequence");
					$update->execute(array('note'=>$this->_note,
											'eleve'=>$this->_eleve,
											'matiere'=>$this->_matiere,
											'classe'=>$this->_classe,
											'sequence'=>$this->_sequence));
					$this->journalUpdateNote($this->_classe, $this->_matiere, $this->_sequence,$this->_competence);
				}
			}

			if(!empty($annuler)){
				for($k=0;$k<count($annuler);$k++){
					$this->_student = $this->setUserId($annuler[$k]);
					$myNote = $this->setNote(-1); // On veut annuler ;-)
					$reset = $this->_db->prepare("UPDATE note
												SET note =:note
												WHERE id_eleve=:eleve
													AND id_matiere =:matiere
													AND id_classe=:classe
													AND id_periode=:sequence");
					$reset->execute(array('note'=>$myNote,
											'eleve'=>$this->_student,
											'matiere'=>$this->_matiere,
											'classe'=>$this->_classe,
											'sequence'=>$this->_sequence));
				}
			}else{}

			if(isset($countValue)){
				$phrase = count($countValue)." notes ont été modifiées ";
			}else{
				$phrase = " aucune note modifiée ";
			}
			if(isset($k)){
				$phrase .= " et ".$k." notes annulées";
			}else{
				$phrase .= " et pas de notes annulée.";
			}
			$_SESSION['message'] = $phrase;
			header('Location:'.$source);
		}
		
		
		
		/**
		 * On vérifie les notes qui ont été saisies 
		 * @param int $classe
		 * @param int $matiere
		 * @param int $periode
		 * @return array $res
		 */
		public function verifNoteSaisie($classe, $matiere, $periode){
			$this->_classe = $this->setUserId($classe);
			$this->_matiere = $this->setUserId($matiere);
			$this->_periode = $this->setUserId($periode);
			$sql = "SELECT id_classe, id_enseignant, id_matiere, id_periode, nom_classe, nom, nom_matiere,
							competence,
							DATE_FORMAT(date_saisie, '%d / %m / %Y') as date_fr,
							DATE_FORMAT(date_saisie, '%Hh %imin %sSec') as heure_fr
					FROM note_saisie, classe, enseignant, matiere 
					WHERE id_classe='$this->_classe'
						AND id_matiere = '$this->_matiere' 
						AND id_periode = '$this->_periode'
						AND classe.id = id_classe
						AND enseignant.id = id_enseignant
						AND matiere.id = id_matiere
						";
			$req = $this->_db->query($sql);
			$res = $req->fetch(PDO::FETCH_ASSOC);
			return $res;
		}
		
		
		
		
		
		
		/**
		 * On liste les notes saisies dans une classe pour une matière au cours d'une séquence
		 * @param int $classe 
		 * @param int $matiere
		 * @param int $sequence
		 * @return array $note
		 */
		public function listeNote($classe, $matiere, $sequence){
			$this->_classe = $this->setUserId($classe);
			$this->_matiere = $this->setUserId($matiere);
			$this->_sequence = $this->setUserId($sequence);
			$sql = "SELECT id_eleve, id_matiere, id_classe, id_periode, note, observation
					FROM note 
					WHERE id_classe = '$this->_classe'
						AND id_matiere = '$this->_matiere'
						AND id_periode = '$this->_sequence'";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}
		
		
		// On ressort les notes saisies pour une classe durant un mois précis 
		public function getNoteSaisieMois($classe, $mois){
			$sql = "SELECT classe, libelle_classe, section, matiere, 
						libelle_competence_fr, libelle_competence_en,
						periode, ip_saisie, type_machine, date_saisie, 
						DATE_FORMAT(date_saisie, '%d / %m / %Y %Hh %imin') as date_saisie_fr,
						date_modification,
						DATE_FORMAT(date_modification, '%d / %m / %Y %Hh %imin') as date_modification_fr
					FROM note_saisie, classe, liste_competence 
					WHERE classe = '$classe'
						AND periode = '$mois'
						AND classe = classe.id
						AND matiere = liste_competence.id ";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}
		
		
		
		
		
		
		
		// On supprime les notes saisies pour une période
		/**
		 * On supprime les notes saisies pour une période 
		 * @param string $source
		 * @param int $periode
		 * @param int $matiere
		 * @param int $classe
		 * @return void car c'est une procédure
		 */ 
		public function deleteNote($source, $periode, $matiere, $classe){
			$this->_periode = $this->setUserId($periode);
			$this->_subject = $this->setUserId($matiere);
			$this->_classe = $this->setUserId($classe);
			// Avant de supprimer, on vérifie qu'elles avaient été effectivement saisies 
			$a = $this->verifNoteSaisie($this->_classe, $this->_subject, $this->_periode);
			if($a==false){
				$_SESSION['message'] = 'Une erreur inconnue s est produite';
				header('Location:'.$source);
			}else{
				// On commence par supprimer du Journal
				$sql = $this->_db->prepare("DELETE FROM note_saisie 
						WHERE id_classe = :classe
							AND id_matiere = :matiere
							AND id_periode = :periode");
				$sql->execute(array(
									'classe'=>$this->_classe,
									'matiere'=>$this->_subject,
									'periode'=>$this->_periode));
				// Ensuite de la table notes 
				$requete = $this->_db->prepare("DELETE FROM note 
										WHERE id_matiere = :matiere 
											And id_classe = :classe
											AND id_periode = :periode");
				$requete->execute(array('matiere'=>$this->_subject,
										'periode'=>$this->_periode,
										'classe'=>$this->_classe));
				// On affiche le message 
				$_SESSION['message'] = 'Les notes ont été supprimées.';
				header('Location:'.$source);
			}
		}
		
		
		

		/**
		 * On liste les classes qui ont déjà saisi au moins une note 
		 * Aucun paramètre
		 * @return array $res
		 */
		public function listClassSaisie(){
			$sql = "SELECT id_classe, nom_classe
					FROM note_saisie, classe
					WHERE classe.id = id_classe
					GROUP BY id_classe
					ORDER BY section, niveau_classe, nom_classe
					";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}




		/**
		 * Sachant la classe choisie, on liste les séquences y ayant enregistré des notes
		 * @param int $classe
		 * @return array $res
		 */
		public function listSequenceSaisie($classe){
			$this->_classe = $this->setUserId($classe);
			$sql = "SELECT id_periode, nom_periode 
					FROM note_saisie, periode
					WHERE id_classe = '$this->_classe'
						AND periode.id = id_periode
					GROUP BY id_periode
					ORDER BY periode.id";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}
		









		// On veut savoir les classes prêtes pour le bulletin séquentiel 
		public function classeMensuellePrete(){
			$sql = "SELECT classe, libelle_classe, section
					FROM bull_mensuel, classe 
					WHERE classe = classe.id
					GROUP BY classe ORDER BY section";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}
		
		
		// On veut, sachant les classes, quels sont les mois prêts pour le bull mensuel 
		public function mensuelPret($classe){
			$sql = "SELECT mois, libelle_periode, code_periode_en, 
							code_periode_fr
					FROM bull_mensuel, periode 
					WHERE classe = '$classe'
						AND periode.id = mois";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}
		
		
		
		// On prépare les données pour le bulletin Mensuel
		public function configBulletinMensuel($classe, $mois){
			
		}
		
		
		
		
		// On traite les notes mensuelles 
		public function traiterNoteMensuelle($source, $classe, $mois){
			$this->_classe = $this->setUserId($classe);
			$this->_mois = $this->setUserId($mois);
			$this->_section = $this->getSectionClasse($this->_classe);
			$this->_as = $this->getCurrentYear();
			// On crée la table qui va recevoir les données 
			$this->prepaTableMensuelle($this->_classe, $this->_mois);
			
			// On hydrate la table avec les données de l'élève: nom, notes 
			$this->addDataMensuel($this->_classe, $this->_mois);
			
			// On lance le calcul des Notes et des moyennes 
			$this->calculNoteMensuel($this->_classe, $this->_mois);
			
			// On informe que tout s'est bien passé 
			$_SESSION['message'] = 'Notes traitées. Imprimez le bulletin Mensuel';
			header('Location:'.$source);
		}
		
		
		
		
		private function prepaTableMensuelle($classe, $mois){
			$nomTable = 'mensuel_'.$mois.'_'.$classe;
			$as = $this->getCurrentYear();
			
			$drop = $this->_db->prepare("DROP TABLE IF EXISTS ".$nomTable);
			$drop->execute();
			$listeMatiere = $this->listeMatiereClasse($classe);
			
			$creation = "CREATE TABLE $nomTable ( ";
			$creation .= "id int(11) auto_increment primary key, ";
			$creation .= "eleve int(11) not null, ";
			for($a=0;$a<count($listeMatiere);$a++){
				$codeMatiere = $listeMatiere[$a]['code_competence'];
				$idMatiere = $listeMatiere[$a]['id_competence'];
				$creation .= $codeMatiere.' float(4,2) null, ';
			}
			$creation .= "total float(5,2) null, ";
			$creation .= "cote varchar(5) null , ";
			$creation .= "appr varchar(10) null )";
			$create = $this->_db->prepare($creation);
			$create->execute();
			$listeEleve = $this->listeEleve($classe, 'non_supprime', $as);
			for($b=0;$b<count($listeEleve);$b++){
				$insert = $this->_db->prepare("INSERT INTO $nomTable 
												SET 
												eleve = :eleve");
				$insert->bindValue(':eleve', $listeEleve[$b]['id']);
				$insert->execute();
			}
		}
		
		
		
		
		
		private function addDataMensuel($classe, $mois){
			$nomTable = 'mensuel_'.$mois.'_'.$classe;
			$as = $this->getCurrentYear();
			$listeEleve = $this->listeEleve($classe, 'non_supprime', $as);
			for($i=0;$i<count($listeEleve);$i++){
				$idEleve = $listeEleve[$i]['id'];
				$listeMatiere = $this->listeMatiereClasse($classe);
				for($j=0;$j<count($listeMatiere);$j++){
					$idMatiere = $listeMatiere[$j]['id_competence'];
					$codeMatiere = $listeMatiere[$j]['code_competence'];
					$sql = "SELECT SUM(note) as note 
							FROM note 
							WHERE eleve = '$idEleve' 
								AND periode = '$mois' 
								AND matiere = '$idMatiere'";
					$req = $this->_db->query($sql);
					$res = $req->fetch(PDO::FETCH_ASSOC);
					$totalEleve = $res['note'];
					$totalGeneral[$idEleve][] = $totalEleve;
					$nomChamp = $codeMatiere;
					$update = $this->_db->prepare("UPDATE $nomTable SET 
													$nomChamp = :valeur 
													WHERE eleve = '$idEleve'");
					$update->execute(array('valeur'=>$totalEleve));
				}
				$totalPoint = array_sum($totalGeneral[$idEleve]);
				$requete = $this->_db->prepare("UPDATE $nomTable SET 
												total = :total 
												WHERE eleve = '$idEleve'");
				$requete->execute(array('total'=>$totalPoint));
			}
		}
		
		
		// Pour les appreciations et les cotes 
		private function calculNoteMensuel($classe, $mois){
			$nomTable = 'mensuel_'.$mois.'_'.$classe;
			$as = $this->getCurrentYear();
			$section = $this->getSectionClasse($classe);
			// Le total des points définis dans chaque classe est 320 points;
			$sql = "SELECT * FROM $nomTable";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			for($i=0;$i<count($res);$i++){
				$id = $res[$i]['id'];
				$noteEleve = $res[$i]['total'];
				$totalEvaluation = self::TOTAL_POINT_CLASSE;
				$cote = $this->getAppreciation($noteEleve, $totalEvaluation);
				$appreciation = $this->getLibelleAppreciation($cote, $section);
				$requete = $this->_db->prepare("UPDATE $nomTable SET 
												cote = :cote,
												appr = :appreciation
												WHERE id = '$id'");
				$requete->execute(array('cote'=>$cote,
										'appreciation'=>$appreciation));
			}
			
			// On insère dans la table bull_mensuel 
			$supprime = $this->_db->prepare("DELETE FROM bull_mensuel 
										WHERE classe = :classe 
											AND mois = :periode");
			$supprime->execute(array('classe'=>$classe,
									'periode'=>$mois));
			$insert = $this->_db->prepare('INSERT INTO bull_mensuel 
											SET  
											classe=:classe, 
											mois=:mois,
											pret = :reponse');
			$insert->bindValue(':classe', $classe);
			$insert->bindValue(':mois', $mois);
			$insert->bindValue(':reponse', 'oui');
			$insert->execute();
		}
		
		
		private function journalSaisieNote($classe, $matiere, $periode, $enseignant, $competence){
			$date = DATE('Y-m-d H:i:s');
			$navig = $this->getNavigateur();
			$navigateur = $navig['navigateur'];
			$os = $navig['os'];
			$ip = $_SERVER['REMOTE_ADDR'];			
			$journal = $this->_db->prepare('INSERT INTO note_saisie 
											SET 
											id_classe=:classe,
											id_enseignant =:enseignant,
											id_matiere=:matiere,
											id_periode=:periode,
											add_by =:enseignant,
											competence =:competence,
											date_saisie=:date,
											navigateur =:navigateur,
											ip=:ip,
											os=:os');
			$journal->bindValue(':classe', $classe);
			$journal->bindValue(':enseignant', $enseignant);
			$journal->bindValue(':matiere', $matiere);
			$journal->bindValue(':periode', $periode);
			$journal->bindValue(':competence', $competence);
			$journal->bindValue(':date', $date);
			$journal->bindValue(':navigateur', $navigateur);
			$journal->bindValue(':ip', $ip);
			$journal->bindValue(':os', $os);
			$journal->execute();
		}




		private function journalUpdateNote($classe, $matiere, $sequence, $competence){
			$date = DATE('Y-m-d H:i:s');
			$upd = $this->_db->prepare("UPDATE note_saisie
										SET date_modification=:modif,
											competence =:compet
										WHERE id_classe=:classe
											AND id_matiere=:matiere
											ANd id_periode=:sequence");
			$upd->execute(array('modif'=>$date,
								'classe'=>$classe,
								'matiere'=>$matiere,
								'sequence'=>$sequence,
								'compet'=>$competence));
		}
		
		
		/**
		 * Les Notes séquentielles d'un élève
		 * @param int $classe
		 * @param int $sequence
		 * @return array $resultat
		 */
		public function noteEleveSequence($classe, $sequence){
			$as = $this->getCurrentYear();
			$this->_classe = $this->setUserId($classe);
			$this->_sequence = $this->setUserId($sequence);
			$listeMatiere = $this->getMatiereClasse($this->_classe);
			// echo '<pre>'; print_r($listeMatiere); echo '</pre>';
			for($i=0;$i<count($listeMatiere);$i++){
				$idMatiere = $listeMatiere[$i]['id_matiere'];
				$codeMatiere = $listeMatiere[$i]['code_matiere'];
				$notesEleve[$codeMatiere] = $this->getNoteEleveSequence($this->_sequence, $idMatiere, $this->_classe);
			}
			return $notesEleve;
		}



		private function getNoteEleveSequence($sequence, $matiere, $classe){
			$sql = "SELECT id_eleve, nom_complet, id_matiere, nom_matiere, code_matiere, 
							id_classe, nom_classe, id_periode, note, observation
					FROM note, eleve, matiere, classe
					WHERE eleve.id = id_eleve
						AND matiere.id = id_matiere
						AND classe.id = id_classe
						AND id_periode = '$sequence'
						AND id_matiere = '$matiere'
						AND id_classe = '$classe'";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}
		
		
		
		
		
		
		
		
		
		
		
		
		/*************
		On visualise les notes séquentielles d'une classe
		******************************************************/
		public function viewNoteSequentielle($periode, $classe){
			// On appelle la fonction qui créé notre table
			$this->tableNoteSequence($periode, $classe);
			$nomTable = "view_Sequence_".$periode."_".$classe;
			
			/*Ensuite on extrait les notes de la table note pour insertion
			dans notre table de destination. On procède de manière unitaire
			c'est-à-dire que pour une classe, on procède à l'extraction élève par élève.*/
			$listeEleve = $this->listeEleve($classe, 'non_supprime','');
			for($i=0;$i<count($listeEleve);$i++){
				$nomEleve = strtoupper($listeEleve[$i]['nom_complet']);
				$sexeEleve = $listeEleve[$i]['sexe'];
				$statutEleve = $listeEleve[$i]['statut'];
				$matriculeEleve = $listeEleve[$i]['matricule'];
				$rneEleve = $listeEleve[$i]['rne'];
				$dateNaissance = $listeEleve[$i]['date_naissance'];
				$idEleve = $listeEleve[$i]['id'];
				$sql = "INSERT INTO $nomTable(nom, sexe, statut, matricule, 
												date_naissance, id_eleve, rne)
						VALUES('$nomEleve','$sexeEleve','$statutEleve',
								'$matriculeEleve','$dateNaissance','$idEleve','$rneEleve')";
				$req = $this->_db->query($sql);
				$variable = $this->viewNoteEleveSequence($idEleve, $periode);
				for($a=0;$a<count($variable);$a++){
					$matiere = $variable[$a]['code_matiere'];
					$note = $this->setNote($variable[$a]['note']);
					$insert = $this->_db->prepare("UPDATE $nomTable SET 
													$matiere =:note
													WHERE id_eleve =:eleve");
					$insert->bindValue(':note', $note);
					$insert->bindValue(':eleve', $idEleve);
					$insert->execute();			
				}
			}
		}
		
		
		
		/*******
		On crée la table qui va permettre de visualiser les notes 
		séquentielles d'une classe au complet.
		***********************************************************/
		private function tableNoteSequence($periode, $classe){
			$listeMatiere = $this->listeMatiereClasse($classe); // On récupère les matières de la classe 
			// echo '<pre>';print_r($listeMatiere);
			$nomTable = "view_Sequence_".$periode."_".$classe;
			// On supprime d'abord la table si elle existe
			$sql_1 = "DROP TABLE IF EXISTS ".$nomTable;
			$req_1 = $this->_db->query($sql_1);
			// Ensuite on la créé à nouveau
			$sql = "CREATE TABLE ".$nomTable."(";
			$sql .= "`id` int(11) AUTO_INCREMENT PRIMARY KEY,";
			$sql .= "`nom` varchar(255) not null,";
			$sql .= "`id_eleve` int(11) not null,";
			$sql .= "`rne` int(11) not null,";
			$sql .= "`sexe` varchar(10),";
			$sql .= "`statut` varchar(10),";
			$sql .= "`date_naissance` date,";
			$sql .= "`matricule` varchar(20),";
			
			// On récupère les noms des matières qu'on insère directement dans les champs 
			for($i=0;$i<count($listeMatiere);$i++){
				$nomMatiere = strtolower($listeMatiere[$i]['code_matiere']);
				$sql .= "`".$nomMatiere."` FLOAT(4,2) null,";
			}
			$sql .= "`vide` varchar(10));";
			$req = $this->_db->query($sql);
			$sql_2 = "ALTER TABLE $nomTable DROP COLUMN vide";
			$req_2 = $this->_db->query($sql_2);
		}
		
		
		public function exportNoteSequence($sequence, $classe){
			$table = "view_sequence_".$sequence."_".$classe;
			$classe = $this->getClasse($classe);
			$sql = "SELECT *
					FROM $table";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			$resultat['eleve'] = $res;
			$resultat['sequence'] = $sequence;
			$resultat['classe'] = $classe['nom_classe'];
			return $resultat;
		}
		
		
		
		
		
		/*Les matières inscrites dans une classe */
		public function listeMatiereClasse($classe) {
			$this->_classe = $this->setUserId($classe);
			$sql = "SELECT prof_classe.id as id, id_matiere, 
							nom_matiere, coef, groupe, code_matiere
					FROM prof_classe, matiere
					WHERE id_classe='$this->_classe'
						AND id_matiere=matiere.id
					ORDER BY nom_matiere";
			$req = $this->_db->query($sql);
			$res=$req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}
		
		
		
		
		private function viewNoteEleveSequence($eleve, $periode){
			$sql = "SELECT id_matiere, note, id_eleve,
							nom_complet, id_periode, code_matiere
					FROM note, eleve, matiere 
					WHERE id_eleve = '$eleve' AND id_periode='$periode'
							AND eleve.id=id_eleve
							AND id_matiere = matiere.id
					ORDER BY nom_complet, id_matiere";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}
		
		
		
		
		// Les Classes pour lesquelles on a déjà saisi les notes
		public function viewClasseNote(){
			$sql = "SELECT id_classe, nom_classe
					FROM note, classe, niveau_classe
					WHERE id_classe = classe.id
						AND niveau_classe = niveau_classe.id
					GROUP BY id_classe ORDER BY classe.section, nom_niveau, nom_classe";
			$req = $this->_db->query($sql);
			while($res = $req->fetch(PDO::FETCH_ASSOC)){
				$reponse[] = $res;
			}
			return $reponse;
		}
		
		
		
		
		
		
		
		/*************
		On a validé le bouton TRAITER LES NOTES SEQUENTIELLES
		******************************************************/
		public function traiterNoteSequence($source,$info){
			// echo '<pre>'; print_r($info); echo '</pre>';
			$this->_periode = $this->setUserId($info['sekence']);
			$this->_classe = $this->setUserId($info['classe']);
			$infoClasse = $this->getClasse($this->_classe);
			$table = 'sequence_'.$this->_periode.'_'.$this->_classe;
			// On crée la table et on y ajoute les noms des élèves 
			$this->prepaTableSequence($this->_periode, $this->_classe,$table);
			// On insère les élèves dans la table créée 
			$this->addEleveTable($this->_classe, $table);
			// On intègre les notes séquentielles de l'élève
			$this->addDataSequence($this->_classe, $this->_periode, $table);
			// On génère les minimum, maximum et rang pour chaque matière présente
			$this->addRankMinMaxSequence($this->_classe, $table);
			// On introduit les heures d'absence 
			// On enregistre le traitement 
			$req_traite = "INSERT INTO bull_seq(pret, classe, sequence) ";
			$req_traite .= "VALUES('oui', '$this->_classe', '$this->_periode')";
			$req_traite_del = "DELETE FROM bull_seq";
			$req_traite_del .= " WHERE classe='$this->_classe' 
									AND sequence='$this->_periode'";
			$exec_traite_del = $this->_db->query($req_traite_del);
			$exec_traite = $this->_db->query($req_traite);
			// Quand tout se termine, on affiche le message
			$_SESSION['message'] = 'Notes de la Séquence '.$this->_periode;
			$_SESSION['message'] .= ' traitées pour la '.$infoClasse['nom_classe'];
			header('Location:'.$source);
		}
		
		
		
		
		private function prepaTableSequence($periode, $classe, $table){
			// echo '<pre>'; print_r($infoClasse); echo '</pre>';
			$sql_prepa = "CREATE TABLE $table (";
			$sql_prepa .= "id int(11) auto_increment primary key, ";
			$sql_prepa .= "id_eleve int(11) not null, ";
			$sql_prepa .= "rne TEXT  null, ";
			$sql_prepa .= "nom_eleve TEXT not null, ";
			$sql_prepa .= "sexe TEXT null, ";
			$sql_prepa .= "date_en date null, ";
			$sql_prepa .= "date_fr TEXT null, ";
			$sql_prepa .= "lieu_naissance TEXT null, ";
			$sql_prepa .= "adresse_parent TEXT null, ";
			$sql_prepa .= "statut TEXT null, ";
			$sql_prepa .= "photo TEXT null, ";
			$listeMatiere = $this->listeMatiereClasse($classe);
			
			for($a=0;$a<count($listeMatiere);$a++){
				$matiere = strtolower($listeMatiere[$a]['code_matiere']);
				$req_creation_0 = "`".$matiere."_competence` TEXT NULL, ";
				$req_creation_1 = "`".$matiere."_seq` decimal(4,2) DEFAULT NULL, ";
				$req_creation_2 = "`".$matiere."_coef` decimal(4,2) NULL, ";
				$req_creation_3 = "`".$matiere."_total` decimal(5,2) NULL, ";
				$req_creation_4 = "`".$matiere."_min` decimal(4,2) NULL, ";
				$req_creation_5 = "`".$matiere."_max` decimal(4,2) NULL, ";
				$req_creation_6 = "`".$matiere."_appreciation` TEXT  null, ";
				$req_creation_7 = "`".$matiere."_cote` TEXT  null, ";
				$req_creation_8 = "`".$matiere."_enseignant` TEXT  null, ";
				$req_creation_9 = "`".$matiere."_rank` int(11) null, ";
				$sql_prepa .= $req_creation_0;
				$sql_prepa .= $req_creation_1;
				$sql_prepa .= $req_creation_2;
				$sql_prepa .= $req_creation_3;
				$sql_prepa .= $req_creation_4;
				$sql_prepa .= $req_creation_5;
				$sql_prepa .= $req_creation_6;
				$sql_prepa .= $req_creation_7;
				$sql_prepa .= $req_creation_8;
				$sql_prepa .= $req_creation_9;
			}
			$groupe = $this->getGroupeClasse($classe);
			// echo '<pre>'; print_r($groupe); echo '</pre>';
			for($b=0;$b<count($groupe);$b++){
				$gp = $groupe[$b]['code_groupe'];
				$sql_prepa .= $gp."_total float(5,2) NULL, ";
				$sql_prepa .= $gp."_coef float(4,2) NULL, ";
				$sql_prepa .= $gp."_moyenne float(4,2) NULL, ";
				$sql_prepa .= $gp."_min float(4,2) NULL, ";
				$sql_prepa .= $gp."_max float(4,2) NULL, ";
				$sql_prepa .= $gp."_appreciation TEXT NULL, ";
				$sql_prepa .= $gp."_cote TEXT NULL, ";
				$sql_prepa .= $gp."_rank int(11) NULL, ";
			}
			$sql_prepa .= "total_point float(5,2) NULL, ";
			$sql_prepa .= "total_coef float(4,2) NULL, ";
			$sql_prepa .= "moyenne float(4,2) NULL, ";
			$sql_prepa .= "min float(4,2) NULL, ";
			$sql_prepa .= "max float(4,2) NULL, ";
			$sql_prepa .= "appreciation TEXT NULL, ";
			$sql_prepa .= "cote TEXT NULL, ";
			$sql_prepa .= "classes int(11), ";
			$sql_prepa .= "rang TEXT null, ";
			$sql_prepa .= "absence_total int(11) null, ";
			$sql_prepa .= "absence_non_just int(11) null, ";
			$sql_prepa .= "absence_just int(11) null ";
			$sql_prepa .= ")";
			$sql_del = "DROP TABLE IF EXISTS $table";
			$this->_db->query($sql_del); 
			$this->_db->query($sql_prepa);
		}
		
		
		
		
		
		
		private function addEleveTable($classe, $table){
			$listeEleve = $this->listeEleve($classe, 'non_supprime','');
			// echo '<pre>'; print_r($listeEleve); echo '</pre>';
			for($c=0;$c<count($listeEleve);$c++){
				$idEleve = $listeEleve[$c]['id'];
				$nomEleve = addslashes($listeEleve[$c]['nom_complet']);
				$sexeEleve = $listeEleve[$c]['sexe'];
				$dateNaissance = $listeEleve[$c]['date_naissance'];
				$date_fr = $listeEleve[$c]['date_fr'];
				$lieuNaissance = strtoupper($listeEleve[$c]['lieu_naissance']);
				$matriculeEleve = $listeEleve[$c]['matricule'];
				$rneEleve = $listeEleve[$c]['rne'];
				$adresseParent = $listeEleve[$c]['adresse_parent'];
				$statut = $listeEleve[$c]['statut'];
				if(empty($listeEleve[$c]['photo'])){
					$photo = 'images/eleve/no_name.png';
				}else{
					$photo = $listeEleve[$c]['photo'];
				}
				$insertion = $this->_db->prepare("INSERT INTO $table SET 
											id_eleve =:idEleve,
											rne =:rne,
											nom_eleve =:nom,
											sexe =:sexe,
											date_en =:dateEn,
											date_fr =:dateFr,
											lieu_naissance =:lieu,
											adresse_parent =:adresse,
											statut =:statut,
											photo =:photo");
				$insertion->bindValue(':idEleve', $idEleve);
				$insertion->bindValue(':rne', $rneEleve);
				$insertion->bindValue(':nom', $nomEleve);
				$insertion->bindValue(':sexe', $sexeEleve);
				$insertion->bindValue(':dateEn', $dateNaissance);
				$insertion->bindValue(':dateFr', $date_fr);
				$insertion->bindValue(':lieu', $lieuNaissance);
				$insertion->bindValue(':adresse', $adresseParent);
				$insertion->bindValue(':statut', $statut);
				$insertion->bindValue(':photo', $photo);
				$insertion->execute();
			}
		}
		
		
		
		
		
		private function addDataSequence($classe, $periode, $table){
			$listeEleve = $this->listeEleve($classe, 'non_supprime','');
			$section = $this->getSectionClasse($classe);
			for($c=0;$c<count($listeEleve);$c++){
				$idEleve = $listeEleve[$c]['id'];
				$noteEleve = $this->viewNoteSequentielleEleve($classe, $periode, $idEleve);
				for($i=0;$i<count($noteEleve);$i++){
					$champCompetence = $noteEleve[$i]['code_matiere'].'_competence';
					$champSequence = $noteEleve[$i]['code_matiere'].'_seq';
					$champCoef = $noteEleve[$i]['code_matiere'].'_coef';
					$champTotal = $noteEleve[$i]['code_matiere'].'_total';
					$champAppreciation = $noteEleve[$i]['code_matiere'].'_appreciation';
					$champCote = $noteEleve[$i]['code_matiere'].'_cote';
					$champEnseignant = $noteEleve[$i]['code_matiere'].'_enseignant';
					$noteObtenue = $this->setNote($noteEleve[$i]['note']);
					// echo var_dump($noteObtenue).'<br />';
					$idEleve = $noteEleve[$i]['id_eleve'];
					$idMatiere = $noteEleve[$i]['id_matiere'];
					$codeMatiere = strtolower($noteEleve[$i]['code_matiere']);
					$competence = $this->getCompetence($classe, $idMatiere, $periode);
					if($noteObtenue==NULL){
						$coef = NULL;
						$total = NULL;
						}else{
							$coef = $this->getCoefMatiere($idMatiere, $classe);
							$total = $noteObtenue * $coef;
						}
					$enseignant = $this->getEnseignantMatiere($idMatiere, $classe);
					$appr = $this->showAppreciation($noteObtenue);
					$libelleAppreciation = 'nom_appreciation_'.$section;
					$appreciation = $appr[$libelleAppreciation];
					$cote = $appr['cote'];
					$requete = $this->_db->prepare("UPDATE $table SET
											$champSequence = :note,
											$champCompetence = :competence,
											$champCoef = :coef,
											$champTotal =:total,
											$champAppreciation =:appreciation,
											$champCote =:cote,
											$champEnseignant = :enseignant
											WHERE id_eleve = :eleve");
					$requete->bindValue(':note', $noteObtenue);
					$requete->bindValue(':competence', $competence['competence']);
					$requete->bindValue(':enseignant', $enseignant);
					$requete->bindValue(':coef', $coef);
					$requete->bindValue(':total', $total);
					$requete->bindValue(':cote', $cote);
					$requete->bindValue(':appreciation', $appreciation);
					$requete->bindValue(':eleve', $idEleve);
					$requete->execute();
				}
			}
		}
		
		
		
		
		private function addRankMinMaxSequence($classe, $table){
			$listeMatiere = $this->listeMatiereClasse($classe);
			// echo '<pre>'; print_r($listeMatiere); echo '</pre>';
			for($i=0;$i<count($listeMatiere);$i++){
				$idMatiere = $listeMatiere[$i]['id'];
				$codeMatiere = $listeMatiere[$i]['code_matiere'];
				$champCible = strtolower($codeMatiere.'_seq');
				$champMin = strtolower($codeMatiere.'_min');
				$champMax = strtolower($codeMatiere.'_max');
				$champRank =  strtolower($codeMatiere.'_rank');
				$min = $this->getMinMatiere($champCible,$table);
				$max = $this->getMaxMatiere($champCible, $table);
				$rank  = $this->getRankMatiere($codeMatiere, $table);
				print_r($rank);
				$requete  = $this->_db->prepare("UPDATE $table SET 
							$champMin =:min,
							$champMax = :max
							");
				$requete->bindValue(':min', $min);
				$requete->bindValue(':max', $max);
				$requete->execute();
			}
		}
		
		
		
		
		// Le nombre  et les noms de groupes définis pour une classe
		public function getGroupeClasse($classe){
			$sql = "SELECT DISTINCT groupe, nom_groupe, code_groupe
					FROM prof_classe, groupe 
					WHERE id_classe='$classe'
						AND groupe = groupe.id
					ORDER BY nom_groupe";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}
		
		
		
		// On visualise les notes séquentielles 
		private function viewNoteSequentielleEleve($classe, $periode, $eleve){
			$sql = "SELECT note.id_eleve as id_eleve, note.id_matiere as id_matiere, 
						note.id_classe as id_classe, note.id_periode as id_periode, 
						note.note as note, note.observation as observation, code_matiere, nom_matiere,
						nom_complet, nom_classe
					FROM note, matiere, eleve, classe
					WHERE note.id_eleve = '$eleve'
						AND note.id_classe = '$classe'
						AND note.id_periode = '$periode'
						AND note.id_matiere = matiere.id
						AND note.id_eleve = eleve.id
						AND note.id_classe = classe.id
					ORDER BY code_matiere";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}
		
		
		
		
		private function getCompetence($classe, $matiere, $periode){
			$sql = "SELECT *
					FROM note_saisie
					WHERE id_classe='$classe'
						AND id_matiere = '$matiere'
						AND id_periode = '$periode'";
			$req = $this->_db->query($sql);
			$res = $req->fetch(PDO::FETCH_ASSOC);
			return $res;
		}
		
		
		// On récupère le Coef d'une matière. Ceci est utile pour calculer les notes
		private function getCoefMatiere($matiere, $classe){
			$sql = "SELECT coef
					FROM prof_classe 
					WHERE id_classe='$classe' AND id_matiere = '$matiere' 
					";
			$req = $this->_db->query($sql);
			$res = $req->fetch(PDO::FETCH_ASSOC);
			return $res['coef'];
		}
		
		
		
		// On récupère le prof d'une matière. Ceci est utile pour calculer les notes
		private function getEnseignantMatiere($matiere, $classe){
			$sql = "SELECT id_prof, nom
					FROM prof_classe, enseignant 
					WHERE id_classe='$classe' 
						AND id_matiere = '$matiere'
						AND id_prof = enseignant.id 
					";
			$req = $this->_db->query($sql);
			$res = $req->fetch(PDO::FETCH_ASSOC);
			return $res['nom'];
		}
		
		
		
		
		// Affiche l'appreciation d'une note
		public function showAppreciation($note){
			// On doit gérer les cas des élèves non classés
			if($note==0){
				$res['nom_appreciation_fr'] = 'Non Classé';
				$res['nom_appreciation_en'] = 'Not Evaluated';
				$res['couleur'] = 'Black';
				$res['cote'] = '-';
			}
			else{
				$sql = "SELECT nom_appreciation_fr, nom_appreciation_en, cote
						FROM appreciation
						WHERE interv_ouvert <= ".$note." 
							AND interv_fermet>".$note;
				$req = $this->_db->query($sql);
				$res = $req->fetch(PDO::FETCH_ASSOC);
			}
			return $res;
		}
		
		
		
		private function getMinMatiere($champ, $table){
			$sql = "SELECT MIN($champ) as minimum
					FROM $table
					WHERE $champ >0";
			$req = $this->_db->query($sql);
			$res = $req->fetch(PDO::FETCH_ASSOC);
			return $res['minimum'];
		}



		private function getMaxMatiere($champ, $table){
			$sql = "SELECT MAX($champ) as maximum
					FROM $table
					WHERE $champ >0";
			$req = $this->_db->query($sql);
			$res = $req->fetch(PDO::FETCH_ASSOC);
			return $res['maximum'];
		}



		private function getRankMatiere($codeMatiere, $table){
			$champCible = strtolower($codeMatiere.'_rank');
			$champMatiere = strtolower($codeMatiere.'_seq');
			$sql = "SELECT $champMatiere, id_eleve
					FROM $table
					WHERE $champMatiere >0
					ORDER BY $champMatiere DESC";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			$a = 1;
			for($i=0;$i<count($res);$i++){
				$eleve = $res[$i]['id_eleve'];
				$rank = $a;
				$sql = "UPDATE $table SET $champCible = '$rank'
						WHERE id_eleve = '$eleve'";
				$req = $this->_db->query($sql);
				$a++;
			}
		}



		private function getRank($table){
			$sql = "SELECT moyenne, id_eleve
					FROM $table
					WHERE moyenne >0
					ORDER BY moyenne DESC";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			$a = 1;
			for($i=0;$i<count($res);$i++){
				$eleve = $res[$i]['id_eleve'];
				$rank = $a;
				$sql = "UPDATE $table SET rang = '$rank'
						WHERE id_eleve = '$eleve'";
				$req = $this->_db->query($sql);
				$a++;
			}
		}
		
		
		
		public function classesTraiteesSeq(){
			$sql = "SELECT classe, nom_classe 
					FROM bull_seq, classe 
					WHERE classe = classe.id
					GROUP BY nom_classe ORDER BY section, niveau_classe, nom_classe";
			$req = $this->_db->query($sql);
			while($res = $req->fetch(PDO::FETCH_ASSOC)){
				$resultat[] = $res;
			}
			return $resultat;
		}
		
		
		
		public function sequencesTraitees($classe){
			$sql = "SELECT DISTINCT sequence 
					FROM bull_seq
					WHERE classe='$classe'";
			$req = $this->_db->query($sql);
			while($res = $req->fetch(PDO::FETCH_ASSOC)){
				$resultat[] = $res;
			}
			return $resultat;
		}
		
		
		


		private function addMoyenneGroupe($classe, $table){
			$listeEleve = $this->listeEleve($classe, 'non_supprime','');
			$section = $this->getSectionClasse($classe);
			for($i=0;$i<count($listeEleve);$i++){
				$idEleve = $listeEleve[$i]['id'];
				//  On récupère les matières par Groupe
				$groupe = $this->getGroupeClasse($classe);
				// print_r($groupe);
				for($a=0;$a<count($groupe);$a++){
					$codeGroupe = $groupe[$a]['code_groupe'];
					$champMoyenne = $codeGroupe.'_moyenne';
					$champCote = $codeGroupe.'_cote';
					$champAppr = $codeGroupe.'_appreciation';
					$sql = "SELECT $champMoyenne
							FROM $table 
							WHERE id_eleve = '$idEleve'";
					$req = $this->_db->query($sql);
					$resultat = $req->fetch(PDO::FETCH_ASSOC);
					$moyenneGroupe = $resultat[$champMoyenne];
					$appreciation = $this->showAppreciation($moyenneGroupe);
					
					$cleAppr = 'nom_appreciation_'.$section;
					$coteGroupe = $appreciation['cote'];
					$apprGroupe = $appreciation[$cleAppr];
					
					$update = $this->_db->prepare("UPDATE $table SET 
													$champCote =:cote,
													$champAppr =:appr
													WHERE id_eleve =:eleve");
					$update->bindValue(':cote',$coteGroupe);
					$update->bindValue(':appr',$apprGroupe);
					$update->bindValue(':eleve',$idEleve);
					$update->execute();
				}

				for($b=0;$b<count($groupe);$b++){
					$codeGroupe = $groupe[$b]['code_groupe'];
					$champMoyenneGroupe = $codeGroupe.'_moyenne';
					$champMin = $codeGroupe.'_min';
					$champMax = $codeGroupe.'_max';
					$min = $this->getMinMatiere($champMoyenneGroupe,$table);
					$max = $this->getMaxMatiere($champMoyenneGroupe, $table);
					$update = $this->_db->prepare("UPDATE $table SET 
							$champMin =:min,
							$champMax =:max");
					$update->bindValue(':min',$min);
					$update->bindValue(':max', $max);
					$update->execute();
				}
			}
		}








		public function trimestresTraites($classe){
			$sql = "SELECT DISTINCT trimestre 
					FROM bull_trim
					WHERE classe='$classe'";
			$req = $this->_db->query($sql);
			while($res = $req->fetch(PDO::FETCH_ASSOC)){
				$resultat[] = $res;
			}
			return $resultat;
		}



		


		public function classesTraiteesTrim(){
			$sql = "SELECT classe, nom_classe 
					FROM bull_trim, classe 
					WHERE classe = classe.id
					GROUP BY nom_classe ORDER BY section, niveau_classe, nom_classe";
			$req = $this->_db->query($sql);
			while($res = $req->fetch(PDO::FETCH_ASSOC)){
				$resultat[] = $res;
			}
			return $resultat;
		}





		// Utile dans la génération des statistiques par matière 
		public function getTrimestre($matiere){
			$sequence = $this->getTrimestreDraft($matiere);
			for($i=0;$i<count($sequence);$i++){
				if($sequence[$i]['id_periode']=='1' or $sequence[$i]['id_periode']=='2'){
					$trimestre[0] = '1';
				}
				if($sequence[$i]['id_periode']=='3' or $sequence[$i]['id_periode']=='4'){
					$trimestre[1] = '2';
				}
				if($sequence[$i]['id_periode']=='5' or $sequence[$i]['id_periode']=='6'){
					$trimestre[2] = '3';
				}
			}
			return $trimestre;
		}









		// On veut vérifier les notes saisies pour un trimestre à travers la table note_saisie 
		public function getTrimestreDraft($matiere){
			$this->_matiere = $this->setUserId($matiere);
			$sql = "SELECT DISTINCT id_periode 
					FROM note_saisie
					WHERE id_matiere = '$this->_matiere'";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}



		
		
		/*************
		On a validé le bouton TRAITER LES MOYENNES SEQUENTIELLES
		******************************************************/
		public function traiterMoyenneSequence($source, $periode, $classe){
			$this->_sequence = $this->setUserId($periode);
			$this->_classe = $this->setUserId($classe);
			$table = 'sequence_'.$this->_sequence.'_'.$this->_classe;
			$section = $this->getSectionClasse($classe);
			$infoClasse = $this->getClasse($this->_classe);
			// On introduit les totaux par groupe ainsi que les moyennes 
			$this->addTotalGroupe($this->_classe, $table);
			// On gère les appréciations et cotes par groupe 
			$this->addMoyenneGroupe($this->_classe, $table);
			// On gère le classement des élèves
			$min = $this->getMinMatiere('moyenne', $table);
			$max = $this->getMaxMatiere('moyenne', $table);
			$count = "SELECT count(moyenne) as moyenne 
					FROM $table 
					WHERE moyenne > '0'";
			$requete = $this->_db->query($count);
			$resultat = $requete->fetch(PDO::FETCH_ASSOC);
			$this->getRank($table);
			$update = $this->_db->prepare("UPDATE $table SET 
							min =:min,
							max =:max,
							classes = :classes
							");
			$update->bindValue(':min',$min);
			$update->bindValue(':max', $max);
			$update->bindValue(':classes', $resultat['moyenne']);
			$update->execute();
			$_SESSION['message'] = 'Moyennes de la classe de '.$infoClasse['nom_classe'];
			$_SESSION['message'] .= ' traitées pour la Séquence '.$this->_sequence;
			$_SESSION['message'] .= '. Vous pouvez imprimer les bulletins de la classe.';

			header('Location: '.$source);
		}









		// On introduit le professeur titulaire dans la table du bulletin
		public function putTitulaire($table, $classe, $champ){
			$sql = "SELECT prof, classe, enseignant.nom as nom, nom_classe, sexe
					FROM classe_principale, enseignant, classe
					WHERE classe='$classe'
						AND prof = enseignant.id
						AND classe = classe.id";
			$req = $this->_db->query($sql);
			$res = $req->fetch(PDO::FETCH_ASSOC);
			// $nomTitulaire = $res['sexe'].' '.$res['nom'];
			$update = $this->_db->prepare("UPDATE $table SET $champ =:titulaire");
			$update->bindValue(':titulaire', $nomTitulaire);
			$update->execute();
		}









		/**
		 * Traitement des Moyennes Trimestrielles
		 * @param string $source la page d'origine
		 * @param int $trimestre le trimestre concerné par le traitement 
		 * @param int $classe la classe concernée a le traitement 
		 * @param void c'est une procédure. Elle renvoie juste un message.
		 */
		public function traiterMoyenneTrimestre($source, $trimestre, $classe){
			$this->_sequence = $this->setUserId($trimestre);
			$this->_classe = $this->setUserId($classe);
			$table = 'trimestre_'.$this->_sequence.'_'.$this->_classe;
			$infoClasse = $this->getClasse($this->_classe);
			// print_r($infoClasse);
			$section = $infoClasse['section'];
			// On introduit les totaux par groupe ainsi que les moyennes
			$this->addTotalGroupe($this->_classe, $table);
			// On gère les appréciations et cotes par groupe 
			$this->addMoyenneGroupe($this->_classe, $table);
			// On gère le classement des élèves
			$min = $this->getMinMatiere('moyenne', $table);
			$max = $this->getMaxMatiere('moyenne', $table);
			$count = "SELECT count(moyenne) as moyenne 
					FROM $table 
					WHERE moyenne > '0'";
			$requete = $this->_db->query($count);
			$resultat = $requete->fetch(PDO::FETCH_ASSOC);
			$this->getRank($table);
			$update = $this->_db->prepare("UPDATE $table SET 
							min =:min,
							max =:max,
							classes = :classes
							");
			$update->bindValue(':min',$min);
			$update->bindValue(':max', $max);
			$update->bindValue(':classes', $resultat['moyenne']);
			$update->execute();
			// On positionne le titulaire de la classe
			$this->putTitulaire($table, $this->_classe, 'titulaire');
			// On introduit les heures d'absence 
			// On renvoie le message de fin
			$_SESSION['message'] = 'Moyennes de la classe de '.$infoClasse['nom_classe'];
			$_SESSION['message'] .= ' traitées pour le trimestre '.$this->_sequence;
			$_SESSION['message'] .= '. Vous pouvez imprimer les bulletins de la classe.';
			header('Location: '.$source);

















			// $table = "trimestre_".$trimestre."_".$classe;
			// $listeEleve = $this->listeEleve($classe, 'non_supprime');
			// $section = $this->getSection($classe);
			// // print_r($listeEleve);
			
			// // On fait un traitement pour chaque élève de la classe 
			// for($i=0;$i<count($listeEleve);$i++){
			// 	$idEleve = $listeEleve[$i]['id'];
			// 	$nom = strtoupper($listeEleve[$i]['nom']);
			// 	$prenom = ucwords($listeEleve[$i]['prenom']);
			// 	$nomComplet = $nom.' '.$prenom;
			// 	// echo '<p>'.$i. ' '.$nomComplet.'</p>';
				
			// 	// On récupère les matières par Groupe 
			// 	$groupe = $this->getGroupeClasse($classe);
			// 	// print_r($groupe);	
			// 	for($a=0;$a<count($groupe);$a++){
			// 		$matieres = $this->getMatiereGroupe($groupe[$a],$classe);
			// 		// print_r($matieres);
			// 		for($b=0;$b<count($matieres);$b++){
			// 			$codeGroupe = $groupe[$a];
			// 			$champMatiere = $matieres[$b]['id_matiere'].'_total';
			// 			$champCoef = $matieres[$b]['id_matiere'].'_coef';
			// 			$champEnseignant = $matieres[$b]['id_matiere'].'_enseignant';
			// 			$nomEnseignant = strtoupper($matieres[$b]['nom']).' ';
			// 			$nomEnseignant .= ucwords($matieres[$b]['prenom']);
			// 			// echo $champEnseignant.' = '.$nomEnseignant.' <br/>';
			// 			$sql_gp_note = "SELECT $champMatiere 
			// 							FROM $table 
			// 							WHERE id_eleve = '$idEleve'";
			// 			// echo $sql_gp_note;
			// 			$req_gp_note = $this->_db->query($sql_gp_note);
			// 			$res_gp_note = $req_gp_note->fetch(PDO::FETCH_ASSOC);
			// 			$champTotalMatiere[$codeGroupe][$champMatiere] = $res_gp_note[$champMatiere];
			// 			$sql_gp_coef = "SELECT $champCoef 
			// 							FROM $table 
			// 							WHERE id_eleve = '$idEleve'";
			// 			// echo $sql_gp_coef;
			// 			$req_gp_coef = $this->_db->query($sql_gp_coef);
			// 			$res_gp_coef = $req_gp_coef->fetch(PDO::FETCH_ASSOC);
			// 			$champTotalCoef[$codeGroupe][$champCoef] = $res_gp_coef[$champCoef];
			// 		}
			// 		$SommeCoef[$a] = array_sum($champTotalCoef[$codeGroupe]);
			// 		$SommePoint[$a] = array_sum($champTotalMatiere[$codeGroupe]);
			// 		if($SommeCoef[$a]!=0){$moyenneGroupe[$a] = $SommePoint[$a] / $SommeCoef[$a];}else{$moyenneGroupe[$a]='';}
					
			// 		$app[$a] = $this->showAppreciation($moyenneGroupe[$a]);
			// 		$apprec[$a] = $app[$a]['cote'];
			// 		$champGroupeTotal = $codeGroupe.'_total';
			// 		$champGroupeCoef = $codeGroupe.'_coef';
			// 		$champGroupeMoyenne = $codeGroupe.'_moyenne';
			// 		$champGroupeCote = $codeGroupe.'_cote';
					
			// 		$sql_upd = "UPDATE $table 
			// 					SET $champGroupeTotal = '$SommePoint[$a]',
			// 					 $champGroupeCoef = '$SommeCoef[$a]',
			// 					 $champGroupeMoyenne = '$moyenneGroupe[$a]',
			// 					 $champEnseignant = '$nomEnseignant',
			// 					 $champGroupeCote = '$apprec[$a]'
			// 					WHERE id_eleve = '$idEleve'";
			// 		$req_upd = $this->_db->query($sql_upd);
			// 	}
			// 	$totalPoint = array_sum($SommePoint);
			// 	$totalCoef = array_sum($SommeCoef);
			// 	/*Pour être classé, le total des Coef doit être supérieur ou égale à 70% des coef 
			// 	définis dans la classe */
			// 	$CoefDefinis = $this->getCoefClasse($classe);
			// 	$classementPossible = $CoefDefinis * 40 / 100;
			// 	if($totalCoef>=$classementPossible){
			// 		$moyenne = $totalPoint / $totalCoef;
			// 		$appr = $this->showAppreciation($moyenne);
			// 		if($section=='fr'){$appreciation = $appr['nom_appreciation']; $cote = $appr['cote'];} 
			// 		elseif($section=='en'){$appreciation = $appr['nom_appreciation_anglais']; $cote = $appr['cote'];}
			// 		// $appreciation = $appr['nom_appreciation'];
			// 	}
			// 	else{
			// 		$moyenne = 0;
			// 		$appreciation= '--';
			// 		$cote = '-';
			// 	}
			// 	$sql_upd2 = "UPDATE $table 
			// 				SET total_point = '$totalPoint',
			// 					total_coef = '$totalCoef',
			// 					moyenne = '$moyenne',
			// 					appreciation = '$appreciation',
			// 					cote = '$cote'
			// 				WHERE id_eleve='$idEleve'";
			// 	$req_upd2 = $this->_db->query($sql_upd2);
				
			// 	$sql = "SELECT count(moyenne) as classes 
			// 			FROM $table 
			// 			WHERE moyenne !='0.00'";
			// 	$req = $this->_db->query($sql);
			// 	$res = $req->fetch(PDO::FETCH_ASSOC);
			// 	$classes = $res['classes'];
			// 	$sql_upd3 = "UPDATE $table 
			// 					SET classes = '$classes'";
			// 	$req_upd3 = $this->_db->query($sql_upd3);
			// }
			// $rang = $this->showRangEleve($table);
			// for($j=0;$j<count($rang['resultat']);$j++){
			// 	echo "<p>L'élève ".$rang['id'][$j]." a obtenu ".$rang['resultat'][$j]." et est classé "; 
			// 			echo $rang['rang'][$j].".</p>";
			// 	$rank = $rang['rang'][$j];
			// 	$id = $rang['id'][$j];
			// 	$moy = $rang['resultat'][$j];
			// 	$sql = "UPDATE $table 
			// 			SET rang = '$rank'
			// 			WHERE  moyenne = '$moy'";
			// 	$req = $this->_db->query($sql);
			// }
			// $_SESSION['message'] = 'Moyennes de la classe de '.$classe;
			// $_SESSION['message'] .= ' traitées pour le Trimestre '.$trimestre;
			// $_SESSION['message'] .= '. Vous pouvez imprimer les bulletins de la classe.';
			// header('Location: '.$source);
		}
		
		
		
		private function addTotalGroupe($classe, $table){
			$listeEleve = $this->listeEleve($classe, 'non_supprime','');
			$section = $this->getSectionClasse($classe);
			for($i=0;$i<count($listeEleve);$i++){
				$idEleve = $listeEleve[$i]['id'];
				//  On récupère les matières par Groupe
				$groupe = $this->getGroupeClasse($classe);
				// print_r($groupe);
				for($a=0;$a<count($groupe);$a++){
					$codeGroupe = $groupe[$a]['code_groupe'];
					$matieres = $this->getMatiereGroupe($groupe[$a]['groupe'],$classe);
					$champGroupePoint[$a] = $codeGroupe.'_total';
					$champGroupeCoef[$a] = $codeGroupe.'_coef';
					$champGroupeMoyenne[$a] = $codeGroupe.'_moyenne';
					// print_r($matieres);
					for($b=0;$b<count($matieres);$b++){
						$champMatiere = strtolower($matieres[$b]['code_matiere'].'_total');
						$champCoef = strtolower($matieres[$b]['code_matiere'].'_coef');
						// echo $champCoef.'<br />';
						$sqlMatiere = "SELECT $champMatiere FROM $table WHERE id_eleve='$idEleve'";
						$reqMatiere = $this->_db->query($sqlMatiere);
						$resMatiere = $reqMatiere->fetch(PDO::FETCH_ASSOC);
						$points[$codeGroupe][$champMatiere] = $resMatiere[$champMatiere];

						$sqlCoef = "SELECT $champCoef FROM $table WHERE id_eleve='$idEleve'";
						$reqCoef = $this->_db->query($sqlCoef);
						$resCoef = $reqCoef->fetch(PDO::FETCH_ASSOC);
						$coef[$codeGroupe][$champCoef] = $resCoef[$champCoef];
					}
					$sommePoint[$a] = array_sum($points[$codeGroupe]);
					$sommeCoef[$a] = array_sum($coef[$codeGroupe]);
					// print_r($coef[$codeGroupe]);
					// echo '<hr />';
					if(empty($sommeCoef[$a]) or $sommeCoef[$a]==0){
						$moyenneGroupe[$a] = NULL;
					}else{
							$moyenneGroupe[$a] = $sommePoint[$a] / $sommeCoef[$a];
					}
					$sqlUpdate = "UPDATE $table SET 
									$champGroupePoint[$a] = '$sommePoint[$a]',
									$champGroupeCoef[$a] = '$sommeCoef[$a]',
									$champGroupeMoyenne[$a] = '$moyenneGroupe[$a]'
								WHERE id_eleve = '$idEleve'
									";
					$this->_db->query($sqlUpdate);
				}
				$sommeTotalePoint = array_sum($sommePoint);
				$sommeTotaleCoef = array_sum($sommeCoef);
				if(empty($sommeTotaleCoef) or $sommeTotaleCoef==0){
					$moyenneTotale = NULL;
					$appr = NULL;
					$cote = NULL;
				}else{
					$totalCoefClasse = $this->totalCoefClasse($classe);
					$classement = $totalCoefClasse * 65 / 100;
					if($sommeTotaleCoef>=$classement){
						$moyenneTotale = $sommeTotalePoint / $sommeTotaleCoef;
						$appreciation = $this->showAppreciation($moyenneTotale);
						$appr = $appreciation['cote'];
						$codeSection = 'nom_appreciation_'.$section;
						$cote = $appreciation[$codeSection];
					}else{
						$moyenneTotale = NULL;
						$appr = NULL;
						$cote = NULL;
					}
				}
				$updateMoyenne = $this->_db->prepare("UPDATE $table SET 
												total_point =:point,
												total_coef =:coef,
												moyenne =:moyenne,
												cote =:cote,
												appreciation =:appr
												WHERE id_eleve =:eleve");
				$updateMoyenne->bindValue(':point', $sommeTotalePoint);
				$updateMoyenne->bindValue(':coef', $sommeTotaleCoef);
				$updateMoyenne->bindValue(':moyenne', $moyenneTotale);
				$updateMoyenne->bindValue(':cote', $cote);
				$updateMoyenne->bindValue(':appr', $appr);
				$updateMoyenne->bindValue(':eleve', $idEleve);
				$updateMoyenne->execute();
			}
		}
		
		
		// Les matières d'un groupe 
		public function getMatiereGroupe($gp,$classe){
			$sql = "SELECT id_matiere, nom_matiere, id_prof, nom, code_matiere
					FROM prof_classe, matiere, enseignant 
					WHERE groupe='$gp'
						AND matiere.id = id_matiere
						AND id_classe = '".$classe."'
						AND enseignant.id = id_prof
					ORDER BY nom_matiere";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}
		
		
		
		// Le Total des coefficients définis dans une classe
		private function totalCoefClasse($classe){
			$sql = "SELECT SUM(coef) as totalCoef
					FROM prof_classe 
					WHERE id_classe = '$classe'";
			$req = $this->_db->query($sql);
			$res = $req->fetch(PDO::FETCH_ASSOC);
			return $res['totalCoef'];
		}
		
		
		
		
		public function viewNomClasse($classe){
			$sql = "SELECT *
					FROM classe
					WHERE code_classe='$classe'
					";
			$req = $this->_db->query($sql);
			$res=$req->fetch(PDO::FETCH_ASSOC);
			$resultat = $res;
			return $resultat;
		}
		
		
		
		
		
		
		// On vérifie la section à laquelle appartient une classe 
		public function verifSectionClasse($classe){
			$sql = "SELECT section 
					FROM classe
					WHERE classe.id='$classe'";
			$req = $this->_db->query($sql);
			$res = $req->fetch(PDO::FETCH_ASSOC);
			$resultat = $res['section'];
			return $resultat;
		}
		
		
		
		
		
		// Quelles informations y'a t-il dans la table moy_sequence_periode_cls ?
		public function moySequenceClasse($periode, $classe){
			$table = 'sequence_'.$periode.'_'.$classe;
			$sql = "SELECT * FROM `$table`";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}









		// Quelles informations y'a t-il dans la table moy_sequence_periode_cls ?
		public function moyTrimestreClasse($periode, $classe){
			$table = 'trimestre_'.$periode.'_'.$classe;
			$sql = "SELECT * FROM `$table`";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}









		// Quelles informations y'a t-il dans la table moy_sequence_periode_cls ?
		// Par Odre de Mérite
		public function moyTrimestreClasseMerite($periode, $classe){
			$table = 'trimestre_'.$periode.'_'.$classe;
			$sql = "SELECT * FROM $table ORDER BY moyenne DESC";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}



		// Quelles informations y'a t-il dans la table moy_sequence_periode_cls ?
		// Par Odre de Mérite
		public function moySequenceClasseMerite($periode, $classe){
			$table = 'sequence_'.$periode.'_'.$classe;
			$sql = "SELECT * FROM $table ORDER BY moyenne DESC";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}
		
		
		
		
		// Quelles informations y'a t-il dans la table sequence_periode_cls ?
		public function sequenceClasse($periode, $classe){
			$table = 'sequence_'.$periode.'_'.$classe;
			$sql = "SELECT * FROM $table";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);{
				$resultat[] = $res;
			}
			return $resultat;
		}









		// Quelles informations y'a t-il dans la table sequence_periode_cls ?
		public function trimestreClasse($periode, $classe){
			$table = 'trimestre_'.$periode.'_'.$classe;
			$sql = "SELECT * FROM $table";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);{
				$resultat[] = $res;
			}
			return $resultat;
		}
		
		
		
		public function statSequence($periode, $classe){
			$table = 'sequence_'.$periode.'_'.$classe;
			
			/*/Pour les statistiques de la séquence, on va d'abord ressortir
			les effectifs genrés. */
			$liste = $this->listeEleve($classe, 'non_supprime','');
			for($i=0;$i<count($liste);$i++){
				$sexe[$i] = $liste[$i]['sexe'];
			}
			$genre = array_count_values($sexe);
			if(!$genre['F']){$effFille = 0;} else{$effFille = $genre['F'];}
			if(!$genre['M']){$effMasc = 0;} else{$effMasc = $genre['M'];}
			$effTotal = $effMasc + $effFille;
			
			/*Maintenant, on ressort les effectifs des élèves réellement
			classés, c'est à dire qui ont au moins une moyenne supérieure
			à zéro. */
			$sql1 = "SELECT count(moyenne) as evalMasc 
					FROM $table 
					WHERE moyenne >'0.00' AND sexe = 'M'";
			/*$req = $this->_db->query($sql);
			while($res = $req->fetch(PDO::FETCH_ASSOC)){*/
			$req1 = $this->_db->query($sql1);
			$res1 = $req1->fetch(PDO::FETCH_ASSOC);
			
			$sql2 = "SELECT count(moyenne) as evalFille 
					FROM $table 
					WHERE moyenne >'0.00' AND sexe = 'F'";
			
			$req2 = $this->_db->query($sql2);
			$res2 = $req2->fetch(PDO::FETCH_ASSOC);
			
			$evalTotal = $res1['evalMasc'] + $res2['evalFille'];
			
			/*Maintenant, on ressort les effectifs des élèves 
			qui ont au moins une moyenne supérieure à 10.
			 */
			$sql3 = "SELECT count(moyenne) as moyMasc 
					FROM $table 
					WHERE moyenne >='10.00' AND sexe = 'M'";
			$req3 = $this->_db->query($sql3);
			$res3 = $req3->fetch(PDO::FETCH_ASSOC);
			
			$sql4 = "SELECT count(moyenne) as moyFille 
					FROM $table 
					WHERE moyenne >='10.00' AND sexe = 'F'";
			$req4 = $this->_db->query($sql4);
			$res4 = $req4->fetch(PDO::FETCH_ASSOC);
			
			/*Maintenant, on ressort les effectifs des élèves 
			qui ont la sous moyenne.
			 */
			$sql5 = "SELECT count(moyenne) as sousMoyMasc 
					FROM $table 
					WHERE moyenne <10 AND moyenne >'0.00' AND sexe = 'M'";
			$req5 = $this->_db->query($sql5);
			$res5 =$req5->fetch(PDO::FETCH_ASSOC);
			
			$sql6 = "SELECT count(moyenne) as sousMoyFille 
					FROM $table 
					WHERE moyenne <10 AND moyenne > '0.00' AND sexe = 'F'";
			$req6 = $this->_db->query($sql6);
			$res6 =$req6->fetch(PDO::FETCH_ASSOC);
			
			
			
			$moyTotal = $res3['moyMasc'] + $res4['moyFille'];
			$sousMoyTotal = $res5['sousMoyMasc'] + $res6['sousMoyFille'];
			
			if($res1['evalMasc']!=0){
				$tauxMasc = $res3['moyMasc']*100/$res1['evalMasc'];
			}else{
				$tauxMasc = '';
			}

			if($res2['evalFille']!=0){
				$tauxFille = $res4['moyFille']*100/$res2['evalFille'];
			}else{
				$tauxFille = '';
			}

			
			
			$sql = "SELECT count(moyenne) as moyTotal 
					FROM $table 
					WHERE moyenne >='10.00'";
			$req = $this->_db->query($sql) ;
			$res =$req->fetch(PDO::FETCH_ASSOC);
			if($evalTotal!=0){
				$tauxTotal = $res['moyTotal']*100/$evalTotal;
			}else{
				$tauxTotal = '';
			}
			
			$sqlNFM = "SELECT MAX(moyenne) as maxMasc 
					FROM $table 
					WHERE sexe = 'M' AND moyenne > '0.00'";
			$reqNFM = $this->_db->query($sqlNFM) ;
			$resNFM =$reqNFM->fetch(PDO::FETCH_ASSOC);
			
			$sqlNFF = "SELECT MAX(moyenne) as maxFille 
					FROM $table 
					WHERE sexe = 'F' AND moyenne >'0.00'";
			$reqNFF = $this->_db->query($sqlNFF) ;
			$resNFF =$reqNFF->fetch(PDO::FETCH_ASSOC);
			
			$sqlNFT = "SELECT MAX(moyenne) as maxTotal 
					FROM $table 
					WHERE moyenne > '0.00'";
			$reqNFT = $this->_db->query($sqlNFT) ;
			$resNFT =$reqNFT->fetch(PDO::FETCH_ASSOC);
			
			$sql10 = "SELECT MIN(moyenne) as minMasc 
					FROM $table 
					WHERE sexe = 'M' AND moyenne >'0.00'";
			$req10 = $this->_db->query($sql10) ;
			$res10 =$req10->fetch(PDO::FETCH_ASSOC);
			
			$sql11 = "SELECT MIN(moyenne) as minFille 
					FROM $table 
					WHERE sexe = 'F' AND moyenne >'0.00'";
			$req11 = $this->_db->query($sql11) ;
			$res11 =$req11->fetch(PDO::FETCH_ASSOC);
			
			$sql12 = "SELECT MIN(moyenne) as minTotal 
					FROM $table 
					WHERE moyenne >'0.00'";
			$req12 = $this->_db->query($sql12) ;
			$res12 =$req12->fetch(PDO::FETCH_ASSOC);
			
			$sql20 = "SELECT AVG(moyenne) as moyGenMasc 
					FROM $table 
					WHERE sexe='M' AND moyenne>'0.00'";
			$req20 = $this->_db->query($sql20) ;
			$res20 =$req20->fetch(PDO::FETCH_ASSOC);
			
			$sql21 = "SELECT AVG(moyenne) as moyGenFille 
					FROM $table 
					WHERE sexe='F' AND moyenne>'0.00'";
			$req21 = $this->_db->query($sql21) ;
			$res21 = $req21->fetch(PDO::FETCH_ASSOC);
			
			$sql22 = "SELECT AVG(moyenne) as moyGenTotal 
					FROM $table 
					WHERE moyenne>'0.00'";
			$req22 = $this->_db->query($sql22) ;
			$res22 = $req22->fetch(PDO::FETCH_ASSOC);
			
			
			$stat['effMasc'] = $effMasc;
			$stat['effFille'] = $effFille;
			$stat['effTotal'] = $effTotal;
			$stat['evalMasc'] = $res1['evalMasc'];
			$stat['evalFille'] = $res2['evalFille'];
			$stat['evalTotal'] = $evalTotal;
			$stat['moyMasc'] = $res3['moyMasc'];
			$stat['moyFille'] = $res4['moyFille'];
			$stat['moyTotal'] = $moyTotal;
			$stat['sousMoyMasc'] = $res5['sousMoyMasc'];
			$stat['sousMoyFille'] = $res6['sousMoyFille'];
			$stat['sousMoyTotal'] = $sousMoyTotal;
			// $stat['tauxMasc'] = $tauxMasc;
			$stat['tauxMasc'] = substr($tauxMasc,0,5);
			$stat['tauxFille'] = substr($tauxFille,0,5);
			$stat['tauxTotal'] = substr($tauxTotal,0,5);
			$stat['noteForteMasc'] = $resNFM['maxMasc'];
			$stat['noteForteFille'] = $resNFF['maxFille'];
			$stat['noteForteTotal'] = $resNFT['maxTotal'];
			$stat['noteFaibleMasc'] = $res10['minMasc'];
			$stat['noteFaibleFille'] = $res11['minFille'];
			$stat['noteFaibleTotal'] = $res12['minTotal'];
			$stat['moyGenMasc'] = substr($res20['moyGenMasc'],0,5);
			$stat['moyGenFille'] = substr($res21['moyGenFille'],0,5);
			$stat['moyGenTotal'] = substr($res22['moyGenTotal'],0,5);
			return $stat;
		}








		public function statTrimestre($periode, $classe){
			$table = 'trimestre_'.$periode.'_'.$classe;
			
			/*/Pour les statistiques de la séquence, on va d'abord ressortir
			les effectifs genrés. */
			$liste = $this->listeEleve($classe, 'non_supprime','');
			for($i=0;$i<count($liste);$i++){
				$sexe[$i] = $liste[$i]['sexe'];
			}
			$genre = array_count_values($sexe);
			if(!$genre['F']){$effFille = 0;} else{$effFille = $genre['F'];}
			if(!$genre['M']){$effMasc = 0;} else{$effMasc = $genre['M'];}
			$effTotal = $effMasc + $effFille;
			
			/*Maintenant, on ressort les effectifs des élèves réellement
			classés, c'est à dire qui ont au moins une moyenne supérieure
			à zéro. */
			$sql1 = "SELECT count(moyenne) as evalMasc 
					FROM $table 
					WHERE moyenne >'0.00' AND sexe = 'M'";
			/*$req = $this->_db->query($sql);
			while($res = $req->fetch(PDO::FETCH_ASSOC)){*/
			$req1 = $this->_db->query($sql1);
			$res1 = $req1->fetch(PDO::FETCH_ASSOC);
			
			$sql2 = "SELECT count(moyenne) as evalFille 
					FROM $table 
					WHERE moyenne >'0.00' AND sexe = 'F'";
			
			$req2 = $this->_db->query($sql2);
			$res2 = $req2->fetch(PDO::FETCH_ASSOC);
			
			$evalTotal = $res1['evalMasc'] + $res2['evalFille'];
			
			/*Maintenant, on ressort les effectifs des élèves 
			qui ont au moins une moyenne supérieure à 10.
			 */
			$sql3 = "SELECT count(moyenne) as moyMasc 
					FROM $table 
					WHERE moyenne >='10.00' AND sexe = 'M'";
			$req3 = $this->_db->query($sql3);
			$res3 = $req3->fetch(PDO::FETCH_ASSOC);
			
			$sql4 = "SELECT count(moyenne) as moyFille 
					FROM $table 
					WHERE moyenne >='10.00' AND sexe = 'F'";
			$req4 = $this->_db->query($sql4);
			$res4 = $req4->fetch(PDO::FETCH_ASSOC);
			
			/*Maintenant, on ressort les effectifs des élèves 
			qui ont la sous moyenne.
			 */
			$sql5 = "SELECT count(moyenne) as sousMoyMasc 
					FROM $table 
					WHERE moyenne <10 AND moyenne >'0.00' AND sexe = 'M'";
			$req5 = $this->_db->query($sql5);
			$res5 =$req5->fetch(PDO::FETCH_ASSOC);
			
			$sql6 = "SELECT count(moyenne) as sousMoyFille 
					FROM $table 
					WHERE moyenne <10 AND moyenne > '0.00' AND sexe = 'F'";
			$req6 = $this->_db->query($sql6);
			$res6 =$req6->fetch(PDO::FETCH_ASSOC);
			
			
			
			$moyTotal = $res3['moyMasc'] + $res4['moyFille'];
			$sousMoyTotal = $res5['sousMoyMasc'] + $res6['sousMoyFille'];
			
			if($res1['evalMasc']!=0){
				$tauxMasc = $res3['moyMasc']*100/$res1['evalMasc'];
			}else{
				$tauxMasc = '';
			}

			if($res2['evalFille']!=0){
				$tauxFille = $res4['moyFille']*100/$res2['evalFille'];
			}else{
				$tauxFille = '';
			}

			
			
			$sql = "SELECT count(moyenne) as moyTotal 
					FROM $table 
					WHERE moyenne >='10.00'";
			$req = $this->_db->query($sql) ;
			$res =$req->fetch(PDO::FETCH_ASSOC);
			if($evalTotal!=0){
				$tauxTotal = $res['moyTotal']*100/$evalTotal;
			}else{
				$tauxTotal = '';
			}
			
			$sqlNFM = "SELECT MAX(moyenne) as maxMasc 
					FROM $table 
					WHERE sexe = 'M' AND moyenne > '0.00'";
			$reqNFM = $this->_db->query($sqlNFM) ;
			$resNFM =$reqNFM->fetch(PDO::FETCH_ASSOC);
			
			$sqlNFF = "SELECT MAX(moyenne) as maxFille 
					FROM $table 
					WHERE sexe = 'F' AND moyenne >'0.00'";
			$reqNFF = $this->_db->query($sqlNFF) ;
			$resNFF =$reqNFF->fetch(PDO::FETCH_ASSOC);
			
			$sqlNFT = "SELECT MAX(moyenne) as maxTotal 
					FROM $table 
					WHERE moyenne > '0.00'";
			$reqNFT = $this->_db->query($sqlNFT) ;
			$resNFT =$reqNFT->fetch(PDO::FETCH_ASSOC);
			
			$sql10 = "SELECT MIN(moyenne) as minMasc 
					FROM $table 
					WHERE sexe = 'M' AND moyenne >'0.00'";
			$req10 = $this->_db->query($sql10) ;
			$res10 =$req10->fetch(PDO::FETCH_ASSOC);
			
			$sql11 = "SELECT MIN(moyenne) as minFille 
					FROM $table 
					WHERE sexe = 'F' AND moyenne >'0.00'";
			$req11 = $this->_db->query($sql11) ;
			$res11 =$req11->fetch(PDO::FETCH_ASSOC);
			
			$sql12 = "SELECT MIN(moyenne) as minTotal 
					FROM $table 
					WHERE moyenne >'0.00'";
			$req12 = $this->_db->query($sql12) ;
			$res12 =$req12->fetch(PDO::FETCH_ASSOC);
			
			$sql20 = "SELECT AVG(moyenne) as moyGenMasc 
					FROM $table 
					WHERE sexe='M' AND moyenne>'0.00'";
			$req20 = $this->_db->query($sql20) ;
			$res20 =$req20->fetch(PDO::FETCH_ASSOC);
			
			$sql21 = "SELECT AVG(moyenne) as moyGenFille 
					FROM $table 
					WHERE sexe='F' AND moyenne>'0.00'";
			$req21 = $this->_db->query($sql21) ;
			$res21 = $req21->fetch(PDO::FETCH_ASSOC);
			
			$sql22 = "SELECT AVG(moyenne) as moyGenTotal 
					FROM $table 
					WHERE moyenne>'0.00'";
			$req22 = $this->_db->query($sql22) ;
			$res22 = $req22->fetch(PDO::FETCH_ASSOC);
			
			
			$stat['effMasc'] = $effMasc;
			$stat['effFille'] = $effFille;
			$stat['effTotal'] = $effTotal;
			$stat['evalMasc'] = $res1['evalMasc'];
			$stat['evalFille'] = $res2['evalFille'];
			$stat['evalTotal'] = $evalTotal;
			$stat['moyMasc'] = $res3['moyMasc'];
			$stat['moyFille'] = $res4['moyFille'];
			$stat['moyTotal'] = $moyTotal;
			$stat['sousMoyMasc'] = $res5['sousMoyMasc'];
			$stat['sousMoyFille'] = $res6['sousMoyFille'];
			$stat['sousMoyTotal'] = $sousMoyTotal;
			// $stat['tauxMasc'] = $tauxMasc;
			$stat['tauxMasc'] = substr($tauxMasc,0,5);
			$stat['tauxFille'] = substr($tauxFille,0,5);
			$stat['tauxTotal'] = substr($tauxTotal,0,5);
			$stat['noteForteMasc'] = $resNFM['maxMasc'];
			$stat['noteForteFille'] = $resNFF['maxFille'];
			$stat['noteForteTotal'] = $resNFT['maxTotal'];
			$stat['noteFaibleMasc'] = $res10['minMasc'];
			$stat['noteFaibleFille'] = $res11['minFille'];
			$stat['noteFaibleTotal'] = $res12['minTotal'];
			$stat['moyGenMasc'] = substr($res20['moyGenMasc'],0,5);
			$stat['moyGenFille'] = substr($res21['moyGenFille'],0,5);
			$stat['moyGenTotal'] = substr($res22['moyGenTotal'],0,5);
			return $stat;
		}

		
		
		
		// Les groupes et le nombre de groupes d'une classe
		public function afficheGroupe($classe){
			$sql = "SELECT groupe, nom_groupe
					FROM prof_classe, groupe 
					WHERE id_classe='$classe'
						AND groupe.id = groupe
					GROUP BY groupe";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			
			return $res;
		}








		private function addHeureAbsence($classe, $periode, $typePeriode){
			$nomTable = $typePeriode.'_'.$periode.'_'.$classe;
			/*if($typePeriode=='trimestre'){}elseif($typePeriode=='mensuel'){}*/
			$listeEleve = $this->listeEleve($classe, 'non_supprime','');
			for($i=0;$i<count($listeEleve);$i++){
				// echo "<h1>Nom de l'élève : ".$listeEleve[$i]['nom_complet']."</h1>";
				$idEleve = $listeEleve[$i]['id'];
				$absEleve = $this->viewAbsenceEleve($idEleve);
				if(!empty($absEleve)){
					// echo '<pre>'; print_r($absEleve); echo '</pre>';
					for($x=0;$x<count($absEleve);$x++){
						$absenceEleveNJ[$idEleve][] = $absEleve[$x]['nombre_heure'];
						$absenceEleveJ[$idEleve][] = $absEleve[$x]['justification'];
					}
					$nonJustif = array_sum($absenceEleveNJ[$idEleve]);
					$justif = array_sum($absenceEleveJ);
					$nj = $nonJustif - $justif;
					$update = $this->_db->prepare("UPDATE $nomTable SET 
													absence_total =:absence,
													absence_non_just =:absenceNJ,
													absence_just =:absenceJ 
													WHERE id_eleve =:eleve");
					$update->bindValue(':absence',$nonJustif);
					$update->bindValue(':absenceNJ',$nj);
					$update->bindValue(':absenceJ',$justif);
					$update->bindValue(':eleve',$idEleve);
					$update->execute();
					// echo "<p>Heures Non Just ".$nonJustif." et Heures Just : ".$justif."</p>";
				}
				
			}
		}








		/**
		 * @param string $source la page d'origine 
		 * @param int $trimestre qui est le trimestre de traitement
		 * @param int $classe qui est la classe à traiter 
		 * L'objet de la fonction est d'intervenir une fois qu'on a cliqué sur 
		 * le bouton traiter Note Trimstrielles
		 */
		public function traiterNoteTrimestre($source, $trimestre, $classe){
			$this->_periode = $this->setUserId($trimestre);
			$this->_classe = $this->setUserId($classe);
			$infoClasse = $this->getClasse($this->_classe);
			$table = 'trimestre_'.$this->_periode.'_'.$this->_classe;
			// On crée la table et on y ajoute les noms des élèves
			$this->prepaTableTrimestre($this->_periode, $this->_classe,$table);
			$this->addEleveTable($this->_classe, $table);
			// On intègre les notes séquentielles de l'élève au besoin
			if($this->_periode==1){
				$sequence[0] = 1;
				$sequence[1] = 2;
			}elseif($this->_periode==2){
				$sequence[0] = 3;
				$sequence[1] = 4;
			}elseif($this->_periode==3){
				$sequence[0] = 5;
				$sequence[1] = 6;
			}
			$this->addDataTrimestre($this->_classe, $sequence, $table);

			// On produit les Notes Trimestrielles par matière
			$listeEleve = $this->listeEleve($classe, 'non_supprime','');
			for($i=0;$i<count($listeEleve);$i++){
				$idEleve = $listeEleve[$i]['id'];
				$this->calculNoteTrimestre($this->_periode, $classe, $idEleve);
			}
			// On génère les minimum, maximum et rang pour chaque matière présente
			$this->addRankMinMaxTrimestre($this->_classe, $table);
			// On introduit les heures d'absence
			$this->addHeureAbsence($this->_classe, $this->_periode, 'trimestre');
			// On enregistre le traitement
			$req_delete = $this->_db->prepare("DELETE FROM bull_trim 
											WHERE classe=:classe AND
											trimestre = :trimestre");
			$req_delete->bindValue(':trimestre', $this->_periode);
			$req_delete->bindValue(':classe', $this->_classe);
			$req_delete->execute();

			$req_traite = $this->_db->prepare("INSERT INTO bull_trim SET 
												pret=:pret, 
												classe=:classe,
												trimestre=:trimestre");
			$req_traite->bindValue(':pret', 'oui');
			$req_traite->bindValue(':trimestre', $this->_periode);
			$req_traite->bindValue(':classe', $this->_classe);
			$req_traite->execute();
			
			// Quand tout se termine, on affiche le message
			$_SESSION['message'] = 'Notes du trimestre '.$this->_periode;
			$_SESSION['message'] .= ' traitées pour la '.$infoClasse['nom_classe'];
			header('Location:'.$source);



			
			
			// Après avoir crée la table, on insère les noms des élèves dans 
			// la table créée.
			
			// for($c=0;$c<count($listeEleve);$c++){
			// 	$req_3 = $this->_db->query($sql_insert);
			// 	/*En fonction du trimestre on récupère les notes séquentielles pour 
			// 	faire les calculs et appliquer un coefficient ainsi que les 
			// 	moyennes par matières et appréciation qui s'imposent */
			// 	if($trimestre==1){
			
			
					
			// 		// On Introduit les heures d'Absence qu'il faut  
			// 		$absences = $this->calculAbsenceTrimestre($idEleve,1);
			// 		$sql_10 = "UPDATE $table SET 
			// 					absence_total = '".$absences['total']."',
			// 					absence_non_just = '".$absences['non_justif']."',
			// 					absence_just = '".$absences['justif']."'
			// 					WHERE id_eleve = '$idEleve'";
			// 		$this->_db->query($sql_10);
			// 		// print_r($absences);
					
			// 		$_SESSION['message'] = "Notes du Trimestre ";
			// 		$_SESSION['message'] .= $trimestre." traitées";
			// 		header('Location: '.$source);
			// 	}
			// 	elseif($trimestre==2){
			// 		// On introduit les notes de la 3ème Séquence 
			// 		$sequence_3 = $this->viewNoteSequentielleEleve($classe,
			// 														3,
			// 														$idEleve);					
			// 		for($d=0;$d<count($sequence_3);$d++){
			// 			$mat = $sequence_3[$d]['id_matiere'];
			// 			$note = $sequence_3[$d]['note_simple'];
			// 			$prof = $sequence_3[$d]['sexe_enseignant']." ";
			// 			$prof .= strtoupper($sequence_3[$d]['nom_enseignant'])." ";
			// 			$prof .= ucwords($sequence_3[$d]['prenom_enseignant']);
			// 			/*$sql_upd = "UPDATE $table SET ";
			// 			$sql_upd .= $mat."_seq1 = '$note',";
			// 			$sql_upd .= $mat."_enseignant = '$prof'";
			// 			$sql_upd .= " WHERE id_eleve = '$idEleve'; ";*/
						
			// 			$sql_upd = "UPDATE $table SET ";
			// 			$sql_upd .= $mat."_seq1 = '$note',";
			// 			$sql_upd .= $mat."_enseignant = '$prof'";
			// 			$sql_upd .= " WHERE id_eleve = '$idEleve'; ";
			// 			$req_4 = $this->_db->query($sql_upd);
			// 		}
					
			// 		// On introduit les notes de la 4ème Séquence 
			// 		$sequence_4 = $this->viewNoteSequentielleEleve($classe,
			// 														4, 
			// 														$idEleve);
			// 		for($e=0;$e<count($sequence_4);$e++){
			// 			$mat1 = $sequence_4[$e]['id_matiere'];
			// 			$note1 = $sequence_4[$e]['note_simple'];
			// 			$prof1 = $sequence_4[$e]['sexe_enseignant']." ";
			// 			$prof1 .= strtoupper($sequence_4[$e]['nom_enseignant'])." ";
			// 			$prof1 .= ucwords($sequence_4[$e]['prenom_enseignant']);
			// 			$sql_upd1 = "UPDATE $table SET ";
			// 			$sql_upd1 .= $mat1."_seq2 = '$note1',";
			// 			$sql_upd1 .= $mat1."_enseignant = '$prof1'";
			// 			$sql_upd1 .= " WHERE id_eleve = '$idEleve'; ";
			// 			$req_5 = $this->_db->query($sql_upd1);
			// 		}
					
			// 		// On produit les Notes Trimestrielles par matière 
			// 		$this->calculNoteTrimestre(2, $classe, $idEleve);
			// 		$req_traite = "INSERT INTO bull_trim(pret, classe, trim) ";
			// 		$req_traite .= "VALUES('oui', '$classe', '$trimestre')";
			// 		$req_traite_del = "DELETE FROM bull_trim";
			// 		$req_traite_del .= " WHERE classe='$classe' 
			// 								AND trim='$trimestre'";
			// 		$exec_traite_del = $this->_db->query($req_traite_del);
			// 		$exec_traite = $this->_db->query($req_traite);
					
			// 		// On Introduit les heures d'Absence qu'il faut  
			// 		$absences = $this->calculAbsenceTrimestre($idEleve,2);
			// 		$sql_10 = "UPDATE $table SET 
			// 					absence_total = '".$absences['total']."',
			// 					absence_non_just = '".$absences['non_justif']."',
			// 					absence_just = '".$absences['justif']."'
			// 					WHERE id_eleve = '$idEleve'";
			// 		$this->_db->query($sql_10);
			// 		// print_r($absences);
					
			// 		$_SESSION['message'] = "Notes du Trimestre ";
			// 		$_SESSION['message'] .= $trimestre." traitées";
			// 		header('Location: '.$source);
			// 	}
			// 	elseif($trimestre==3){
			// 		// On introduit les notes de la 5ème Séquence 
			// 		$sequence_5 = $this->viewNoteSequentielleEleve($classe,
			// 														5,
			// 														$idEleve);					
			// 		for($d=0;$d<count($sequence_5);$d++){
			// 			$mat = $sequence_5[$d]['id_matiere'];
			// 			$note = $sequence_5[$d]['note_simple'];
			// 			$prof = $sequence_5[$d]['sexe_enseignant']." ";
			// 			$prof .= strtoupper($sequence_5[$d]['nom_enseignant'])." ";
			// 			$prof .= ucwords($sequence_5[$d]['prenom_enseignant']);
			// 			$sql_upd = "UPDATE $table SET ";
			// 			$sql_upd .= $mat."_seq1 = '$note',";
			// 			$sql_upd .= $mat."_enseignant = '$prof'";
			// 			$sql_upd .= " WHERE id_eleve = '$idEleve'; ";
			// 			$req_4 = $this->_db->query($sql_upd);
			// 		}
					
			// 		// On duplique les Notes de la Séquence 5 à la Séquence 6 
			// 		$sequence_6 = $this->viewNoteSequentielleEleve($classe,
			// 														6, 
			// 														$idEleve);
			// 		for($e=0;$e<count($sequence_6);$e++){
			// 			$mat1 = $sequence_6[$e]['id_matiere'];
			// 			$note1 = $sequence_6[$e]['note_simple'];
			// 			$prof1 = $sequence_6[$e]['sexe_enseignant']." ";
			// 			$prof1 .= strtoupper($sequence_6[$e]['nom_enseignant'])." ";
			// 			$prof1 .= ucwords($sequence_6[$e]['prenom_enseignant']);
			// 			$sql_upd1 = "UPDATE $table SET ";
			// 			$sql_upd1 .= $mat1."_seq2 = '$note1',";
			// 			$sql_upd1 .= $mat1."_enseignant = '$prof1'";
			// 			$sql_upd1 .= " WHERE id_eleve = '$idEleve'; ";
			// 			$req_5 = $this->_db->query($sql_upd1);
			// 		}
					
			// 		// On produit les Notes Trimestrielles par matière 
			// 		$this->calculNoteTrimestre(3, $classe, $idEleve);
			// 		$req_traite = "INSERT INTO bull_trim(pret, classe, trim) ";
			// 		$req_traite .= "VALUES('oui', '$classe', '$trimestre')";
			// 		$req_traite_del = "DELETE FROM bull_trim";
			// 		$req_traite_del .= " WHERE classe='$classe' 
			// 								AND trim='$trimestre'";
			// 		$exec_traite_del = $this->_db->query($req_traite_del);
			// 		$exec_traite = $this->_db->query($req_traite);
					
			// 		// On Introduit les heures d'Absence qu'il faut  
			// 		$absences = $this->calculAbsenceTrimestre($idEleve,3);
			// 		$sql_10 = "UPDATE $table SET 
			// 					absence_total = '".$absences['total']."',
			// 					absence_non_just = '".$absences['non_justif']."',
			// 					absence_just = '".$absences['justif']."'
			// 					WHERE id_eleve = '$idEleve'";
			// 		$this->_db->query($sql_10);
			// 		// print_r($absences);
					
			// 		$_SESSION['message'] = "Notes du Trimestre ";
			// 		$_SESSION['message'] .= $trimestre." traitées";
			// 		header('Location: '.$source);
			// 	}
								
			// }
		}






		private function prepaTableTrimestre($periode, $classe, $table){
			// echo '<pre>'; print_r($infoClasse); echo '</pre>';
			$sql_prepa = "CREATE TABLE $table (";
			$sql_prepa .= "id int(11) auto_increment primary key, ";
			$sql_prepa .= "id_eleve int(11) not null, ";
			$sql_prepa .= "rne TEXT  null, ";
			$sql_prepa .= "nom_eleve TEXT not null, ";
			$sql_prepa .= "sexe TEXT null, ";
			$sql_prepa .= "date_en date null, ";
			$sql_prepa .= "date_fr TEXT null, ";
			$sql_prepa .= "lieu_naissance TEXT null, ";
			$sql_prepa .= "adresse_parent TEXT null, ";
			$sql_prepa .= "statut TEXT null, ";
			$sql_prepa .= "photo TEXT null, ";
			$listeMatiere = $this->listeMatiereClasse($classe);
			
			for($a=0;$a<count($listeMatiere);$a++){
				$matiere = strtolower($listeMatiere[$a]['code_matiere']);
				$req_creation_0 = "`".$matiere."_seq1` DECIMAL(4,2) NULL, ";
				$req_creation_1 = "`".$matiere."_seq2` DECIMAL(4,2) NULL, ";
				$req_creation_2 = "`".$matiere."_trim` DECIMAL(4,2) NULL, ";
				$req_creation_3 = "`".$matiere."_coef` decimal(4,2) NULL, ";
				$req_creation_4 = "`".$matiere."_total` decimal(5,2) NULL, ";
				$req_creation_5 = "`".$matiere."_competence_a` TEXT NULL, ";
				$req_creation_6 = "`".$matiere."_competence_b` TEXT NULL, ";
				$req_creation_7 = "`".$matiere."_min` decimal(4,2) NULL, ";
				$req_creation_8 = "`".$matiere."_max` decimal(4,2) NULL, ";
				$req_creation_9 = "`".$matiere."_appreciation` TEXT  null, ";
				$req_creation_10 = "`".$matiere."_cote` TEXT  null, ";
				$req_creation_11 = "`".$matiere."_enseignant` TEXT  null, ";
				$req_creation_12 = "`".$matiere."_rank` int(11) null, ";

				$sql_prepa .= $req_creation_0;
				$sql_prepa .= $req_creation_1;
				$sql_prepa .= $req_creation_2;
				$sql_prepa .= $req_creation_3;
				$sql_prepa .= $req_creation_4;
				$sql_prepa .= $req_creation_5;
				$sql_prepa .= $req_creation_6;
				$sql_prepa .= $req_creation_7;
				$sql_prepa .= $req_creation_8;
				$sql_prepa .= $req_creation_9;
				$sql_prepa .= $req_creation_10;
				$sql_prepa .= $req_creation_11;
				$sql_prepa .= $req_creation_12;
			}
			$groupe = $this->getGroupeClasse($classe);
			// echo '<pre>'; print_r($groupe); echo '</pre>';
			for($b=0;$b<count($groupe);$b++){
				$gp = $groupe[$b]['code_groupe'];
				$sql_prepa .= $gp."_total float(5,2) NULL, ";
				$sql_prepa .= $gp."_coef float(4,2) NULL, ";
				$sql_prepa .= $gp."_moyenne float(4,2) NULL, ";
				$sql_prepa .= $gp."_min float(4,2) NULL, ";
				$sql_prepa .= $gp."_max float(4,2) NULL, ";
				$sql_prepa .= $gp."_appreciation TEXT NULL, ";
				$sql_prepa .= $gp."_cote TEXT NULL, ";
				$sql_prepa .= $gp."_rank int(11) NULL, ";
			}
			$sql_prepa .= "total_point float(5,2) NULL, ";
			$sql_prepa .= "total_coef float(4,2) NULL, ";
			$sql_prepa .= "moyenne float(4,2) NULL, ";
			$sql_prepa .= "min float(4,2) NULL, ";
			$sql_prepa .= "max float(4,2) NULL, ";
			$sql_prepa .= "appreciation TEXT NULL, ";
			$sql_prepa .= "cote TEXT NULL, ";
			$sql_prepa .= "classes int(11), ";
			$sql_prepa .= "rang TEXT null, ";
			$sql_prepa .= "absence_total int(11) null, ";
			$sql_prepa .= "absence_non_just int(11) null, ";
			$sql_prepa .= "absence_just int(11) null, ";
			$sql_prepa .= "titulaire TEXT null ";
			$sql_prepa .= ")";
			$sql_del = "DROP TABLE IF EXISTS $table";
			$this->_db->query($sql_del); 
			$this->_db->query($sql_prepa);
		}









		private function addDataTrimestre($classe, $periode, $table){
			$listeEleve = $this->listeEleve($classe, 'non_supprime','');
			$section = $this->getSectionClasse($classe);
			for($c=0;$c<count($listeEleve);$c++){
				$idEleve = $listeEleve[$c]['id'];
				$sequenceImpaire = $periode[0];
				$sequencePaire = $periode[1];

				$sequence_1 = $this->viewNoteSequentielleEleve($classe, $sequenceImpaire, $idEleve);
				$sequence_2 = $this->viewNoteSequentielleEleve($classe, $sequencePaire, $idEleve);
				// echo '<pre>'; print_r($sequence_2); echo '</pre>';
				// On introduit les notes de la Séquence impaire
				if(!empty($sequence_1)){
					for($d=0;$d<count($sequence_1);$d++){
						$mat = $sequence_1[$d]['code_matiere'];
						$idMatiere = $sequence_1[$d]['id_matiere'];
						$competence = $this->getCompetence($classe, $idMatiere, $sequenceImpaire);
						$note = $sequence_1[$d]['note'];
						$champSequence = $mat.'_seq1';
						$champCompetence = $mat.'_competence_a';
						$champEnseignant = $mat.'_enseignant';
						$enseignant = $this->getEnseignantMatiere($idMatiere, $classe);
						$updSeq1 = $this->_db->prepare("UPDATE `$table` SET 
													`$champSequence` =:sequence,
													$champCompetence =:competence,
													$champEnseignant =:enseignant
													WHERE id_eleve = :eleve");
						$updSeq1->bindValue(':sequence',$note);
						$updSeq1->bindValue(':competence',$competence['competence']);
						$updSeq1->bindValue(':eleve',$idEleve);
						$updSeq1->bindValue(':enseignant',$enseignant);
						$updSeq1->execute();
					}
				}
				// On introduit les notes de la Séquence paire
				if(!empty($sequence_2)){
					for($e=0;$e<count($sequence_2);$e++){
						$mat = $sequence_2[$e]['code_matiere'];
						$idMatiere = $sequence_2[$e]['id_matiere'];
						$competence = $this->getCompetence($classe, $idMatiere, $sequencePaire);
						$note = $sequence_2[$e]['note'];
						$champSequence = $mat.'_seq2';
						$champCompetence = $mat.'_competence_b';
						$champEnseignant = $mat.'_enseignant';
						$enseignant = $this->getEnseignantMatiere($idMatiere, $classe);
						$updSeq2 = $this->_db->prepare("UPDATE `$table` SET 
													`$champSequence` =:sequence,
													$champCompetence =:competence,
													$champEnseignant =:enseignant
													WHERE id_eleve = :eleve");
						$updSeq2->bindValue(':sequence',$note);
						$updSeq2->bindValue(':competence',$competence['competence']);
						$updSeq2->bindValue(':eleve',$idEleve);
						$updSeq2->bindValue(':enseignant',$enseignant);
						$updSeq2->execute();
					}
				}
			}
		}









		// On calcule la note trimestrielle d'une matière
		protected function calculNoteTrimestre($trimestre, $classe, $eleve){
			$table = "trimestre_".$trimestre."_".$classe;
			$listeMatiere = $this->listeMatiereClasse($classe);
			$section = $this->getSectionClasse($classe);
			for($a=0;$a<count($listeMatiere);$a++){
				$idMatiere = $listeMatiere[$a]['id_matiere'];
				$codeMatiere = strtolower($listeMatiere[$a]['code_matiere']);
				$coefMatiere = $listeMatiere[$a]['coef'];
				$champSeq1 = $codeMatiere.'_seq1';
				$champSeq2 = $codeMatiere.'_seq2';
				$champTrim = $codeMatiere.'_trim';
				$champCoef = $codeMatiere.'_coef';
				$champTotal = $codeMatiere.'_total';
				$champCote = $codeMatiere.'_cote';
				$champAppreciation = $codeMatiere.'_appreciation';

				$sql = "SELECT $champSeq1, $champSeq2
						FROM $table
						WHERE id_eleve = '$eleve'";
				$requete = $this->_db->query($sql);
				$res = $requete->fetchAll(PDO::FETCH_ASSOC);
				// echo '<pre>';print_r($res);
				for($b=0;$b<count($res);$b++){
					if(empty($res[$b][$champSeq1]) or empty($res[$b][$champSeq2])){
						$trim = $res[$b][$champSeq1] + $res[$b][$champSeq2];
						$noteTri = $this->setNote($trim);
						if(empty($noteTri)){
							$totalTri = NULL;
							$coefTri = NULL;
							$appr = NULL;
							$cote = NULL;
						}
						else{
							$coefTri = $listeMatiere[$a]['coef'];
							$totalTri = $noteTri*$coefTri;
							$appreciation = $this->showAppreciation($noteTri);
							$cle = 'nom_appreciation_'.$section;
							$appr = strtoupper($appreciation[$cle]);
							$cote = strtoupper($appreciation['cote']);
						}
					}else{
						$trim = ($res[$b][$champSeq1] + $res[$b][$champSeq2]) / 2;
						$noteTri = $this->setNote($trim);
						$coefTri = $listeMatiere[$a]['coef'];
						$totalTri = $noteTri*$coefTri;
						$appreciation = $this->showAppreciation($noteTri);
						$cle = 'nom_appreciation_'.$section;
						$appr = strtoupper($appreciation[$cle]);
						$cote = strtoupper($appreciation['cote']);
					}
					$update = $this->_db->prepare("UPDATE $table SET 
											$champTrim = :noteTri,
											$champCoef = :coef, 
											$champTotal = :total,
											$champCote =:cote,
											$champAppreciation =:appr
											WHERE id_eleve =:eleve");
					$update->bindValue(':noteTri',$noteTri);
					$update->bindValue(':coef',$coefTri);
					$update->bindValue(':total',$totalTri);
					$update->bindValue(':cote',$cote);
					$update->bindValue(':appr',$appr);
					$update->bindValue(':eleve', $eleve);
					$update->execute();
				}
			}
		}









		private function addRankMinMaxTrimestre($classe, $table){
			$listeMatiere = $this->listeMatiereClasse($classe);
			// echo '<pre>'; print_r($listeMatiere); echo '</pre>';
			for($i=0;$i<count($listeMatiere);$i++){
				$idMatiere = $listeMatiere[$i]['id'];
				$codeMatiere = $listeMatiere[$i]['code_matiere'];
				$champCible = strtolower($codeMatiere.'_trim');
				$champMin = strtolower($codeMatiere.'_min');
				$champMax = strtolower($codeMatiere.'_max');
				$champRank =  strtolower($codeMatiere.'_rank');
				$min = $this->getMinMatiere($champCible,$table);
				$max = $this->getMaxMatiere($champCible, $table);
				/*$rank  = $this->getRankMatiere($codeMatiere, $table, $champCible);
				print_r($rank);*/
				$requete  = $this->_db->prepare("UPDATE $table SET 
							$champMin =:min,
							$champMax = :max
							");
				$requete->bindValue(':min', $min);
				$requete->bindValue(':max', $max);
				$requete->execute();
			}
		}








		// Les Statistiques relatives à une classe pour une matière donnée 
		public function statClasse($matiere, $periode, $classe){
			$this->_matiere = $this->getMatiere($this->setUserId($matiere));
			$codeMatiere = $this->_matiere['code_matiere'];
			// Effectif de la Classe
			$eff = $this->listeEleveStat($classe, 'non_supprime', '');
			// Effectif Evalué
			$nbEval = $this->nbEvaluesMatiereTrimestre($classe, $codeMatiere, $periode);
			// Effectif Evalué ayant eu la moyenne
			$nbMoy = $this->nbMoyenneMatiereTrimestre($classe, $codeMatiere, $periode);
			// Taux de réussite
			if($nbEval['Masc']!=0){
				$tauxGarcon = $nbMoy['Masc'] * 100 / $nbEval['Masc'];
			}else{$tauxGarcon='';}
			if($nbEval['Fem']!=0){
				$tauxFille = $nbMoy['Fem'] * 100 / $nbEval['Fem'];
			}else{$tauxFille='';}
			if($nbEval['total']!=0){
				$tauxGlobal = $nbMoy['total'] * 100 / $nbEval['total'];
			}else{$tauxGlobal='';}			
			// Notes Maximales et Minimales
			$minMax = $this->minMaxMatiereTrimestre($classe, $codeMatiere, $periode);
			// Moyennes Générales par matières 
			$moyGen = $this->moyenneMatiereTrimestre($classe, $codeMatiere, $periode);													
			$effectif = array(
								'effM'=>$eff['G'],
								'effF'=>$eff['F'],
								'effT'=>$eff['T'],
								'evalM'=>$nbEval['Masc'],
								'evalF'=>$nbEval['Fem'],
								'evalT'=>$nbEval['total'],
								'moyM'=>$nbMoy['Masc'],
								'moyF'=>$nbMoy['Fem'],
								'moyT'=>$nbMoy['total'],
								'tauxM'=>substr($tauxGarcon,0,5),
								'tauxF'=>substr($tauxFille,0,5),
								'tauxT'=>substr($tauxGlobal,0,5),
								'maxM'=>$minMax['max']['Masc'],
								'maxF'=>$minMax['max']['Fem'],
								'maxT'=>$minMax['max']['total'],
								'minM'=>$minMax['min']['Masc'],
								'minF'=>$minMax['min']['Fem'],
								'minT'=>$minMax['min']['total'],
								'mgM'=>round($moyGen['Masc'],2),
								'mgF'=>round($moyGen['Fem'],2),
								'mgT'=>round($moyGen['total'],2)
								);
			return $effectif;
		}



		// Ceux qui ont été évalués dans une matière par genre
		public function nbEvaluesMatiereTrimestre($classe,$matiere, $periode){
			$table = 'trimestre_'.$periode.'_'.$classe;
			$champ = $matiere.'_trim';
			$masc = "SELECT count($champ) as masculin
					FROM $table
					WHERE $champ>0
						AND sexe='M'";
			$reqMasc = $this->_db->query($masc);
			$resMasc = $reqMasc->fetch(PDO::FETCH_ASSOC);
			if(empty($resMasc)){$resMasc = NULL;}

			$fem = "SELECT count($champ) as feminin
					FROM $table
					WHERE $champ>0
						AND sexe='F'";
			$reqFem = $this->_db->query($fem);
			$resFem = $reqFem->fetch(PDO::FETCH_ASSOC);
			if(empty($resFem)){$resFem = NULL;}
			

			$res['Masc'] = $resMasc['masculin'];
			$res['Fem'] = $resFem['feminin'];
			$res['total'] = $res['Masc'] + $res['Fem'];
			return $res;
		}








		// Ceux qui ont été évalués et ont eu la moyenne dans une matière par genre
		public function nbMoyenneMatiereTrimestre($classe,$matiere, $periode){
			$table = 'trimestre_'.$periode.'_'.$classe;
			$champ = $matiere.'_trim';
			$masc = "SELECT count($champ) as masculin
					FROM $table
					WHERE $champ>=10
						AND sexe='M'";
			$reqMasc = $this->_db->query($masc);
			$resMasc = $reqMasc->fetch(PDO::FETCH_ASSOC);
			if(empty($resMasc)){$resMasc = NULL;}

			$fem = "SELECT count($champ) as feminin
					FROM $table
					WHERE $champ>=10
						AND sexe='F'";
			$reqFem = $this->_db->query($fem);
			$resFem = $reqFem->fetch(PDO::FETCH_ASSOC);
			if(empty($resFem)){$resFem = NULL;}
			

			$res['Masc'] = $resMasc['masculin'];
			$res['Fem'] = $resFem['feminin'];
			$res['total'] = $res['Masc'] + $res['Fem'];
			return $res;
		}









		// La plus grande note obtenue dans la matière pour le trimestre
		public function minMaxMatiereTrimestre($classe,$matiere, $periode){
			$table = 'trimestre_'.$periode.'_'.$classe;
			$champMin = $matiere.'_min';
			$champMax = $matiere.'_max';
			$champ = $matiere.'_trim';
			$sqlMin = "SELECT $champMin as minimum
						FROM $table";
			$reqMin = $this->_db->query($sqlMin);
			$resMin = $reqMin->fetch(PDO::FETCH_ASSOC);

			$sqlMax = "SELECT $champMax as maximum
						FROM $table";
			$reqMax = $this->_db->query($sqlMax);
			$resMax = $reqMax->fetch(PDO::FETCH_ASSOC);

			$sqlMaxM = "SELECT MAX($champ) as maxM
						FROM $table
						WHERE $champ>0 
							AND sexe='M'";
			$reqMaxM = $this->_db->query($sqlMaxM);
			$resMaxM = $reqMaxM->fetch(PDO::FETCH_ASSOC);

			$sqlMaxF = "SELECT MAX($champ) as maxF
						FROM $table
						WHERE $champ>0 
							AND sexe='F'";
			$reqMaxF = $this->_db->query($sqlMaxF);
			$resMaxF = $reqMaxF->fetch(PDO::FETCH_ASSOC);

			$sqlMinM = "SELECT MIN($champ) as minM
						FROM $table
						WHERE $champ>0 
							AND sexe='M'";
			$reqMinM = $this->_db->query($sqlMinM);
			$resMinM = $reqMinM->fetch(PDO::FETCH_ASSOC);

			$sqlMinF = "SELECT MIN($champ) as minF
						FROM $table
						WHERE $champ>0 
							AND sexe='F'";
			$reqMinF = $this->_db->query($sqlMinF);
			$resMinF = $reqMinF->fetch(PDO::FETCH_ASSOC);

			
			$res['min']['total'] = $resMin['minimum'];
			$res['min']['Masc'] = $resMinM['minM'];
			$res['min']['Fem'] = $resMinF['minF'];
			$res['max']['total'] = $resMax['maximum'];
			$res['max']['Masc'] = $resMaxM['maxM'];
			$res['max']['Fem'] = $resMaxF['maxF'];
			return $res;
		}









		// La moyenne générale obtenue dans la matière pour le trimestre
		public function moyenneMatiereTrimestre($classe,$matiere, $periode){
			$table = 'trimestre_'.$periode.'_'.$classe;
			$champ = $matiere.'_trim';
			$sql = "SELECT AVG($champ) as moyenne 
					FROM $table
					WHERE $champ>0";
			$req = $this->_db->query($sql);
			$res = $req->fetch(PDO::FETCH_ASSOC);
			$resultat['total'] = $res['moyenne'];

			$sqlFem = "SELECT AVG($champ) as moyenneFem
					FROM $table
					WHERE $champ>0
						AND sexe = 'F'";
			$reqFem = $this->_db->query($sqlFem);
			$resFem = $reqFem->fetch(PDO::FETCH_ASSOC);
			$resultat['Fem'] = $resFem['moyenneFem'];

			$sqlM = "SELECT AVG($champ) as moyenneM 
					FROM $table
					WHERE $champ>0
						AND sexe='M'";
			$reqM = $this->_db->query($sqlM);
			$resM = $reqM->fetch(PDO::FETCH_ASSOC);
			$resultat['total'] = $res['moyenne'];
			$resultat['Masc'] = $resM['moyenneM'];
			/*$champMin = $matiere.'_min';
			$champMax = $matiere.'_max';
			$champ = $matiere.'_trim';
			$sqlMin = "SELECT $champMin as minimum
						FROM $table";
			$reqMin = $this->_db->query($sqlMin);
			$resMin = $reqMin->fetch(PDO::FETCH_ASSOC);

			$sqlMax = "SELECT $champMax as maximum
						FROM $table";
			$reqMax = $this->_db->query($sqlMax);
			$resMax = $reqMax->fetch(PDO::FETCH_ASSOC);

			$sqlMaxM = "SELECT MAX($champ) as maxM
						FROM $table
						WHERE $champ>0 
							AND sexe='M'";
			$reqMaxM = $this->_db->query($sqlMaxM);
			$resMaxM = $reqMaxM->fetch(PDO::FETCH_ASSOC);

			$sqlMaxF = "SELECT MAX($champ) as maxF
						FROM $table
						WHERE $champ>0 
							AND sexe='F'";
			$reqMaxF = $this->_db->query($sqlMaxF);
			$resMaxF = $reqMaxF->fetch(PDO::FETCH_ASSOC);

			$sqlMinM = "SELECT MIN($champ) as minM
						FROM $table
						WHERE $champ>0 
							AND sexe='M'";
			$reqMinM = $this->_db->query($sqlMinM);
			$resMinM = $reqMinM->fetch(PDO::FETCH_ASSOC);

			$sqlMinF = "SELECT MIN($champ) as minF
						FROM $table
						WHERE $champ>0 
							AND sexe='F'";
			$reqMinF = $this->_db->query($sqlMinF);
			$resMinF = $reqMinF->fetch(PDO::FETCH_ASSOC);

			
			$res['min']['total'] = $resMin['minimum'];
			$res['min']['Masc'] = $resMinM['minM'];
			$res['min']['Fem'] = $resMinF['minF'];
			$res['max']['total'] = $resMax['maximum'];
			$res['max']['Masc'] = $resMaxM['maxM'];
			$res['max']['Fem'] = $resMaxF['maxF'];*/
			return $resultat;
		}











		// On Justifie les Absences d'un élève
		public function updateAbsenceEleve($source, $id){
			$justif = $id['just'];
			for($i=0;$i<count($justif);$i++){
				if(!empty($justif[$i])){
					$ligne = $id['ligne'][$i];
					$justification = $justif[$i];
					// On additionne à la précédente justification existante
					$returnValue = $this->ligneJustifiee($ligne);
					$addition = (int) $returnValue + (int) $justification;
					
					$req = $this->_db->prepare("UPDATE absence SET 
										justification =:just 
										WHERE id=:id");
					$req->bindValue(':just',$addition);
					$req->bindValue(':id',$ligne);
					$req->execute();
					$_SESSION['message'] = 'Absence(s) justifée(s)';
				}
			}
			header('Location:'.$source);
		}



		private function ligneJustifiee($ligne){
			$sql = "SELECT justification FROM absence WHERE id='$ligne'";
			$req = $this->_db->query($sql);
			$res = $req->fetch(PDO::FETCH_ASSOC);
			return $res['justification'];
		}



























		
		
		
		
		
		
		
		
		
		
		
		public function updateApp(){
			/*$requete_1 = "UPDATE groupe SET 
						nom_groupe = 'Enseignements Professionnels'
						WHERE code_groupe = 'gp1'";
			$this->_db->query($requete_1);
			$requete_2 = "UPDATE groupe SET 
						nom_groupe = 'Enseignements Generaux'
						WHERE code_groupe = 'gp2'";
			$this->_db->query($requete_2);
			$requete_3 = "UPDATE groupe SET 
						nom_groupe = 'Enseignements Complémentaires'
						WHERE code_groupe = 'gp3'";
			$this->_db->query($requete_3);*/
			/*$sql = "SELECT * 
					FROM groupe";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			return $res;*/
		}
		
		
		/* Arranger les noms et prénoms des enseignants 
		public function arranger($users){
			$user = (int) $users;
			$utilisateur = $this->getUser($user);
			$name = strtoupper($utilisateur['nom']);
			$fname = strtolower($utilisateur['prenom']);
			$nom = $name.' '.ucwords($fname);
			echo '<pre>';print_r($utilisateur); echo '</pre>';
			$update = "UPDATE enseignant SET nom = '".$nom."', prenom ='' WHERE id ='".$user."'";
			$this->_db->query($update);
			echo $update;
		}*/
		
		
		/* Arranger les noms et prenoms des élèves */
		/*public function arranger(){
			$classe = '5e';
			$sql = "SELECT * 
					FROM eleve 
					WHERE classe = '".$classe."' 
					ORDER BY nom";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			echo '<pre>'; print_r($res); echo '</pre>';
			for($i=0;$i<count($res);$i++){
				$name = strtoupper($res[$i]['nom']);
				$fname = strtolower($res[$i]['prenom']);
				$nom = $name.' '.ucwords($fname);
				$id = $res[$i]['id'];
				$requete = "UPDATE eleve SET nom_complet ='".$nom."', classe = '2', add_by='2', add_date = '2025-09-19 15:38:40',
							nom='', prenom=''
							WHERE id = '".$id."'";
				$this->_db->query($requete);
				// echo $requete.'<br />';
				// echo $nom.' a pour id '.$id.'<br />';
			}
		}*/
		
		
	}