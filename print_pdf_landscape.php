<?php 
	session_start();
	require_once('inc/pdfL.class.php');
	
	$pdf = new pdf('L', 'mm', 'A4');
	$pdf->SetFillColor(155, 150, 149);
	
	
	
	
	
	
	if(isset($_SESSION['print'])){
		if($_SESSION['print']=='releveEleve'){
			$classe = $_SESSION['releve'];
			// La page doit s'afficher en fonction de la section 
			if($classe['section']=='en'){
				$pdf->addPage();
				$titre = 'Reported Marks of ';
				$titre.= $classe['sousMatiere'][0]['libelle_classe'];
				$pdf->Titre($titre);
				$subject = 'Subject : '.$classe['sousMatiere'][0]['libelle_competence_en'];
				$pdf->SousTitre($subject);
				$pdf->Cell(10, 6, $pdf->convert('Term : ____________________'), 0, 0 , 'L');
				$pdf->Ln(7);
				$pdf->SetFont('Times','BI',8);
				$pdf->Cell(10, 12, $pdf->convert('N°'), 1, 0 , 'C',true);
				$pdf->Cell(65, 12, $pdf->convert('Full Name'), 1, 0 , 'C',true);
				$pdf->Cell(69, 6, $pdf->convert('Month 1'), 1, 0 , 'C',true);
				$pdf->Cell(69, 6, $pdf->convert('Month 2'), 1, 0 , 'C',true);
				$pdf->Cell(69, 6, $pdf->convert('Month 3'), 1, 0 , 'C',true);
				$pdf->Ln(6);
				$pdf->Cell(10,12,'',0,0,'C');
				$pdf->Cell(65,12,'',0,0,'C');
				for($i=0;$i<3;$i++){
					$nbMat = count($classe['sousMatiere'])+1;
					$cell = 69 / $nbMat;
					$pdf->SetFont('Times','BI',6);
					for($j=0;$j<count($classe['sousMatiere']);$j++){
						$matiere = $classe['sousMatiere'][$j]['libelle_sous_competence_en'];
						$total[$j] = $classe['sousMatiere'][$j]['nb_point'];
						$point = $classe['sousMatiere'][$j]['nb_point'];
						$pdf->Cell($cell,6,$pdf->convert(ucwords($matiere).' / '.$point),1,0,'C',true);
					}
					$pdf->SetFont('Times','BI',8);
					$totalMatiere = array_sum($total);
					$pdf->Cell($cell,6, $pdf->convert('Total / '.$totalMatiere),1,0,'C',true);
				}
				$pdf->Ln(6);
				$a = 1;
				$pdf->SetFont('Times','',8);
				for($k=0;$k<count($classe['eleve']);$k++){
					$nomEleve = strtoupper($classe['eleve'][$k]['nom_complet']);
					$pdf->Cell(10, 6, $pdf->convert($a), 1, 0 , 'C');
					$pdf->Cell(65, 6, $pdf->convert($nomEleve), 1, 0 , 'L');
					for($l=0;$l<3;$l++){
						$nbMat = count($classe['sousMatiere'])+1;
						$cell = 69 / $nbMat;
						for($m=0;$m<count($classe['sousMatiere']);$m++){
							$pdf->Cell($cell,6,'',1,0,'C');
						}
						$pdf->Cell($cell,6,$pdf->convert(''),1,0,'C',true);
					}
					
					$pdf->Ln(6);
					$a++;
				}
								
				$fileName=strtoupper('reported_marks_');
				$fileName.= strtoupper(str_replace(' ','_',$classe['sousMatiere'][0]['libelle_classe']));
				$fileName.= '_'.strtoupper(str_replace(' ','_',$classe['sousMatiere'][0]['libelle_competence_en']));
				$fileName.= '.pdf';
			}
			elseif($classe['section']=='fr'){
				$pdf->addPage();
				$titre = 'Releve de Notes de ';
				$titre.= $classe['sousMatiere'][0]['libelle_classe'];
				$pdf->Titre($titre);
				$subject = 'Matiere : '.$classe['sousMatiere'][0]['libelle_competence_fr'];
				$pdf->SousTitre($subject);
				$pdf->Cell(10, 6, $pdf->convert('Trimestre : ____________________'), 0, 0 , 'L');
				$pdf->Ln(7);
				$pdf->SetFont('Times','BI',8);
				$pdf->Cell(10, 12, $pdf->convert('N°'), 1, 0 , 'C',true);
				$pdf->Cell(65, 12, $pdf->convert('Nom Complet'), 1, 0 , 'C',true);
				$pdf->Cell(69, 6, $pdf->convert('Mois 1'), 1, 0 , 'C',true);
				$pdf->Cell(69, 6, $pdf->convert('Mois 2'), 1, 0 , 'C',true);
				$pdf->Cell(69, 6, $pdf->convert('Mois 3'), 1, 0 , 'C',true);
				$pdf->Ln(6);
				$pdf->Cell(10,12,'',0,0,'C');
				$pdf->Cell(65,12,'',0,0,'C');
				for($i=0;$i<3;$i++){
					$nbMat = count($classe['sousMatiere'])+1;
					$cell = 69 / $nbMat;
					$pdf->SetFont('Times','BI',6);
					for($j=0;$j<count($classe['sousMatiere']);$j++){
						$matiere = $classe['sousMatiere'][$j]['libelle_sous_competence_fr'];
						$total[$j] = $classe['sousMatiere'][$j]['nb_point'];
						$point = $classe['sousMatiere'][$j]['nb_point'];
						$pdf->Cell($cell,6,$pdf->convert(ucwords($matiere).' / '.$point),1,0,'C',true);
					}
					$pdf->SetFont('Times','BI',8);
					$totalMatiere = array_sum($total);
					$pdf->Cell($cell,6, $pdf->convert('Total / '.$totalMatiere),1,0,'C',true);
				}
				$pdf->Ln(6);
				$a = 1;
				$pdf->SetFont('Times','',8);
				for($k=0;$k<count($classe['eleve']);$k++){
					$nomEleve = strtoupper($classe['eleve'][$k]['nom_complet']);
					$pdf->Cell(10, 6, $pdf->convert($a), 1, 0 , 'C');
					$pdf->Cell(65, 6, $pdf->convert($nomEleve), 1, 0 , 'L');
					for($l=0;$l<3;$l++){
						$nbMat = count($classe['sousMatiere'])+1;
						$cell = 69 / $nbMat;
						for($m=0;$m<count($classe['sousMatiere']);$m++){
							$pdf->Cell($cell,6,'',1,0,'C');
						}
						$pdf->Cell($cell,6,$pdf->convert(''),1,0,'C',true);
					}
					
					$pdf->Ln(6);
					$a++;
				}
								
				$fileName=strtoupper('releve_Notes_');
				$fileName.= strtoupper(str_replace(' ','_',$classe['sousMatiere'][0]['libelle_classe']));
				$fileName.= '_'.strtoupper(str_replace(' ','_',$classe['sousMatiere'][0]['libelle_competence_fr']));
				$fileName.= '.pdf';
			} 
			
			$pdf->setAuthor('Nyambi Computer Services');
			$pdf->Output($fileName, 'I');
			
			
			
			
		}




		if($_SESSION['print']=='VisualiserNoteSequentielle'){
			$classe = $_SESSION['classe'];
			$eleve = $_SESSION['eleve'];
			$matiere = $_SESSION['matiere'];
			if($classe['section']=='fr'){
				$pdf->addPage();
				$pdf->Entete();
				$titre = 'visualisation des notes sequentielles';
				$pdf->Titre($titre);
				$pdf->Ln(10);
				$pdf->Cell(25);
				$libClasse = 'Classe : '.$classe['nom_classe'];
				$libSequence = 'Sequence : Sequence '.$eleve['sequence'];
				$pdf->Cell(120,6,$libClasse,0,0,'L');
				$pdf->Cell(120,6,$libSequence,0,0,'L');
				$pdf->Ln(10);
				$pdf->setFont('Times', '',11);
				$pdf->Cell(10,5,utf8_decode('N°'),1,0,'C', true);
				$pdf->Cell(60,5,utf8_decode('Noms et Prénoms'),1,0,'C', true);
				$pdf->Cell(10,5,utf8_decode('Sexe'),1,0,'C', true);
				$pdf->Cell(10,5,utf8_decode('Statut'),1,0,'C', true);
				// On liste les matières ici 
				for($i=0;$i<count($matiere); $i++){
					$codeMatiere = strtolower($matiere[$i]['code_matiere']);
					$pdf->Cell(10,5,$codeMatiere,1,0,'C', true);
				}
				$pdf->Ln(5);
				$x = 1;
				for($a=0;$a<count($eleve['eleve']);$a++){
					$infoEleve = $eleve['eleve'];
					$nomComplet = substr($infoEleve[$a]['nom'], 0, 23);
					$sexe = $eleve['eleve'][$a]['sexe'];
					$statut = $eleve['eleve'][$a]['statut'];
					$pdf->Cell(10,5,utf8_decode($x),1,0,'C');
					$pdf->Cell(60,5,utf8_decode($nomComplet),1,0,'L');
					$pdf->Cell(10,5,utf8_decode($sexe),1,0,'C');
					$pdf->Cell(10,5,utf8_decode($statut),1,0,'C');
					$pdf->setFont('Times', '',10);
					// On va lister d'abord les array de matières et ensuite récupérer leurs notes 
					for($b=0;$b<count($matiere);$b++){
						$codeMat = strtolower($matiere[$b]['code_matiere']);
						$noteEleve = $infoEleve[$a][$codeMat];
						$pdf->Cell(10,5,$noteEleve,1,0,'C');
					}
					$pdf->Ln(5);
					$x++;
				}
				$pdf->Ln(10);
				$pdf->setFont('Times', '',11);
				$phrase = utf8_decode('Fait à '.strtoupper($_SESSION['information']['ville']).' le ______________');
				$phrase2 = utf8_decode("L'Administration");
				$pdf->Cell(200);
				$pdf->Cell(60, 5, $phrase, 0,0,'C');
				$pdf->Ln(5);
				$pdf->Cell(200);
				$pdf->Cell(60, 5, $phrase2, 0,0,'C');
				$fileName=strtoupper('etat_de_saisie_sequence_'.$eleve['sequence'].'_');
				$fileName .= strtoupper(str_replace(' ','_',$classe['nom_classe']));
				$fileName.= '.pdf';
			}
			elseif($classe['section']=='en'){
				$pdf->addPage();
				$pdf->Entete();
				$titre = 'sequential marks of the class';
				$pdf->Titre($titre);
				$pdf->Ln(10);
				$pdf->Cell(25);
				$libClasse = 'Class : '.$classe['nom_classe'];
				$libSequence = 'Sequence : Sequence '.$eleve['sequence'];
				$pdf->Cell(120,6,$libClasse,0,0,'L');
				$pdf->Cell(120,6,$libSequence,0,0,'L');
				$pdf->Ln(10);
				$pdf->setFont('Times', '',11);
				$pdf->Cell(10,5,utf8_decode('N°'),1,0,'C', true);
				$pdf->Cell(60,5,utf8_decode('Student Name'),1,0,'C', true);
				$pdf->Cell(10,5,utf8_decode('Sex'),1,0,'C', true);
				$pdf->Cell(10,5,utf8_decode('Status'),1,0,'C', true);
				// On liste les matières ici 
				for($i=0;$i<count($matiere); $i++){
					$codeMatiere = strtolower($matiere[$i]['code_matiere']);
					$pdf->Cell(10,5,$codeMatiere,1,0,'C', true);
				}
				$pdf->Ln(5);
				$x = 1;
				for($a=0;$a<count($eleve['eleve']);$a++){
					$infoEleve = $eleve['eleve'];
					$nomComplet = substr($infoEleve[$a]['nom'], 0, 23);
					$sexe = $eleve['eleve'][$a]['sexe'];
					$statut = $eleve['eleve'][$a]['statut'];
					$pdf->Cell(10,5,utf8_decode($x),1,0,'C');
					$pdf->Cell(60,5,utf8_decode($nomComplet),1,0,'L');
					$pdf->Cell(10,5,utf8_decode($sexe),1,0,'C');
					$pdf->Cell(10,5,utf8_decode($statut),1,0,'C');
					$pdf->setFont('Times', '',10);
					// On va lister d'abord les array de matières et ensuite récupérer leurs notes 
					for($b=0;$b<count($matiere);$b++){
						$codeMat = strtolower($matiere[$b]['code_matiere']);
						$noteEleve = $infoEleve[$a][$codeMat];
						$pdf->Cell(10,5,$noteEleve,1,0,'C');
					}
					$pdf->Ln(5);
					$x++;
				}
				$pdf->Ln(10);
				$pdf->setFont('Times', '',11);
				$phrase = utf8_decode('Done at '.strtoupper($_SESSION['information']['ville']).' on the ______________');
				$phrase2 = utf8_decode("The Administration");
				$pdf->Cell(200);
				$pdf->Cell(60, 5, $phrase, 0,0,'C');
				$pdf->Ln(5);
				$pdf->Cell(200);
				$pdf->Cell(60, 5, $phrase2, 0,0,'C');
				$fileName=strtoupper('etat_de_saisie_sequence_'.$eleve['sequence'].'_');
				$fileName .= strtoupper(str_replace(' ','_',$classe['nom_classe']));
				$fileName.= '.pdf';
			}
			$pdf->Output($fileName, 'I');
		}









		elseif($_SESSION['print']=='RapportTrimestriel'){
			$pdf->addPage();
			$pdf->Entete();
			$classe = $_SESSION['classe'];
			$pdf->rapportTrimestre($classe, $classe['classe']['section']);
			$pdf->brefTrimestre($classe, $classe['classe']['section']);
			$fileName='Recapitulatif_';
			$fileName.= str_replace(' ','_',$classe['classe']['nom_classe']);
			$fileName .= '_trimestre_'.$classe['periode'].'.pdf';
			$pdf->Output($fileName, 'I');	
		}








		elseif($_SESSION['print']=='RecapMatiere'){
			$pdf->addPage();
			$pdf->Entete();
			$title = "Statistiques des Notes de : ";
			$title .= strtoupper($_SESSION['matiere']['nom_matiere']);
			$pdf->Titre($title);
			$pdf->Ln(5);
			$periode = 'Période Concernée : Trimestre '.$_SESSION['matiere']['trimestre'];
			$pdf->Cell(145,10,utf8_decode($periode), 0,0,'L');
			$pdf->Ln(15);

			$pdf->SetFont('Times','B',9);
			// Je positionne l'entete du tableau
			$pdf->Cell(10, 14, utf8_decode('N°'), 1, 0 , 'C', true);
			$pdf->Cell(50, 14, 'Classe', 1, 0 , 'C', true);
			$pdf->Cell(10, 14, 'Coef', 1, 0 , 'C', true);
			$pdf->Cell(24, 7, 'Effectif', 1, 0 , 'C',true);
			$pdf->Cell(24, 7, utf8_decode('Evalué'), 1, 0 , 'C',true);
			$pdf->Cell(24, 7, 'Nb Moyennes', 1, 0 , 'C',true);
			$pdf->Cell(27, 7, utf8_decode('% Réussite'), 1, 0 , 'C',true);
			$pdf->Cell(27, 7, 'Forte Note', 1, 0 , 'C',true);
			$pdf->Cell(27, 7, 'Faible Note', 1, 0 , 'C',true);
			$pdf->Cell(30, 7, utf8_decode('Moyenne Générale'), 1, 0 , 'C',true);

			$pdf->Ln(7);
			$pdf->Cell(10, 7, '', 0, 0 , 'C');
			$pdf->Cell(50, 7, '', 0, 0 , 'C');
			$pdf->Cell(10, 7, '', 0, 0 , 'C');
			// Effectif de la classe
			$pdf->Cell(8, 7, 'M', 1, 0 , 'C');
			$pdf->Cell(8, 7, 'F', 1, 0 , 'C');
			$pdf->Cell(8, 7, 'T', 1, 0 , 'C',true);
			// Effectif évalué
			$pdf->Cell(8, 7, 'M', 1, 0 , 'C');
			$pdf->Cell(8, 7, 'F', 1, 0 , 'C');
			$pdf->Cell(8, 7, 'T', 1, 0 , 'C',true);
			// Nombre de Moyennes
			$pdf->Cell(8, 7, 'M', 1, 0 , 'C');
			$pdf->Cell(8, 7, 'F', 1, 0 , 'C');
			$pdf->Cell(8, 7, 'T', 1, 0 , 'C',true);
			// Taux de Réussite
			$pdf->Cell(9, 7, 'M', 1, 0 , 'C');
			$pdf->Cell(9, 7, 'F', 1, 0 , 'C');
			$pdf->Cell(9, 7, 'T', 1, 0 , 'C',true);
			// Forte Note
			$pdf->Cell(9, 7, 'M', 1, 0 , 'C');
			$pdf->Cell(9, 7, 'F', 1, 0 , 'C');
			$pdf->Cell(9, 7, 'T', 1, 0 , 'C',true);
			// Faible Note
			$pdf->Cell(9, 7, 'M', 1, 0 , 'C');
			$pdf->Cell(9, 7, 'F', 1, 0 , 'C');
			$pdf->Cell(9, 7, 'T', 1, 0 , 'C',true);
			// Moyenne Générale
			$pdf->Cell(10, 7, 'M', 1, 0 , 'C');
			$pdf->Cell(10, 7, 'F', 1, 0 , 'C');
			$pdf->Cell(10, 7, 'T', 1, 0 , 'C',true);

			$pdf->Ln(7);


			$a = 1;
			// On boucle les classes concernées par la Matière ici 
			for($i=0;$i<count($_SESSION['classe']);$i++){
				$nomClasse = $_SESSION['classe'][$i]['nom_classe'];
				$codeClasse = $_SESSION['classe'][$i]['code_classe'];
				$coefClasse = $_SESSION['classe'][$i]['coef'];
				$class = $_SESSION['stat'][$codeClasse];
				$pdf->Cell(10, 7, $a, 1, 0 , 'C', true);
				$pdf->Cell(50, 7, $nomClasse, 1, 0 , 'L', true);
				$pdf->Cell(10, 7, $coefClasse,1,0,'C');
				$pdf->Cell(8, 7, $class['effM'],1,0,'C');
				$pdf->Cell(8,7,$class['effF'],1,0,'C');
				$pdf->Cell(8,7,$class['effT'],1,0,'C',true);
				$pdf->Cell(8,7,$class['evalM'],1,0,'C');
				$pdf->Cell(8,7,$class['evalF'],1,0,'C');
				$pdf->Cell(8,7,$class['evalT'],1,0,'C',true);
				$pdf->Cell(8,7,$class['moyM'],1,0,'C');
				$pdf->Cell(8,7,$class['moyF'],1,0,'C');
				$pdf->Cell(8,7,$class['moyT'],1,0,'C',true);
				$pdf->Cell(9,7,$class['tauxM'],1,0,'C');
				$pdf->Cell(9,7,$class['tauxF'],1,0,'C');
				$pdf->Cell(9,7,$class['tauxT'],1,0,'C',true);
				$pdf->Cell(9,7,$class['maxM'],1,0,'C');
				$pdf->Cell(9,7,$class['maxF'],1,0,'C');
				$pdf->Cell(9,7,$class['maxT'],1,0,'C',true);
				$pdf->Cell(9,7,$class['minM'],1,0,'C');
				$pdf->Cell(9,7,$class['minF'],1,0,'C');
				$pdf->Cell(9,7,$class['minT'],1,0,'C',true);
				$pdf->Cell(10,7,$class['mgM'],1,0,'C');
				$pdf->Cell(10,7,$class['mgF'],1,0,'C');
				$pdf->Cell(10,7,$class['mgT'],1,0,'C',true);
				$pdf->Ln(7);
				$a++;
				$effM[] = $class['effM'];
				$effF[] = $class['effF'];
				$effT[] = $class['effT'];
				$evalM[] = $class['evalM'];
				$evalF[] = $class['evalF'];
				$evalT[] = $class['evalT'];
				$moyM[] = $class['moyM'];
				$moyF[] = $class['moyF'];
				$moyT[] = $class['moyT'];
			}
			$pdf->Cell(70, 7, 'TOTAL', 1, 0, 'C', true);
			$pdf->Cell(8,7,array_sum($effM),1,0,'C');
			$pdf->Cell(8,7,array_sum($effF),1,0,'C');
			$pdf->Cell(8,7,array_sum($effT),1,0,'C',true);
			$pdf->Cell(8,7,array_sum($evalM),1,0,'C');
			$pdf->Cell(8,7,array_sum($evalF),1,0,'C');
			$pdf->Cell(8,7,array_sum($evalT),1,0,'C',true);
			$pdf->Cell(8,7,array_sum($moyM),1,0,'C');
			$pdf->Cell(8,7,array_sum($moyF),1,0,'C');
			$pdf->Cell(8,7,array_sum($moyT),1,0,'C',true);

			if(array_sum($evalM)!=0){
				$tauxMasc = array_sum($moyM) * 100 / array_sum($evalM);
			}else{$tauxMasc = NULL;}
			if(array_sum($evalF)!=0){
				$tauxFille = array_sum($moyF) * 100 / array_sum($evalF);
			}else{$tauxFille = NULL;}
			if(array_sum($evalT)!=0){
				$tauxGlob = array_sum($moyT) * 100 / array_sum($evalT);
			}else{$tauxGlob = NULL;}
			$pdf->Cell(9,7,round($tauxMasc,2),1,0,'C');
			$pdf->Cell(9,7,round($tauxFille,2),1,0,'C');
			$pdf->Cell(9,7,round($tauxGlob,2),1,0,'C',true);
			// $pdf->SetFillColor(25, 15, 15);
			/*$pdf->Cell(9,7,'',1,0,'C',true);
			$pdf->Cell(9,7,'',1,0,'C',true);
			$pdf->Cell(9,7,'',1,0,'C',true);
			$pdf->Cell(9,7,'',1,0,'C',true);
			$pdf->Cell(9,7,'',1,0,'C',true);
			$pdf->Cell(9,7,'',1,0,'C',true);
			$pdf->Cell(10,7,'',1,0,'C',true);
			$pdf->Cell(10,7,'',1,0,'C',true);
			$pdf->Cell(10,7,'',1,0,'C',true);*/
			$pdf->SetFillColor(155, 150, 149);
			$fileName='Statistiques_';
			$fileName.= str_replace(' ','_',$_SESSION['matiere']['nom_matiere']);
			$fileName .= '.pdf';
			$pdf->Output($fileName, 'I');
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
	