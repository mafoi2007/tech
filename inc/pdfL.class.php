<?php 
	require_once('fpdf.class.php');
	
	
	class pdf extends FPDF {
		
		function convert($texte){
			$txt = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $texte);
			return $txt;
		}
		
		
		
			
		function Entete(){
			$this->Image('images/logo.png', 125, 20, 25);
			$this->SetFont('Times','',8);
			$this->Cell(90,10, $this->convert($_SESSION['information']['pays_fr']),0,0,'C');
			$this->Cell(80,10, $this->convert(''),0,0,'C');
			$this->Cell(90,10, $this->convert($_SESSION['information']['pays_en']),0,0,'C');
			
			$this->Ln(4);
			
			$this->Cell(90,10, $this->convert($_SESSION['information']['devise_fr']),0,0,'C');
			$this->Cell(80,10, $this->convert(''),0,0,'C');
			$this->Cell(90,10, $this->convert($_SESSION['information']['devise_en']),0,0,'C');
			$this->Ln(3);
			
			$this->Cell(90,10, $this->convert('**************'),0,0,'C');
			$this->Cell(80,10, $this->convert(''),0,0,'C');
			$this->Cell(90,10, $this->convert('**************'),0,0,'C');
			$this->Ln(4);
			
			$this->Cell(90,10, strtoupper($this->convert($_SESSION['information']['ministere_fr'])),0,0,'C');
			$this->Cell(80,10, strtoupper($this->convert('')),0,0,'C');
			$this->Cell(90,10, strtoupper($this->convert($_SESSION['information']['ministere_en'])),0,0,'C');
			$this->Ln(4);
			
			$this->Cell(90,10, $this->convert('**************'),0,0,'C');
			$this->Cell(80,10, $this->convert(''),0,0,'C');
			$this->Cell(90,10, $this->convert('**************'),0,0,'C');
			$this->Ln(4);
			
			$this->Cell(90,10, strtoupper($this->convert($_SESSION['information']['region_fr'])),0,0,'C');
			$this->Cell(80,10, strtoupper($this->convert('')),0,0,'C');
			$this->Cell(90,10, strtoupper($this->convert($_SESSION['information']['region_en'])),0,0,'C');
			$this->Ln(4);
			
			$this->Cell(90,10, $this->convert('**************'),0,0,'C');
			$this->Cell(80,10, $this->convert(''),0,0,'C');
			$this->Cell(90,10, $this->convert('**************'),0,0,'C');
			$this->Ln(4);
			
			$this->Cell(90,10, strtoupper($this->convert($_SESSION['information']['departement_fr'])),0,0,'C');
			$this->Cell(80,10, strtoupper($this->convert('')),0,0,'C');
			$this->Cell(90,10, strtoupper($this->convert($_SESSION['information']['departement_en'])),0,0,'C');
			$this->Ln(4);
			
			$this->Cell(90,10, $this->convert('**************'),0,0,'C');
			$this->Cell(80,10, $this->convert(''),0,0,'C');
			$this->Cell(90,10, $this->convert('**************'),0,0,'C');
			$this->Ln(4);
			
			$this->SetFont('Times','B',9);
			$this->Cell(90,10, strtoupper($this->convert($_SESSION['information']['nom_etablissement_fr'])),0,0,'C');
			$this->Cell(80,10, $this->convert(''),0,0,'C');
			$this->Cell(90,10, strtoupper($this->convert($_SESSION['information']['nom_etablissement_en'])),0,0,'C');
			$this->Ln(4);
			
			$this->SetFont('Times','I',8);
			$contactFr = 'Contact : '.$_SESSION['information']['contact'];
			$contactEn = 'Contact : '.$_SESSION['information']['contact'];
			$emailFr = 'Email : '.$_SESSION['information']['email'];
			$emailEn = 'Email : '.$_SESSION['information']['email'];
			$bpFr = 'B.P. : '.$_SESSION['information']['bp'].' '.$_SESSION['information']['arrondissement'];
			$bpEn = 'P.O. Box: '.$_SESSION['information']['bp'].' '.$_SESSION['information']['arrondissement'];
			$this->Cell(90,10, $this->convert($bpFr.'. '.$contactFr),0,0,'C');
			$this->Cell(80,10, $this->convert(''),0,0,'C');
			$this->Cell(90,10, $this->convert($bpEn.'. '.$contactEn),0,0,'C');
			$this->Ln(4);
			
			$this->SetFont('Times','B',8);
			$asFr = 'Année Scolaire : '.$_SESSION['information']['annee_scolaire'];
			$asEn = 'School Year : '.$_SESSION['information']['annee_scolaire'];
			$this->Cell(90,10, $this->convert($asFr),0,0,'C');
			$this->Cell(80,10, $this->convert(''),0,0,'C');
			$this->Cell(90,10, $this->convert($asEn),0,0,'C');
			$this->Ln(4);
			
		}
		
		
		
		
		function Footer(){
			$this->setFont('Arial', 'I', 8);
			$texte = $_SESSION['appName'].' '.$_SESSION['appVersion'];
			$texte .= ', votre partenaire éducatif. Tel : ';
			$texte .= $_SESSION['appContact'];
			$numeroPage = 'Page '.$this->PageNo().' / {nb}';
			$printed = 'Edition Date : '.DATE('d / m / Y  H:i:s');
			$this->Text(25,200, $this->convert($printed));
			$this->Text(100,200, $this->convert($texte));
			$this->Text(250,200, $this->convert($numeroPage));
			$this->setAuthor('Nyambi Computer Services');
			$this->setCreator('Nyambi Ngikwa Richard');
			$this->AliasNbPages();
		}
		
		
		
		
		function Titre($titre){
			// On crée d'abord un espace pour gérer les informations d'entête
			$this->Ln(9);
			$this->SetFont('Times', 'B', 18);
			// Déplacer à droite
			$this->Cell(10);
			// Bordure du titre
			$this->Cell(250, 10, $this->convert(strtoupper($titre)), 0, 0 , 'C');
			// Retour à la ligne
			$this->Ln(5);
		}
		
		
		function SousTitre($titre){
			// On crée d'abord un espace pour gérer les informations d'entête
			$this->Ln(2);
			$this->SetFont('Times', 'BI', 14);
			// Déplacer à droite
			$this->Cell(10);
			// Bordure du titre
			$this->Cell(200, 8, $this->convert(strtoupper($titre)), 0, 0 , 'C');
			// Retour à la ligne
			$this->Ln(5);
		}




		public function tableauHonneurTrimestriel($eleve, $section){
			$this->addPage();
			$this->Entete();
			if($_SESSION['trimestre']==1){
				$titreTrimestre['fr'] = 'Premier Trimestre';
				$titreTrimestre['en'] = 'First Term';
			}elseif($_SESSION['trimestre']==2){
				$titreTrimestre['fr'] = 'Deuxieme Trimestre';
				$titreTrimestre['en'] = 'Second Term';
			}elseif($_SESSION['trimestre']==3){
				$titreTrimestre['fr'] = 'Troisieme Trimestre';
				$titreTrimestre['en'] = 'Third Term';
			}
			// On met le titre du document 
			$titre['fr'] = "Tableau d'Honneur";
			$titre['en'] = "Honour Holl";
			$this->SetFont('Times','BUI',24);
			$this->Text(100,75,strtoupper(utf8_decode($titre[$section])));

			$this->SetFont('Times','',14);
			$lib_nom['fr'] = "Attribué à l'élève : ";
			$lib_nom['en'] = 'Attributed to :';
			$lib_classe['fr'] = 'De la Classe de  : ';
			$lib_classe['en'] = 'From Class  : ';
			$lib_matricule['fr'] = 'Matricule. : ';
			$lib_matricule['en'] = 'Identifier. : ';
			$lib_effectif['fr'] = 'Effectif Classe : ';
			$lib_effectif['en'] = 'Roll : ';
			$lib_dateNaissance['fr'] = "Né(e) le : ";
			$lib_dateNaissance['en'] = "Born on : ";
			$lib_lieuNaissance['fr'] = 'à : ';
			$lib_lieuNaissance['en'] = 'at : ';
			$lib_sexe['fr'] = 'Pour le : ';
			$lib_sexe['en'] = 'For the : ';
			$lib_redoublant['fr'] = "De l'année Scolaire : ";
			$lib_redoublant['en'] = "Of the School Year : ";
			$lib_moyenne['fr'] = 'Moyenne Obtenue : ';
			$lib_moyenne['en'] = 'Average obtained : ';
			$lib_rang['fr'] = 'Rang : ';
			$lib_rang['en'] = 'Rank : ';
			$encouragement['fr'] = "Avec Encouragements";
			$encouragement['en'] = "With Encouragements";
			$felicitation['fr'] = "Avec Félicitations";
			$felicitation['en'] = "With Congratulations";
			$this->Text(40,85,utf8_decode($lib_nom[$section]));
			$this->Text(40,95,utf8_decode($lib_dateNaissance[$section]));
			$this->Text(130,95,utf8_decode($lib_lieuNaissance[$section]));
			$this->Text(40,105,utf8_decode($lib_classe[$section]));
			$this->Text(175,105,utf8_decode($lib_matricule[$section]));
			$this->Text(40,115,utf8_decode($lib_sexe[$section]));
			$this->Text(175,115,utf8_decode($lib_redoublant[$section]));
			$this->Text(40,125,utf8_decode($lib_moyenne[$section]));
			$this->Text(175,125,utf8_decode($lib_rang[$section]));

			$this->SetFont('Times','B',14);
			$nom = substr($eleve['nom_eleve'],0,30);
			$nomClasse = substr(strtoupper($_SESSION['nom_classe']),0,30);
			$matricule = $eleve['rne'];
			// $effectif = $_SESSION['effectif'];
			$effectif = $eleve['classes'];
			$dateNaissance = $eleve['date_fr'];
			$lieuNaissance = $eleve['lieu_naissance'];
			$sexe = $eleve['sexe'];
			$redoublant = $eleve['statut'];
			$as = $_SESSION['information']['annee_scolaire'];
			$titulaire = substr($eleve['titulaire'],0,20);
			$image =$eleve['photo'];
			$moyenne = $eleve['moyenne']." / 20";
			$rang = $eleve['rang']." / ".$effectif;			
			$this->Text(90,85,utf8_decode($nom));
			$this->Text(90,95,utf8_decode($dateNaissance));
			$this->Text(145,95,utf8_decode($lieuNaissance));
			$this->Text(90,105,utf8_decode($nomClasse));
			$this->Text(200,105,utf8_decode($matricule));
			$this->Text(90,115,utf8_decode($titreTrimestre[$section]));
			$this->Text(220,115,utf8_decode($as));
			$this->Text(90,125,utf8_decode($moyenne));
			$this->Text(220,125,utf8_decode($rang));
			$this->SetFont('Times','BI',18);
			if($eleve['moyenne'] >=14){
				$this->Text(40, 135, utf8_decode($encouragement[$section]));
			}
			if($eleve['moyenne'] >=15){
				$this->Text(40, 145, utf8_decode($felicitation[$section]));
			}			
			$this->Image($image, 245, 75, 30, 30);

			$this->SetFont('Times','B',14);
			$ville = $_SESSION['information']['ville'];
			$faitA['fr'] = 'Fait à '.strtoupper($ville).' le ________________';
			$faitA['en'] = 'Done at '.strtoupper($ville).' the ________________';
			$signataire['fr'] = $_SESSION['information']['signataire_fr'];
			$signataire['en'] = $_SESSION['information']['signataire_en'];
			$this->Text(180, 150, utf8_decode($faitA[$section]));
			$this->Text(200,160, utf8_decode($signataire[$section]));
			// On créé un espace supplémentaire entre le tableau et les info du haut
			$this->Ln(40);
			$this->SetFont('Times','B',8);
			$bullMatiere['fr'] = 'Matière';
			$bullMatiere['en'] = 'Subject';
			$bullCompetence['fr'] = 'Compétences évaluées';
			$bullCompetence['en'] = 'Skills evaluated';
			$bullNote['fr'] = 'N /20';
			$bullNote['en'] = 'M/20';
			$bullNoteTri['fr'] = 'M/20';
			$bullNoteTri['en'] = 'A/20';
			$bullCoef['fr'] = 'Coef';
			$bullCoef['en'] = 'Coef';
			$bullProduit['fr'] = 'M x Coef';
			$bullProduit['en'] = 'A x Coef';
			$bullMinMax['fr'] = 'Min - Max';
			$bullMinMax['en'] = 'Min - Max';
			$bullAppr['fr'] = 'Appréciation';
			$bullAppr['en'] = 'Grade';
			$bullCote['fr'] = 'Cote';
			$bullCote['en'] = 'Cote';
			$bullParaphe['fr'] = 'Paraphe Ens.';
			$bullParaphe['en'] = 'Teacher Obs.';
			$this->Cell(8);
			// $this->Cell(40,5, utf8_decode($bullMatiere[$section]),1,0,'C',true);
			// $this->Cell(35,5, utf8_decode($bullCompetence[$section]),1,0,'C',true);
			// $this->Cell(12,5, utf8_decode($bullNote[$section]),1,0,'C',true);
			// $this->Cell(12,5, utf8_decode($bullNoteTri[$section]),1,0,'C',true);
			// $this->Cell(10,5, utf8_decode($bullCoef[$section]),1,0,'C',true);
			// $this->Cell(15,5, utf8_decode($bullProduit[$section]),1,0,'C',true);
			// $this->Cell(10,5, utf8_decode($bullCote[$section]),1,0,'C',true);
			// $this->Cell(18,5, utf8_decode($bullMinMax[$section]),1,0,'C',true);
			// $this->Cell(10,5, utf8_decode('Max'),1,0,'C',true);
			// $this->Cell(22,5, utf8_decode($bullAppr[$section]),1,0,'C',true);
			// $this->Cell(20,5, utf8_decode($bullParaphe[$section]),1,0,'C',true);
			$this->SetFont('Times','',8);
			$this->Ln(5);
			// // On ressort une boucle qui liste les groupes définis
			for($b=0;$b<count($_SESSION['groupe']);$b++){
				$codeGroupe = $_SESSION['groupe'][$b]['code_groupe'];
				$idGroupe = $_SESSION['groupe'][$b]['groupe'];
				$nomGroupe = $_SESSION['groupe'][$b]['nom_groupe'];
				$matieresGroupe = $_SESSION['matiereGroupe'][$idGroupe];
				
				
				// $this->Cell(20,5, '',1,0,'C',true);
				$this->Ln(5);
				$this->SetFont('Times','',7);
			}
			
			
			
			
			$parent['fr'] = 'Le Parent';
			$parent['en'] = 'The Parent';
			$pp['fr'] = 'Le Professeur Principal';
			$pp['en'] = 'The Class Principal';
			

			
			
			$this->Ln(6);
			$this->Cell(8);

			

			
			
		}








		public function tableauHonneurAnnuel($eleve, $section){
			$this->addPage();
			$this->Entete();
			$titreTrim1['fr'] = 'Trim 1 : ';
			$titreTrim1['en'] =  'Term 1 : ';
			$titreTrim2['fr'] = 'Trim 2 : ';
			$titreTrim2['en'] =  'Term 2 : ';
			$titreTrim3['fr'] = 'Trim 3 : ';
			$titreTrim3['en'] =  'Term 3 : ';
			// On met le titre du document 
			$titre['fr'] = "Tableau d'Honneur Annuel";
			$titre['en'] = "Annual Honour Holl";
			$this->SetFont('Times','BUI',24);
			$this->Text(100,75,strtoupper(utf8_decode($titre[$section])));

			$this->SetFont('Times','',14);
			$lib_nom['fr'] = "Attribué à l'élève : ";
			$lib_nom['en'] = 'Attributed to :';
			$lib_classe['fr'] = 'De la Classe de  : ';
			$lib_classe['en'] = 'From Class  : ';
			$lib_matricule['fr'] = 'Matricule. : ';
			$lib_matricule['en'] = 'Identifier. : ';
			$lib_effectif['fr'] = 'Effectif Classe : ';
			$lib_effectif['en'] = 'Roll : ';
			$lib_dateNaissance['fr'] = "Né(e) le : ";
			$lib_dateNaissance['en'] = "Born on : ";
			$lib_lieuNaissance['fr'] = 'à : ';
			$lib_lieuNaissance['en'] = 'at : ';
			$lib_t1['fr'] = 'Pour le : ';
			$lib_t1['en'] = 'For the : ';
			$lib_redoublant['fr'] = "De l'année Scolaire : ";
			$lib_redoublant['en'] = "Of the School Year : ";
			$lib_moyenne['fr'] = 'Moyenne Annuelle : ';
			$lib_moyenne['en'] = 'Annual Average : ';
			$lib_rang['fr'] = 'Rang : ';
			$lib_rang['en'] = 'Rank : ';
			$encouragement['fr'] = "Avec Encouragements";
			$encouragement['en'] = "With Encouragements";
			$felicitation['fr'] = "Avec Félicitations";
			$felicitation['en'] = "With Congratulations";
			$this->Text(40,85,utf8_decode($lib_nom[$section]));
			$this->Text(40,95,utf8_decode($lib_dateNaissance[$section]));
			$this->Text(130,95,utf8_decode($lib_lieuNaissance[$section]));
			$this->Text(40,105,utf8_decode($lib_classe[$section]));
			$this->Text(175,105,utf8_decode($lib_matricule[$section]));
			$this->Text(40,115,utf8_decode($titreTrim1[$section]));
			$this->Text(100,115,utf8_decode($titreTrim2[$section]));
			$this->Text(160,115,utf8_decode($titreTrim3[$section]));
			// $this->Text(175,115,utf8_decode($lib_redoublant[$section]));
			$this->Text(40,125,utf8_decode($lib_moyenne[$section]));
			$this->Text(175,125,utf8_decode($lib_rang[$section]));

			$this->SetFont('Times','B',14);
			$nom = substr($eleve['nom_eleve'],0,30);
			$nomClasse = substr(strtoupper($_SESSION['nom_classe']),0,30);
			$matricule = $eleve['rne'];
			// $effectif = $_SESSION['effectif'];
			$effectif = $eleve['classes'];
			$dateNaissance = $eleve['date_fr'];
			$lieuNaissance = $eleve['lieu_naissance'];
			$sexe = $eleve['sexe'];
			$redoublant = $eleve['statut'];
			$as = $_SESSION['information']['annee_scolaire'];
			$titulaire = substr($eleve['titulaire'],0,20);
			$image =$eleve['photo'];
			$moyenne = $eleve['moyenne']." / 20";
			$rang = $eleve['rang']." / ".$effectif;			
			$this->Text(90,85,utf8_decode($nom));
			$this->Text(90,95,utf8_decode($dateNaissance));
			$this->Text(145,95,utf8_decode($lieuNaissance));
			$this->Text(90,105,utf8_decode($nomClasse));
			$this->Text(200,105,utf8_decode($matricule));
			/*$this->Text(90,115,utf8_decode($titreTrimestre[$section]));*/
			$this->Text(60,115,utf8_decode($eleve['moyenne_1']));
			$this->Text(120,115,utf8_decode($eleve['moyenne_2']));
			$this->Text(180,115,utf8_decode($eleve['moyenne_3']));
			$this->Text(90,125,utf8_decode($moyenne));
			$this->Text(220,125,utf8_decode($rang));
			$this->SetFont('Times','BI',18);
			if($eleve['moyenne'] >=14){
				$this->Text(40, 135, utf8_decode($encouragement[$section]));
			}
			if($eleve['moyenne'] >=15){
				$this->Text(40, 145, utf8_decode($felicitation[$section]));
			}			
			$this->Image($image, 245, 75, 30, 30);

			$this->SetFont('Times','B',14);
			$ville = $_SESSION['information']['ville'];
			$faitA['fr'] = 'Fait à '.strtoupper($ville).' le ________________';
			$faitA['en'] = 'Done at '.strtoupper($ville).' the ________________';
			$signataire['fr'] = $_SESSION['information']['signataire_fr'];
			$signataire['en'] = $_SESSION['information']['signataire_en'];
			$this->Text(180, 150, utf8_decode($faitA[$section]));
			$this->Text(200,160, utf8_decode($signataire[$section]));
			// On créé un espace supplémentaire entre le tableau et les info du haut
			$this->Ln(40);
			$this->SetFont('Times','B',8);
			$bullMatiere['fr'] = 'Matière';
			$bullMatiere['en'] = 'Subject';
			$bullCompetence['fr'] = 'Compétences évaluées';
			$bullCompetence['en'] = 'Skills evaluated';
			$bullNote['fr'] = 'N /20';
			$bullNote['en'] = 'M/20';
			$bullNoteTri['fr'] = 'M/20';
			$bullNoteTri['en'] = 'A/20';
			$bullCoef['fr'] = 'Coef';
			$bullCoef['en'] = 'Coef';
			$bullProduit['fr'] = 'M x Coef';
			$bullProduit['en'] = 'A x Coef';
			$bullMinMax['fr'] = 'Min - Max';
			$bullMinMax['en'] = 'Min - Max';
			$bullAppr['fr'] = 'Appréciation';
			$bullAppr['en'] = 'Grade';
			$bullCote['fr'] = 'Cote';
			$bullCote['en'] = 'Cote';
			$bullParaphe['fr'] = 'Paraphe Ens.';
			$bullParaphe['en'] = 'Teacher Obs.';
			$this->Cell(8);
			// $this->Cell(40,5, utf8_decode($bullMatiere[$section]),1,0,'C',true);
			// $this->Cell(35,5, utf8_decode($bullCompetence[$section]),1,0,'C',true);
			// $this->Cell(12,5, utf8_decode($bullNote[$section]),1,0,'C',true);
			// $this->Cell(12,5, utf8_decode($bullNoteTri[$section]),1,0,'C',true);
			// $this->Cell(10,5, utf8_decode($bullCoef[$section]),1,0,'C',true);
			// $this->Cell(15,5, utf8_decode($bullProduit[$section]),1,0,'C',true);
			// $this->Cell(10,5, utf8_decode($bullCote[$section]),1,0,'C',true);
			// $this->Cell(18,5, utf8_decode($bullMinMax[$section]),1,0,'C',true);
			// $this->Cell(10,5, utf8_decode('Max'),1,0,'C',true);
			// $this->Cell(22,5, utf8_decode($bullAppr[$section]),1,0,'C',true);
			// $this->Cell(20,5, utf8_decode($bullParaphe[$section]),1,0,'C',true);
			$this->SetFont('Times','',8);
			$this->Ln(5);
			// // On ressort une boucle qui liste les groupes définis
			for($b=0;$b<count($_SESSION['groupe']);$b++){
				$codeGroupe = $_SESSION['groupe'][$b]['code_groupe'];
				$idGroupe = $_SESSION['groupe'][$b]['groupe'];
				$nomGroupe = $_SESSION['groupe'][$b]['nom_groupe'];
				$matieresGroupe = $_SESSION['matiereGroupe'][$idGroupe];
				
				
				// $this->Cell(20,5, '',1,0,'C',true);
				$this->Ln(5);
				$this->SetFont('Times','',7);
			}
			
			
			
			
			$parent['fr'] = 'Le Parent';
			$parent['en'] = 'The Parent';
			$pp['fr'] = 'Le Professeur Principal';
			$pp['en'] = 'The Class Principal';
			

			
			
			$this->Ln(6);
			$this->Cell(8);

			

			
			
		}
		
		
		
	}