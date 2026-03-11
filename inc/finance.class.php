<?php 
    class Finance extends Config {

        private $_db;

        public function __construct($db){
            $this->setDb($db);
        }

        public function setDb(PDO $db){
            $this->_db = $db;
        }


        public function nomRubrique(){return $this->_nomRubrique;}
		public function codeRubrique(){return $this->_codeRubrique;}
		public function etatRubrique(){return $this->_etatRubrique;}


        /**
         * LES SETTERS 
         */
        /***************************************************************
		******************************************************************
		***********  		LES SETTERS OU MUTATEURS 		*************
		*******************************************************************
		***************************************************************/
		public function setCodeRubrique($rubrique){
			$this->_rubrique = (string) str_replace(' ','_',$rubrique);
			if(strlen($this->_rubrique)<=0){
				$this->_rubrique = 'Rubrique';
			}elseif(strlen($this->_rubrique)<=2){
				$this->_rubrique .= '_';
			}else{
				$this->_rubrique = utf8_encode($this->_rubrique);
			}
			return addslashes($this->_rubrique);
		}
		
		
		
		
		
		
		
		
		
		public function setNomRubrique($rubrique){
			$this->_rubrique = (string) str_replace(' ','_',$rubrique);
			if(strlen($this->_rubrique)<=0){
				$this->_rubrique = 'Rubrique';
			}elseif(strlen($this->_rubrique)<=4){
				$this->_rubrique .= '_';
			}else{
				$this->_rubrique = utf8_encode($this->_rubrique);
			}
			return addslashes($this->_rubrique);
		}
		
		
		
		
		
		
		
		/************************************************************
		********   On vérifie qu'un rubrique existe déjà ou pas *****
		************************************************************/
		
		private function verifRubrique($code, $libelle){
			$sql = "SELECT *
					FROM rubrique_finance
					WHERE code_rubrique = '$code'
						OR nom_rubrique = '$libelle'
					ORDER BY code_rubrique";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}
		
		
		protected function checkInfo($nom, $table, $champ){
			$sql = "SELECT $champ 
					FROM $table 
					WHERE $champ = '$nom'";
			$req = $this->_db->query($sql);
			$res = $req->fetch(PDO::FETCH_ASSOC);
			return $res;
		}
		
		
		
		
		
		
		
		
		/******************************************************************
		*******************************************************************
		******** 	on ajoute une rubrique ********************************
		*******************************************************************
		******************************************************************/
		
		public function ajouterRubrique($source, $info){
			echo '<pre>'; print_r($info); echo '</pre>';
            $this->_code = $this->setCodeRubrique($info['codeRubrique']);
            $this->_nom = $this->setNomRubrique($info['nomRubrique']);
            if($this->_code=='Rubrique'){
                $_SESSION['message'] = 'Le Code de la Rubrique doit contenir des valeurs';
                header('Location:'.$source);
            }elseif(strlen($this->_code)<3){
                $_SESSION['message'] = 'Le Code de la Rubrique doit contenir au moins ';
                $_SESSION['message'] .= '3 caractères';
                header('Location:'.$source);
            }else{
                // On vérifie que la Rubrique n'existe pas déjà. 
                $verification = $this->checkInfo($this->_code,'rubrique_finance', 'code_rubrique');
                if(empty($verification)){
                    $verif = $this->checkInfo($this->_nom, 'rubrique_finance', 'nom_rubrique');
                    if(empty($verif)){
                        $requete = $this->_db->prepare("INSERT INTO rubrique_finance SET 
                                                        nom_rubrique =:nom,
                                                        code_rubrique =:code,
                                                        etat =:etat");
                        $requete->bindValue(':nom', $this->_nom);
                        $requete->bindValue(':code', $this->_code);
                        $requete->bindValue(':etat', 'actif');
                        $requete->execute();
                        $_SESSION['message'] = 'La Rubrique '.$this->_nom.' a été créée.';
                        header('Location:'.$source);
                    }else{
                         $_SESSION['message'] = 'Ce nom de rubrique existe déjà.';
                         header('Location:'.$source);
                    }
                }else{
                    $_SESSION['message'] = 'Ce code existe déjà.';
                    header('Location:'.$source);
                }
            }
            
		}
		
		
		
		
		
		
		
		
		
		/*********************************************************************
		*********  On liste les Rubriques inscrites **************************
		*********************************************************************/
		public function listeRubriqueAll(){
			$sql = "SELECT *
					FROM rubrique_finance
					ORDER BY code_rubrique";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}
		
		
		
		
		public function listeRubrique($etat){
			$sql = "SELECT *
					FROM rubrique_finance
					WHERE etat = '$etat'
					ORDER BY code_rubrique";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}
		
		
		
		
		
		
		
		
		
		public function getRubrique($rubrique){
			$sql = "SELECT *
					FROM rubrique_finance
					WHERE id = '$rubrique'";
			$req = $this->_db->query($sql);
			$res = $req->fetch(PDO::FETCH_ASSOC);
			return $res;
		}
		
		
		
	
		
		
		
		
		
		/***********************************************************************
		**************  On modifie les informations d'une rubrique *************
		************************************************************************
		***********************************************************************/
		public function editRubrique($source, $info){
			echo '<pre>'; print_r($info); echo '</pre>';
            $this->_code = $this->setCodeRubrique($info['code']);
            $this->_nom = $this->setNomRubrique($info['nom']);
            $this->_id = $this->setUserId($info['id']);
            if($this->_code=='Rubrique'){
                $_SESSION['message'] = 'Le Code de la Rubrique doit contenir des valeurs';
                header('Location:'.$source);
            }elseif(strlen($this->_code)<3){
                $_SESSION['message'] = 'Le Code de la Rubrique doit contenir au moins ';
                $_SESSION['message'] .= '3 caractères';
                header('Location:'.$source);
            }else{
                $update = $this->_db->prepare("UPDATE rubrique_finance 
                                                SET 
                                                nom_rubrique =:nom,
                                                code_rubrique =:code
                                                WHERE id = :id");
                $update->execute(array('nom'=>$this->_nom,
                                        'code'=>$this->_code,
                                        'id'=>$this->_id));
                $_SESSION['message'] = 'Rubrique mise à jour.';
                header('Location:'.$source);
            }
		}
		
		
		
		
		
		
		
		
		
		/***********************************************************************
		********************  On veut supprimer ou rendre inactif une rubrique *
		***********************************************************************/
		public function deleteRubrique($source, $id){
            $this->_id = $this->setUserId($id);
            $update = $this->_db->prepare("UPDATE rubrique_finance 
                                            SET etat = 'inactif' 
                                            WHERE id = :id");
            $update->execute(array('id'=>$this->_id));
			$_SESSION['message'] = 'La Rubrique a été supprimée.';
			header('Location:'.$source);
		}
		
		
		
		
		
		
		
		
		
		
		/***********************************************************************
		********************  On veut supprimer ou rendre inactif une rubrique *
		***********************************************************************/
		public function updateRubrique($source, $id){
			$this->_id = $this->setUserId($id);
            $update = $this->_db->prepare("UPDATE rubrique_finance 
                                            SET etat = 'actif' 
                                            WHERE id = :id");
            $update->execute(array('id'=>$this->_id));
			$_SESSION['message'] = 'La Rubrique a été restaurée.';
			header('Location:'.$source);
		}
		
		
		
		
		
		
		
		
		
		/********************************************************************
		************** Liste des Rubriques introduites dans une classe ******
		********************************************************************/
		public function listeRubriqueClasse($classe){
			$sql = "SELECT rubrique_classe.id as id, rubrique, classe, montant,
							nom_rubrique
					FROM rubrique_classe, rubrique_finance
					WHERE classe = '$classe' AND rubrique_finance.id = rubrique
					ORDER BY nom_rubrique
					";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}
		
		
		
		
		
		
		
		
		
		/**************************************************************************
		************ Ajouter une rubrique à la classe *****************************
		**************************************************************************/
		public function ajouterRubriqueClasse($source, $classe, $rubrique, $montant){
			$this->rubrique = (int) $rubrique;
			$this->montant = (int) $montant;
			
			// On vérifie d'abord que la rubrique n'existe pas déjà dans la classe 
			$sql_verif = "SELECT * 
						FROM rubrique_classe 
						WHERE rubrique='$this->rubrique' AND classe='$classe'";
			$req_verif = $this->_db->query($sql_verif);
			$res_verif = $req_verif->fetch(PDO::FETCH_ASSOC);
			if(empty($res_verif)){
				$sql = "INSERT INTO rubrique_classe(rubrique, classe, montant)
						VALUES('$this->rubrique','$classe','$this->montant')";
				$this->_db->query($sql);
				$_SESSION['message'] = 'Rubrique insérée dans la classe.';
				header('Location:'.$source);
			}else{
				$_SESSION['message'] = 'La Rubrique existe déjà pour cette classe.';
				header('Location:'.$source);
			}
		}
		
		
		
		
		
		
		
		
		
		
		/**************************************************************************
		************ Supprimer une rubrique de la classe *****************************
		**************************************************************************/
		public function supprimerRubriqueClasse($source, $rubrique){
			$this->_rubrique = $this->setUserId($rubrique);
			$sql = "DELETE FROM rubrique_classe WHERE id = '$this->_rubrique'";
			$this->_db->query($sql);
		}
		
		
		
		
		
		
		
		
		
		/***************************************************************************
		****************** Le Montant total de la scolarité inscrit dans une Classe*
		***************************************************************************/
		public function totalScolarite($classe){
			$sql = "SELECT SUM(montant) as scolarite
					FROM rubrique_classe
					WHERE classe='$classe'";
			$req = $this->_db->query($sql);
			$res = $req->fetch(PDO::FETCH_ASSOC);
			return $res;
		}
		
		
		
		
		
		
		
		
		
		/*****************************************************************
		********  Payement de la Scolarité *******************************
		*****************************************************************/
		public function payerScolarite($source, $eleve, $rubrique, $montant, $date,$obs){
			// On ne devrait pas payer doublement la pension
			$paid = $this->verifierPayement($eleve);
			$dateEnregistrement = DATE('Y-m-d H:i:s');
			$user = $this->getUser($_SESSION['login']);
			$numRecu = $this->getNumRecu() + 1;
			echo $user;
			if(empty($paid)){
				$this->_eleve = (int) $eleve;
				if($this->_eleve <=0){
					$_SESSION['message'] = 'Vous devez choisir un élève';
				}else{
					for($i=0;$i<count($rubrique);$i++){
						if($obs[$i]=='oui'){
							$observation = 'Remise';
							$montant[$i] = NULL;
						}else{
							$observation = NULL;
						}
						
						$sql = "INSERT INTO rubrique_payement(id_eleve, rubrique, montant,
															date_payement, date_enregistrement,
															paid_by, observation, num_recu)
								VALUES('$eleve','$rubrique[$i]',
									'$montant[$i]','$date','$dateEnregistrement',
									'$user','$observation','$numRecu')";
						echo '<p>'.$sql.'</p>';
						$this->_db->query($sql);
					}
					$_SESSION['message'] = 'Scolarité enregistrée.';
					$_SESSION['new_message'] = 'Scolarité enregistrée.';
					$_SESSION['paid'] = $eleve;
				}
			}else{
				$_SESSION['message'] = 'Cet élève a déjà payé sa scolarité';
			}
			header('Location:'.$source);
		}
		
		
		
	
		
		
		
		
		
		/*
		La Fonction qu'on appelle pour générer les informations relatives au Recu 
		*/
		public function PayementEleve($eleve){
			$sql = "SELECT rubrique_payement.id as id, id_eleve, num_recu, rubrique, montant, 
							date_payement, DATE_FORMAT(date_payement, '%d/%m/%Y') as date_pay_fr,
							date_enregistrement, 
							DATE_FORMAT(date_enregistrement, '%d %M %Y à %H:%i:%s') as date_enreg_fr,
							observation,rne, 
							eleve.nom as nom_eleve,eleve.prenom as prenom_eleve, 
							classe, photo, nom_classe, nom_rubrique, code_rubrique, paid_by,
							enseignant.nom as nom_payeur, enseignant.prenom as prenom_payeur
							
					FROM rubrique_payement, eleve, classe, rubrique_finance, enseignant 
					WHERE id_eleve = '$eleve' AND 
						  id_eleve = eleve.id AND 
						  eleve.classe = code_classe AND
						  rubrique = rubrique_finance.id AND
						  enseignant.id = paid_by";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}
		
		
		
		
		
		
		
		
		
		/******************************************************************
		************* On vérifie un payement en machine *******************
		******************************************************************/
		public function verifierPayement($eleve){
			$sql = "SELECT *
					FROM rubrique_payement
					WHERE id_eleve = '$eleve'";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}
		
		
		
		
		
		
		
		
		/*
			On veut l'id de l'enregistreur du payement 
		*/
		public function getUser($login){
			$sql = "SELECT id 
					FROM enseignant 
					WHERE login='$login'";
			$req = $this->_db->query($sql);
			$res = $req->fetch(PDO::FETCH_ASSOC);
			return $res['id'];
		}
		
		
		
		
		
		
		
		
		/*
		Cette Fonction renvoie un nombre, qui est la plus grande valeur de num_recu.
		Utile pour générer le prochain reçu.
		*/
		public function getNumRecu(){
			$sql = "SELECT max(num_recu) as numero 
					FROM rubrique_payement 
					";
			$req = $this->_db->query($sql);
			$res = $req->fetch(PDO::FETCH_ASSOC);
			return $res['numero'];
		}
		
		
		
		
		
		
		
	
		
		public function listeSolvableGlobale(){
			$sql = "SELECT id_eleve, nom, prenom 
					FROM rubrique_payement, eleve 
					WHERE id_eleve = eleve.id
					GROUP BY id_eleve ORDER BY nom";
			$req = $this->_db->query($sql);
			$res = $req->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}
		
		
		
    }