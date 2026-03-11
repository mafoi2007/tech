<?php 
	require_once('fpdf.class.php');
	
	
	class pdf extends FPDF {
		
		function convert($texte){
			$txt = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $texte);
			return $txt;
		}
		
		
		
			
		function Entete(){
			$this->Image('images/logo.jpg', 90, 20, 25);
			$this->SetFont('Times','',8);
			$this->Cell(70,7, $this->convert($_SESSION['information']['pays_fr']),0,0,'C');
			$this->Cell(50,7, $this->convert(''),0,0,'C');
			$this->Cell(70,7, $this->convert($_SESSION['information']['pays_en']),0,0,'C');
			
			$this->Ln(4);
			
			$this->Cell(70,7, $this->convert($_SESSION['information']['devise_fr']),0,0,'C');
			$this->Cell(50,7, $this->convert(''),0,0,'C');
			$this->Cell(70,7, $this->convert($_SESSION['information']['devise_en']),0,0,'C');
			$this->Ln(3);
			
			$this->Cell(70,7, $this->convert('**************'),0,0,'C');
			$this->Cell(50,7, $this->convert(''),0,0,'C');
			$this->Cell(70,7, $this->convert('**************'),0,0,'C');
			$this->Ln(4);
			
			$this->Cell(70,7, strtoupper($this->convert($_SESSION['information']['ministere_fr'])),0,0,'C');
			$this->Cell(50,7, strtoupper($this->convert('')),0,0,'C');
			$this->Cell(70,7, strtoupper($this->convert($_SESSION['information']['ministere_en'])),0,0,'C');
			$this->Ln(4);
			
			$this->Cell(70,7, $this->convert('**************'),0,0,'C');
			$this->Cell(50,7, $this->convert(''),0,0,'C');
			$this->Cell(70,7, $this->convert('**************'),0,0,'C');
			$this->Ln(4);
			
			$this->Cell(70,7, strtoupper($this->convert($_SESSION['information']['region_fr'])),0,0,'C');
			$this->Cell(50,7, strtoupper($this->convert('')),0,0,'C');
			$this->Cell(70,7, strtoupper($this->convert($_SESSION['information']['region_en'])),0,0,'C');
			$this->Ln(4);
			
			$this->Cell(70,7, $this->convert('**************'),0,0,'C');
			$this->Cell(50,7, $this->convert(''),0,0,'C');
			$this->Cell(70,7, $this->convert('**************'),0,0,'C');
			$this->Ln(4);
			
			$this->Cell(70,7, strtoupper($this->convert($_SESSION['information']['departement_fr'])),0,0,'C');
			$this->Cell(50,7, strtoupper($this->convert('')),0,0,'C');
			$this->Cell(70,7, strtoupper($this->convert($_SESSION['information']['departement_en'])),0,0,'C');
			$this->Ln(4);
			
			$this->Cell(70,7, $this->convert('**************'),0,0,'C');
			$this->Cell(50,7, $this->convert(''),0,0,'C');
			$this->Cell(70,7, $this->convert('**************'),0,0,'C');
			$this->Ln(4);
			
			$this->SetFont('Times','B',9);
			$this->Cell(70,7, strtoupper($this->convert($_SESSION['information']['nom_etablissement_fr'])),0,0,'C');
			$this->Cell(50,7, $this->convert(''),0,0,'C');
			$this->Cell(70,7, strtoupper($this->convert($_SESSION['information']['nom_etablissement_en'])),0,0,'C');
			$this->Ln(4);
			
			$this->SetFont('Times','I',8);
			$contactFr = 'Contact : '.$_SESSION['information']['contact'];
			$contactEn = 'Contact : '.$_SESSION['information']['contact'];
			$emailFr = 'Email : '.$_SESSION['information']['email'];
			$emailEn = 'Email : '.$_SESSION['information']['email'];
			$bpFr = 'B.P. : '.$_SESSION['information']['bp'].' '.$_SESSION['information']['arrondissement'];
			$bpEn = 'P.O. Box: '.$_SESSION['information']['bp'].' '.$_SESSION['information']['arrondissement'];
			$this->Cell(70,7, $this->convert($bpFr.'. '.$contactFr),0,0,'C');
			$this->Cell(50,7, $this->convert(''),0,0,'C');
			$this->Cell(70,7, $this->convert($bpEn.'. '.$contactEn),0,0,'C');
			$this->Ln(4);
			
			$this->SetFont('Times','B',8);
			$asFr = 'Année Scolaire : '.$_SESSION['information']['annee_scolaire'];
			$asEn = 'School Year : '.$_SESSION['information']['annee_scolaire'];
			$this->Cell(70,7, $this->convert($asFr),0,0,'C');
			$this->Cell(50,7, $this->convert(''),0,0,'C');
			$this->Cell(70,7, $this->convert($asEn),0,0,'C');
			$this->Ln(10);

		}
		
		


		public function pvSequentielAlpha($section){
			$this->addPage();
			$this->Entete();
			if($_SESSION['sequence']==1){
				$titreSequence['fr'] = 'Premiere Sequence';
				$titreSequence['en'] = 'First Sequence';
			}elseif($_SESSION['sequence']==2){
				$titreSequence['fr'] = 'Deuxieme Sequence';
				$titreSequence['en'] = 'Second Sequence';
			}elseif($_SESSION['sequence']==3){
				$titreSequence['fr'] = 'Troisieme Sequence';
				$titreSequence['en'] = 'Third Sequence';
			}elseif($_SESSION['sequence']==4){
				$titreSequence['fr'] = 'Quatrieme Sequence';
				$titreSequence['en'] = 'Fourth Sequence';
			}elseif($_SESSION['sequence']==5){
				$titreSequence['fr'] = 'Cinquieme Sequence';
				$titreSequence['en'] = 'Fifth Sequence';
			}elseif($_SESSION['sequence']==6){
				$titreSequence['fr'] = 'Sixieme Sequence';
				$titreSequence['en'] = 'Sixth Sequence';
			}
			$titre['fr'] = "Proces Verbal de la ".$titreSequence['fr'];
			$titre['en'] = "report of the ".$titreSequence['en'];
			$classe['fr'] = "Classe : ".strtoupper($_SESSION['nom_classe']);
			$classe['en'] = "Class : ".strtoupper($_SESSION['nom_classe']);
			$effectifClasse['fr'] = 'Effectif : '.count($_SESSION['eleve']);
			$effectifClasse['en'] = 'Roll : '.count($_SESSION['eleve']);
			$effectifEvalue['fr'] = 'Evalués : '.$_SESSION['eleve'][0]['classes'];
			$effectifEvalue['en'] = 'Evaluated : '.$_SESSION['eleve'][0]['classes'];

			$this->Titre($titre[$section]);

			$this->SetFont('Times','B',12);
			$this->Cell(85,5,utf8_decode($classe[$section]),0,0,'L');
			$this->Cell(35,5,utf8_decode($effectifClasse[$section]),0,0,'C');
			$this->Cell(35,5,utf8_decode($effectifEvalue[$section]),0,0,'C');
			$this->Ln(5);

			// Construction du tableau Informationnel statistique
			$libelle['fr'] = 'Libellé';
			$libelle['en'] = 'Title';
			$feminin['fr'] = 'Féminin';
			$feminin['en'] = 'Female';
			$masculin['fr'] = 'Masculin';
			$masculin['en'] = 'Male';
			$total['fr'] = 'Total';
			$total['en'] = 'Global';
			$moyennes['fr'] = 'Moyennes';
			$moyennes['en'] = 'Averages';
			$sousMoyennes['fr'] = 'Sous - Moyennes';
			$sousMoyennes['en'] = 'Sub - Averages';
			$moyenneGenerale['fr'] = 'Moyenne Générale';
			$moyenneGenerale['en'] = 'General Average';
			$taux['fr'] = 'Taux Réussite';
			$taux['en'] = 'Percentage';
			$forteMoy['fr'] = 'Forte Moyenne';
			$forteMoy['en'] = 'Max Average';
			$faibleMoy['fr'] = 'Faible Moyenne';
			$faibleMoy['en'] = 'Low Average';
			$this->Cell(55,8,'',0,0,'C');
			$this->Cell(35,8,utf8_decode($libelle[$section]),1,0,'C',true);
			$this->Cell(20,8,utf8_decode($feminin[$section]),1,0,'C',true);
			$this->Cell(20,8,utf8_decode($masculin[$section]),1,0,'C',true);
			$this->Cell(20,8,utf8_decode($total[$section]),1,0,'C',true);
			$this->Ln(8);
			$this->Cell(55);
			$this->SetFont('Times','',10);
			$this->Cell(35,8,utf8_decode($moyennes[$section]),1,0,'C');
			$this->Cell(20,8,utf8_decode($_SESSION['statistique']['moyFille']),1,0,'C');
			$this->Cell(20,8,utf8_decode($_SESSION['statistique']['moyMasc']),1,0,'C');
			$this->Cell(20,8,utf8_decode($_SESSION['statistique']['moyTotal']),1,0,'C');
			$this->Ln(8);
			$this->Cell(55);
			$this->Cell(35,8,utf8_decode($sousMoyennes[$section]),1,0,'C');
			$this->Cell(20,8,utf8_decode($_SESSION['statistique']['sousMoyFille']),1,0,'C');
			$this->Cell(20,8,utf8_decode($_SESSION['statistique']['sousMoyMasc']),1,0,'C');
			$this->Cell(20,8,utf8_decode($_SESSION['statistique']['sousMoyTotal']),1,0,'C');
			$this->Ln(8);
			$this->Cell(55);
			$this->Cell(35,8,utf8_decode($moyenneGenerale[$section]),1,0,'C');
			$this->Cell(20,8,utf8_decode(substr($_SESSION['statistique']['moyGenFille'],0,5)),1,0,'C');
			$this->Cell(20,8,utf8_decode(substr($_SESSION['statistique']['moyGenMasc'],0,5)),1,0,'C');
			$this->Cell(20,8,utf8_decode(substr($_SESSION['statistique']['moyGenTotal'],0,5)),1,0,'C');
			$this->Ln(8);
			$this->Cell(55);
			$this->Cell(35,8,utf8_decode($taux[$section]),1,0,'C');
			$this->Cell(20,8,utf8_decode(substr($_SESSION['statistique']['tauxFille'],0,5).' %'),1,0,'C');
			$this->Cell(20,8,utf8_decode(substr($_SESSION['statistique']['tauxMasc'],0,5).' %'),1,0,'C');
			$this->Cell(20,8,utf8_decode(substr($_SESSION['statistique']['tauxTotal'],0,5).' %'),1,0,'C');
			$this->Ln(8);
			$this->Cell(55);
			$this->Cell(35,8,utf8_decode($forteMoy[$section]),1,0,'C');
			$this->Cell(20,8,utf8_decode($_SESSION['statistique']['noteForteFille']),1,0,'C');
			$this->Cell(20,8,utf8_decode($_SESSION['statistique']['noteForteMasc']),1,0,'C');
			$this->Cell(20,8,utf8_decode($_SESSION['statistique']['noteForteTotal']),1,0,'C');
			$this->Ln(8);
			$this->Cell(55);
			$this->Cell(35,8,utf8_decode($faibleMoy[$section]),1,0,'C');
			$this->Cell(20,8,utf8_decode($_SESSION['statistique']['noteFaibleFille']),1,0,'C');
			$this->Cell(20,8,utf8_decode($_SESSION['statistique']['noteFaibleMasc']),1,0,'C');
			$this->Cell(20,8,utf8_decode($_SESSION['statistique']['noteFaibleTotal']),1,0,'C');
			$this->Ln(10);

			// Informations du PV 
			$pvNumber['fr'] = 'N°';
			$pvNumber['en'] = 'N°';
			$pvMatricule['fr'] = 'Matricule';
			$pvMatricule['en'] = 'Identifier';
			$pvNom['fr'] = 'Noms et Prénoms';
			$pvNom['en'] = 'Student Name';
			$pvSexe['fr'] = 'Sexe';
			$pvSexe['en'] = 'Sex';
			$pvMoyenne['fr'] = 'Moyenne';
			$pvMoyenne['en'] = 'Average';
			$pvRang['fr'] = 'Rang';
			$pvRang['en'] = 'Rank';
			$pvAppr['fr'] = 'Appréc.';
			$pvAppr['en'] = 'Grade';
			$pvCote['fr'] = 'Cote';
			$pvCote['en'] = 'Cote';
			$pvObserv['fr'] = 'Observations';
			$pvObserv['en'] = 'Observations';
			$this->SetFont('Times','B',8);
			$this->Cell(10,5,utf8_decode($pvNumber[$section]	),1,0,'C',true);
			$this->Cell(20,5,utf8_decode($pvMatricule[$section]),1,0,'C',true);
			$this->Cell(55,5,utf8_decode($pvNom[$section]),1,0,'C',true);
			$this->Cell(10,5,utf8_decode($pvSexe[$section]),1,0,'C',true);
			$this->Cell(15,5,utf8_decode($pvMoyenne[$section]),1,0,'C',true);
			$this->Cell(10,5,utf8_decode($pvRang[$section]),1,0,'C',true);
			$this->Cell(15,5,utf8_decode($pvAppr[$section]),1,0,'C',true);
			$this->Cell(10,5,utf8_decode($pvCote[$section]),1,0,'C',true);
			$this->Cell(40,5,utf8_decode($pvObserv[$section]),1,0,'C',true);
			$this->Ln(5);
			$a = 1;
			$this->SetFont('Times','',9);
			for($i=0;$i<count($_SESSION['eleve']);$i++){
				$rneEleve = utf8_decode($_SESSION['eleve'][$i]['rne']);
				$nomEleve = utf8_decode(stripslashes(substr($_SESSION['eleve'][$i]['nom_eleve'],0,28)));
				$sexeEleve = utf8_decode($_SESSION['eleve'][$i]['sexe']);
				$moyenneEleve = $_SESSION['eleve'][$i]['moyenne'];
				$rankEleve = $_SESSION['eleve'][$i]['rang'];
				$apprEleve = $_SESSION['eleve'][$i]['appreciation'];
				$coteEleve = $_SESSION['eleve'][$i]['cote'];
				$this->Cell(10,5,utf8_decode($a),1,0,'C');
				$this->Cell(20,5,$rneEleve,1,0,'C');
				$this->Cell(55,5,$nomEleve,1,0,'L');
				$this->Cell(10,5,$sexeEleve,1,0,'C');
				$this->SetFont('Times','B',9);
				$this->Cell(15,5,$moyenneEleve,1,0,'C',true);
				$this->SetFont('Times','',9);
				$this->Cell(10,5,$rankEleve,1,0,'C');
				$this->Cell(15,5,$apprEleve,1,0,'C');
				$this->Cell(10,5,$coteEleve,1,0,'C');
				$this->Cell(40,5,utf8_decode(''),1,0,'C');
				$this->Ln(5);
				$a++;
			}
			$ville = $_SESSION['information']['ville'];
			$faitA['fr'] = 'Fait à '.strtoupper($ville).', le __________________.';
			$faitA['en'] = 'Done at '.strtoupper($ville).', the __________________.';
			$signataire['fr'] = $_SESSION['information']['signataire_fr'];
			$signataire['en'] = $_SESSION['information']['signataire_en'];
			$this->Ln(2);
			$this->Cell(125);
			$this->Cell(60,5, utf8_decode($faitA[$section]),0,0,'R');
			$this->Ln(5);
			$this->Cell(125);
			$this->SetFont('Times','BI',9);
			$this->Cell(60,5,utf8_decode($signataire[$section]),0,0,'C');
		}









		public function pvTrimestrielAlpha($section){
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
			$titre['fr'] = "Proces Verbal du ".$titreTrimestre['fr'];
			$titre['en'] = "report of the ".$titreTrimestre['en'];
			$classe['fr'] = "Classe : ".strtoupper($_SESSION['nom_classe']);
			$classe['en'] = "Class : ".strtoupper($_SESSION['nom_classe']);
			$effectifClasse['fr'] = 'Effectif : '.count($_SESSION['eleve']);
			$effectifClasse['en'] = 'Roll : '.count($_SESSION['eleve']);
			$effectifEvalue['fr'] = 'Evalués : '.$_SESSION['eleve'][0]['classes'];
			$effectifEvalue['en'] = 'Evaluated : '.$_SESSION['eleve'][0]['classes'];

			$this->Titre($titre[$section]);

			$this->SetFont('Times','B',12);
			$this->Cell(85,5,utf8_decode($classe[$section]),0,0,'L');
			$this->Cell(35,5,utf8_decode($effectifClasse[$section]),0,0,'C');
			$this->Cell(35,5,utf8_decode($effectifEvalue[$section]),0,0,'C');
			$this->Ln(5);

			// Construction du tableau Informationnel statistique
			$libelle['fr'] = 'Libellé';
			$libelle['en'] = 'Title';
			$feminin['fr'] = 'Féminin';
			$feminin['en'] = 'Female';
			$masculin['fr'] = 'Masculin';
			$masculin['en'] = 'Male';
			$total['fr'] = 'Total';
			$total['en'] = 'Global';
			$moyennes['fr'] = 'Moyennes';
			$moyennes['en'] = 'Averages';
			$sousMoyennes['fr'] = 'Sous - Moyennes';
			$sousMoyennes['en'] = 'Sub - Averages';
			$moyenneGenerale['fr'] = 'Moyenne Générale';
			$moyenneGenerale['en'] = 'General Average';
			$taux['fr'] = 'Taux Réussite';
			$taux['en'] = 'Percentage';
			$forteMoy['fr'] = 'Forte Moyenne';
			$forteMoy['en'] = 'Max Average';
			$faibleMoy['fr'] = 'Faible Moyenne';
			$faibleMoy['en'] = 'Low Average';
			$this->Cell(55,8,'',0,0,'C');
			$this->Cell(35,8,utf8_decode($libelle[$section]),1,0,'C',true);
			$this->Cell(20,8,utf8_decode($feminin[$section]),1,0,'C',true);
			$this->Cell(20,8,utf8_decode($masculin[$section]),1,0,'C',true);
			$this->Cell(20,8,utf8_decode($total[$section]),1,0,'C',true);
			$this->Ln(8);
			$this->Cell(55);
			$this->SetFont('Times','',10);
			$this->Cell(35,8,utf8_decode($moyennes[$section]),1,0,'C');
			$this->Cell(20,8,utf8_decode($_SESSION['statistique']['moyFille']),1,0,'C');
			$this->Cell(20,8,utf8_decode($_SESSION['statistique']['moyMasc']),1,0,'C');
			$this->Cell(20,8,utf8_decode($_SESSION['statistique']['moyTotal']),1,0,'C');
			$this->Ln(8);
			$this->Cell(55);
			$this->Cell(35,8,utf8_decode($sousMoyennes[$section]),1,0,'C');
			$this->Cell(20,8,utf8_decode($_SESSION['statistique']['sousMoyFille']),1,0,'C');
			$this->Cell(20,8,utf8_decode($_SESSION['statistique']['sousMoyMasc']),1,0,'C');
			$this->Cell(20,8,utf8_decode($_SESSION['statistique']['sousMoyTotal']),1,0,'C');
			$this->Ln(8);
			$this->Cell(55);
			$this->Cell(35,8,utf8_decode($moyenneGenerale[$section]),1,0,'C');
			$this->Cell(20,8,utf8_decode(substr($_SESSION['statistique']['moyGenFille'],0,5)),1,0,'C');
			$this->Cell(20,8,utf8_decode(substr($_SESSION['statistique']['moyGenMasc'],0,5)),1,0,'C');
			$this->Cell(20,8,utf8_decode(substr($_SESSION['statistique']['moyGenTotal'],0,5)),1,0,'C');
			$this->Ln(8);
			$this->Cell(55);
			$this->Cell(35,8,utf8_decode($taux[$section]),1,0,'C');
			$this->Cell(20,8,utf8_decode(substr($_SESSION['statistique']['tauxFille'],0,5).' %'),1,0,'C');
			$this->Cell(20,8,utf8_decode(substr($_SESSION['statistique']['tauxMasc'],0,5).' %'),1,0,'C');
			$this->Cell(20,8,utf8_decode(substr($_SESSION['statistique']['tauxTotal'],0,5).' %'),1,0,'C');
			$this->Ln(8);
			$this->Cell(55);
			$this->Cell(35,8,utf8_decode($forteMoy[$section]),1,0,'C');
			$this->Cell(20,8,utf8_decode($_SESSION['statistique']['noteForteFille']),1,0,'C');
			$this->Cell(20,8,utf8_decode($_SESSION['statistique']['noteForteMasc']),1,0,'C');
			$this->Cell(20,8,utf8_decode($_SESSION['statistique']['noteForteTotal']),1,0,'C');
			$this->Ln(8);
			$this->Cell(55);
			$this->Cell(35,8,utf8_decode($faibleMoy[$section]),1,0,'C');
			$this->Cell(20,8,utf8_decode($_SESSION['statistique']['noteFaibleFille']),1,0,'C');
			$this->Cell(20,8,utf8_decode($_SESSION['statistique']['noteFaibleMasc']),1,0,'C');
			$this->Cell(20,8,utf8_decode($_SESSION['statistique']['noteFaibleTotal']),1,0,'C');
			$this->Ln(10);

			// Informations du PV 
			$pvNumber['fr'] = 'N°';
			$pvNumber['en'] = 'N°';
			$pvMatricule['fr'] = 'Matricule';
			$pvMatricule['en'] = 'Identifier';
			$pvNom['fr'] = 'Noms et Prénoms';
			$pvNom['en'] = 'Student Name';
			$pvSexe['fr'] = 'Sexe';
			$pvSexe['en'] = 'Sex';
			$pvMoyenne['fr'] = 'Moyenne';
			$pvMoyenne['en'] = 'Average';
			$pvRang['fr'] = 'Rang';
			$pvRang['en'] = 'Rank';
			$pvAppr['fr'] = 'Appréc.';
			$pvAppr['en'] = 'Grade';
			$pvCote['fr'] = 'Cote';
			$pvCote['en'] = 'Cote';
			$pvObserv['fr'] = 'Observations';
			$pvObserv['en'] = 'Observations';
			$this->SetFont('Times','B',8);
			$this->Cell(10,5,utf8_decode($pvNumber[$section]	),1,0,'C',true);
			$this->Cell(20,5,utf8_decode($pvMatricule[$section]),1,0,'C',true);
			$this->Cell(55,5,utf8_decode($pvNom[$section]),1,0,'C',true);
			$this->Cell(10,5,utf8_decode($pvSexe[$section]),1,0,'C',true);
			$this->Cell(15,5,utf8_decode($pvMoyenne[$section]),1,0,'C',true);
			$this->Cell(10,5,utf8_decode($pvRang[$section]),1,0,'C',true);
			$this->Cell(15,5,utf8_decode($pvAppr[$section]),1,0,'C',true);
			$this->Cell(10,5,utf8_decode($pvCote[$section]),1,0,'C',true);
			$this->Cell(40,5,utf8_decode($pvObserv[$section]),1,0,'C',true);
			$this->Ln(5);
			$a = 1;
			$this->SetFont('Times','',9);
			for($i=0;$i<count($_SESSION['eleve']);$i++){
				$rneEleve = utf8_decode($_SESSION['eleve'][$i]['rne']);
				$nomEleve = utf8_decode(stripslashes(substr($_SESSION['eleve'][$i]['nom_eleve'],0,28)));
				$sexeEleve = utf8_decode($_SESSION['eleve'][$i]['sexe']);
				$moyenneEleve = $_SESSION['eleve'][$i]['moyenne'];
				$rankEleve = $_SESSION['eleve'][$i]['rang'];
				$apprEleve = $_SESSION['eleve'][$i]['appreciation'];
				$coteEleve = $_SESSION['eleve'][$i]['cote'];
				$this->Cell(10,5,utf8_decode($a),1,0,'C');
				$this->Cell(20,5,$rneEleve,1,0,'C');
				$this->Cell(55,5,$nomEleve,1,0,'L');
				$this->Cell(10,5,$sexeEleve,1,0,'C');
				$this->SetFont('Times','B',9);
				$this->Cell(15,5,$moyenneEleve,1,0,'C',true);
				$this->SetFont('Times','',9);
				$this->Cell(10,5,$rankEleve,1,0,'C');
				$this->Cell(15,5,$apprEleve,1,0,'C');
				$this->Cell(10,5,$coteEleve,1,0,'C');
				$this->Cell(40,5,utf8_decode(''),1,0,'C');
				$this->Ln(5);
				$a++;
			}
			$ville = $_SESSION['information']['ville'];
			$faitA['fr'] = 'Fait à '.strtoupper($ville).', le __________________.';
			$faitA['en'] = 'Done at '.strtoupper($ville).', the __________________.';
			$signataire['fr'] = $_SESSION['information']['signataire_fr'];
			$signataire['en'] = $_SESSION['information']['signataire_en'];
			$this->Ln(2);
			$this->Cell(125);
			$this->Cell(60,5, utf8_decode($faitA[$section]),0,0,'R');
			$this->Ln(5);
			$this->Cell(125);
			$this->SetFont('Times','BI',9);
			$this->Cell(60,5,utf8_decode($signataire[$section]),0,0,'C');
		}








		public function pvSequentielMerite($section){
			$this->addPage();
			$this->Entete();
			if($_SESSION['sequence']==1){
				$titreSequence['fr'] = 'Premiere Sequence';
				$titreSequence['en'] = 'First Sequence';
			}elseif($_SESSION['sequence']==2){
				$titreSequence['fr'] = 'Deuxieme Sequence';
				$titreSequence['en'] = 'Second Sequence';
			}elseif($_SESSION['sequence']==3){
				$titreSequence['fr'] = 'Troisieme Sequence';
				$titreSequence['en'] = 'Third Sequence';
			}elseif($_SESSION['sequence']==4){
				$titreSequence['fr'] = 'Quatrieme Sequence';
				$titreSequence['en'] = 'Fourth Sequence';
			}elseif($_SESSION['sequence']==5){
				$titreSequence['fr'] = 'Cinquieme Sequence';
				$titreSequence['en'] = 'Fifth Sequence';
			}elseif($_SESSION['sequence']==6){
				$titreSequence['fr'] = 'Sixieme Sequence';
				$titreSequence['en'] = 'Sixth Sequence';
			}
			$titre['fr'] = "Proces Verbal de la ".$titreSequence['fr'];
			$titre['en'] = "report of the ".$titreSequence['en'];
			$classe['fr'] = "Classe : ".strtoupper($_SESSION['nom_classe']);
			$classe['en'] = "Class : ".strtoupper($_SESSION['nom_classe']);
			$effectifClasse['fr'] = 'Effectif : '.count($_SESSION['eleve']);
			$effectifClasse['en'] = 'Roll : '.count($_SESSION['eleve']);
			$effectifEvalue['fr'] = 'Evalués : '.$_SESSION['eleve'][0]['classes'];
			$effectifEvalue['en'] = 'Evaluated : '.$_SESSION['eleve'][0]['classes'];

			$this->Titre($titre[$section]);

			$this->SetFont('Times','B',12);
			$this->Cell(85,5,utf8_decode($classe[$section]),0,0,'L');
			$this->Cell(35,5,utf8_decode($effectifClasse[$section]),0,0,'C');
			$this->Cell(35,5,utf8_decode($effectifEvalue[$section]),0,0,'C');
			$this->Ln(5);

			// Construction du tableau Informationnel statistique
			$libelle['fr'] = 'Libellé';
			$libelle['en'] = 'Title';
			$feminin['fr'] = 'Féminin';
			$feminin['en'] = 'Female';
			$masculin['fr'] = 'Masculin';
			$masculin['en'] = 'Male';
			$total['fr'] = 'Total';
			$total['en'] = 'Global';
			$moyennes['fr'] = 'Moyennes';
			$moyennes['en'] = 'Averages';
			$sousMoyennes['fr'] = 'Sous - Moyennes';
			$sousMoyennes['en'] = 'Sub - Averages';
			$moyenneGenerale['fr'] = 'Moyenne Générale';
			$moyenneGenerale['en'] = 'General Average';
			$taux['fr'] = 'Taux Réussite';
			$taux['en'] = 'Percentage';
			$forteMoy['fr'] = 'Forte Moyenne';
			$forteMoy['en'] = 'Max Average';
			$faibleMoy['fr'] = 'Faible Moyenne';
			$faibleMoy['en'] = 'Low Average';
			$this->Cell(55,8,'',0,0,'C');
			$this->Cell(35,8,utf8_decode($libelle[$section]),1,0,'C',true);
			$this->Cell(20,8,utf8_decode($feminin[$section]),1,0,'C',true);
			$this->Cell(20,8,utf8_decode($masculin[$section]),1,0,'C',true);
			$this->Cell(20,8,utf8_decode($total[$section]),1,0,'C',true);
			$this->Ln(8);
			$this->Cell(55);
			$this->SetFont('Times','',10);
			$this->Cell(35,8,utf8_decode($moyennes[$section]),1,0,'C');
			$this->Cell(20,8,utf8_decode($_SESSION['statistique']['moyFille']),1,0,'C');
			$this->Cell(20,8,utf8_decode($_SESSION['statistique']['moyMasc']),1,0,'C');
			$this->Cell(20,8,utf8_decode($_SESSION['statistique']['moyTotal']),1,0,'C');
			$this->Ln(8);
			$this->Cell(55);
			$this->Cell(35,8,utf8_decode($sousMoyennes[$section]),1,0,'C');
			$this->Cell(20,8,utf8_decode($_SESSION['statistique']['sousMoyFille']),1,0,'C');
			$this->Cell(20,8,utf8_decode($_SESSION['statistique']['sousMoyMasc']),1,0,'C');
			$this->Cell(20,8,utf8_decode($_SESSION['statistique']['sousMoyTotal']),1,0,'C');
			$this->Ln(8);
			$this->Cell(55);
			$this->Cell(35,8,utf8_decode($moyenneGenerale[$section]),1,0,'C');
			$this->Cell(20,8,utf8_decode(substr($_SESSION['statistique']['moyGenFille'],0,5)),1,0,'C');
			$this->Cell(20,8,utf8_decode(substr($_SESSION['statistique']['moyGenMasc'],0,5)),1,0,'C');
			$this->Cell(20,8,utf8_decode(substr($_SESSION['statistique']['moyGenTotal'],0,5)),1,0,'C');
			$this->Ln(8);
			$this->Cell(55);
			$this->Cell(35,8,utf8_decode($taux[$section]),1,0,'C');
			$this->Cell(20,8,utf8_decode(substr($_SESSION['statistique']['tauxFille'],0,5).' %'),1,0,'C');
			$this->Cell(20,8,utf8_decode(substr($_SESSION['statistique']['tauxMasc'],0,5).' %'),1,0,'C');
			$this->Cell(20,8,utf8_decode(substr($_SESSION['statistique']['tauxTotal'],0,5).' %'),1,0,'C');
			$this->Ln(8);
			$this->Cell(55);
			$this->Cell(35,8,utf8_decode($forteMoy[$section]),1,0,'C');
			$this->Cell(20,8,utf8_decode($_SESSION['statistique']['noteForteFille']),1,0,'C');
			$this->Cell(20,8,utf8_decode($_SESSION['statistique']['noteForteMasc']),1,0,'C');
			$this->Cell(20,8,utf8_decode($_SESSION['statistique']['noteForteTotal']),1,0,'C');
			$this->Ln(8);
			$this->Cell(55);
			$this->Cell(35,8,utf8_decode($faibleMoy[$section]),1,0,'C');
			$this->Cell(20,8,utf8_decode($_SESSION['statistique']['noteFaibleFille']),1,0,'C');
			$this->Cell(20,8,utf8_decode($_SESSION['statistique']['noteFaibleMasc']),1,0,'C');
			$this->Cell(20,8,utf8_decode($_SESSION['statistique']['noteFaibleTotal']),1,0,'C');
			$this->Ln(10);

			// Informations du PV 
			$pvNumber['fr'] = 'N°';
			$pvNumber['en'] = 'N°';
			$pvMatricule['fr'] = 'Matricule';
			$pvMatricule['en'] = 'Identifier';
			$pvNom['fr'] = 'Noms et Prénoms';
			$pvNom['en'] = 'Student Name';
			$pvSexe['fr'] = 'Sexe';
			$pvSexe['en'] = 'Sex';
			$pvMoyenne['fr'] = 'Moyenne';
			$pvMoyenne['en'] = 'Average';
			$pvRang['fr'] = 'Rang';
			$pvRang['en'] = 'Rank';
			$pvAppr['fr'] = 'Appréc.';
			$pvAppr['en'] = 'Grade';
			$pvCote['fr'] = 'Cote';
			$pvCote['en'] = 'Cote';
			$pvObserv['fr'] = 'Observations';
			$pvObserv['en'] = 'Observations';
			$this->SetFont('Times','B',8);
			$this->Cell(10,5,utf8_decode($pvNumber[$section]	),1,0,'C',true);
			$this->Cell(20,5,utf8_decode($pvMatricule[$section]),1,0,'C',true);
			$this->Cell(55,5,utf8_decode($pvNom[$section]),1,0,'C',true);
			$this->Cell(10,5,utf8_decode($pvSexe[$section]),1,0,'C',true);
			$this->Cell(15,5,utf8_decode($pvMoyenne[$section]),1,0,'C',true);
			$this->Cell(10,5,utf8_decode($pvRang[$section]),1,0,'C',true);
			$this->Cell(15,5,utf8_decode($pvAppr[$section]),1,0,'C',true);
			$this->Cell(10,5,utf8_decode($pvCote[$section]),1,0,'C',true);
			$this->Cell(40,5,utf8_decode($pvObserv[$section]),1,0,'C',true);
			$this->Ln(5);
			$a = 1;
			$this->SetFont('Times','',9);
			for($i=0;$i<count($_SESSION['eleve2']);$i++){
				$rneEleve = utf8_decode($_SESSION['eleve2'][$i]['rne']);
				$nomEleve = utf8_decode(stripslashes(substr($_SESSION['eleve2'][$i]['nom_eleve'],0,28)));
				$sexeEleve = utf8_decode($_SESSION['eleve2'][$i]['sexe']);
				$moyenneEleve = $_SESSION['eleve2'][$i]['moyenne'];
				$rankEleve = $_SESSION['eleve2'][$i]['rang'];
				$apprEleve = $_SESSION['eleve2'][$i]['appreciation'];
				$coteEleve = $_SESSION['eleve2'][$i]['cote'];
				$this->Cell(10,5,utf8_decode($a),1,0,'C');
				$this->Cell(20,5,$rneEleve,1,0,'C');
				$this->Cell(55,5,$nomEleve,1,0,'L');
				$this->Cell(10,5,$sexeEleve,1,0,'C');
				$this->SetFont('Times','B',9);
				$this->Cell(15,5,$moyenneEleve,1,0,'C',true);
				$this->SetFont('Times','',9);
				$this->Cell(10,5,$rankEleve,1,0,'C');
				$this->Cell(15,5,$apprEleve,1,0,'C');
				$this->Cell(10,5,$coteEleve,1,0,'C');
				$this->Cell(40,5,utf8_decode(''),1,0,'C');
				$this->Ln(5);
				$a++;
			}
			$ville = $_SESSION['information']['ville'];
			$faitA['fr'] = 'Fait à '.strtoupper($ville).', le __________________.';
			$faitA['en'] = 'Done at '.strtoupper($ville).', the __________________.';
			$signataire['fr'] = $_SESSION['information']['signataire_fr'];
			$signataire['en'] = $_SESSION['information']['signataire_en'];
			$this->Ln(2);
			$this->Cell(125);
			$this->Cell(60,5, utf8_decode($faitA[$section]),0,0,'R');
			$this->Ln(5);
			$this->Cell(125);
			$this->SetFont('Times','BI',9);
			$this->Cell(60,5,utf8_decode($signataire[$section]),0,0,'C');
		}









		public function pvTrimestrielMerite($section){
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
			$titre['fr'] = "Proces Verbal du ".$titreTrimestre['fr'];
			$titre['en'] = "report of the ".$titreTrimestre['en'];
			$classe['fr'] = "Classe : ".strtoupper($_SESSION['nom_classe']);
			$classe['en'] = "Class : ".strtoupper($_SESSION['nom_classe']);
			$effectifClasse['fr'] = 'Effectif : '.count($_SESSION['eleve']);
			$effectifClasse['en'] = 'Roll : '.count($_SESSION['eleve']);
			$effectifEvalue['fr'] = 'Evalués : '.$_SESSION['eleve'][0]['classes'];
			$effectifEvalue['en'] = 'Evaluated : '.$_SESSION['eleve'][0]['classes'];

			$this->Titre($titre[$section]);

			$this->SetFont('Times','B',12);
			$this->Cell(85,5,utf8_decode($classe[$section]),0,0,'L');
			$this->Cell(35,5,utf8_decode($effectifClasse[$section]),0,0,'C');
			$this->Cell(35,5,utf8_decode($effectifEvalue[$section]),0,0,'C');
			$this->Ln(5);

			// Construction du tableau Informationnel statistique
			$libelle['fr'] = 'Libellé';
			$libelle['en'] = 'Title';
			$feminin['fr'] = 'Féminin';
			$feminin['en'] = 'Female';
			$masculin['fr'] = 'Masculin';
			$masculin['en'] = 'Male';
			$total['fr'] = 'Total';
			$total['en'] = 'Global';
			$moyennes['fr'] = 'Moyennes';
			$moyennes['en'] = 'Averages';
			$sousMoyennes['fr'] = 'Sous - Moyennes';
			$sousMoyennes['en'] = 'Sub - Averages';
			$moyenneGenerale['fr'] = 'Moyenne Générale';
			$moyenneGenerale['en'] = 'General Average';
			$taux['fr'] = 'Taux Réussite';
			$taux['en'] = 'Percentage';
			$forteMoy['fr'] = 'Forte Moyenne';
			$forteMoy['en'] = 'Max Average';
			$faibleMoy['fr'] = 'Faible Moyenne';
			$faibleMoy['en'] = 'Low Average';
			$this->Cell(55,8,'',0,0,'C');
			$this->Cell(35,8,utf8_decode($libelle[$section]),1,0,'C',true);
			$this->Cell(20,8,utf8_decode($feminin[$section]),1,0,'C',true);
			$this->Cell(20,8,utf8_decode($masculin[$section]),1,0,'C',true);
			$this->Cell(20,8,utf8_decode($total[$section]),1,0,'C',true);
			$this->Ln(8);
			$this->Cell(55);
			$this->SetFont('Times','',10);
			$this->Cell(35,8,utf8_decode($moyennes[$section]),1,0,'C');
			$this->Cell(20,8,utf8_decode($_SESSION['statistique']['moyFille']),1,0,'C');
			$this->Cell(20,8,utf8_decode($_SESSION['statistique']['moyMasc']),1,0,'C');
			$this->Cell(20,8,utf8_decode($_SESSION['statistique']['moyTotal']),1,0,'C');
			$this->Ln(8);
			$this->Cell(55);
			$this->Cell(35,8,utf8_decode($sousMoyennes[$section]),1,0,'C');
			$this->Cell(20,8,utf8_decode($_SESSION['statistique']['sousMoyFille']),1,0,'C');
			$this->Cell(20,8,utf8_decode($_SESSION['statistique']['sousMoyMasc']),1,0,'C');
			$this->Cell(20,8,utf8_decode($_SESSION['statistique']['sousMoyTotal']),1,0,'C');
			$this->Ln(8);
			$this->Cell(55);
			$this->Cell(35,8,utf8_decode($moyenneGenerale[$section]),1,0,'C');
			$this->Cell(20,8,utf8_decode(substr($_SESSION['statistique']['moyGenFille'],0,5)),1,0,'C');
			$this->Cell(20,8,utf8_decode(substr($_SESSION['statistique']['moyGenMasc'],0,5)),1,0,'C');
			$this->Cell(20,8,utf8_decode(substr($_SESSION['statistique']['moyGenTotal'],0,5)),1,0,'C');
			$this->Ln(8);
			$this->Cell(55);
			$this->Cell(35,8,utf8_decode($taux[$section]),1,0,'C');
			$this->Cell(20,8,utf8_decode(substr($_SESSION['statistique']['tauxFille'],0,5).' %'),1,0,'C');
			$this->Cell(20,8,utf8_decode(substr($_SESSION['statistique']['tauxMasc'],0,5).' %'),1,0,'C');
			$this->Cell(20,8,utf8_decode(substr($_SESSION['statistique']['tauxTotal'],0,5).' %'),1,0,'C');
			$this->Ln(8);
			$this->Cell(55);
			$this->Cell(35,8,utf8_decode($forteMoy[$section]),1,0,'C');
			$this->Cell(20,8,utf8_decode($_SESSION['statistique']['noteForteFille']),1,0,'C');
			$this->Cell(20,8,utf8_decode($_SESSION['statistique']['noteForteMasc']),1,0,'C');
			$this->Cell(20,8,utf8_decode($_SESSION['statistique']['noteForteTotal']),1,0,'C');
			$this->Ln(8);
			$this->Cell(55);
			$this->Cell(35,8,utf8_decode($faibleMoy[$section]),1,0,'C');
			$this->Cell(20,8,utf8_decode($_SESSION['statistique']['noteFaibleFille']),1,0,'C');
			$this->Cell(20,8,utf8_decode($_SESSION['statistique']['noteFaibleMasc']),1,0,'C');
			$this->Cell(20,8,utf8_decode($_SESSION['statistique']['noteFaibleTotal']),1,0,'C');
			$this->Ln(10);

			// Informations du PV 
			$pvNumber['fr'] = 'N°';
			$pvNumber['en'] = 'N°';
			$pvMatricule['fr'] = 'Matricule';
			$pvMatricule['en'] = 'Identifier';
			$pvNom['fr'] = 'Noms et Prénoms';
			$pvNom['en'] = 'Student Name';
			$pvSexe['fr'] = 'Sexe';
			$pvSexe['en'] = 'Sex';
			$pvMoyenne['fr'] = 'Moyenne';
			$pvMoyenne['en'] = 'Average';
			$pvRang['fr'] = 'Rang';
			$pvRang['en'] = 'Rank';
			$pvAppr['fr'] = 'Appréc.';
			$pvAppr['en'] = 'Grade';
			$pvCote['fr'] = 'Cote';
			$pvCote['en'] = 'Cote';
			$pvObserv['fr'] = 'Observations';
			$pvObserv['en'] = 'Observations';
			$this->SetFont('Times','B',8);
			$this->Cell(10,5,utf8_decode($pvNumber[$section]	),1,0,'C',true);
			$this->Cell(20,5,utf8_decode($pvMatricule[$section]),1,0,'C',true);
			$this->Cell(55,5,utf8_decode($pvNom[$section]),1,0,'C',true);
			$this->Cell(10,5,utf8_decode($pvSexe[$section]),1,0,'C',true);
			$this->Cell(15,5,utf8_decode($pvMoyenne[$section]),1,0,'C',true);
			$this->Cell(10,5,utf8_decode($pvRang[$section]),1,0,'C',true);
			$this->Cell(15,5,utf8_decode($pvAppr[$section]),1,0,'C',true);
			$this->Cell(10,5,utf8_decode($pvCote[$section]),1,0,'C',true);
			$this->Cell(40,5,utf8_decode($pvObserv[$section]),1,0,'C',true);
			$this->Ln(5);
			$a = 1;
			$this->SetFont('Times','',9);
			for($i=0;$i<count($_SESSION['eleve2']);$i++){
				$rneEleve = utf8_decode($_SESSION['eleve2'][$i]['rne']);
				$nomEleve = utf8_decode(stripslashes(substr($_SESSION['eleve2'][$i]['nom_eleve'],0,28)));
				$sexeEleve = utf8_decode($_SESSION['eleve2'][$i]['sexe']);
				$moyenneEleve = $_SESSION['eleve2'][$i]['moyenne'];
				$rankEleve = $_SESSION['eleve2'][$i]['rang'];
				$apprEleve = $_SESSION['eleve2'][$i]['appreciation'];
				$coteEleve = $_SESSION['eleve2'][$i]['cote'];
				$this->Cell(10,5,utf8_decode($a),1,0,'C');
				$this->Cell(20,5,$rneEleve,1,0,'C');
				$this->Cell(55,5,$nomEleve,1,0,'L');
				$this->Cell(10,5,$sexeEleve,1,0,'C');
				$this->SetFont('Times','B',9);
				$this->Cell(15,5,$moyenneEleve,1,0,'C',true);
				$this->SetFont('Times','',9);
				$this->Cell(10,5,$rankEleve,1,0,'C');
				$this->Cell(15,5,$apprEleve,1,0,'C');
				$this->Cell(10,5,$coteEleve,1,0,'C');
				$this->Cell(40,5,utf8_decode(''),1,0,'C');
				$this->Ln(5);
				$a++;
			}
			$ville = $_SESSION['information']['ville'];
			$faitA['fr'] = 'Fait à '.strtoupper($ville).', le __________________.';
			$faitA['en'] = 'Done at '.strtoupper($ville).', the __________________.';
			$signataire['fr'] = $_SESSION['information']['signataire_fr'];
			$signataire['en'] = $_SESSION['information']['signataire_en'];
			$this->Ln(2);
			$this->Cell(125);
			$this->Cell(60,5, utf8_decode($faitA[$section]),0,0,'R');
			$this->Ln(5);
			$this->Cell(125);
			$this->SetFont('Times','BI',9);
			$this->Cell(60,5,utf8_decode($signataire[$section]),0,0,'C');
		}








		public function bulletinSequentiel($eleve, $section){
			$this->addPage();
			$this->Entete();
			if($_SESSION['sequence']==1){
				$titreSequence['fr'] = 'Premiere Sequence';
				$titreSequence['en'] = 'First Sequence';
			}elseif($_SESSION['sequence']==2){
				$titreSequence['fr'] = 'Deuxieme Sequence';
				$titreSequence['en'] = 'Second Sequence';
			}elseif($_SESSION['sequence']==3){
				$titreSequence['fr'] = 'Troisieme Sequence';
				$titreSequence['en'] = 'Third Sequence';
			}elseif($_SESSION['sequence']==4){
				$titreSequence['fr'] = 'Quatrieme Sequence';
				$titreSequence['en'] = 'Fourth Sequence';
			}elseif($_SESSION['sequence']==5){
				$titreSequence['fr'] = 'Cinquieme Sequence';
				$titreSequence['en'] = 'Fifth Sequence';
			}elseif($_SESSION['sequence']==6){
				$titreSequence['fr'] = 'Sixieme Sequence';
				$titreSequence['en'] = 'Sixth Sequence';
			}
			// On met le titre du document 
			$titre['fr'] = "Bulletin de Notes de la ".$titreSequence['fr'];
			$titre['en'] = "Reported marks of the ".$titreSequence['en'];
			$this->SetFont('Times','BUI',14);
			$this->Text(40,75,strtoupper(utf8_decode($titre[$section])));

			$this->SetFont('Times','',10);
			$lib_nom['fr'] = 'Noms et Prénoms : ';
			$lib_nom['en'] = 'Student Name :';
			$lib_classe['fr'] = 'Classe de  : ';
			$lib_classe['en'] = 'Class  : ';
			$lib_matricule['fr'] = 'Matricule. : ';
			$lib_matricule['en'] = 'Identifier. : ';
			$lib_effectif['fr'] = 'Effectif Classe : ';
			$lib_effectif['en'] = 'Roll : ';
			$lib_dateNaissance['fr'] = 'Date de Naissance : ';
			$lib_dateNaissance['en'] = 'Date of birth : ';
			$lib_lieuNaissance['fr'] = 'à : ';
			$lib_lieuNaissance['en'] = 'at : ';
			$lib_sexe['fr'] = 'Sexe : ';
			$lib_sexe['en'] = 'Sex : ';
			$lib_redoublant['fr'] = 'Redoublant : ';
			$lib_redoublant['en'] = 'Repeater : ';
			$lib_titulaire['fr'] = 'Professeur Principal : ';
			$lib_titulaire['en'] = 'Class Principal : ';
			$this->Text(20,85,utf8_decode($lib_nom[$section]));
			$this->Text(120,85,utf8_decode($lib_classe[$section]));
			$this->Text(20,90,utf8_decode($lib_matricule[$section]));
			$this->Text(120,90,utf8_decode($lib_effectif[$section]));
			$this->Text(20,95,utf8_decode($lib_dateNaissance[$section]));
			$this->Text(100,95,utf8_decode($lib_lieuNaissance[$section]));
			$this->Text(20,100,utf8_decode($lib_sexe[$section]));
			$this->Text(50,100,utf8_decode($lib_redoublant[$section]));
			$this->Text(100,100,utf8_decode($lib_titulaire[$section]));

			$this->SetFont('Times','B',10);
			$nom = substr($eleve['nom_eleve'],0,30);
			$nomClasse = strtoupper($_SESSION['nom_classe']);
			$matricule = $eleve['rne'];
			$effectif = $_SESSION['effectif'];
			$dateNaissance = $eleve['date_fr'];
			$lieuNaissance = $eleve['lieu_naissance'];
			$sexe = $eleve['sexe'];
			$redoublant = $eleve['statut'];
			$titulaire = ''; /*$_SESSION['professeurPrincipal'];*/
			$image =$eleve['photo'];
			$this->Text(50,85,utf8_decode($nom));
			$this->Text(140,85,utf8_decode($nomClasse));
			$this->Text(40,90,utf8_decode($matricule));
			$this->Text(150,90,utf8_decode($effectif));
			$this->Text(55,95,utf8_decode($dateNaissance));
			$this->Text(105,95,utf8_decode($lieuNaissance));
			$this->Text(30,100,utf8_decode($sexe));
			$this->Text(70,100,utf8_decode($redoublant));
			$this->Text(135,100,utf8_decode($titulaire));
			$this->Image($image, 170, 77, 22, 22);

			// On créé un espace supplémentaire entre le tableau et les info du haut
			$this->Ln(40);
			$this->SetFont('Times','B',8);
			$bullMatiere['fr'] = 'Matière';
			$bullMatiere['en'] = 'Subject';
			$bullCompetence['fr'] = 'Competence';
			$bullCompetence['en'] = 'Skill';
			$bullNote['fr'] = 'Note /20';
			$bullNote['en'] = 'Mark /20';
			$bullCoef['fr'] = 'Coef';
			$bullCoef['en'] = 'Coef';
			$bullProduit['fr'] = 'Produit';
			$bullProduit['en'] = 'Product';
			$bullMinMax['fr'] = 'Min - Max';
			$bullMinMax['en'] = 'Min - Max';
			$bullAppr['fr'] = 'Appréciation';
			$bullAppr['en'] = 'Grade';
			$bullCote['fr'] = 'Cote';
			$bullCote['en'] = 'Cote';
			$bullParaphe['fr'] = 'Paraphe Ens.';
			$bullParaphe['en'] = 'Teacher Obs.';
			$this->Cell(8);
			$this->Cell(40,5, utf8_decode($bullMatiere[$section]),1,0,'C',true);
			$this->Cell(35,5, utf8_decode($bullCompetence[$section]),1,0,'C',true);
			$this->Cell(12,5, utf8_decode($bullNote[$section]),1,0,'C',true);
			$this->Cell(10,5, utf8_decode($bullCoef[$section]),1,0,'C',true);
			$this->Cell(15,5, utf8_decode($bullProduit[$section]),1,0,'C',true);
			$this->Cell(18,5, utf8_decode($bullMinMax[$section]),1,0,'C',true);
			// $this->Cell(10,5, utf8_decode('Max'),1,0,'C',true);
			$this->Cell(22,5, utf8_decode($bullAppr[$section]),1,0,'C',true);
			$this->Cell(10,5, utf8_decode($bullCote[$section]),1,0,'C',true);
			$this->Cell(20,5, utf8_decode($bullParaphe[$section]),1,0,'C',true);
			$this->SetFont('Times','',8);
			$this->Ln(5);
			// On ressort une boucle qui liste les groupes définis
			for($b=0;$b<count($_SESSION['groupe']);$b++){
				$codeGroupe = $_SESSION['groupe'][$b]['code_groupe'];
				$idGroupe = $_SESSION['groupe'][$b]['groupe'];
				$nomGroupe = $_SESSION['groupe'][$b]['nom_groupe'];
				$matieresGroupe = $_SESSION['matiereGroupe'][$idGroupe];
				for($c=0;$c<count($matieresGroupe);$c++){
					$codeMatiere = $matieresGroupe[$c]['code_matiere'];
					$competence = strtolower($codeMatiere.'_competence');
					$sekence = strtolower($codeMatiere.'_seq');
					$coef = strtolower($codeMatiere.'_coef');
					$produit = strtolower($codeMatiere.'_total');
					$min = strtolower($codeMatiere.'_min');
					$max = strtolower($codeMatiere.'_max');
					$appr = strtolower($codeMatiere.'_appreciation');
					$cote = strtolower($codeMatiere.'_cote');
					$enseignant = strtolower($codeMatiere.'_enseignant');
					$nomMatiere = strtoupper($matieresGroupe[$c]['nom_matiere']);
					// $this->Cell(12,6, utf8_decode($eleve[$a][$seq1]),1,0,'C');
					// $this->SetFont('Times','B',8);
					$this->Cell(8);
					$this->Cell(40,3, substr($nomMatiere,0,23),'TRL',0,'L');
							
					$this->SetFont('Times','',5);
					$competenceEvaluee = strtolower(utf8_decode(substr($eleve[$competence],0,45)));
					$minMax = "[".$eleve[$min]." - ".$eleve[$max]."]";
					$this->Cell(35,6, $competenceEvaluee,1,0,'L');
					$this->SetFont('Times','',8);
					$this->Cell(12,6, utf8_decode($eleve[$sekence]),1,0,'C');
					$this->Cell(10,6, utf8_decode($eleve[$coef]),1,0,'C');
					$this->SetFont('Times','B',8);
					$this->Cell(15,6, utf8_decode($eleve[$produit]),1,0,'C',true);
					$this->SetFont('Times','',8);
					$this->Cell(18,6, $minMax,1,0,'C');
					// $this->Cell(10,6, utf8_decode($eleve[$a][$max]),1,0,'C');
					$this->Cell(22,6, utf8_decode($eleve[$appr]),1,0,'C');
					$this->Cell(10,6, utf8_decode($eleve[$cote]),1,0,'C');
					$this->Cell(20,6, utf8_decode(''),1,0,'C');
					$this->SetFont('Times','',8);
					// $this->Ln(6);
					$this->Ln(3);
					$this->SetFont('Times','I',7);
					$this->Cell(8);
					$this->Cell(40,3, utf8_decode($eleve[$enseignant]),'BRL',0,'L');
					/*$this->SetFont('Times','',7);
					$this->Cell(35,3, utf8_decode(substr($eleve[$a][$competence],20,35)),1,0,'L');*/
					$this->Ln(3);
					$this->SetFont('Times','',8);
				}
				$this->Cell(8);
				$this->SetFont('Times','B',8);
				$moyenneGroupe = $codeGroupe.'_moyenne';
				$coefGroupe = $codeGroupe.'_coef';
				$totalGroupe = $codeGroupe.'_total';
				$minGroupe = $codeGroupe.'_min';
				$maxGroupe = $codeGroupe.'_max';
				$apprGroupe = $codeGroupe.'_appreciation';
				$coteGroupe = $codeGroupe.'_cote';
				$minMaxGroupe = "[".$eleve[$minGroupe]."- ".$eleve[$maxGroupe]."]";
				$texteTotalGroupe['fr'] = 'Total du Groupe ';
				$texteTotalGroupe['en'] = 'Total of the group ';
				$this->Cell(75,5, utf8_decode(strtoupper($texteTotalGroupe[$section].$nomGroupe)),1,0,'L',true);
				$this->Cell(12,5, utf8_decode(utf8_decode($eleve[$moyenneGroupe])),1,0,'C',true);
				$this->Cell(10,5, utf8_decode($eleve[$coefGroupe]),1,0,'C',true);
				$this->Cell(15,5, utf8_decode($eleve[$totalGroupe]),1,0,'C',true);
				$this->Cell(18,5, $minMaxGroupe,1,0,'C',true);
				// $this->Cell(10,5, $eleve[$a][$maxGroupe],1,0,'C',true);
				$this->Cell(22,5, $eleve[$apprGroupe],1,0,'C',true);
				$this->Cell(10,5, $eleve[$coteGroupe],1,0,'C',true);
				$this->Cell(20,5, '',1,0,'C',true);
				$this->Ln(5);
				$this->SetFont('Times','',7);
			}
			$this->SetFont('Times','B',9);
			$txtTotal['fr'] = 'TOTAL';
			$txtTotal['en'] = 'TOTAL';
			$txtMoy['fr'] = 'Moyenne Obtenue';
			$txtMoy['en'] = 'Average';
			$txtDiscipline['fr'] = 'Discipline';
			$txtDiscipline['en'] = 'Discipline';
			$txtTravail['fr'] = 'Travail';
			$txtTravail['en'] = 'Work';
			$txtProfil['fr'] = 'Profil de la Classe';
			$txtProfil['en'] = 'Class Profile';
			$absNJust['fr'] = 'Abs Non Just.';
			$absNJust['en'] = 'Abs Not Just.';
			$avc['fr'] = 'Avert. Cond.';
			$avc['en'] = 'Avert. Cond.';
			$totalGen['fr'] = 'Total Gén.';
			$totalGen['en'] = 'Global';
			$appreci['fr'] = 'Appréciation';
			$appreci['en'] = 'Grade';
			$moyenneClasse['fr'] = 'Moyenne Générale';
			$moyenneClasse['en'] = 'Class Average';
			$absJust['fr'] = 'Abs Just.';
			$absJust['en'] = 'Abs Just.';
			$bc['fr'] = 'Blâme. Cond.';
			$bc['en'] = 'Blâme. Cond.';
			$ret['fr'] = 'Retards';
			$ret['en'] = 'Retards';
			$exclusion['fr'] = 'Exclusions';
			$exclusion['en'] = 'Exclusions';
			$moyenneEleve['fr'] = 'Moyenne';
			$moyenneEleve['en'] = 'Average';
			$nbMoyenne['fr'] = 'Nb Moyennes';
			$nbMoyenne['en'] = 'Nb Aver.';
			$consigne['fr'] = 'Consignes';
			$consigne['en'] = 'Consignes';
			$exclusionDef['fr'] = 'Excl. Déf.';
			$exclusionDef['en'] = 'Excl. Déf.';
			$coteEleve['fr'] = 'Côte';
			$coteEleve['en'] = 'Cote';
			$taux['fr'] = 'Taux de Réussite';
			$taux['en'] = 'Percentage';
			$rank['fr'] = 'Rang';
			$rank['en'] = 'Rank';
			$ville = $_SESSION['information']['ville'];
			$faitA['fr'] = 'Fait à '.strtoupper($ville).' le ________________';
			$faitA['en'] = 'Done at '.strtoupper($ville).' the ________________';
			$parent['fr'] = 'Le Parent';
			$parent['en'] = 'The Parent';
			$pp['fr'] = 'Le Professeur Principal';
			$pp['en'] = 'The Class Principal';
			$signataire['fr'] = $_SESSION['information']['signataire_fr'];
			$signataire['en'] = $_SESSION['information']['signataire_en'];

			$this->Ln(1);
			$this->Cell(8);
			$this->Cell(87,5, utf8_decode($txtTotal[$section]),1,0,'C',true);
			// $this->Cell(12,6, utf8_decode($eleve[$a]['moyenne']),1,0,'C',true);
			$this->Cell(10,5, utf8_decode($eleve['total_coef']),1,0,'C',true);
			$this->Cell(15,5, utf8_decode($eleve['total_point']),1,0,'C',true);
			$this->Cell(35,5, utf8_decode($txtMoy[$section]),1,0,'C',true);
			$this->Cell(25,5, utf8_decode(ucwords($eleve['moyenne'])),1,0,'L',true);
			$this->Ln(6);
			$this->Cell(8);

			$this->Cell(53,6,utf8_decode($txtDiscipline[$section]), 1,0,'C',true);
			$this->Cell(5, 6, utf8_decode(''),0,0,'C');
			$this->Cell(53,6,utf8_decode($txtTravail[$section]), 1,0,'C',true);
			$this->Cell(5, 6, utf8_decode(''),0,0,'C');
			$this->Cell(53,6,utf8_decode($txtProfil[$section]), 1,0,'C',true);
			$this->Ln(6);
			$this->Cell(8);

			$this->Cell(20,6,utf8_decode($absNJust[$section]), 1,0,'C');
			$this->Cell(6,6,utf8_decode(''), 1,0,'C');
			$this->Cell(20,6,utf8_decode($avc[$section]), 1,0,'C');
			$this->Cell(7,6,utf8_decode(''), 1,0,'C');
			$this->Cell(5, 6, utf8_decode(''),0,0,'C');
			$this->Cell(17,6,utf8_decode($totalGen[$section]), 1,0,'C');
			$this->Cell(10,6,utf8_decode($eleve['total_point']), 1,0,'C');
			$this->Cell(26,6,utf8_decode($appreci[$section]), 1,0,'C');
			$this->Cell(5, 6, utf8_decode(''),0,0,'C');
			$this->Cell(30,6,utf8_decode($moyenneClasse[$section]), 1,0,'C');
			$this->Cell(23,6,$_SESSION['statistique']['moyGenTotal'], 1,0,'C');
			$this->Ln(6);
			$this->Cell(8);

			$this->Cell(20,6,utf8_decode($absJust[$section]), 1,0,'C');
			$this->Cell(6,6,utf8_decode(''), 1,0,'C');
			$this->Cell(20,6,utf8_decode($bc[$section]), 1,0,'C');
			$this->Cell(7,6,utf8_decode(''), 1,0,'C');
			$this->Cell(5, 6, utf8_decode(''),0,0,'C');
			$this->Cell(17,6,utf8_decode('Coef'), 1,0,'C');
			$this->Cell(10,6,utf8_decode($eleve['total_coef']), 1,0,'C');
			$this->Cell(26,6,utf8_decode($eleve['appreciation']), 1,0,'C');
			$this->Cell(5, 6, utf8_decode(''),0,0,'C');
			$minMax = "[ ".$_SESSION['statistique']['noteFaibleTotal'];
			$minMax .= " - ".$_SESSION['statistique']['noteForteTotal'];
			$minMax .= " ]";
			$this->Cell(30,6,utf8_decode('[Min - Max]'), 1,0,'C');
			$this->Cell(23,6,$minMax, 1,0,'C');
			$this->Ln(6);
			$this->Cell(8);

			$this->Cell(20,6,utf8_decode($ret[$section]), 1,0,'C');
			$this->Cell(6,6,utf8_decode(''), 1,0,'C');
			$this->Cell(20,6,utf8_decode($exclusion[$section]), 1,0,'C');
			$this->Cell(7,6,utf8_decode(''), 1,0,'C');
			$this->Cell(5, 6, utf8_decode(''),0,0,'C');
			$this->Cell(27,6,utf8_decode($moyenneEleve[$section]), 1,0,'C');
			$this->Cell(26,6,utf8_decode($eleve['moyenne']), 1,0,'C');
			// $this->Cell(26,6,'', 1,0,'C');
			$this->Cell(5, 6, utf8_decode(''),0,0,'C');
			$this->Cell(30,6,utf8_decode($nbMoyenne[$section]), 1,0,'C');
			$this->Cell(23,6,$_SESSION['statistique']['moyTotal'], 1,0,'C');
			$this->Ln(6);
			$this->Cell(8);

			$this->Cell(20,6,utf8_decode($consigne[$section]), 1,0,'C');
			$this->Cell(6,6,utf8_decode(''), 1,0,'C');
			$this->Cell(20,6,utf8_decode($exclusionDef[$section]), 1,0,'C');
			$this->Cell(7,6,utf8_decode(''), 1,0,'C');
			$this->Cell(5, 6, utf8_decode(''),0,0,'C');
			$this->Cell(27,6,utf8_decode($coteEleve[$section]), 1,0,'C');
			$this->Cell(26,6,utf8_decode($eleve['cote']), 1,0,'C');
			// $this->Cell(26,6,'', 1,0,'C');
			$this->Cell(5, 6, utf8_decode(''),0,0,'C');
			$this->Cell(30,6,utf8_decode($taux[$section]), 1,0,'C');
			$this->Cell(23,6,$_SESSION['statistique']['tauxTotal'].' %', 1,0,'C');
			$this->Ln(6);
			$this->Cell(8);

			$this->Cell(46,6,utf8_decode(''), 0,0,'C');
			$this->Cell(7,6,utf8_decode(''), 0,0,'C');
			$this->Cell(5, 6, utf8_decode(''),0,0,'C');
			$this->Cell(27,6,$rank[$section], 1,0,'C');
			$rangEleve = utf8_decode($eleve['rang']).' / '.$eleve['classes'];
			$this->Cell(26,6,$rangEleve, 1,0,'C');
			$this->Cell(5, 6, '',0,0,'C');
			$this->Cell(53,6,utf8_decode(''), 0,0,'C');
			$this->Ln(6);
			$this->Cell(8);

			$this->Cell(46,6,utf8_decode(''), 0,0,'C');
			$this->Cell(7,6,utf8_decode(''), 0,0,'C');
			$this->Cell(5, 6, utf8_decode(''),0,0,'C');
			$this->Cell(27,6,'', 0,0,'C');
			$this->Cell(26,6,'', 0,0,'C');
			$this->Cell(5, 6, '',0,0,'C');
			$this->Cell(53,6,utf8_decode($faitA[$section]), 0,0,'C');
			$this->Ln(3);
			$this->Cell(8);

			$this->Cell(46,6,utf8_decode($parent[$section]), 0,0,'C');
			$this->Cell(7,6,utf8_decode(''), 0,0,'C');
			$this->Cell(5, 6, utf8_decode(''),0,0,'C');
			$this->Cell(53,6,$pp[$section], 0,0,'C');
			$this->Cell(5, 6, utf8_decode(''),0,0,'C');
			$this->Cell(53,6,$signataire[$section], 0,0,'C');
			$this->Ln(6);
			$this->Cell(8);
			$this->SetFont('Times','B',9);
		}









		public function bulletinTrimestriel($eleve, $section){
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
			$titre['fr'] = "Bulletin de Notes du ".$titreTrimestre['fr'];
			$titre['en'] = "Reported marks of the ".$titreTrimestre['en'];
			$this->SetFont('Times','BUI',14);
			$this->Text(40,75,strtoupper(utf8_decode($titre[$section])));

			$this->SetFont('Times','',10);
			$lib_nom['fr'] = 'Noms et Prénoms : ';
			$lib_nom['en'] = 'Student Name :';
			$lib_classe['fr'] = 'Classe de  : ';
			$lib_classe['en'] = 'Class  : ';
			$lib_matricule['fr'] = 'Matricule. : ';
			$lib_matricule['en'] = 'Identifier. : ';
			$lib_effectif['fr'] = 'Effectif Classe : ';
			$lib_effectif['en'] = 'Roll : ';
			$lib_dateNaissance['fr'] = 'Date de Naissance : ';
			$lib_dateNaissance['en'] = 'Date of birth : ';
			$lib_lieuNaissance['fr'] = 'à : ';
			$lib_lieuNaissance['en'] = 'at : ';
			$lib_sexe['fr'] = 'Sexe : ';
			$lib_sexe['en'] = 'Sex : ';
			$lib_redoublant['fr'] = 'Redoublant : ';
			$lib_redoublant['en'] = 'Repeater : ';
			$lib_titulaire['fr'] = 'Professeur Principal : ';
			$lib_titulaire['en'] = 'Class Principal : ';
			$this->Text(40,85,utf8_decode($lib_nom[$section]));
			$this->Text(140,85,utf8_decode($lib_classe[$section]));
			$this->Text(40,90,utf8_decode($lib_matricule[$section]));
			$this->Text(140,90,utf8_decode($lib_effectif[$section]));
			$this->Text(40,95,utf8_decode($lib_dateNaissance[$section]));
			$this->Text(120,95,utf8_decode($lib_lieuNaissance[$section]));
			$this->Text(40,100,utf8_decode($lib_sexe[$section]));
			$this->Text(70,100,utf8_decode($lib_redoublant[$section]));
			$this->Text(120,100,utf8_decode($lib_titulaire[$section]));

			$this->SetFont('Times','B',10);
			$nom = substr($eleve['nom_eleve'],0,30);
			$nomClasse = substr(strtoupper($_SESSION['nom_classe']),0,30);
			$matricule = $eleve['rne'];
			$effectif = $_SESSION['effectif'];
			$dateNaissance = $eleve['date_fr'];
			$lieuNaissance = $eleve['lieu_naissance'];
			$sexe = $eleve['sexe'];
			$redoublant = $eleve['statut'];
			$titulaire = substr($eleve['titulaire'],0,20);
			$image =$eleve['photo'];
			$this->Text(70,85,utf8_decode($nom));
			$this->Text(160,85,utf8_decode($nomClasse));
			$this->Text(60,90,utf8_decode($matricule));
			$this->Text(170,90,utf8_decode($effectif));
			$this->Text(75,95,utf8_decode($dateNaissance));
			$this->Text(125,95,utf8_decode($lieuNaissance));
			$this->Text(50,100,utf8_decode($sexe));
			$this->Text(90,100,utf8_decode($redoublant));
			$this->Text(155,100,utf8_decode($titulaire));
			$this->Image($image, 15, 77, 22, 22);

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
			$this->Cell(40,5, utf8_decode($bullMatiere[$section]),1,0,'C',true);
			$this->Cell(35,5, utf8_decode($bullCompetence[$section]),1,0,'C',true);
			$this->Cell(12,5, utf8_decode($bullNote[$section]),1,0,'C',true);
			$this->Cell(12,5, utf8_decode($bullNoteTri[$section]),1,0,'C',true);
			$this->Cell(10,5, utf8_decode($bullCoef[$section]),1,0,'C',true);
			$this->Cell(15,5, utf8_decode($bullProduit[$section]),1,0,'C',true);
			$this->Cell(10,5, utf8_decode($bullCote[$section]),1,0,'C',true);
			$this->Cell(18,5, utf8_decode($bullMinMax[$section]),1,0,'C',true);
			// $this->Cell(10,5, utf8_decode('Max'),1,0,'C',true);
			// $this->Cell(22,5, utf8_decode($bullAppr[$section]),1,0,'C',true);
			$this->Cell(20,5, utf8_decode($bullParaphe[$section]),1,0,'C',true);
			$this->SetFont('Times','',8);
			$this->Ln(5);
			// // On ressort une boucle qui liste les groupes définis
			for($b=0;$b<count($_SESSION['groupe']);$b++){
				$codeGroupe = $_SESSION['groupe'][$b]['code_groupe'];
				$idGroupe = $_SESSION['groupe'][$b]['groupe'];
				$nomGroupe = $_SESSION['groupe'][$b]['nom_groupe'];
				$matieresGroupe = $_SESSION['matiereGroupe'][$idGroupe];
				for($c=0;$c<count($matieresGroupe);$c++){
					$codeMatiere = $matieresGroupe[$c]['code_matiere'];
					$competence_a = strtolower($codeMatiere.'_competence_a');
					$competence_b = strtolower($codeMatiere.'_competence_b');
					$sekence1 = strtolower($codeMatiere.'_seq1');
					$sekence2 = strtolower($codeMatiere.'_seq2');
					$trimestr = strtolower($codeMatiere.'_trim');
					$coef = strtolower($codeMatiere.'_coef');
					$competenceEvalueeA = strtolower(utf8_decode(substr($eleve[$competence_a],0,45)));
					$competenceEvalueeB = strtolower(utf8_decode(substr($eleve[$competence_b],0,45)));
					$cote = strtolower($codeMatiere.'_cote');
					$produit = strtolower($codeMatiere.'_total');
					$min = strtolower($codeMatiere.'_min');
					$max = strtolower($codeMatiere.'_max');
				// 	$appr = strtolower($codeMatiere.'_appreciation');
				// 	
					$enseignant = strtolower($codeMatiere.'_enseignant');
					$nomMatiere = strtoupper($matieresGroupe[$c]['nom_matiere']);
					$this->Cell(8);
					$this->Cell(40,3, substr($nomMatiere,0,23),'LRT',0,'L');
					$this->Cell(35,3, stripslashes(substr($competenceEvalueeA,0,30)),'LRT',0,'L');
					$this->Cell(12,3, utf8_decode($eleve[$sekence1]),1,0,'C');
					$this->Cell(12,6, utf8_decode($eleve[$trimestr]),1,0,'C');
					$this->Cell(10,6, utf8_decode($eleve[$coef]),1,0,'C');
					$this->Cell(15,6, utf8_decode($eleve[$produit]),1,0,'C',true);
					$this->Cell(10,6, utf8_decode($eleve[$cote]),1,0,'C');
					$minMax = "[".$eleve[$min]." - ".$eleve[$max]."]";
					$this->Cell(18,6, $minMax,1,0,'C');
					$this->Cell(20,6, utf8_decode(''),1,0,'C');
							
					$this->SetFont('Times','',5);
					
				// 	$minMax = "[".$eleve[$min]." - ".$eleve[$max]."]";
					// $this->Cell(35,6, $competenceEvalueeA,1,0,'L');
				// 	$this->SetFont('Times','',8);
				// 	$this->Cell(12,6, utf8_decode($eleve[$sekence]),1,0,'C');
				// 	$this->Cell(10,6, utf8_decode($eleve[$coef]),1,0,'C');
				// 	$this->SetFont('Times','B',8);
				// 	$this->Cell(15,6, utf8_decode($eleve[$produit]),1,0,'C',true);
				// 	$this->SetFont('Times','',8);
				// 	$this->Cell(18,6, $minMax,1,0,'C');
				// 	// $this->Cell(10,6, utf8_decode($eleve[$a][$max]),1,0,'C');
				// 	$this->Cell(22,6, utf8_decode($eleve[$appr]),1,0,'C');
				// 	$this->Cell(10,6, utf8_decode($eleve[$cote]),1,0,'C');
				// 	$this->Cell(20,6, utf8_decode(''),1,0,'C');
					$this->SetFont('Times','',8);
				// 	// $this->Ln(6);
					$this->Ln(3);
					$this->SetFont('Times','I',7);
					$this->Cell(8);
					$this->Cell(40,3, utf8_decode($eleve[$enseignant]),'LRB',0,'L');
					$this->SetFont('Times','',7);
					$this->Cell(35,3, stripslashes(substr($competenceEvalueeB,0,28)),1,0,'L');
					$this->Cell(12,3, utf8_decode($eleve[$sekence2]),1,0,'C');
				// 	/*$this->SetFont('Times','',7);
				// 	$this->Cell(35,3, utf8_decode(substr($eleve[$a][$competence],20,35)),1,0,'L');*/
					$this->Ln(3);
					$this->SetFont('Times','',8);
				}
				$this->Cell(8);
				$this->SetFont('Times','B',8);
				$moyenneGroupe = $codeGroupe.'_moyenne';
				$coefGroupe = $codeGroupe.'_coef';
				$totalGroupe = $codeGroupe.'_total';
				$minGroupe = $codeGroupe.'_min';
				$maxGroupe = $codeGroupe.'_max';
				$apprGroupe = $codeGroupe.'_appreciation';
				$coteGroupe = $codeGroupe.'_cote';
				$minMaxGroupe = "[".$eleve[$minGroupe]."- ".$eleve[$maxGroupe]."]";
				$texteTotalGroupe['fr'] = 'Total de ';
				$texteTotalGroupe['en'] = 'Total of  ';
				$this->Cell(87,5, utf8_decode(strtoupper($texteTotalGroupe[$section].$nomGroupe)),1,0,'L',true);
				$this->Cell(12,5, utf8_decode(utf8_decode($eleve[$moyenneGroupe])),1,0,'C',true);
				$this->Cell(10,5, utf8_decode($eleve[$coefGroupe]),1,0,'C',true);
				$this->Cell(15,5, utf8_decode($eleve[$totalGroupe]),1,0,'C',true);
				$this->Cell(10,5, $eleve[$coteGroupe],1,0,'C',true);
				$this->Cell(18,5, $minMaxGroupe,1,0,'C',true);
				// $this->Cell(10,5, $eleve[$a][$maxGroupe],1,0,'C',true);
				// $this->Cell(22,5, $eleve[$apprGroupe],1,0,'C',true);
				
				$this->Cell(20,5, '',1,0,'C',true);
				$this->Ln(5);
				$this->SetFont('Times','',7);
			}
			$this->SetFont('Times','B',9);
			$txtTotal['fr'] = 'TOTAL';
			$txtTotal['en'] = 'TOTAL';
			$txtMoy['fr'] = 'Moyenne Obtenue';
			$txtMoy['en'] = 'Average';
			$txtDiscipline['fr'] = 'Discipline';
			$txtDiscipline['en'] = 'Discipline';
			$txtTravail['fr'] = 'Travail';
			$txtTravail['en'] = 'Work';
			$txtProfil['fr'] = 'Profil de la Classe';
			$txtProfil['en'] = 'Class Profile';
			$absNJust['fr'] = 'Abs Non Just.';
			$absNJust['en'] = 'Abs Not Just.';
			$avc['fr'] = 'Avert. Cond.';
			$avc['en'] = 'Avert. Cond.';
			$totalGen['fr'] = 'Total Gén.';
			$totalGen['en'] = 'Global';
			$appreci['fr'] = 'Appréciation';
			$appreci['en'] = 'Grade';
			$moyenneClasse['fr'] = 'Moyenne Générale';
			$moyenneClasse['en'] = 'Class Average';
			$absJust['fr'] = 'Abs Just.';
			$absJust['en'] = 'Abs Just.';
			$bc['fr'] = 'Blâme. Cond.';
			$bc['en'] = 'Blâme. Cond.';
			$ret['fr'] = 'Retards';
			$ret['en'] = 'Retards';
			$exclusion['fr'] = 'Exclusions';
			$exclusion['en'] = 'Exclusions';
			$moyenneEleve['fr'] = 'Moyenne';
			$moyenneEleve['en'] = 'Average';
			$nbMoyenne['fr'] = 'Nb Moyennes';
			$nbMoyenne['en'] = 'Nb Aver.';
			$consigne['fr'] = 'Consignes';
			$consigne['en'] = 'Consignes';
			$exclusionDef['fr'] = 'Excl. Déf.';
			$exclusionDef['en'] = 'Excl. Déf.';
			$coteEleve['fr'] = 'Côte';
			$coteEleve['en'] = 'Cote';
			$taux['fr'] = 'Taux de Réussite';
			$taux['en'] = 'Percentage';
			$rank['fr'] = 'Rang';
			$rank['en'] = 'Rank';
			$ville = $_SESSION['information']['ville'];
			$faitA['fr'] = 'Fait à '.strtoupper($ville).' le ________________';
			$faitA['en'] = 'Done at '.strtoupper($ville).' the ________________';
			$parent['fr'] = 'Le Parent';
			$parent['en'] = 'The Parent';
			$pp['fr'] = 'Le Professeur Principal';
			$pp['en'] = 'The Class Principal';
			$signataire['fr'] = $_SESSION['information']['signataire_fr'];
			$signataire['en'] = $_SESSION['information']['signataire_en'];

			$this->Ln(1);
			$this->Cell(8);
			$this->Cell(99,5, utf8_decode($txtTotal[$section]),1,0,'C',true);
			$this->Cell(10,5, utf8_decode($eleve['total_coef']),1,0,'C',true);
			$this->Cell(15,5, utf8_decode($eleve['total_point']),1,0,'C',true);
			$this->Cell(28,5, utf8_decode($txtMoy[$section]),'TBL',0,'C',true);
			$this->Cell(20,5, utf8_decode(ucwords($eleve['moyenne'])),'TRB',0,'L',true);
			
			$this->Ln(6);
			$this->Cell(8);

			$this->Cell(53,6,utf8_decode($txtDiscipline[$section]), 1,0,'C',true);
			$this->Cell(5, 6, '',0,0,'C');
			$this->Cell(53,6,utf8_decode($txtTravail[$section]), 1,0,'C',true);
			$this->Cell(5, 6, utf8_decode(''),0,0,'C');
			$this->Cell(53,6,utf8_decode($txtProfil[$section]), 1,0,'C',true);
			$this->Ln(6);
			$this->Cell(8);

			$this->Cell(20,6,utf8_decode($absNJust[$section]), 1,0,'C');
			$this->Cell(6,6,utf8_decode($eleve['absence_non_just']), 1,0,'C');
			$this->Cell(20,6,utf8_decode($avc[$section]), 1,0,'C');
			$this->Cell(7,6,utf8_decode(''), 1,0,'C');
			$this->Cell(5, 6, utf8_decode(''),0,0,'C');
			$this->Cell(17,6,utf8_decode($totalGen[$section]), 1,0,'C');
			$this->Cell(10,6,utf8_decode($eleve['total_point']), 1,0,'C');
			$this->Cell(26,6,utf8_decode($appreci[$section]), 1,0,'C');
			$this->Cell(5, 6, utf8_decode(''),0,0,'C');
			$this->Cell(30,6,utf8_decode($moyenneClasse[$section]), 1,0,'C');
			$this->Cell(23,6,$_SESSION['statistique']['moyGenTotal'], 1,0,'C');
			$this->Ln(6);
			$this->Cell(8);

			$this->Cell(20,6,utf8_decode($absJust[$section]), 1,0,'C');
			$this->Cell(6,6,utf8_decode($eleve['absence_just']), 1,0,'C');
			$this->Cell(20,6,utf8_decode($bc[$section]), 1,0,'C');
			$this->Cell(7,6,utf8_decode(''), 1,0,'C');
			$this->Cell(5, 6, utf8_decode(''),0,0,'C');
			$this->Cell(17,6,utf8_decode('Coef'), 1,0,'C');
			$this->Cell(10,6,utf8_decode($eleve['total_coef']), 1,0,'C');
			$this->Cell(26,6,utf8_decode($eleve['appreciation']), 1,0,'C');
			$this->Cell(5, 6, utf8_decode(''),0,0,'C');
			$minMax = "[ ".$_SESSION['statistique']['noteFaibleTotal'];
			$minMax .= " - ".$_SESSION['statistique']['noteForteTotal'];
			$minMax .= " ]";
			$this->Cell(30,6,utf8_decode('[Min - Max]'), 1,0,'C');
			$this->Cell(23,6,$minMax, 1,0,'C');
			$this->Ln(6);
			$this->Cell(8);

			$this->Cell(20,6,utf8_decode($ret[$section]), 1,0,'C');
			$this->Cell(6,6,utf8_decode(''), 1,0,'C');
			$this->Cell(20,6,utf8_decode($exclusion[$section]), 1,0,'C');
			$this->Cell(7,6,utf8_decode(''), 1,0,'C');
			$this->Cell(5, 6, utf8_decode(''),0,0,'C');
			$this->Cell(27,6,utf8_decode($moyenneEleve[$section]), 1,0,'C');
			$this->Cell(26,6,utf8_decode($eleve['moyenne']), 1,0,'C');
			// $this->Cell(26,6,'', 1,0,'C');
			$this->Cell(5, 6, utf8_decode(''),0,0,'C');
			$this->Cell(30,6,utf8_decode($nbMoyenne[$section]), 1,0,'C');
			$this->Cell(23,6,$_SESSION['statistique']['moyTotal'], 1,0,'C');
			$this->Ln(6);
			$this->Cell(8);

			$this->Cell(20,6,utf8_decode($consigne[$section]), 1,0,'C');
			$this->Cell(6,6,utf8_decode(''), 1,0,'C');
			$this->Cell(20,6,utf8_decode($exclusionDef[$section]), 1,0,'C');
			$this->Cell(7,6,utf8_decode(''), 1,0,'C');
			$this->Cell(5, 6, utf8_decode(''),0,0,'C');
			$this->Cell(27,6,utf8_decode($coteEleve[$section]), 1,0,'C');
			$this->Cell(26,6,utf8_decode($eleve['cote']), 1,0,'C');
			// $this->Cell(26,6,'', 1,0,'C');
			$this->Cell(5, 6, utf8_decode(''),0,0,'C');
			$this->Cell(30,6,utf8_decode($taux[$section]), 1,0,'C');
			$this->Cell(23,6,$_SESSION['statistique']['tauxTotal'].' %', 1,0,'C');
			$this->Ln(6);
			$this->Cell(8);

			$this->Cell(46,6,utf8_decode(''), 0,0,'C');
			$this->Cell(7,6,utf8_decode(''), 0,0,'C');
			$this->Cell(5, 6, utf8_decode(''),0,0,'C');
			$this->Cell(27,6,$rank[$section], 1,0,'C');
			$rangEleve = utf8_decode($eleve['rang']).' / '.$eleve['classes'];
			$this->Cell(26,6,$rangEleve, 1,0,'C');
			$this->Cell(5, 6, '',0,0,'C');
			$this->Cell(53,6,utf8_decode(''), 0,0,'C');
			$this->Ln(6);
			$this->Cell(8);

			$this->Cell(46,6,utf8_decode(''), 0,0,'C');
			$this->Cell(7,6,utf8_decode(''), 0,0,'C');
			$this->Cell(5, 6, utf8_decode(''),0,0,'C');
			$this->Cell(27,6,'', 0,0,'C');
			$this->Cell(26,6,'', 0,0,'C');
			$this->Cell(5, 6, '',0,0,'C');
			$this->Cell(53,6,utf8_decode($faitA[$section]), 0,0,'C');
			$this->Ln(3);
			$this->Cell(8);

			$this->Cell(46,6,utf8_decode($parent[$section]), 0,0,'C');
			$this->Cell(7,6,utf8_decode(''), 0,0,'C');
			$this->Cell(5, 6, utf8_decode(''),0,0,'C');
			$this->Cell(53,6,$pp[$section], 0,0,'C');
			$this->Cell(5, 6, utf8_decode(''),0,0,'C');
			$this->Cell(53,6,$signataire[$section], 0,0,'C');
			$this->Ln(6);
			$this->Cell(8);
			$this->SetFont('Times','B',9);
		}


		
		
		function Footer(){
			$this->setFont('Arial', 'I', 6);
			$texte = $_SESSION['appName'].' '.$_SESSION['appVersion'];
			$texte .= ', votre partenaire éducatif. Tel : ';
			$texte .= $_SESSION['appContact'];
			// $numeroPage = 'Page '.$this->PageNo().' / '.$this->AliasNbPages();
			$this->Text(90,290, $this->convert($texte));
			$this->setAuthor('Nyambi Computer Services');
			$this->setCreator('Nyambi Ngikwa Richard');
			$dateGeneration = 'Edité le '.DATE('d / m / Y').' à '.DATE('H:i:s');
			$this->Text(25, 290, $this->convert($dateGeneration));
		}
		
		
		
		
		function Titre($titre){
			// On crée d'abord un espace pour gérer les informations d'entête
			$this->Ln(9);
			$this->SetFont('Times', 'B', 18);
			// Déplacer à droite
			$this->Cell(10);
			// Bordure du titre
			$this->Cell(180, 8, $this->convert(strtoupper($titre)), 0, 0 , 'C');
			// Retour à la ligne
			$this->Ln(10);
		}
		
		
		function SousTitre($titre){
			// On crée d'abord un espace pour gérer les informations d'entête
			$this->Ln(2);
			$this->SetFont('Times', 'BI', 14);
			// Déplacer à droite
			$this->Cell(10);
			// Bordure du titre
			$this->Cell(140, 8, $this->convert(strtoupper($titre)), 0, 0 , 'C');
			// Retour à la ligne
			$this->Ln(5);
		}





		function certificatScolariteFr($eleve,$information){
			$this->Titre('certificat de scolarite');
			// Informations diverses
			$this->SetFont('Times','BI',14);
			$annee_scolaire = $eleve['libelle_annee'];
			$this->Cell(150,10,utf8_decode('Année Scolaire : ').$annee_scolaire,0,0,'C');
			$this->Ln(15);
			
			$phrase_1 = 'Je soussigné ';
			$this->SetFont('Times','',14);
			$this->Cell(70, 7, utf8_decode($phrase_1), 0, 0 , 'C');
			$this->SetFont('Times','B',14);
			$this->Cell(70, 7, strtoupper($information['chefEts']), 0, 0 , 'C');
			$this->Ln(10);
			$this->SetFont('Times','',14);
			$this->Cell(80, 7, 'Proviseur du ', 0, 0 , 'C');
			$this->SetFont('Times','BI',14);
			$this->Cell(60, 7, utf8_decode(strtoupper($information['nom_etablissement_fr'])), 0, 0 , 'C');
			$this->Ln(10);
			$this->SetFont('Times','',14);
			$this->Cell(35, 7, 'Atteste que ', 0, 0 , 'C');
			$this->SetFont('Times','BI',14);
			$this->Cell(100, 7, utf8_decode($eleve['nom_complet']), 0, 0 , 'C');
			$this->SetFont('Times','',14);
			$this->Cell(25, 7, 'Matricule : ', 0, 0 , 'C');
			$this->SetFont('Times','BI',14);
			$this->Cell(32, 7, utf8_decode($eleve['matricule']), 0, 0 , 'C');
			$this->Ln(10);
			$this->SetFont('Times','',14);
			$this->Cell(25, 7, utf8_decode('Né(e) le : '), 0, 0 , 'C');
			$this->SetFont('Times','BI',14);
			$this->Cell(55, 7, utf8_decode($eleve['date_fr']), 0, 0 , 'C');
			$this->SetFont('Times','',14);
			$this->Cell(15, 7, utf8_decode('à : '), 0, 0 , 'C');
			$this->SetFont('Times','BI',14);
			$this->Cell(85, 7, utf8_decode($eleve['lieu_naissance']), 0, 0 , 'C');
			$this->SetFont('Arial','B',10);
			$this->Ln(10);
			$this->SetFont('Times','',14);
			$this->Cell(25, 7, utf8_decode('De : '), 0, 0 , 'C');
			$this->SetFont('Times','BI',14);
			$this->Cell(115, 7, utf8_decode($eleve['nom_pere']), 0, 0 , 'C');
			$this->Ln(10);
			$this->SetFont('Times','',14);
			$this->Cell(25, 7, utf8_decode(' Et De : '), 0, 0 , 'C');
			$this->SetFont('Times','BI',14);
			$this->Cell(115, 7, utf8_decode($eleve['nom_mere']), 0, 0 , 'C');
			$this->Ln(10);
			$this->SetFont('Times','',14);
			$phrase_2 = "Est inscrit comme élève de notre";
			$phrase_2 .= " établissement durant l'année scolaire ";
			$this->Cell(160, 7, utf8_decode($phrase_2), 0,0,'C');
			$this->SetFont('Times','BI',14);
			$this->Cell(30, 7, utf8_decode($annee_scolaire), 0,0,'C');
			$this->Ln(10);
			$this->SetFont('Times','',14);
			$this->Cell(40, 7, utf8_decode('En classe de : '), 0,0,'C');
			$this->SetFont('Times','BI',14);
			$this->Cell(100, 7, utf8_decode($eleve['nom_classe']), 0,0,'C');
			$this->Ln(10);
			$this->SetFont('Times','',14);
			$this->Cell(70, 7, utf8_decode('Son Matricule National est : '), 0,0,'C');
			$this->SetFont('Times','BI',14);
			$this->Cell(100, 7, utf8_decode($eleve['rne']), 0,0,'C');
			
			// Le signataire du document 
			$this->Ln(10);
			$this->Cell(100,30, ' ');
			$arrondissement = $information['arrondissement'];
			$signataire = $information['signataire_fr'];
			$this->SetFont('Times','',14);
			$this->Cell(100,30, utf8_decode('Fait à ').ucwords($arrondissement).', le '.DATE('d / m / Y'));
			$this->Ln(10);
			$this->Cell(130,30, ' ');
			$this->SetFont('Times','BI',14);
			$this->Cell(100,25, $signataire.',');
		}




		function certificatScolariteEn($eleve){
			$this->Titre('school attedance certificate');
			// Informations diverses
			$this->SetFont('Times','BI',14);
			$annee_scolaire = $eleve['libelle_annee'];
			$this->Cell(150,10,utf8_decode('School Year : ').$annee_scolaire,0,0,'C');
			$this->Ln(15);
			
			$phrase_1 = 'I, undersigned ';
			$this->SetFont('Times','',14);
			$this->Cell(70, 7, utf8_decode($phrase_1), 0, 0 , 'C');
			$this->SetFont('Times','B',14);
			$this->Cell(70, 7, strtoupper($information['chefEts']), 0, 0 , 'C');
			$this->Ln(10);
			$this->SetFont('Times','',14);
			$this->Cell(80, 7, 'Principal of ', 0, 0 , 'C');
			$this->SetFont('Times','BI',14);
			$this->Cell(60, 7, utf8_decode(strtoupper($information['nom_etablissement_en'])), 0, 0 , 'C');
			$this->Ln(10);
			$this->SetFont('Times','',14);
			$this->Cell(35, 7, 'hereby certifies that ', 0, 0 , 'C');
			$this->SetFont('Times','BI',14);
			$this->Cell(100, 7, utf8_decode($eleve['nom_complet']), 0, 0 , 'C');
			$this->SetFont('Times','',14);
			$this->Cell(25, 7, 'Registred Number : ', 0, 0 , 'C');
			$this->SetFont('Times','BI',14);
			$this->Cell(32, 7, utf8_decode($eleve['matricule']), 0, 0 , 'C');
			$this->Ln(10);
			$this->SetFont('Times','',14);
			$this->Cell(25, 7, utf8_decode('Born on the : '), 0, 0 , 'C');
			$this->SetFont('Times','BI',14);
			$this->Cell(55, 7, utf8_decode($eleve['date_naissance']), 0, 0 , 'C');
			$this->SetFont('Times','',14);
			$this->Cell(15, 7, utf8_decode('at : '), 0, 0 , 'C');
			$this->SetFont('Times','BI',14);
			$this->Cell(85, 7, utf8_decode($eleve['lieu_naissance']), 0, 0 , 'C');
			$this->SetFont('Arial','B',10);
			$this->Ln(10);
			$this->SetFont('Times','',14);
			$this->Cell(25, 7, utf8_decode('Fom : '), 0, 0 , 'C');
			$this->SetFont('Times','BI',14);
			$this->Cell(115, 7, utf8_decode($eleve['nom_pere']), 0, 0 , 'C');
			$this->Ln(10);
			$this->SetFont('Times','',14);
			$this->Cell(25, 7, utf8_decode(' And from : '), 0, 0 , 'C');
			$this->SetFont('Times','BI',14);
			$this->Cell(115, 7, utf8_decode($eleve['nom_mere']), 0, 0 , 'C');
			$this->Ln(10);
			$this->SetFont('Times','',14);
			$phrase_2 = "Is recognized as our student during the school year ";
			$this->Cell(160, 7, utf8_decode($phrase_2), 0,0,'C');
			$this->SetFont('Times','BI',14);
			$this->Cell(30, 7, utf8_decode($annee_scolaire), 0,0,'C');
			$this->Ln(10);
			$this->SetFont('Times','',14);
			$this->Cell(40, 7, utf8_decode('In Class : '), 0,0,'C');
			$this->SetFont('Times','BI',14);
			$this->Cell(100, 7, utf8_decode($eleve['nom_classe']), 0,0,'C');
			$this->Ln(10);
			$this->SetFont('Times','',14);
			$this->Cell(70, 7, utf8_decode('His / Her National Id is : '), 0,0,'C');
			$this->SetFont('Times','BI',14);
			$this->Cell(100, 7, utf8_decode($eleve['rne']), 0,0,'C');
			
			// Le signataire du document 
			$this->Ln(10);
			$this->Cell(100,30, ' ');
			$arrondissement = $information['arrondissement'];
			$signataire = $information['signataire_en'];
			$this->SetFont('Times','',14);
			$this->Cell(100,30, utf8_decode('Done at ').ucwords($arrondissement).', on the '.DATE('Y - m - d'));
			$this->Ln(10);
			$this->Cell(130,30, ' ');
			$this->SetFont('Times','BI',14);
			$this->Cell(100,25, $signataire.',');
		}
		
		
		
	}