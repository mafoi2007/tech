<?php 
	session_start();
	require_once('inc/pdf.class.php');
	$pdf = new pdf('P', 'mm', 'A4');
	// Couleur de fond par défaut 
	$pdf->SetFillColor(200,205,180);
	
	
	
	
	
	
	if(isset($_SESSION['print'])){
		if($_SESSION['print']=='certificatScolarite'){
			$eleve = $_SESSION['eleve'];
			$classe = $_SESSION['classe'];
			$information = $_SESSION['information'];
			// $pdf->SetFillColor(155, 150, 149);
			// La page doit s'afficher en fonction de la section 
			if($classe['section']=='en'){
				$pdf->addPage();
				$pdf->certificatScolariteEn($eleve, $information);
			}
			elseif($classe['section']=='fr'){
				$pdf->addPage();
				$pdf->Entete();
				$pdf->certificatScolariteFr($eleve, $information);
			}
			$fileName = 'Certificat_Scolarite_';
			$fileName .= str_replace(' ','_', $eleve['nom_complet']);
			$pdf->Output($fileName, 'I');
			
			
			
			
		}
		
		
		if($_SESSION['print']=='listeEleve'){
			$classe = $_SESSION['classe'];
			// $pdf->SetFillColor(155, 150, 149);
			// La page doit s'afficher en fonction de la section 
			if($classe['section']=='en'){
				$pdf->addPage();
				$pdf->Entete();
				$titre = 'Student list of ';
				$titre.= $classe['eleve'][0]['nom_classe'];
				$pdf->Titre($titre);
				
				$pdf->SetFont('Times','',8);
				$pdf->Cell(90);
				$pdf->Cell(14, 7, 'Sex', 1, 0 , 'C', true);
				$pdf->Cell(12, 7, 'Female', 1, 0 , 'C', true);
				$pdf->Cell(14, 7, 'Male', 1, 0 , 'C', true);
				$pdf->Cell(10, 7, 'Global', 1, 0 , 'C', true);
				$pdf->Ln(7);
				$pdf->SetFont('Times','',8);
				$pdf->Cell(90);
				$pdf->Cell(14, 7, 'Repeater', 1, 0 , 'C');
				$pdf->Cell(12, 7,  $classe['stat']['FR'], 1, 0 , 'C');
				$pdf->Cell(14, 7,  $classe['stat']['GR'], 1, 0 , 'C');
				$pdf->Cell(10, 7,  $classe['stat']['R'], 1, 0 , 'C');
				$pdf->Ln(7);
				$pdf->SetFont('Times','',8);
				$pdf->Cell(90);
				$pdf->Cell(14, 7, 'New', 1, 0 , 'C');
				$pdf->Cell(12, 7,  $classe['stat']['FN'], 1, 0 , 'C');
				$pdf->Cell(14, 7,  $classe['stat']['GN'], 1, 0 , 'C');
				$pdf->Cell(10, 7,  $classe['stat']['N'], 1, 0 , 'C');
				$pdf->Ln(7);
				$pdf->SetFont('Times','',8);
				$pdf->Cell(90);
				$pdf->Cell(14, 7, 'Global', 1, 0 , 'C');
				$pdf->Cell(12, 7,  $classe['stat']['F'], 1, 0 , 'C');
				$pdf->Cell(14, 7,  $classe['stat']['G'], 1, 0 , 'C');
				$pdf->Cell(10, 7,  $classe['stat']['T'], 1, 0 , 'C');
				$pdf->Ln(15);
				
				$pdf->SetFont('Times','B',10);
				// Je positionne l'entete du tableau
				$pdf->Cell(10, 6, $pdf->convert('N°'), 1, 0 , 'C',true);
				$pdf->Cell(28, 6, $pdf->convert('Identifier'), 1, 0 , 'C',true);
				$pdf->Cell(75, 6, $pdf->convert('Full Name'), 1, 0 , 'C',true);
				$pdf->Cell(9, 6, $pdf->convert('Sex'), 1, 0 , 'C',true);
				$pdf->Cell(13, 6, $pdf->convert('Status'), 1, 0 , 'C',true);
				$pdf->Cell(55, 6, $pdf->convert('Date and place of birth'), 1, 0 , 'C',true);
				$pdf->SetFont('Times','',10);
				$pdf->Ln(6);
				$a = 1;
				for($i=0;$i<count($classe['eleve']);$i++){
					$pdf->Cell(10, 6, $a, 1, 0 , 'C');
					$pdf->Cell(28, 6, $pdf->convert($classe['eleve'][$i]['rne']), 1, 0 , 'C');
					$pdf->Cell(75, 6, $pdf->convert($classe['eleve'][$i]['nom_complet']), 1, 0 , 'L');
					$pdf->Cell(9, 6, $pdf->convert($classe['eleve'][$i]['sexe']), 1, 0 , 'C');
					$pdf->Cell(13, 6, $pdf->convert($classe['eleve'][$i]['statut']), 1, 0 , 'C');
					$dateNaiss = $classe['eleve'][$i]['date_fr'].' at '.ucwords($classe['eleve'][$i]['lieu_naissance']);
					$pdf->Cell(55, 6, $pdf->convert($dateNaiss), 1, 0 , 'L');
					$pdf->Ln(6);
					$a++;
				}
				$texte = 'Done at '.ucwords($_SESSION['information']['ville']);
				$texte.= ', on the '.DATE('d / m / Y');
				$pdf->Cell(190,10, $texte,0,0,'R');
				
				$pdf->Ln(5);
				// $pdf->Cell(130,30, ' ');
				$pdf->SetFont('Arial','BI',10);
				// $titre = $classe['information']['titre'];
				$pdf->Cell(190,10, $classe['information']['signataire_en'],0,0,'R');
				
				$fileName='student_list_';
				$fileName.= strtoupper(str_replace(' ','_',$classe['eleve'][0]['nom_classe']));
				$fileName.= '.pdf';
			}elseif($classe['section']=='fr'){
				$pdf->addPage();
				$pdf->Entete();
				$titre = 'Liste des eleves de la ';
				$titre.= $classe['eleve'][0]['nom_classe'];
				$pdf->Titre($titre);
				
				$pdf->SetFont('Times','',8);
				$pdf->Cell(90);
				$pdf->Cell(14, 7, 'Sexe', 1, 0 , 'C', true);
				$pdf->Cell(12, 7, 'Feminin', 1, 0 , 'C', true);
				$pdf->Cell(14, 7, 'Masculin', 1, 0 , 'C', true);
				$pdf->Cell(10, 7, 'Total', 1, 0 , 'C', true);
				$pdf->Ln(7);
				$pdf->SetFont('Times','',8);
				$pdf->Cell(90);
				$pdf->Cell(14, 7, 'Redoublant', 1, 0 , 'C');
				$pdf->Cell(12, 7,  $classe['stat']['FR'], 1, 0 , 'C');
				$pdf->Cell(14, 7,  $classe['stat']['GR'], 1, 0 , 'C');
				$pdf->Cell(10, 7,  $classe['stat']['R'], 1, 0 , 'C');
				$pdf->Ln(7);
				$pdf->SetFont('Times','',8);
				$pdf->Cell(90);
				$pdf->Cell(14, 7, 'Nouveau', 1, 0 , 'C');
				$pdf->Cell(12, 7,  $classe['stat']['FN'], 1, 0 , 'C');
				$pdf->Cell(14, 7,  $classe['stat']['GN'], 1, 0 , 'C');
				$pdf->Cell(10, 7,  $classe['stat']['N'], 1, 0 , 'C');
				$pdf->Ln(7);
				$pdf->SetFont('Times','',8);
				$pdf->Cell(90);
				$pdf->Cell(14, 7, 'Total', 1, 0 , 'C');
				$pdf->Cell(12, 7,  $classe['stat']['F'], 1, 0 , 'C');
				$pdf->Cell(14, 7,  $classe['stat']['G'], 1, 0 , 'C');
				$pdf->Cell(10, 7,  $classe['stat']['T'], 1, 0 , 'C');
				$pdf->Ln(15);
				
				$pdf->SetFont('Times','B',10);
				// Je positionne l'entete du tableau
				$pdf->Cell(10, 6, $pdf->convert('N°'), 1, 0 , 'C',true);
				$pdf->Cell(28, 6, $pdf->convert('Matricule'), 1, 0 , 'C',true);
				$pdf->Cell(75, 6, $pdf->convert('Nom Complet'), 1, 0 , 'C',true);
				$pdf->Cell(9, 6, $pdf->convert('Sexe'), 1, 0 , 'C',true);
				$pdf->Cell(13, 6, $pdf->convert('Statut'), 1, 0 , 'C',true);
				$pdf->Cell(55, 6, $pdf->convert('Date et lieu de naissance'), 1, 0 , 'C',true);
				$pdf->SetFont('Times','',10);
				$pdf->Ln(6);
				$a = 1;
				for($i=0;$i<count($classe['eleve']);$i++){
					$pdf->Cell(10, 6, $a, 1, 0 , 'C');
					$pdf->Cell(28, 6, $pdf->convert($classe['eleve'][$i]['rne']), 1, 0 , 'C');
					$pdf->Cell(75, 6, $pdf->convert($classe['eleve'][$i]['nom_complet']), 1, 0 , 'L');
					$pdf->Cell(9, 6, $pdf->convert($classe['eleve'][$i]['sexe']), 1, 0 , 'C');
					$pdf->Cell(13, 6, $pdf->convert($classe['eleve'][$i]['statut']), 1, 0 , 'C');
					$dateNaiss = $classe['eleve'][$i]['date_fr'].' à '.ucwords($classe['eleve'][$i]['lieu_naissance']);
					$pdf->Cell(55, 6, $pdf->convert($dateNaiss), 1, 0 , 'L');
					$pdf->Ln(6);
					$a++;
				}
				$texte = 'Fait a '.ucwords($_SESSION['information']['ville']);
				$texte.= ', le '.DATE('d / m / Y');
				$pdf->Cell(190,10, $texte,0,0,'R');
				
				$pdf->Ln(5);
				// $pdf->Cell(130,30, ' ');
				$pdf->SetFont('Arial','BI',10);
				// $titre = $classe['information']['titre'];
				$pdf->Cell(190,10, $classe['information']['signataire_fr'],0,0,'R');
				
				$fileName='liste_Eleve_';
				$fileName.= strtoupper(str_replace(' ','_',$classe['eleve'][0]['nom_classe']));
				$fileName.= '.pdf';
			} 
			
			$pdf->Output($fileName, 'I');
			
			
			
			
		}


		if($_SESSION['print']=='vueEffectif'){
			$classe = $_SESSION['classe'];
			// $pdf->SetFillColor(155, 150, 149);
			$pdf->addPage();
			$pdf->Entete();
			$pdf->Titre("Vue d'ensemble des effectifs");
			$pdf->SetFont('Times','B',10);
			$pdf->Cell(50);
			$pdf->Cell(8, 5, utf8_decode('N°'), 1, 0 , 'C',true);
			$pdf->Cell(48, 5, 'Classe', 1, 0 , 'C',true);
			$pdf->Cell(18, 5, 'Masculin', 1, 0 , 'C',true);
			$pdf->Cell(18, 5, 'Feminin', 1, 0 , 'C',true);
			$pdf->Cell(25, 5, 'Total', 1, 0 , 'C',true);
			$pdf->Ln(5);

			// $pdf->SetFont('Times','',10);
			$a = 1;
			for($i=0;$i<count($classe['niveau']);$i++){
				$listeClasse = $classe['liste'];
				$effectifClasse = $classe['effectif'];
				$pdf->SetFont('Times','',10);
				for($j=0;$j<count($listeClasse[$i]);$j++){
					$masculinClasse[] = $effectifClasse[$i][$j]['G'];
					$femininClasse[] = $effectifClasse[$i][$j]['F'];
					$totalClasse[] = $effectifClasse[$i][$j]['T'];
					$pdf->Cell(50);
					$pdf->Cell(8, 5, $a, 1, 0 , 'C');
					$pdf->Cell(48, 5, $listeClasse[$i][$j]['nom_classe'], 1, 0 , 'L');
					$pdf->Cell(18, 5, $effectifClasse[$i][$j]['G'], 1, 0 , 'C');
					$pdf->Cell(18, 5, $effectifClasse[$i][$j]['F'], 1, 0 , 'C');
					$pdf->SetFont('Times','B',10);
					$pdf->Cell(25, 5, $effectifClasse[$i][$j]['T'], 1, 0 , 'C');
					$pdf->SetFont('Times','',10);
					$pdf->Ln(5);
					$a++;
				}
				$pdf->SetFont('Times','B',10);
				$pdf->Cell(50);
				$pdf->Cell(56, 5, utf8_decode('Total Niveau '.$classe['niveau'][$i]['nom_niveau']), 1, 0 , 'C',true);
				$pdf->Cell(18, 5, $classe['stat'][$i]['M'], 1, 0 , 'C',true);
				$pdf->Cell(18, 5, $classe['stat'][$i]['F'], 1, 0 , 'C',true);
				$pdf->Cell(25, 5, $classe['stat'][$i]['T'], 1, 0 , 'C',true);
				$pdf->Ln(5);
				$masc[] = $classe['stat'][$i]['M'];
				$fem[] = $classe['stat'][$i]['F'];
				$tot[] = $classe['stat'][$i]['T'];
			}
			$pdf->setFont('Times', 'B', 12);
			$pdf->Cell(50);
			$pdf->Cell(56, 5, utf8_decode('TOTAL '), 1, 0 , 'C',true);
			$pdf->Cell(18, 5, array_sum($masc), 1, 0 , 'C',true);
			$pdf->Cell(18, 5, array_sum($fem), 1, 0 , 'C',true);
			$pdf->Cell(25, 5, array_sum($tot), 1, 0 , 'C',true);
			$pdf->Ln(5);


			$fileName='Vue_Effectif.pdf';
			$pdf->Output($fileName, 'I');
		}


		if($_SESSION['print']=='releveNote'){
			$classe = $_SESSION['classe'];
			// $pdf->SetFillColor(155, 150, 149);
			// La page doit s'afficher en fonction de la section 
			if($classe['section']=='en'){			
				$pdf->addPage();
				$pdf->Entete();
				$titre = "Reported marks of the teacher ";
				// $titre.= $classe['eleve'][0]['nom_classe'];
				$pdf->Titre($titre);
				
				$pdf->setFont('Times', 'B', 12);
				$pdf->Cell(75, 7, 'Class : '.$classe['eleve'][0]['nom_classe'], 0,0,'C');
				$pdf->Ln(7);
				$pdf->setFont('Times', '', 10);
				$pdf->Cell(75,7, utf8_decode('Subject : _____________________'),0,0,'C');
				$pdf->Cell(35,7, utf8_decode('Coef : _______'),0,0,'C');
				$pdf->Cell(75,7, utf8_decode('Teacher : _____________________'),0,0,'C');
				$pdf->SetFont('Times','B',8);
				$pdf->Ln(10);
				
				// Je positionne l'entete du tableau
				$pdf->Cell(9, 5, $pdf->convert('N°'), 1, 0 , 'C',true);
				$pdf->Cell(9, 5, $pdf->convert('Sex'), 1, 0 , 'C',true);
				$pdf->Cell(13, 5, $pdf->convert('Status'), 1, 0 , 'C',true);
				$pdf->Cell(75, 5, $pdf->convert('Full Name'), 1, 0 , 'C',true);
				for($x=1;$x<=6;$x++){
					$pdf->Cell(15,5, $pdf->convert('Seq '.$x), 1, 0, 'C', true);
				}
				$pdf->SetFont('Times','',10);
				$pdf->Ln(5);
				$a = 1;
				for($i=0;$i<count($classe['eleve']);$i++){
					$pdf->Cell(9, 5, $a, 1, 0 , 'C');
					$pdf->Cell(9, 5, $pdf->convert($classe['eleve'][$i]['sexe']), 1, 0 , 'C');
					$pdf->Cell(13, 5, $pdf->convert($classe['eleve'][$i]['statut']), 1, 0 , 'C');
					$pdf->Cell(75, 5, $pdf->convert($classe['eleve'][$i]['nom_complet']), 1, 0 , 'L');
					for($j=1;$j<=6;$j++){
						$pdf->Cell(15,5, '', 1, 0, 'C');
					}
					$pdf->Ln(5);
					$a++;
				}
				$pdf->Cell(130,4,'',0,0,'L');
				$pdf->Ln(6);
				for($w=1;$w<=6;$w++){
					$texte = 'Skill Evaluated '.$w.' : _________________________________________________________________';
					$pdf->Cell(130,4, utf8_decode($texte),0,0,'L');
					$pdf->Ln(6);
				}
				$pdf->SetFont('Arial','BI',10);				
				
				$fileName='Reported_Marks_';
				$fileName.= strtoupper(str_replace(' ','_',$classe['eleve'][0]['nom_classe']));
				$fileName.= '.pdf';
			}elseif($classe['section']=='fr'){
				$pdf->addPage();
				$pdf->Entete();
				$titre = "Releve de Notes de l'enseignant ";
				// $titre.= $classe['eleve'][0]['nom_classe'];
				$pdf->Titre($titre);
				
				$pdf->setFont('Times', 'B', 12);
				$pdf->Cell(75, 7, 'Classe : '.$classe['eleve'][0]['nom_classe'], 0,0,'C');
				$pdf->Ln(7);
				$pdf->setFont('Times', '', 10);
				$pdf->Cell(75,7, utf8_decode('Matière : _____________________'),0,0,'C');
				$pdf->Cell(35,7, utf8_decode('Coef : _______'),0,0,'C');
				$pdf->Cell(75,7, utf8_decode('Enseignant : _____________________'),0,0,'C');
				$pdf->SetFont('Times','B',8);
				$pdf->Ln(10);
				
				// Je positionne l'entete du tableau
				$pdf->Cell(9, 5, $pdf->convert('N°'), 1, 0 , 'C',true);
				$pdf->Cell(9, 5, $pdf->convert('Sexe'), 1, 0 , 'C',true);
				$pdf->Cell(13, 5, $pdf->convert('Statut'), 1, 0 , 'C',true);
				$pdf->Cell(75, 5, $pdf->convert('Nom Complet'), 1, 0 , 'C',true);
				for($x=1;$x<=6;$x++){
					$pdf->Cell(15,5, $pdf->convert('Séq '.$x), 1, 0, 'C', true);
				}
				$pdf->SetFont('Times','',10);
				$pdf->Ln(5);
				$a = 1;
				for($i=0;$i<count($classe['eleve']);$i++){
					$pdf->Cell(9, 5, $a, 1, 0 , 'C');
					$pdf->Cell(9, 5, $pdf->convert($classe['eleve'][$i]['sexe']), 1, 0 , 'C');
					$pdf->Cell(13, 5, $pdf->convert($classe['eleve'][$i]['statut']), 1, 0 , 'C');
					$pdf->Cell(75, 5, $pdf->convert($classe['eleve'][$i]['nom_complet']), 1, 0 , 'L');
					for($j=1;$j<=6;$j++){
						$pdf->Cell(15,5, '', 1, 0, 'C');
					}
					$pdf->Ln(5);
					$a++;
				}
				$pdf->Cell(130,4,'',0,0,'L');
				$pdf->Ln(6);
				for($w=1;$w<=6;$w++){
					$texte = 'Compétence évaluée '.$w.' : _________________________________________________________________';
					$pdf->Cell(130,4, utf8_decode($texte),0,0,'L');
					$pdf->Ln(6);
				}
				$pdf->SetFont('Arial','BI',10);				
				
				$fileName='Releve_Note_';
				$fileName.= strtoupper(str_replace(' ','_',$classe['eleve'][0]['nom_classe']));
				$fileName.= '.pdf';
			} 
			
			$pdf->Output($fileName, 'I');
		}



		

		if($_SESSION['print']=='professeursPrincipaux'){
			$prof = $_SESSION['prof'];
			// $pdf->SetFillColor(155, 150, 149);
			$pdf->addPage();
			$pdf->Entete();
			$pdf->Titre("Liste des Professeurs Principaux");
			$pdf->SetFont('Times','B',10);
			$pdf->Cell(20);
			$pdf->Cell(8, 5, utf8_decode('N°'), 1, 0 , 'C',true);
			$pdf->Cell(60, 5, 'Classe', 1, 0 , 'C',true);
			$pdf->Cell(60, 5, 'Professeur Principal', 1, 0 , 'C',true);
			$pdf->Ln(5);

			$pdf->SetFont('Times','',10);
			$a = 1;
			for($i=0;$i<count($prof);$i++){
				$pdf->Cell(20);
				$pdf->Cell(8, 5, utf8_decode($a), 1, 0 , 'C');
				$pdf->Cell(60, 5, $prof[$i]['nom_classe'], 1, 0 , 'C');
				$pdf->Cell(60, 5, stripslashes($prof[$i]['nom']), 1, 0 , 'C');
				$pdf->Ln(5);
				$a++;
			}
			
			$fileName='enseignant_titulaire.pdf';
			$pdf->Output($fileName, 'I');
		}







		if($_SESSION['print']=='professeursPrincipaux'){
			$prof = $_SESSION['prof'];
			// $pdf->SetFillColor(155, 150, 149);
			$pdf->addPage();
			$pdf->Titre("Liste des Professeurs Principaux");
			$pdf->SetFont('Times','B',10);
			$pdf->Cell(20);
			$pdf->Cell(8, 5, utf8_decode('N°'), 1, 0 , 'C',true);
			$pdf->Cell(60, 5, 'Classe', 1, 0 , 'C',true);
			$pdf->Cell(60, 5, 'Professeur Principal', 1, 0 , 'C',true);
			$pdf->Ln(5);

			$pdf->SetFont('Times','',10);
			$a = 1;
			for($i=0;$i<count($prof);$i++){
				$pdf->Cell(20);
				$pdf->Cell(8, 5, utf8_decode($a), 1, 0 , 'C');
				$pdf->Cell(60, 5, $prof[$i]['nom_classe'], 1, 0 , 'C');
				$pdf->Cell(60, 5, stripslashes($prof[$i]['nom']), 1, 0 , 'C');
				$pdf->Ln(5);
				$a++;
			}
			
			$fileName='enseignant_titulaire.pdf';
			$pdf->Output($fileName, 'I');
		}








		if($_SESSION['print']=='conseilClasse'){
			$information = $_SESSION['conseil'];
			$classe = $information[0]['nom_classe'];
			if($information[0]['section']=='fr'){
				// $pdf->SetFillColor(155, 150, 149);
				$pdf->addPage();
				$pdf->Entete();
				$pdf->Titre("Conseil de classe de ".$classe);
				$pdf->SetFont('Times','B',10);
				$pdf->Cell(20);
				$pdf->Cell(8, 5, utf8_decode('N°'), 1, 0 , 'C',true);
				$pdf->Cell(80, 5, utf8_decode('Matière'), 1, 0 , 'C',true);
				$pdf->Cell(80, 5, 'Enseignant', 1, 0 , 'C',true);
				$pdf->Ln(5);

				$pdf->SetFont('Times','',10);
				$a = 1;

				for($i=0;$i<count($information);$i++){
					$pdf->Cell(20);
					$pdf->Cell(8, 5, utf8_decode($a), 1, 0 , 'C');
					$pdf->Cell(80, 5, utf8_decode(stripslashes($information[$i]['nom_matiere'])), 1, 0 , 'C');
					$pdf->Cell(80, 5, utf8_decode(stripslashes($information[$i]['nom'])), 1, 0 , 'C');
					$pdf->Ln(5);
					$a++;
				}


				$fileName='conseil_classe_'.str_replace(' ','_',$classe).'.pdf';
				$pdf->Output($fileName, 'I');


			}elseif($information[0]['section']=='en'){}
			/*$prof = $_SESSION['prof'];
			
			*/
		}








		
		elseif($_SESSION['print']=='BullSeq'){
			$eleve = $_SESSION['eleve'];
			$ville = strtoupper($_SESSION['information']['ville']);
			$pdf->pvSequentielAlpha($_SESSION['section']);
			$pdf->pvSequentielMerite($_SESSION['section']);
			$_SESSION['effectif'] = count($eleve);
			for($i=0;$i<count($eleve);$i++){
				$pdf->bulletinSequentiel($eleve[$i], $_SESSION['section']);
			}
			$nomFichier = "Bulletin_Sequence_".$_SESSION['sequence']."_".$_SESSION['nom_classe'].".pdf";
			$pdf->Output($nomFichier, 'I');
			
			// if($_SESSION['section']=='en'){
				
			// 	/****** PV SEQUENTIEL ALPHABETIQUE*****/
			// 	$pdf->addPage();
			// 	$pdf->Entete();
			// 	$ville = $_SESSION['information']['ville'];
			// 	$signataire = $_SESSION['information']['signataire_en'];
			// 	if($_SESSION['sequence']==1){
			// 		$sequence = 'First Sequence';
			// 	}elseif($_SESSION['sequence']==2){
			// 		$sequence = 'Second Sequence';
			// 	}elseif($_SESSION['sequence']==3){
			// 		$sequence = 'Third Sequence';
			// 	}elseif($_SESSION['sequence']==4){
			// 		$sequence = 'Fourth Sequence';
			// 	}elseif($_SESSION['sequence']==5){
			// 		$sequence = 'Fifth Sequence';
			// 	}elseif($_SESSION['sequence']==6){
			// 		$sequence = 'Sixth Sequence';
			// 	}
			// 	$titre = $sequence." report";
			// 	$pdf->Titre($titre);
			// 	$classe = "Class : ".strtoupper($_SESSION['nom_classe']);
			// 	$effectifClasse = 'Roll : '.count($_SESSION['eleve']);
			// 	$effectifEvalue = 'Evaluated : '.$_SESSION['eleve'][0]['classes'];
			// 	$signataire = $_SESSION['information']['signataire_en'];
			// 	$pdf->SetFont('Times','B',12);
			// 	$pdf->Cell(95,6,utf8_decode($classe),0,0,'L');
			// 	$pdf->Cell(45,6,utf8_decode($effectifClasse),0,0,'L');
			// 	$pdf->Cell(45,6,utf8_decode($effectifEvalue),0,0,'L');
			// 	$pdf->Ln(10);
				
			// 	/*Construction du tableau Informationnel statistique*/
			// 	$pdf->Cell(55,8,'',0,0,'C');
			// 	$pdf->Cell(35,8,utf8_decode('Title'),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode('Female'),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode('Male'),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode('Total'),1,0,'C');
			// 	$pdf->Ln(8);
			// 	$pdf->Cell(55);
			// 	$pdf->SetFont('Times','',10);
				
			// 	$pdf->Cell(35,8,utf8_decode('Averages'),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode($_SESSION['statistique']['moyFille']),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode($_SESSION['statistique']['moyMasc']),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode($_SESSION['statistique']['moyTotal']),1,0,'C');
			// 	$pdf->Ln(8);
			// 	$pdf->Cell(55);
			// 	$pdf->Cell(35,8,utf8_decode('Sub - Averages'),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode($_SESSION['statistique']['sousMoyFille']),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode($_SESSION['statistique']['sousMoyMasc']),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode($_SESSION['statistique']['sousMoyTotal']),1,0,'C');
			// 	$pdf->Ln(8);
			// 	$pdf->Cell(55);
			// 	$pdf->Cell(35,8,utf8_decode('General Average'),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode(substr($_SESSION['statistique']['moyGenFille'],0,5)),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode(substr($_SESSION['statistique']['moyGenMasc'],0,5)),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode(substr($_SESSION['statistique']['moyGenTotal'],0,5)),1,0,'C');
			// 	$pdf->Ln(8);
			// 	$pdf->Cell(55);
			// 	$pdf->Cell(35,8,utf8_decode('Percentages'),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode(substr($_SESSION['statistique']['tauxFille'],0,5)),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode(substr($_SESSION['statistique']['tauxMasc'],0,5)),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode(substr($_SESSION['statistique']['tauxTotal'],0,5)),1,0,'C');
			// 	$pdf->Ln(8);
			// 	$pdf->Cell(55);
				
			// 	$pdf->Cell(35,8,utf8_decode('Max Average'),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode($_SESSION['statistique']['noteForteFille']),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode($_SESSION['statistique']['noteForteMasc']),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode($_SESSION['statistique']['noteForteTotal']),1,0,'C');
			// 	$pdf->Ln(8);
			// 	$pdf->Cell(55);
			// 	$pdf->Cell(35,8,utf8_decode('Low Average'),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode($_SESSION['statistique']['noteFaibleFille']),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode($_SESSION['statistique']['noteFaibleMasc']),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode($_SESSION['statistique']['noteFaibleTotal']),1,0,'C');
			// 	$pdf->Ln(10);
				
				
				
			// 	// On propose sa propre couleur
			// 	$pdf->SetFillColor(200,205,180);
			// 	// Informations du PV
			// 	$pdf->SetFont('Times','B',8);
			// 	$pdf->Cell(10,5,utf8_decode('N°'),1,0,'C',true);
			// 	$pdf->Cell(20,5,utf8_decode('Identifier'),1,0,'C',true);
			// 	$pdf->Cell(55,5,utf8_decode('Student Name'),1,0,'C',true);
			// 	$pdf->Cell(10,5,utf8_decode('Sex'),1,0,'C',true);
			// 	$pdf->Cell(15,5,utf8_decode('Average'),1,0,'C',true);
			// 	$pdf->Cell(10,5,utf8_decode('Rank'),1,0,'C',true);
			// 	$pdf->Cell(25,5,utf8_decode('Grade'),1,0,'C',true);
			// 	$pdf->Cell(10,5,utf8_decode('Cote'),1,0,'C',true);
			// 	$pdf->Cell(35,5,utf8_decode('Observations'),1,0,'C',true);
			// 	$pdf->Ln(5);
			// 	$a = 1;
			// 	$pdf->SetFont('Times','',9);
			// 	for($i=0;$i<count($_SESSION['eleve']);$i++){
			// 		$pdf->Cell(10,5,utf8_decode($a),1,0,'C');
			// 		$pdf->Cell(20,5,utf8_decode($_SESSION['eleve'][$i]['rne']),1,0,'C');
			// 		$pdf->Cell(55,5,utf8_decode($_SESSION['eleve'][$i]['nom_eleve']),1,0,'L');
			// 		$pdf->Cell(10,5,utf8_decode($_SESSION['eleve'][$i]['sexe']),1,0,'C');
			// 		// Si la moyenne est zéro, alors l'élève n'a pas été classé.
			// 		if($_SESSION['eleve'][$i]['moyenne']=='0.00'){
			// 			$pdf->Cell(15,5,utf8_decode('--'),1,0,'C');
			// 			$pdf->Cell(10,5,utf8_decode('--'),1,0,'C');
			// 		}
			// 		else{
			// 			if($_SESSION['eleve'][$i]['rang']=='1'){
			// 				$rang = $_SESSION['eleve'][$i]['rang'].'st';
			// 			}elseif($_SESSION['eleve'][$i]['rang']=='2'){
			// 				$rang = $_SESSION['eleve'][$i]['rang'].'nd';
			// 			}elseif($_SESSION['eleve'][$i]['rang']=='3'){
			// 				$rang = $_SESSION['eleve'][$i]['rang'].'rd';
			// 			}else{
			// 				if($_SESSION['eleve'][$i]['rang']>3){
			// 					$rang = $_SESSION['eleve'][$i]['rang'].'th';
			// 				}else{
			// 					$rang = '';
			// 				}
			// 			}
			// 			$pdf->Cell(15,5,utf8_decode($_SESSION['eleve'][$i]['moyenne']),1,0,'C');
			// 			$pdf->Cell(10,5,utf8_decode($rang),1,0,'C');
			// 		}				
			// 		$pdf->Cell(25,5,utf8_decode(ucwords($_SESSION['eleve'][$i]['appreciation'])),1,0,'L');
			// 		$pdf->Cell(10,5,utf8_decode(ucwords($_SESSION['eleve'][$i]['cote'])),1,0,'L');
			// 		$pdf->Cell(35,5,utf8_decode(''),1,0,'C');
			// 		$pdf->Ln(5);
			// 		$a++;
			// 	}
			// 	$pdf->Ln(2);
			// 	$pdf->Cell(100);
			// 	$texte = 'Done at '.strtoupper($ville).', on the ________________.';
			// 	$pdf->Cell(80,5, utf8_decode($texte),0,0,'C');
			// 	$pdf->Ln(5);
			// 	$pdf->Cell(100);
			// 	$pdf->Cell(60,5,utf8_decode($signataire),0,0,'C');
								
								
								
								
			// 					/****** PV SEQUENTIEL DE MERITE *****/
			// 	$pdf->addPage();
			// 	$pdf->Entete();
			// 	if($_SESSION['sequence']==1){
			// 		$sequence = 'First Sequence';
			// 	}elseif($_SESSION['sequence']==2){
			// 		$sequence = 'Second Sequence';
			// 	}elseif($_SESSION['sequence']==3){
			// 		$sequence = 'Third Sequence';
			// 	}elseif($_SESSION['sequence']==4){
			// 		$sequence = 'Fourth Sequence';
			// 	}elseif($_SESSION['sequence']==5){
			// 		$sequence = 'Fifth Sequence';
			// 	}elseif($_SESSION['sequence']==6){
			// 		$sequence = 'Sixth Sequence';
			// 	}
			// 	$titre = $sequence." report";
			// 	$pdf->Titre($titre);
			// 	$classe = "Class : ".strtoupper($_SESSION['nom_classe']);
			// 	$effectifClasse = 'Roll : '.count($_SESSION['eleve']);
			// 	$effectifEvalue = 'Evaluated : '.$_SESSION['eleve'][0]['classes'];
			// 	$signataire = $_SESSION['information']['signataire_en'];
			// 	$pdf->SetFont('Times','B',12);
			// 	$pdf->Cell(95,6,utf8_decode($classe),0,0,'L');
			// 	$pdf->Cell(45,6,utf8_decode($effectifClasse),0,0,'L');
			// 	$pdf->Cell(45,6,utf8_decode($effectifEvalue),0,0,'L');
			// 	$pdf->Ln(10);
			// 	// $pdf->Ln(20);
			// 	/*Construction du tableau Informationnel statistique*/
			// 	$pdf->Cell(55,8,'',0,0,'C');
			// 	$pdf->Cell(35,8,utf8_decode('Title'),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode('Female'),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode('Male'),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode('Total'),1,0,'C');
			// 	$pdf->Ln(8);
			// 	$pdf->Cell(55);
			// 	$pdf->SetFont('Times','',10);
				
			// 	$pdf->Cell(35,8,utf8_decode('Averages'),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode($_SESSION['statistique']['moyFille']),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode($_SESSION['statistique']['moyMasc']),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode($_SESSION['statistique']['moyTotal']),1,0,'C');
			// 	$pdf->Ln(8);
			// 	$pdf->Cell(55);
			// 	$pdf->Cell(35,8,utf8_decode('Sub - Averages'),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode($_SESSION['statistique']['sousMoyFille']),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode($_SESSION['statistique']['sousMoyMasc']),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode($_SESSION['statistique']['sousMoyTotal']),1,0,'C');
			// 	$pdf->Ln(8);
			// 	$pdf->Cell(55);
			// 	$pdf->Cell(35,8,utf8_decode('General Average'),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode(substr($_SESSION['statistique']['moyGenFille'],0,5)),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode(substr($_SESSION['statistique']['moyGenMasc'],0,5)),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode(substr($_SESSION['statistique']['moyGenTotal'],0,5)),1,0,'C');
			// 	$pdf->Ln(8);
			// 	$pdf->Cell(55);
			// 	$pdf->Cell(35,8,utf8_decode('Percentages'),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode(substr($_SESSION['statistique']['tauxFille'],0,5)),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode(substr($_SESSION['statistique']['tauxMasc'],0,5)),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode(substr($_SESSION['statistique']['tauxTotal'],0,5)),1,0,'C');
			// 	$pdf->Ln(8);
			// 	$pdf->Cell(55);
				
			// 	$pdf->Cell(35,8,utf8_decode('Max Average'),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode($_SESSION['statistique']['noteForteFille']),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode($_SESSION['statistique']['noteForteMasc']),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode($_SESSION['statistique']['noteForteTotal']),1,0,'C');
			// 	$pdf->Ln(8);
			// 	$pdf->Cell(55);
			// 	$pdf->Cell(35,8,utf8_decode('Low Average'),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode($_SESSION['statistique']['noteFaibleFille']),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode($_SESSION['statistique']['noteFaibleMasc']),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode($_SESSION['statistique']['noteFaibleTotal']),1,0,'C');
			// 	$pdf->Ln(10);
				
				
				
			// 	// On propose sa propre couleur
			// 	$pdf->SetFillColor(200,205,180);
			// 	// Informations du PV
			// 	$pdf->SetFont('Times','B',8);
			// 	$pdf->Cell(10,5,utf8_decode('N°'),1,0,'C',true);
			// 	$pdf->Cell(20,5,utf8_decode('Identifier'),1,0,'C',true);
			// 	$pdf->Cell(55,5,utf8_decode('Student Name'),1,0,'C',true);
			// 	$pdf->Cell(10,5,utf8_decode('Sex'),1,0,'C',true);
			// 	$pdf->Cell(15,5,utf8_decode('Average'),1,0,'C',true);
			// 	$pdf->Cell(10,5,utf8_decode('Rank'),1,0,'C',true);
			// 	$pdf->Cell(25,5,utf8_decode('Grade'),1,0,'C',true);
			// 	$pdf->Cell(10,5,utf8_decode('Cote'),1,0,'C',true);
			// 	$pdf->Cell(35,5,utf8_decode('Observations'),1,0,'C',true);
			// 	$pdf->Ln(5);
			// 	$a = 1;
			// 	$pdf->SetFont('Times','',9);
			// 	for($i=0;$i<count($_SESSION['eleve2']);$i++){
			// 		$pdf->Cell(10,5,utf8_decode($a),1,0,'C');
			// 		$pdf->Cell(20,5,utf8_decode($_SESSION['eleve2'][$i]['rne']),1,0,'C');
			// 		$pdf->Cell(55,5,utf8_decode($_SESSION['eleve2'][$i]['nom_eleve']),1,0,'L');
			// 		$pdf->Cell(10,5,utf8_decode($_SESSION['eleve2'][$i]['sexe']),1,0,'C');
			// 		// Si la moyenne est zéro, alors l'élève n'a pas été classé.
			// 		if($_SESSION['eleve2'][$i]['moyenne']=='0.00'){
			// 			$pdf->Cell(15,5,utf8_decode('--'),1,0,'C');
			// 			$pdf->Cell(10,5,utf8_decode('--'),1,0,'C');
			// 		}
			// 		else{
			// 			if($_SESSION['eleve2'][$i]['rang']=='1'){
			// 				$rang = $_SESSION['eleve2'][$i]['rang'].'st';
			// 			}elseif($_SESSION['eleve2'][$i]['rang']=='2'){
			// 				$rang = $_SESSION['eleve2'][$i]['rang'].'nd';
			// 			}elseif($_SESSION['eleve2'][$i]['rang']=='3'){
			// 				$rang = $_SESSION['eleve2'][$i]['rang'].'rd';
			// 			}else{
			// 				if($_SESSION['eleve2'][$i]['rang']>3){
			// 					$rang = $_SESSION['eleve'][$i]['rang'].'th';
			// 				}else{
			// 					$rang = '';
			// 				}
			// 			}
			// 			$pdf->Cell(15,5,utf8_decode($_SESSION['eleve2'][$i]['moyenne']),1,0,'C');
			// 			$pdf->Cell(10,5,utf8_decode($rang),1,0,'C');
			// 		}				
			// 		$pdf->Cell(25,5,utf8_decode(ucwords($_SESSION['eleve2'][$i]['appreciation'])),1,0,'L');
			// 		$pdf->Cell(10,5,utf8_decode(ucwords($_SESSION['eleve2'][$i]['cote'])),1,0,'L');
			// 		$pdf->Cell(35,5,utf8_decode(''),1,0,'C');
			// 		$pdf->Ln(5);
			// 		$a++;
			// 	}
			// 	$pdf->Ln(2);
			// 	$pdf->Cell(100);
			// 	$texte = 'Done at '.strtoupper($ville).', on the ________________.';
			// 	$pdf->Cell(80,5, utf8_decode($texte),0,0,'C');
			// 	$pdf->Ln(5);
			// 	$pdf->Cell(100);
			// 	$pdf->Cell(60,5,utf8_decode($signataire),0,0,'C');
				
				
				
			// 	/**** GENERATION DU BULLETIN SEQUENTIEL PAR ELEVE *****/
				
			// 	$eleve = $_SESSION['eleve'];
				
			// 	for($a=0;$a<count($eleve);$a++){
			// 		$pdf->addPage();
			// 		// On met l'entête du document
			// 		$pdf->Entete();
			// 		// On met le titre du document
			// 		$titre = "Reported marks of the ".$sequence;
			// 		$pdf->SetFont('Times','BUI',14);
			// 		// $pdf->SetFont('Times','BU',14);
			// 		// Informations sur l'élève 
			// 		$pdf->Text(40,75,strtoupper(utf8_decode($titre)));
			// 		$pdf->SetFont('Times','',10);
			// 		$lib_nom = 'Student Name : ';
			// 		$lib_classe = 'Class  : ';
			// 		$lib_matricule = 'Identifier. : ';
			// 		$lib_effectif = 'Roll : ';
			// 		$lib_dateNaissance = 'Date of birth : ';
			// 		$lib_lieuNaissance = 'at : ';
			// 		$lib_sexe = 'Sex : ';
			// 		$lib_redoublant = 'Repeater : ';
			// 		$lib_titulaire = 'Class Principal : ';
			// 		$pdf->Text(20,80,utf8_decode($lib_nom));
			// 		$pdf->Text(120,80,utf8_decode($lib_classe));
			// 		$pdf->Text(20,85,utf8_decode($lib_matricule));
			// 		$pdf->Text(120,85,utf8_decode($lib_effectif));
			// 		$pdf->Text(20,90,utf8_decode($lib_dateNaissance));
			// 		$pdf->Text(100,90,utf8_decode($lib_lieuNaissance));
			// 		$pdf->Text(20,95,utf8_decode($lib_sexe));
			// 		$pdf->Text(50,95,utf8_decode($lib_redoublant));
			// 		$pdf->Text(100,95,utf8_decode($lib_titulaire));
					
			// 		$pdf->SetFont('Times','B',10);
			// 		$nom = $eleve[$a]['nom_eleve'];
			// 		$nomClasse = strtoupper($_SESSION['nom_classe']);
			// 		$matricule = $eleve[$a]['rne'];
			// 		$effectif = count($eleve);
			// 		$dateNaissance = $eleve[$a]['date_fr'];
			// 		$lieuNaissance = $eleve[$a]['lieu_naissance'];
			// 		$sexe = $eleve[$a]['sexe'];
			// 		$redoublant = $eleve[$a]['statut'];
			// 		$titulaire = ''; /*$_SESSION['professeurPrincipal'];*/
			// 		$image =$eleve[$a]['photo'];
					
			// 		$pdf->Text(50,80,utf8_decode($nom));
			// 		$pdf->Text(140,80,utf8_decode($nomClasse));
			// 		$pdf->Text(40,85,utf8_decode($matricule));
			// 		$pdf->Text(150,85,utf8_decode($effectif));
			// 		$pdf->Text(55,90,utf8_decode($dateNaissance));
			// 		$pdf->Text(105,90,utf8_decode($lieuNaissance));
			// 		$pdf->Text(30,95,utf8_decode($sexe));
			// 		$pdf->Text(70,95,utf8_decode($redoublant));
			// 		$pdf->Text(135,95,utf8_decode($titulaire));
					 
			// 		// $pdf->Image($image, 30, 40, 10);
			// 		// $pdf->Image($image, 170, 45, 22, 22);
			// 		// Titre du Tableau du bulletin
					
			// 		// On créé un espace supplémentaire entre le tableau et les info du haut
			// 		$pdf->Ln(35);
			// 		$pdf->SetFont('Times','B',8);
			// 		$pdf->Cell(8);
			// 		$pdf->Cell(40,6, utf8_decode('Subject'),1,0,'C',true);
			// 		$pdf->Cell(35,6, utf8_decode('Competence'),1,0,'C',true);
			// 		$pdf->Cell(12,6, utf8_decode('Note /20'),1,0,'C',true);
			// 		$pdf->Cell(10,6, utf8_decode('Coef'),1,0,'C',true);
			// 		$pdf->Cell(15,6, utf8_decode('Product'),1,0,'C',true);
			// 		$pdf->Cell(10,6, utf8_decode('Min'),1,0,'C',true);
			// 		$pdf->Cell(10,6, utf8_decode('Max'),1,0,'C',true);
			// 		$pdf->Cell(22,6, utf8_decode('Grade'),1,0,'C',true);
			// 		$pdf->Cell(10,6, utf8_decode('Cote'),1,0,'C',true);
			// 		$pdf->Cell(20,6, utf8_decode('Teacher Obs.'),1,0,'C',true);
			// 		$pdf->SetFont('Times','',8);
			// 		$pdf->Ln(6);
					
			// 		// On ressort une boucle qui liste les groupes définis
			// 		for($b=0;$b<count($_SESSION['groupe']);$b++){
			// 			$codeGroupe = $_SESSION['groupe'][$b]['code_groupe'];
			// 			$idGroupe = $_SESSION['groupe'][$b]['groupe'];
			// 			$nomGroupe = $_SESSION['groupe'][$b]['nom_groupe'];
			// 			$matieresGroupe = $_SESSION['matiereGroupe'][$idGroupe];
			// 			for($c=0;$c<count($matieresGroupe);$c++){
			// 				$codeMatiere = $matieresGroupe[$c]['code_matiere'];
			// 				$competence = strtolower($codeMatiere.'_competence');
			// 				$sekence = strtolower($codeMatiere.'_seq');
			// 				$coef = strtolower($codeMatiere.'_coef');
			// 				$produit = strtolower($codeMatiere.'_total');
			// 				$min = strtolower($codeMatiere.'_min');
			// 				$max = strtolower($codeMatiere.'_max');
			// 				$appr = strtolower($codeMatiere.'_appreciation');
			// 				$cote = strtolower($codeMatiere.'_cote');
			// 				$enseignant = strtolower($codeMatiere.'_enseignant');
			// 				$nomMatiere = strtoupper($matieresGroupe[$c]['nom_matiere']);
			// 				// $pdf->Cell(12,6, utf8_decode($eleve[$a][$seq1]),1,0,'C');
			// 				// $pdf->SetFont('Times','B',8);
			// 				$pdf->Cell(8);
			// 				$pdf->Cell(40,3, $nomMatiere,1,0,'L');
							
			// 				$pdf->Cell(35,6, utf8_decode(substr($eleve[$a][$competence],0,20)),1,0,'L');
			// 				$pdf->Cell(12,6, utf8_decode($eleve[$a][$sekence]),1,0,'C');
			// 				$pdf->Cell(10,6, utf8_decode($eleve[$a][$coef]),1,0,'C');
			// 				$pdf->Cell(15,6, utf8_decode($eleve[$a][$produit]),1,0,'C');
			// 				$pdf->Cell(10,6, utf8_decode($eleve[$a][$min]),1,0,'C');
			// 				$pdf->Cell(10,6, utf8_decode($eleve[$a][$max]),1,0,'C');
			// 				$pdf->Cell(22,6, utf8_decode($eleve[$a][$appr]),1,0,'C');
			// 				$pdf->Cell(10,6, utf8_decode($eleve[$a][$cote]),1,0,'C');
			// 				$pdf->Cell(20,6, utf8_decode(''),1,0,'C');
			// 				$pdf->SetFont('Times','',8);
			// 				// $pdf->Ln(6);
			// 				$pdf->Ln(3);
			// 				$pdf->SetFont('Times','I',7);
			// 				$pdf->Cell(8);
			// 				$pdf->Cell(40,3, utf8_decode($eleve[$a][$enseignant]),0,0,'L');
			// 				$pdf->Ln(3);
			// 				$pdf->SetFont('Times','',8);
			// 			}
			// 			$pdf->Cell(8);
			// 			$pdf->SetFont('Times','B',8);
			// 			$moyenneGroupe = $codeGroupe.'_moyenne';
			// 			$coefGroupe = $codeGroupe.'_coef';
			// 			$totalGroupe = $codeGroupe.'_total';
			// 			$minGroupe = $codeGroupe.'_min';
			// 			$maxGroupe = $codeGroupe.'_max';
			// 			$apprGroupe = $codeGroupe.'_appreciation';
			// 			$coteGroupe = $codeGroupe.'_cote';
			// 			$pdf->Cell(75,6, utf8_decode(strtoupper('Total of '.$nomGroupe)),1,0,'L',true);
			// 			$pdf->Cell(12,6, utf8_decode(utf8_decode($eleve[$a][$moyenneGroupe])),1,0,'C',true);
			// 			$pdf->Cell(10,6, utf8_decode($eleve[$a][$coefGroupe]),1,0,'C',true);
			// 			$pdf->Cell(15,6, utf8_decode($eleve[$a][$totalGroupe]),1,0,'C',true);
			// 			$pdf->Cell(10,6, $eleve[$a][$minGroupe],1,0,'C',true);
			// 			$pdf->Cell(10,6, $eleve[$a][$maxGroupe],1,0,'C',true);
			// 			$pdf->Cell(22,6, $eleve[$a][$apprGroupe],1,0,'C',true);
			// 			$pdf->Cell(10,6, $eleve[$a][$coteGroupe],1,0,'C',true);
			// 			$pdf->Cell(20,6, '',1,0,'C',true);
			// 			$pdf->Ln(6);
			// 			$pdf->SetFont('Times','',7);
			// 		}
			// 		$pdf->SetFont('Times','B',9);
			// 		$pdf->Ln(2);
			// 		$pdf->Cell(8);
			// 		$pdf->Cell(87,6, utf8_decode('TOTAL'),1,0,'C',true);
			// 		// $pdf->Cell(12,6, utf8_decode($eleve[$a]['moyenne']),1,0,'C',true);
			// 		$pdf->Cell(10,6, utf8_decode($eleve[$a]['total_coef']),1,0,'C',true);
			// 		$pdf->Cell(15,6, utf8_decode($eleve[$a]['total_point']),1,0,'C',true);
			// 		$pdf->Cell(35,6, utf8_decode('Student Average'),1,0,'C',true);
					
			// 		$pdf->Cell(25,6, utf8_decode(ucwords($eleve[$a]['moyenne'])),1,0,'L',true);
			// 		// $pdf->Cell(10,6, utf8_decode(ucwords($eleve[$a]['cote'])),1,0,'L',true);
			// 		// $pdf->Cell(20,6, '',1,0,'L',true);
			// 		$pdf->Ln(10);
			// 		$pdf->Cell(8);
					
			// 		$pdf->Cell(53,6,utf8_decode('Discipline'), 1,0,'C',true);
			// 		$pdf->Cell(5, 6, utf8_decode(''),0,0,'C');
			// 		$pdf->Cell(53,6,utf8_decode('Work'), 1,0,'C',true);
			// 		$pdf->Cell(5, 6, utf8_decode(''),0,0,'C');
			// 		$pdf->Cell(53,6,utf8_decode('Class Profile'), 1,0,'C',true);
			// 		$pdf->Ln(6);
			// 		$pdf->Cell(8);
					
			// 		$pdf->Cell(20,6,utf8_decode('Abs Non Just.'), 1,0,'C');
			// 		$pdf->Cell(6,6,utf8_decode(''), 1,0,'C');
			// 		$pdf->Cell(20,6,utf8_decode('Avert. Cond.'), 1,0,'C');
			// 		$pdf->Cell(7,6,utf8_decode(''), 1,0,'C');
			// 		$pdf->Cell(5, 6, utf8_decode(''),0,0,'C');
			// 		$pdf->Cell(17,6,utf8_decode('Total Gén.'), 1,0,'C');
			// 		$pdf->Cell(10,6,utf8_decode($eleve[$a]['total_point']), 1,0,'C');
			// 		$pdf->Cell(26,6,utf8_decode('Grade'), 1,0,'C');
			// 		$pdf->Cell(5, 6, utf8_decode(''),0,0,'C');
			// 		$pdf->Cell(30,6,utf8_decode('General Averag'), 1,0,'C');
			// 		$pdf->Cell(23,6,$_SESSION['statistique']['moyGenTotal'], 1,0,'C');
			// 		$pdf->Ln(6);
			// 		$pdf->Cell(8);
					
			// 		$pdf->Cell(20,6,utf8_decode('Abs Just.'), 1,0,'C');
			// 		$pdf->Cell(6,6,utf8_decode(''), 1,0,'C');
			// 		$pdf->Cell(20,6,utf8_decode('Blâme. Cond.'), 1,0,'C');
			// 		$pdf->Cell(7,6,utf8_decode(''), 1,0,'C');
			// 		$pdf->Cell(5, 6, utf8_decode(''),0,0,'C');
			// 		$pdf->Cell(17,6,utf8_decode('Coef'), 1,0,'C');
			// 		$pdf->Cell(10,6,utf8_decode($eleve[$a]['total_coef']), 1,0,'C');
			// 		$pdf->Cell(26,6,utf8_decode($eleve[$a]['appreciation']), 1,0,'C');
			// 		$pdf->Cell(5, 6, utf8_decode(''),0,0,'C');
			// 		$minMax = "[ ".$_SESSION['statistique']['noteFaibleTotal'];
			// 		$minMax .= " - ".$_SESSION['statistique']['noteForteTotal'];
			// 		$minMax .= " ]";
			// 		$pdf->Cell(30,6,utf8_decode('[Min - Max]'), 1,0,'C');
			// 		$pdf->Cell(23,6,$minMax, 1,0,'C');
			// 		$pdf->Ln(6);
			// 		$pdf->Cell(8);
					
			// 		$pdf->Cell(20,6,utf8_decode('Retards'), 1,0,'C');
			// 		$pdf->Cell(6,6,utf8_decode(''), 1,0,'C');
			// 		$pdf->Cell(20,6,utf8_decode('Exclusions'), 1,0,'C');
			// 		$pdf->Cell(7,6,utf8_decode(''), 1,0,'C');
			// 		$pdf->Cell(5, 6, utf8_decode(''),0,0,'C');
			// 		$pdf->Cell(27,6,utf8_decode('Average'), 1,0,'C');
			// 		if($eleve[$a]['moyenne']=='0.00'){
			// 			$pdf->Cell(26,6,'--', 1,0,'C');
			// 		}else{
			// 			$pdf->Cell(26,6,utf8_decode($eleve[$a]['moyenne']), 1,0,'C');
			// 		}
			// 		// $pdf->Cell(26,6,'', 1,0,'C');
			// 		$pdf->Cell(5, 6, utf8_decode(''),0,0,'C');
			// 		$pdf->Cell(30,6,utf8_decode('Nb of Aver.'), 1,0,'C');
			// 		$pdf->Cell(23,6,$_SESSION['statistique']['moyTotal'], 1,0,'C');
			// 		$pdf->Ln(6);
			// 		$pdf->Cell(8);
					
			// 		$pdf->Cell(20,6,utf8_decode('Consignes'), 1,0,'C');
			// 		$pdf->Cell(6,6,utf8_decode(''), 1,0,'C');
			// 		$pdf->Cell(20,6,utf8_decode('Excl. Déf.'), 1,0,'C');
			// 		$pdf->Cell(7,6,utf8_decode(''), 1,0,'C');
			// 		$pdf->Cell(5, 6, utf8_decode(''),0,0,'C');
			// 		$pdf->Cell(27,6,utf8_decode('Cote'), 1,0,'C');
			// 		if($eleve[$a]['moyenne']=='0.00'){
			// 			$pdf->Cell(26,6,'--', 1,0,'C');
			// 		}else{
			// 			$pdf->Cell(26,6,utf8_decode($eleve[$a]['cote']), 1,0,'C');
			// 		}
			// 		// $pdf->Cell(26,6,'', 1,0,'C');
			// 		$pdf->Cell(5, 6, utf8_decode(''),0,0,'C');
			// 		$pdf->Cell(30,6,utf8_decode('Percentage'), 1,0,'C');
			// 		$pdf->Cell(23,6,$_SESSION['statistique']['tauxTotal'], 1,0,'C');
			// 		$pdf->Ln(6);
			// 		$pdf->Cell(8);
					
			// 		/*$pdf->Cell(20,6,utf8_decode(''), 0,0,'C');
			// 		$pdf->Cell(6,6,utf8_decode(''), 0,0,'C');
			// 		$pdf->Cell(20,6,utf8_decode(''), 0,0,'C');
			// 		$pdf->Cell(7,6,utf8_decode(''), 0,0,'C');
			// 		$pdf->Cell(5, 6, utf8_decode(''),0,0,'C');
			// 		$pdf->Cell(17,6,utf8_decode(''), 0,0,'C');
			// 		$pdf->Cell(10,6,utf8_decode(''), 0,0,'C');
			// 		$pdf->Cell(26,6,'', 0,0,'C');
			// 		$pdf->Cell(5, 6, utf8_decode(''),0,0,'C');
			// 		$pdf->Cell(30,6,utf8_decode(''), 0,0,'C');
			// 		$pdf->Cell(23,6,'', 0,0,'C');
			// 		$pdf->Ln(6);
			// 		$pdf->Cell(8);*/
					
			// 		$pdf->Cell(46,6,utf8_decode('The Parent'), 0,0,'C');
					

			// 		$pdf->Cell(12,6,utf8_decode(''), 0,0,'C');
			// 		$texte = 'Done at '.strtoupper($ville).' on the ________________';
			// 		$pdf->Cell(39,6,utf8_decode('The Class Principal'), 0,0,'C');
					
			// 		$pdf->Cell(26,6,'', 0,0,'C');
			// 		$pdf->Cell(5, 6, utf8_decode(''),0,0,'C');
			// 		$pdf->Cell(58,6,utf8_decode($texte), 0,0,'C');
					
			// 		$pdf->Ln(3);
			// 		$pdf->Cell(8);
					
										
			// 		$pdf->SetFont('Times','I',9);
			// 		$pdf->Cell(28,6,utf8_decode(''), 0,0,'C');
			// 		$pdf->Cell(25,6,utf8_decode(''), 0,0,'C');
			// 		$pdf->Cell(5, 6, utf8_decode(''),0,0,'C');
			// 		$pdf->Cell(28,6,utf8_decode(''), 0,0,'C');
			// 		$pdf->Cell(25,6,utf8_decode(''), 0,0,'C');
			// 		$pdf->Cell(25,6,utf8_decode(''), 0,0,'C');
			// 		$pdf->Cell(25,6,utf8_decode($signataire), 0,0,'C');
			// 		/*$pdf->Ln(6);
			// 		$pdf->Cell(8);
			// 		$pdf->Cell(28,6,utf8_decode(''), 0,0,'C');
			// 		$pdf->Cell(25,6,utf8_decode(''), 0,0,'C');
			// 		$pdf->Cell(5, 6, utf8_decode(''),0,0,'C');
			// 		$pdf->Cell(28,6,utf8_decode(''), 0,0,'C');
			// 		$pdf->Cell(25,6,utf8_decode(''), 0,0,'C');
					
			// 		$pdf->SetFont('Times','B',9);*/
										
			// 	}
				
				
			// 	// Le nom du fichier sera Bull_Trimestre_NumeroTrimestre_Classe
			// 	$nomFichier = 'Bulletin_Sequence_'.$_SESSION['sequence'].'_'.$_SESSION['nom_classe'].'.pdf';
			// 	$pdf->Output($nomFichier, 'I');
			
			// }
			
			// elseif($_SESSION['section']=='fr'){
			// 	/****** PV SEQUENTIEL ALPHABETIQUE*****/
			// 	$pdf->addPage();
			// 	$pdf->Entete();
			// 	$ville = $_SESSION['information']['ville'];
			// 	$signataire = $_SESSION['information']['signataire_fr'];
			// 	if($_SESSION['sequence']==1){
			// 		$sequence = 'Premiere Sequence';
			// 	}elseif($_SESSION['sequence']==2){
			// 		$sequence = 'Second Sequence';
			// 	}elseif($_SESSION['sequence']==3){
			// 		$sequence = 'Third Sequence';
			// 	}elseif($_SESSION['sequence']==4){
			// 		$sequence = 'Fourth Sequence';
			// 	}elseif($_SESSION['sequence']==5){
			// 		$sequence = 'Fifth Sequence';
			// 	}elseif($_SESSION['sequence']==6){
			// 		$sequence = 'Sixth Sequence';
			// 	}
			// 	$titre = "proces verbal de la ".$sequence;
			// 	$pdf->Titre($titre);
			// 	$classe = "Classe : ".strtoupper($_SESSION['nom_classe']);
			// 	$effectifClasse = 'Effectif : '.count($_SESSION['eleve']);
			// 	$effectifEvalue = 'Evaluaté : '.$_SESSION['eleve'][0]['classes'];
				
			// 	$pdf->SetFont('Times','B',12);
			// 	$pdf->Cell(95,6,utf8_decode($classe),0,0,'L');
			// 	$pdf->Cell(45,6,utf8_decode($effectifClasse),0,0,'L');
			// 	$pdf->Cell(45,6,utf8_decode($effectifEvalue),0,0,'L');
			// 	$pdf->Ln(10);
				
			// 	/*Construction du tableau Informationnel statistique*/
			// 	$pdf->Cell(55,8,'',0,0,'C');
			// 	$pdf->Cell(35,8,utf8_decode('Libelle'),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode('Feminin'),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode('Masculin'),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode('Total'),1,0,'C');
			// 	$pdf->Ln(8);
			// 	$pdf->Cell(55);
			// 	$pdf->SetFont('Times','',10);
				
			// 	$pdf->Cell(35,8,utf8_decode('Moyennes'),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode($_SESSION['statistique']['moyFille']),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode($_SESSION['statistique']['moyMasc']),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode($_SESSION['statistique']['moyTotal']),1,0,'C');
			// 	$pdf->Ln(8);
			// 	$pdf->Cell(55);
			// 	$pdf->Cell(35,8,utf8_decode('Sous - Moyennes'),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode($_SESSION['statistique']['sousMoyFille']),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode($_SESSION['statistique']['sousMoyMasc']),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode($_SESSION['statistique']['sousMoyTotal']),1,0,'C');
			// 	$pdf->Ln(8);
			// 	$pdf->Cell(55);
			// 	$pdf->Cell(35,8,utf8_decode('Moyenne Géneréle '),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode(substr($_SESSION['statistique']['moyGenFille'],0,5)),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode(substr($_SESSION['statistique']['moyGenMasc'],0,5)),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode(substr($_SESSION['statistique']['moyGenTotal'],0,5)),1,0,'C');
			// 	$pdf->Ln(8);
			// 	$pdf->Cell(55);
			// 	$pdf->Cell(35,8,utf8_decode('Taux de réussite'),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode(substr($_SESSION['statistique']['tauxFille'],0,5)),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode(substr($_SESSION['statistique']['tauxMasc'],0,5)),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode(substr($_SESSION['statistique']['tauxTotal'],0,5)),1,0,'C');
			// 	$pdf->Ln(8);
			// 	$pdf->Cell(55);
				
			// 	$pdf->Cell(35,8,utf8_decode('Forte Moyenne'),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode($_SESSION['statistique']['noteForteFille']),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode($_SESSION['statistique']['noteForteMasc']),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode($_SESSION['statistique']['noteForteTotal']),1,0,'C');
			// 	$pdf->Ln(8);
			// 	$pdf->Cell(55);
			// 	$pdf->Cell(35,8,utf8_decode('Faible Moyenne'),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode($_SESSION['statistique']['noteFaibleFille']),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode($_SESSION['statistique']['noteFaibleMasc']),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode($_SESSION['statistique']['noteFaibleTotal']),1,0,'C');
			// 	$pdf->Ln(10);
				
				
				
			// 	// On propose sa propre couleur
			// 	$pdf->SetFillColor(200,205,180);
			// 	// Informations du PV
			// 	$pdf->SetFont('Times','B',8);
			// 	$pdf->Cell(10,5,utf8_decode('N°'),1,0,'C',true);
			// 	$pdf->Cell(20,5,utf8_decode('Matricule'),1,0,'C',true);
			// 	$pdf->Cell(55,5,utf8_decode('Nom de l élève'),1,0,'C',true);
			// 	$pdf->Cell(10,5,utf8_decode('Sexe'),1,0,'C',true);
			// 	$pdf->Cell(15,5,utf8_decode('Moyenne'),1,0,'C',true);
			// 	$pdf->Cell(10,5,utf8_decode('Rang'),1,0,'C',true);
			// 	$pdf->Cell(25,5,utf8_decode('Appreciation'),1,0,'C',true);
			// 	$pdf->Cell(10,5,utf8_decode('Cote'),1,0,'C',true);
			// 	$pdf->Cell(35,5,utf8_decode('Observations'),1,0,'C',true);
			// 	$pdf->Ln(5);
			// 	$a = 1;
			// 	$pdf->SetFont('Times','',9);
			// 	for($i=0;$i<count($_SESSION['eleve']);$i++){
			// 		$pdf->Cell(10,5,utf8_decode($a),1,0,'C');
			// 		$pdf->Cell(20,5,utf8_decode($_SESSION['eleve'][$i]['rne']),1,0,'C');
			// 		$pdf->Cell(55,5,utf8_decode($_SESSION['eleve'][$i]['nom_eleve']),1,0,'L');
			// 		$pdf->Cell(10,5,utf8_decode($_SESSION['eleve'][$i]['sexe']),1,0,'C');
			// 		// Si la moyenne est zéro, alors l'élève n'a pas été classé.
			// 		if($_SESSION['eleve'][$i]['moyenne']=='0.00'){
			// 			$pdf->Cell(15,5,utf8_decode('--'),1,0,'C');
			// 			$pdf->Cell(10,5,utf8_decode('--'),1,0,'C');
			// 		}
			// 		else{
			// 			if($_SESSION['eleve'][$i]['rang']=='1'){
			// 				$rang = $_SESSION['eleve'][$i]['rang'].'er';
			// 			}elseif($_SESSION['eleve'][$i]['rang']=='2'){
			// 				$rang = $_SESSION['eleve'][$i]['rang'].'nd';
			// 			}elseif($_SESSION['eleve'][$i]['rang']=='3'){
			// 				$rang = $_SESSION['eleve'][$i]['rang'].'eme';
			// 			}else{
			// 				if($_SESSION['eleve'][$i]['rang']>3){
			// 					$rang = $_SESSION['eleve'][$i]['rang'].'eme';
			// 				}else{
			// 					$rang = '';
			// 				}
			// 			}
			// 			$pdf->Cell(15,5,utf8_decode($_SESSION['eleve'][$i]['moyenne']),1,0,'C');
			// 			$pdf->Cell(10,5,utf8_decode($rang),1,0,'C');
			// 		}				
			// 		$pdf->Cell(25,5,utf8_decode(ucwords($_SESSION['eleve'][$i]['appreciation'])),1,0,'L');
			// 		$pdf->Cell(10,5,utf8_decode(ucwords($_SESSION['eleve'][$i]['cote'])),1,0,'L');
			// 		$pdf->Cell(35,5,utf8_decode(''),1,0,'C');
			// 		$pdf->Ln(5);
			// 		$a++;
			// 	}
			// 	$pdf->Ln(2);
			// 	$pdf->Cell(100);
			// 	$texte = 'Fait à  '.strtoupper($ville).', le ________________.';
			// 	$pdf->Cell(80,5, utf8_decode($texte),0,0,'C');
			// 	$pdf->Ln(5);
			// 	$pdf->Cell(100);
			// 	$pdf->Cell(60,5,utf8_decode($signataire),0,0,'C');
								
								
								
								
			// 					/****** PV SEQUENTIEL DE MERITE *****/
			// 	$pdf->addPage();
			// 	$pdf->Entete();
			// 	if($_SESSION['sequence']==1){
			// 		$sequence = 'Premiere Sequence';
			// 	}elseif($_SESSION['sequence']==2){
			// 		$sequence = 'Second Sequence';
			// 	}elseif($_SESSION['sequence']==3){
			// 		$sequence = 'Third Sequence';
			// 	}elseif($_SESSION['sequence']==4){
			// 		$sequence = 'Fourth Sequence';
			// 	}elseif($_SESSION['sequence']==5){
			// 		$sequence = 'Fifth Sequence';
			// 	}elseif($_SESSION['sequence']==6){
			// 		$sequence = 'Sixth Sequence';
			// 	}
			// 	$titre = "proces vebal de la ".$sequence;
			// 	$pdf->Titre($titre);
			// 	$classe = "Classe : ".strtoupper($_SESSION['nom_classe']);
			// 	$effectifClasse = 'Effectif : '.count($_SESSION['eleve']);
			// 	$effectifEvalue = 'Evaluatés : '.$_SESSION['eleve'][0]['classes'];
				
			// 	$pdf->SetFont('Times','B',12);
			// 	$pdf->Cell(95,6,utf8_decode($classe),0,0,'L');
			// 	$pdf->Cell(45,6,utf8_decode($effectifClasse),0,0,'L');
			// 	$pdf->Cell(45,6,utf8_decode($effectifEvalue),0,0,'L');
			// 	$pdf->Ln(10);
			// 	// $pdf->Ln(20);
			// 	/*Construction du tableau Informationnel statistique*/
			// 	$pdf->Cell(55,8,'',0,0,'C');
			// 	$pdf->Cell(35,8,utf8_decode('Libelle'),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode('Feminin'),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode('Masculin'),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode('Total'),1,0,'C');
			// 	$pdf->Ln(8);
			// 	$pdf->Cell(55);
			// 	$pdf->SetFont('Times','',10);
				
			// 	$pdf->Cell(35,8,utf8_decode('Moyenne'),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode($_SESSION['statistique']['moyFille']),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode($_SESSION['statistique']['moyMasc']),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode($_SESSION['statistique']['moyTotal']),1,0,'C');
			// 	$pdf->Ln(8);
			// 	$pdf->Cell(55);
			// 	$pdf->Cell(35,8,utf8_decode('Sous - Moyennes'),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode($_SESSION['statistique']['sousMoyFille']),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode($_SESSION['statistique']['sousMoyMasc']),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode($_SESSION['statistique']['sousMoyTotal']),1,0,'C');
			// 	$pdf->Ln(8);
			// 	$pdf->Cell(55);
			// 	$pdf->Cell(35,8,utf8_decode('Moyenne Générale'),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode(substr($_SESSION['statistique']['moyGenFille'],0,5)),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode(substr($_SESSION['statistique']['moyGenMasc'],0,5)),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode(substr($_SESSION['statistique']['moyGenTotal'],0,5)),1,0,'C');
			// 	$pdf->Ln(8);
			// 	$pdf->Cell(55);
			// 	$pdf->Cell(35,8,utf8_decode('Taux de Réussite'),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode(substr($_SESSION['statistique']['tauxFille'],0,5)),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode(substr($_SESSION['statistique']['tauxMasc'],0,5)),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode(substr($_SESSION['statistique']['tauxTotal'],0,5)),1,0,'C');
			// 	$pdf->Ln(8);
			// 	$pdf->Cell(55);
				
			// 	$pdf->Cell(35,8,utf8_decode('Forte Moyenne'),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode($_SESSION['statistique']['noteForteFille']),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode($_SESSION['statistique']['noteForteMasc']),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode($_SESSION['statistique']['noteForteTotal']),1,0,'C');
			// 	$pdf->Ln(8);
			// 	$pdf->Cell(55);
			// 	$pdf->Cell(35,8,utf8_decode('Faible Moyenne'),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode($_SESSION['statistique']['noteFaibleFille']),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode($_SESSION['statistique']['noteFaibleMasc']),1,0,'C');
			// 	$pdf->Cell(20,8,utf8_decode($_SESSION['statistique']['noteFaibleTotal']),1,0,'C');
			// 	$pdf->Ln(10);
				
				
				
			// 	// On propose sa propre couleur
			// 	$pdf->SetFillColor(200,205,180);
			// 	// Informations du PV
			// 	$pdf->SetFont('Times','B',8);
			// 	$pdf->Cell(10,5,utf8_decode('N°'),1,0,'C',true);
			// 	$pdf->Cell(20,5,utf8_decode('Matricule'),1,0,'C',true);
			// 	$pdf->Cell(55,5,utf8_decode('nom de l élève'),1,0,'C',true);
			// 	$pdf->Cell(10,5,utf8_decode('Sexe'),1,0,'C',true);
			// 	$pdf->Cell(15,5,utf8_decode('Moyenne'),1,0,'C',true);
			// 	$pdf->Cell(10,5,utf8_decode('Rang'),1,0,'C',true);
			// 	$pdf->Cell(25,5,utf8_decode('Appreciation'),1,0,'C',true);
			// 	$pdf->Cell(10,5,utf8_decode('Cote'),1,0,'C',true);
			// 	$pdf->Cell(35,5,utf8_decode('Observations'),1,0,'C',true);
			// 	$pdf->Ln(5);
			// 	$a = 1;
			// 	$pdf->SetFont('Times','',9);
			// 	for($i=0;$i<count($_SESSION['eleve2']);$i++){
			// 		$pdf->Cell(10,5,utf8_decode($a),1,0,'C');
			// 		$pdf->Cell(20,5,utf8_decode($_SESSION['eleve2'][$i]['rne']),1,0,'C');
			// 		$pdf->Cell(55,5,utf8_decode($_SESSION['eleve2'][$i]['nom_eleve']),1,0,'L');
			// 		$pdf->Cell(10,5,utf8_decode($_SESSION['eleve2'][$i]['sexe']),1,0,'C');
			// 		// Si la moyenne est zéro, alors l'élève n'a pas été classé.
			// 		if($_SESSION['eleve2'][$i]['moyenne']=='0.00'){
			// 			$pdf->Cell(15,5,utf8_decode('--'),1,0,'C');
			// 			$pdf->Cell(10,5,utf8_decode('--'),1,0,'C');
			// 		}
			// 		else{
			// 			if($_SESSION['eleve2'][$i]['rang']=='1'){
			// 				$rang = $_SESSION['eleve2'][$i]['rang'].'er';
			// 			}elseif($_SESSION['eleve2'][$i]['rang']=='2'){
			// 				$rang = $_SESSION['eleve2'][$i]['rang'].'nd';
			// 			}elseif($_SESSION['eleve2'][$i]['rang']=='3'){
			// 				$rang = $_SESSION['eleve2'][$i]['rang'].'eme';
			// 			}else{
			// 				if($_SESSION['eleve2'][$i]['rang']>3){
			// 					$rang = $_SESSION['eleve2'][$i]['rang'].'eme';
			// 				}else{
			// 					$rang = '';
			// 				}
			// 			}
			// 			$pdf->Cell(15,5,utf8_decode($_SESSION['eleve2'][$i]['moyenne']),1,0,'C');
			// 			$pdf->Cell(10,5,utf8_decode($rang),1,0,'C');
			// 		}				
			// 		$pdf->Cell(25,5,utf8_decode(ucwords($_SESSION['eleve2'][$i]['appreciation'])),1,0,'L');
			// 		$pdf->Cell(10,5,utf8_decode(ucwords($_SESSION['eleve2'][$i]['cote'])),1,0,'L');
			// 		$pdf->Cell(35,5,utf8_decode(''),1,0,'C');
			// 		$pdf->Ln(5);
			// 		$a++;
			// 	}
			// 	$pdf->Ln(2);
			// 	$pdf->Cell(100);
			// 	$texte = 'Fait à '.strtoupper($ville).', on the ________________.';
			// 	$pdf->Cell(80,5, utf8_decode($texte),0,0,'C');
			// 	$pdf->Ln(5);
			// 	$pdf->Cell(100);
			// 	$pdf->Cell(60,5,utf8_decode($signataire),0,0,'C');
				
				
				
			// 	/**** GENERATION DU BULLETIN SEQUENTIEL PAR ELEVE *****/
				
			// 	$eleve = $_SESSION['eleve'];
				
			// 	for($a=0;$a<count($eleve);$a++){
			// 		$pdf->addPage();
			// 		// On met l'entête du document
			// 		$pdf->Entete();
			// 		// On met le titre du document
			// 		$titre = "bulletin de notes de la ".$sequence;
			// 		$pdf->SetFont('Times','BUI',14);
			// 		// $pdf->SetFont('Times','BU',14);
			// 		// Informations sur l'élève 
			// 		$pdf->Text(40,75,strtoupper(utf8_decode($titre)));
			// 		$pdf->SetFont('Times','',10);
			// 		$lib_nom = 'Nom de lélève : ';
			// 		$lib_classe = 'Classe  : ';
			// 		$lib_matricule = 'Matricule : ';
			// 		$lib_effectif = 'Effectif : ';
			// 		$lib_dateNaissance = 'Date de Naissance : ';
			// 		$lib_lieuNaissance = 'à : ';
			// 		$lib_sexe = 'Sexe : ';
			// 		$lib_redoublant = 'Redoublant : ';
			// 		$lib_titulaire = 'Professeur Principal : ';
			// 		$pdf->Text(20,80,utf8_decode($lib_nom));
			// 		$pdf->Text(120,80,utf8_decode($lib_classe));
			// 		$pdf->Text(20,85,utf8_decode($lib_matricule));
			// 		$pdf->Text(120,85,utf8_decode($lib_effectif));
			// 		$pdf->Text(20,90,utf8_decode($lib_dateNaissance));
			// 		$pdf->Text(100,90,utf8_decode($lib_lieuNaissance));
			// 		$pdf->Text(20,95,utf8_decode($lib_sexe));
			// 		$pdf->Text(50,95,utf8_decode($lib_redoublant));
			// 		$pdf->Text(100,95,utf8_decode($lib_titulaire));
					
			// 		$pdf->SetFont('Times','B',10);
			// 		$nom = $eleve[$a]['nom_eleve'];
			// 		$nomClasse = strtoupper($_SESSION['nom_classe']);
			// 		$matricule = $eleve[$a]['rne'];
			// 		$effectif = count($eleve);
			// 		$dateNaissance = $eleve[$a]['date_fr'];
			// 		$lieuNaissance = $eleve[$a]['lieu_naissance'];
			// 		$sexe = $eleve[$a]['sexe'];
			// 		$redoublant = $eleve[$a]['statut'];
			// 		$titulaire = ''; /*$_SESSION['professeurPrincipal'];*/
			// 		$image =$eleve[$a]['photo'];
					
			// 		$pdf->Text(50,80,utf8_decode($nom));
			// 		$pdf->Text(140,80,utf8_decode($nomClasse));
			// 		$pdf->Text(40,85,utf8_decode($matricule));
			// 		$pdf->Text(150,85,utf8_decode($effectif));
			// 		$pdf->Text(55,90,utf8_decode($dateNaissance));
			// 		$pdf->Text(105,90,utf8_decode($lieuNaissance));
			// 		$pdf->Text(30,95,utf8_decode($sexe));
			// 		$pdf->Text(70,95,utf8_decode($redoublant));
			// 		$pdf->Text(135,95,utf8_decode($titulaire));
					 
			// 		// $pdf->Image($image, 30, 40, 10);
			// 		// $pdf->Image($image, 170, 45, 22, 22);
			// 		// Titre du Tableau du bulletin
					
			// 		// On créé un espace supplémentaire entre le tableau et les info du haut
			// 		$pdf->Ln(35);
			// 		$pdf->SetFont('Times','B',8);
			// 		$pdf->Cell(8);
			// 		$pdf->Cell(40,6, utf8_decode('Matière'),1,0,'C',true);
			// 		$pdf->Cell(35,6, utf8_decode('Competence'),1,0,'C',true);
			// 		$pdf->Cell(12,6, utf8_decode('Note /20'),1,0,'C',true);
			// 		$pdf->Cell(10,6, utf8_decode('Coef'),1,0,'C',true);
			// 		$pdf->Cell(15,6, utf8_decode('Produit'),1,0,'C',true);
			// 		$pdf->Cell(10,6, utf8_decode('Min'),1,0,'C',true);
			// 		$pdf->Cell(10,6, utf8_decode('Max'),1,0,'C',true);
			// 		$pdf->Cell(22,6, utf8_decode('Grade'),1,0,'C',true);
			// 		$pdf->Cell(10,6, utf8_decode('Cote'),1,0,'C',true);
			// 		$pdf->Cell(20,6, utf8_decode('Teacher Obs.'),1,0,'C',true);
			// 		$pdf->SetFont('Times','',8);
			// 		$pdf->Ln(6);
					
			// 		// On ressort une boucle qui liste les groupes définis
			// 		for($b=0;$b<count($_SESSION['groupe']);$b++){
			// 			$codeGroupe = $_SESSION['groupe'][$b]['code_groupe'];
			// 			$idGroupe = $_SESSION['groupe'][$b]['groupe'];
			// 			$nomGroupe = $_SESSION['groupe'][$b]['nom_groupe'];
			// 			$matieresGroupe = $_SESSION['matiereGroupe'][$idGroupe];
			// 			for($c=0;$c<count($matieresGroupe);$c++){
			// 				$codeMatiere = $matieresGroupe[$c]['code_matiere'];
			// 				$competence = strtolower($codeMatiere.'_competence');
			// 				$sekence = strtolower($codeMatiere.'_seq');
			// 				$coef = strtolower($codeMatiere.'_coef');
			// 				$produit = strtolower($codeMatiere.'_total');
			// 				$min = strtolower($codeMatiere.'_min');
			// 				$max = strtolower($codeMatiere.'_max');
			// 				$appr = strtolower($codeMatiere.'_appreciation');
			// 				$cote = strtolower($codeMatiere.'_cote');
			// 				$enseignant = strtolower($codeMatiere.'_enseignant');
			// 				$nomMatiere = strtoupper($matieresGroupe[$c]['nom_matiere']);
			// 				// $pdf->Cell(12,6, utf8_decode($eleve[$a][$seq1]),1,0,'C');
			// 				// $pdf->SetFont('Times','B',8);
			// 				$pdf->Cell(8);
			// 				$pdf->Cell(40,3, $nomMatiere,1,0,'L');
							
			// 				$pdf->Cell(35,6, utf8_decode(substr($eleve[$a][$competence],0,20)),1,0,'L');
			// 				$pdf->Cell(12,6, utf8_decode($eleve[$a][$sekence]),1,0,'C');
			// 				$pdf->Cell(10,6, utf8_decode($eleve[$a][$coef]),1,0,'C');
			// 				$pdf->Cell(15,6, utf8_decode($eleve[$a][$produit]),1,0,'C');
			// 				$pdf->Cell(10,6, utf8_decode($eleve[$a][$min]),1,0,'C');
			// 				$pdf->Cell(10,6, utf8_decode($eleve[$a][$max]),1,0,'C');
			// 				$pdf->Cell(22,6, utf8_decode($eleve[$a][$appr]),1,0,'C');
			// 				$pdf->Cell(10,6, utf8_decode($eleve[$a][$cote]),1,0,'C');
			// 				$pdf->Cell(20,6, utf8_decode(''),1,0,'C');
			// 				$pdf->SetFont('Times','',8);
			// 				// $pdf->Ln(6);
			// 				$pdf->Ln(3);
			// 				$pdf->SetFont('Times','I',7);
			// 				$pdf->Cell(8);
			// 				$pdf->Cell(40,3, utf8_decode($eleve[$a][$enseignant]),0,0,'L');
			// 				$pdf->Ln(3);
			// 				$pdf->SetFont('Times','',8);
			// 			}
			// 			$pdf->Cell(8);
			// 			$pdf->SetFont('Times','B',8);
			// 			$moyenneGroupe = $codeGroupe.'_moyenne';
			// 			$coefGroupe = $codeGroupe.'_coef';
			// 			$totalGroupe = $codeGroupe.'_total';
			// 			$minGroupe = $codeGroupe.'_min';
			// 			$maxGroupe = $codeGroupe.'_max';
			// 			$apprGroupe = $codeGroupe.'_appreciation';
			// 			$coteGroupe = $codeGroupe.'_cote';
			// 			$pdf->Cell(75,6, utf8_decode(strtoupper('Total of '.$nomGroupe)),1,0,'L',true);
			// 			$pdf->Cell(12,6, utf8_decode(utf8_decode($eleve[$a][$moyenneGroupe])),1,0,'C',true);
			// 			$pdf->Cell(10,6, utf8_decode($eleve[$a][$coefGroupe]),1,0,'C',true);
			// 			$pdf->Cell(15,6, utf8_decode($eleve[$a][$totalGroupe]),1,0,'C',true);
			// 			$pdf->Cell(10,6, $eleve[$a][$minGroupe],1,0,'C',true);
			// 			$pdf->Cell(10,6, $eleve[$a][$maxGroupe],1,0,'C',true);
			// 			$pdf->Cell(22,6, $eleve[$a][$apprGroupe],1,0,'C',true);
			// 			$pdf->Cell(10,6, $eleve[$a][$coteGroupe],1,0,'C',true);
			// 			$pdf->Cell(20,6, '',1,0,'C',true);
			// 			$pdf->Ln(6);
			// 			$pdf->SetFont('Times','',7);
			// 		}
			// 		$pdf->SetFont('Times','B',9);
			// 		$pdf->Ln(2);
			// 		$pdf->Cell(8);
			// 		$pdf->Cell(87,6, utf8_decode('TOTAL'),1,0,'C',true);
			// 		// $pdf->Cell(12,6, utf8_decode($eleve[$a]['moyenne']),1,0,'C',true);
			// 		$pdf->Cell(10,6, utf8_decode($eleve[$a]['total_coef']),1,0,'C',true);
			// 		$pdf->Cell(15,6, utf8_decode($eleve[$a]['total_point']),1,0,'C',true);
			// 		$pdf->Cell(35,6, utf8_decode('Student Average'),1,0,'C',true);
					
			// 		$pdf->Cell(25,6, utf8_decode(ucwords($eleve[$a]['moyenne'])),1,0,'L',true);
			// 		// $pdf->Cell(10,6, utf8_decode(ucwords($eleve[$a]['cote'])),1,0,'L',true);
			// 		// $pdf->Cell(20,6, '',1,0,'L',true);
			// 		$pdf->Ln(10);
			// 		$pdf->Cell(8);
					
			// 		$pdf->Cell(53,6,utf8_decode('Discipline'), 1,0,'C',true);
			// 		$pdf->Cell(5, 6, utf8_decode(''),0,0,'C');
			// 		$pdf->Cell(53,6,utf8_decode('Travail'), 1,0,'C',true);
			// 		$pdf->Cell(5, 6, utf8_decode(''),0,0,'C');
			// 		$pdf->Cell(53,6,utf8_decode('Class Profile'), 1,0,'C',true);
			// 		$pdf->Ln(6);
			// 		$pdf->Cell(8);
					
			// 		$pdf->Cell(20,6,utf8_decode('Abs Non Just.'), 1,0,'C');
			// 		$pdf->Cell(6,6,utf8_decode(''), 1,0,'C');
			// 		$pdf->Cell(20,6,utf8_decode('Avert. Cond.'), 1,0,'C');
			// 		$pdf->Cell(7,6,utf8_decode(''), 1,0,'C');
			// 		$pdf->Cell(5, 6, utf8_decode(''),0,0,'C');
			// 		$pdf->Cell(17,6,utf8_decode('Total Gén.'), 1,0,'C');
			// 		$pdf->Cell(10,6,utf8_decode($eleve[$a]['total_point']), 1,0,'C');
			// 		$pdf->Cell(26,6,utf8_decode('Grade'), 1,0,'C');
			// 		$pdf->Cell(5, 6, utf8_decode(''),0,0,'C');
			// 		$pdf->Cell(30,6,utf8_decode('General Averag'), 1,0,'C');
			// 		$pdf->Cell(23,6,$_SESSION['statistique']['moyGenTotal'], 1,0,'C');
			// 		$pdf->Ln(6);
			// 		$pdf->Cell(8);
					
			// 		$pdf->Cell(20,6,utf8_decode('Abs Just.'), 1,0,'C');
			// 		$pdf->Cell(6,6,utf8_decode(''), 1,0,'C');
			// 		$pdf->Cell(20,6,utf8_decode('Blâme. Cond.'), 1,0,'C');
			// 		$pdf->Cell(7,6,utf8_decode(''), 1,0,'C');
			// 		$pdf->Cell(5, 6, utf8_decode(''),0,0,'C');
			// 		$pdf->Cell(17,6,utf8_decode('Coef'), 1,0,'C');
			// 		$pdf->Cell(10,6,utf8_decode($eleve[$a]['total_coef']), 1,0,'C');
			// 		$pdf->Cell(26,6,utf8_decode($eleve[$a]['appreciation']), 1,0,'C');
			// 		$pdf->Cell(5, 6, utf8_decode(''),0,0,'C');
			// 		$minMax = "[ ".$_SESSION['statistique']['noteFaibleTotal'];
			// 		$minMax .= " - ".$_SESSION['statistique']['noteForteTotal'];
			// 		$minMax .= " ]";
			// 		$pdf->Cell(30,6,utf8_decode('[Min - Max]'), 1,0,'C');
			// 		$pdf->Cell(23,6,$minMax, 1,0,'C');
			// 		$pdf->Ln(6);
			// 		$pdf->Cell(8);
					
			// 		$pdf->Cell(20,6,utf8_decode('Retards'), 1,0,'C');
			// 		$pdf->Cell(6,6,utf8_decode(''), 1,0,'C');
			// 		$pdf->Cell(20,6,utf8_decode('Exclusions'), 1,0,'C');
			// 		$pdf->Cell(7,6,utf8_decode(''), 1,0,'C');
			// 		$pdf->Cell(5, 6, utf8_decode(''),0,0,'C');
			// 		$pdf->Cell(27,6,utf8_decode('Average'), 1,0,'C');
			// 		if($eleve[$a]['moyenne']=='0.00'){
			// 			$pdf->Cell(26,6,'--', 1,0,'C');
			// 		}else{
			// 			$pdf->Cell(26,6,utf8_decode($eleve[$a]['moyenne']), 1,0,'C');
			// 		}
			// 		// $pdf->Cell(26,6,'', 1,0,'C');
			// 		$pdf->Cell(5, 6, utf8_decode(''),0,0,'C');
			// 		$pdf->Cell(30,6,utf8_decode('Nb of Aver.'), 1,0,'C');
			// 		$pdf->Cell(23,6,$_SESSION['statistique']['moyTotal'], 1,0,'C');
			// 		$pdf->Ln(6);
			// 		$pdf->Cell(8);
					
			// 		$pdf->Cell(20,6,utf8_decode('Consignes'), 1,0,'C');
			// 		$pdf->Cell(6,6,utf8_decode(''), 1,0,'C');
			// 		$pdf->Cell(20,6,utf8_decode('Excl. Déf.'), 1,0,'C');
			// 		$pdf->Cell(7,6,utf8_decode(''), 1,0,'C');
			// 		$pdf->Cell(5, 6, utf8_decode(''),0,0,'C');
			// 		$pdf->Cell(27,6,utf8_decode('Cote'), 1,0,'C');
			// 		if($eleve[$a]['moyenne']=='0.00'){
			// 			$pdf->Cell(26,6,'--', 1,0,'C');
			// 		}else{
			// 			$pdf->Cell(26,6,utf8_decode($eleve[$a]['cote']), 1,0,'C');
			// 		}
			// 		// $pdf->Cell(26,6,'', 1,0,'C');
			// 		$pdf->Cell(5, 6, utf8_decode(''),0,0,'C');
			// 		$pdf->Cell(30,6,utf8_decode('Percentage'), 1,0,'C');
			// 		$pdf->Cell(23,6,$_SESSION['statistique']['tauxTotal'], 1,0,'C');
			// 		$pdf->Ln(6);
			// 		$pdf->Cell(8);
					
			// 		$pdf->Cell(20,6,utf8_decode(''), 0,0,'C');
			// 		$pdf->Cell(6,6,utf8_decode(''), 0,0,'C');
			// 		$pdf->Cell(20,6,utf8_decode(''), 0,0,'C');
			// 		$pdf->Cell(7,6,utf8_decode(''), 0,0,'C');
			// 		$pdf->Cell(5, 6, utf8_decode(''),0,0,'C');
			// 		$pdf->Cell(17,6,utf8_decode(''), 0,0,'C');
			// 		$pdf->Cell(10,6,utf8_decode(''), 0,0,'C');
			// 		$pdf->Cell(26,6,'', 0,0,'C');
			// 		$pdf->Cell(5, 6, utf8_decode(''),0,0,'C');
			// 		$pdf->Cell(30,6,utf8_decode(''), 0,0,'C');
			// 		$pdf->Cell(23,6,'', 0,0,'C');
			// 		$pdf->Ln(6);
			// 		$pdf->Cell(8);
					
			// 		$pdf->Cell(46,6,utf8_decode('The Parent'), 0,0,'C');
					

			// 		$pdf->Cell(12,6,utf8_decode(''), 0,0,'C');
			// 		$texte = 'Done at '.strtoupper($ville).' on the ________________';
			// 		$pdf->Cell(39,6,utf8_decode('The Class Principal'), 0,0,'C');
					
			// 		$pdf->Cell(26,6,'', 0,0,'C');
			// 		$pdf->Cell(5, 6, utf8_decode(''),0,0,'C');
			// 		$pdf->Cell(58,6,utf8_decode($texte), 0,0,'C');
					
			// 		$pdf->Ln(6);
			// 		$pdf->Cell(8);
					
										
			// 		$pdf->SetFont('Times','I',9);
			// 		$pdf->Cell(28,6,utf8_decode(''), 0,0,'C');
			// 		$pdf->Cell(25,6,utf8_decode(''), 0,0,'C');
			// 		$pdf->Cell(5, 6, utf8_decode(''),0,0,'C');
			// 		$pdf->Cell(28,6,utf8_decode(''), 0,0,'C');
			// 		$pdf->Cell(25,6,utf8_decode(''), 0,0,'C');
			// 		$pdf->Cell(25,6,utf8_decode(''), 0,0,'C');
			// 		$pdf->Cell(25,6,utf8_decode($signataire), 0,0,'C');
			// 		$pdf->Ln(6);
			// 		$pdf->Cell(8);
			// 		$pdf->Cell(28,6,utf8_decode(''), 0,0,'C');
			// 		$pdf->Cell(25,6,utf8_decode(''), 0,0,'C');
			// 		$pdf->Cell(5, 6, utf8_decode(''),0,0,'C');
			// 		$pdf->Cell(28,6,utf8_decode(''), 0,0,'C');
			// 		$pdf->Cell(25,6,utf8_decode(''), 0,0,'C');
					
			// 		$pdf->SetFont('Times','B',9);
										
			// 	}
				
				
			// 	// Le nom du fichier sera Bull_Trimestre_NumeroTrimestre_Classe
			// 	$nomFichier = 'Bulletin_Sequence_'.$_SESSION['sequence'].'_'.$_SESSION['nom_classe'].'.pdf';
			// 	$pdf->Output($nomFichier, 'I');
			// }
			
		}







		/**********************************************************************
		***********************************************************************
		**********	Génération du Bulletin trimestriel					*******
		***********************************************************************
		**********************************************************************/
		elseif($_SESSION['print']=='BulletinTrimestriel'){
			$eleve = $_SESSION['eleve'];
			$ville = strtoupper($_SESSION['information']['ville']);
			$pdf->pvTrimestrielAlpha($_SESSION['section']);
			$pdf->pvTrimestrielMerite($_SESSION['section']);
			$_SESSION['effectif'] = count($eleve);
			for($i=0;$i<count($eleve);$i++){
				$pdf->bulletinTrimestriel($eleve[$i], $_SESSION['section']);
			}
			$nomFichier = "Bulletin_Trimestre_".$_SESSION['trimestre']."_".$_SESSION['nom_classe'].".pdf";
			$pdf->Output($nomFichier, 'I');
		}
		
	}
	
	
	else{
		$pdf->addPage();
		$titre = 'No data Sent';
		// $pdf->Titre($titre);
		$pdf->SetFont('Times','B',35);
		$pdf->Text(70,100,'No Data Sent');
		$nomFichier = 'NoData.pdf';
		$pdf->setAuthor('Nyambi Computer Services');
		$pdf->Output($nomFichier, 'I');
	}
	
	
	
	
	
	unset($_SESSION['print']);
	unset($_SESSION['classe']);
	unset($_SESSION['releve']);
	unset($_SESSION['eleve']);
	