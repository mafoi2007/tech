<?php 
	session_start();
	require_once('inc/pdfL.class.php');
	
	$pdf = new pdf('L', 'mm', 'A4');
	$pdf->SetFillColor(200,205,180);
	
	
	
	
	
	
	if(isset($_SESSION['print'])){
		if($_SESSION['print']=='releveEleve'){
			$classe = $_SESSION['releve'];
			// $pdf->SetFillColor(155, 150, 149);
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









		if($_SESSION['print']=='TableauHonneurTrimestriel'){
			$eleve = $_SESSION['eleve'];
			$ville = strtoupper($_SESSION['information']['ville']);
			
			
			$_SESSION['effectif'] = count($eleve);
			for($i=0;$i<count($eleve);$i++){
				$pdf->tableauHonneurTrimestriel($eleve[$i], $_SESSION['section']);
			}
			$nomFichier = "tableau_Honneur_Trimestre_".$_SESSION['trimestre']."_".$_SESSION['nom_classe'].".pdf";
			$pdf->Output($nomFichier, 'I');
		}









		if($_SESSION['print']=='TableauHonneurAnnuel'){
			$eleve = $_SESSION['eleve'];
			$ville = strtoupper($_SESSION['information']['ville']);
			
			
			$_SESSION['effectif'] = count($eleve);
			for($i=0;$i<count($eleve);$i++){
				$pdf->tableauHonneurAnnuel($eleve[$i], $_SESSION['section']);
			}
			$nomFichier = "tableau_Honneur_Annuel_".$_SESSION['nom_classe'].".pdf";
			$pdf->Output($nomFichier, 'I');
		}









		if($_SESSION['print']=='StatTrimestriel'){
			// On récuère tout ce qui a été envoyé dans la variable $info
			$info = $_SESSION['classe'];
			$listeClasse = $info['classe'];
			$ville = strtoupper($_SESSION['information']['ville']);

			$pdf->addPage();
			$pdf->Entete();
			$pdf->Titre('Statistiques du Trimestre '.$info['periode']);
			$pdf->Ln(10);
			$pdf->setFont('Times', 'B',13);
			$pdf->Cell(45, 12, 'Classe', 1, 0, 'C', true);
			$pdf->Cell(30, 6, 'Effectif', 1, 0, 'C', true);
			$pdf->Cell(30, 6, utf8_decode('Evalués'), 1, 0, 'C', true);
			$pdf->Cell(30, 6, utf8_decode('Nb Moy.'), 1, 0, 'C', true);
			$pdf->Cell(40, 6, utf8_decode('Taux'), 1, 0, 'C', true);
			$pdf->Cell(40, 6, utf8_decode('Forte Moy.'), 1, 0, 'C', true);
			$pdf->Cell(30, 6, utf8_decode('Faible Moy.'), 1, 0, 'C', true);
			$pdf->Cell(40, 6, utf8_decode('Moy. Gén.'), 1, 0, 'C', true);
			$pdf->Ln(6);
			$pdf->Cell(45, 6, ' ', 0, 0, 'C');
			// Effectif 
			$pdf->Cell(10, 6, 'F', 1, 0, 'C',true);
			$pdf->Cell(10, 6, 'M', 1, 0, 'C',true);
			$pdf->Cell(10, 6, 'T', 1, 0, 'C',true);
			// Evalués 
			$pdf->Cell(10, 6, 'F', 1, 0, 'C',true);
			$pdf->Cell(10, 6, 'M', 1, 0, 'C',true);
			$pdf->Cell(10, 6, 'T', 1, 0, 'C',true);
			// Nb Moy 
			$pdf->Cell(10, 6, 'F', 1, 0, 'C',true);
			$pdf->Cell(10, 6, 'M', 1, 0, 'C',true);
			$pdf->Cell(10, 6, 'T', 1, 0, 'C',true);
			// Taux 
			$pdf->Cell(12, 6, 'F', 1, 0, 'C',true);
			$pdf->Cell(13, 6, 'M', 1, 0, 'C',true);
			$pdf->Cell(15, 6, 'T', 1, 0, 'C',true);
			// Forte Moyenne 
			$pdf->Cell(12, 6, 'F', 1, 0, 'C',true);
			$pdf->Cell(13, 6, 'M', 1, 0, 'C',true);
			$pdf->Cell(15, 6, 'T', 1, 0, 'C',true);
			// Faible Moyenne 
			$pdf->Cell(10, 6, 'F', 1, 0, 'C',true);
			$pdf->Cell(10, 6, 'M', 1, 0, 'C',true);
			$pdf->Cell(10, 6, 'T', 1, 0, 'C',true);
			// Moyenne Générale 
			$pdf->Cell(12, 6, 'F', 1, 0, 'C',true);
			$pdf->Cell(13, 6, 'M', 1, 0, 'C',true);
			$pdf->Cell(15, 6, 'T', 1, 0, 'C',true);
			$pdf->setFont('Times', '',10);
			$pdf->Ln(6);
			for($x=0;$x<count($listeClasse);$x++){
				// On met ici les statistiques de chaque classe issus de la boucle 
				$stat = $info['stat'][$x];
				$effFille[] = $info['stat'][$x]['effFille'];
				$effMasc[] = $info['stat'][$x]['effMasc'];
				$effTotal[] = $info['stat'][$x]['effTotal'];
				$evalFille[] = $info['stat'][$x]['evalFille'];
				$evalMasc[] = $info['stat'][$x]['evalMasc'];
				$evalTotal[] = $info['stat'][$x]['evalTotal'];
				$moyFille[] = $info['stat'][$x]['moyFille'];
				$moyMasc[] = $info['stat'][$x]['moyMasc'];
				$moyTotal[] = $info['stat'][$x]['moyTotal'];
				/*$tauxFille[] = $info['stat'][$x]['tauxFille'];
				$tauxMasc[] = $info['stat'][$x]['tauxMasc'];
				$tauxTotal[] = $info['stat'][$x]['tauxTotal'];*/
				$noteForteFille[] = $info['stat'][$x]['noteForteFille'];
				$noteForteMasc[] = $info['stat'][$x]['noteForteMasc'];
				$noteForteTotal[] = $info['stat'][$x]['noteForteTotal'];
				$noteFaibleFille[] = $info['stat'][$x]['noteFaibleFille'];
				$noteFaibleMasc[] = $info['stat'][$x]['noteFaibleMasc'];
				$noteFaibleTotal[] = $info['stat'][$x]['noteFaibleTotal'];
				$moyGenFille[] = $info['stat'][$x]['moyGenFille'];
				$moyGenMasc[] = $info['stat'][$x]['moyGenMasc'];
				$moyGenTotal[] = $info['stat'][$x]['moyGenTotal'];


				$pdf->Cell(45, 6, utf8_decode($info['classe'][$x]['nom_classe']), 1, 0, 'L');
				// Effectif 
				$pdf->Cell(10, 6, $stat['effFille'], 1, 0, 'C');
				$pdf->Cell(10, 6, $stat['effMasc'], 1, 0, 'C');
				$pdf->Cell(10, 6, $stat['effTotal'], 1, 0, 'C');
				// Evalués 
				$pdf->Cell(10, 6, $stat['evalFille'], 1, 0, 'C');
				$pdf->Cell(10, 6, $stat['evalMasc'], 1, 0, 'C');
				$pdf->Cell(10, 6, $stat['evalTotal'], 1, 0, 'C');
				// Nb Moy 
				$pdf->Cell(10, 6, $stat['moyFille'], 1, 0, 'C');
				$pdf->Cell(10, 6, $stat['moyMasc'], 1, 0, 'C');
				$pdf->Cell(10, 6, $stat['moyTotal'], 1, 0, 'C');
				// Taux 
				$pdf->Cell(12, 6, $stat['tauxFille'], 1, 0, 'C');
				$pdf->Cell(13, 6, $stat['tauxMasc'], 1, 0, 'C');
				$pdf->Cell(15, 6, $stat['tauxTotal'], 1, 0, 'C');
				// Forte Moyenne 
				$pdf->Cell(12, 6, $stat['noteForteFille'], 1, 0, 'C');
				$pdf->Cell(13, 6, $stat['noteForteMasc'], 1, 0, 'C');
				$pdf->Cell(15, 6, $stat['noteForteTotal'], 1, 0, 'C');
				// Faible Moyenne 
				$pdf->Cell(10, 6, $stat['noteFaibleFille'], 1, 0, 'C');
				$pdf->Cell(10, 6, $stat['noteFaibleMasc'], 1, 0, 'C');
				$pdf->Cell(10, 6, $stat['noteFaibleTotal'], 1, 0, 'C');
				// Moyenne Générale 
				$pdf->Cell(12, 6, $stat['moyGenFille'], 1, 0, 'C');
				$pdf->Cell(13, 6, $stat['moyGenMasc'], 1, 0, 'C');
				$pdf->Cell(15, 6, $stat['moyGenTotal'], 1, 0, 'C');
				$pdf->Ln(6);
			}
			$pdf->setFont('Times', 'B',12);
			// $pdf->Ln(6);
			// Après les statistiques de chaque classe, 
			// on peut faire une ligne de total pour les statistiques globales de l'établissement
			$pdf->Cell(45, 6, 'Total', 1, 0, 'C', true);
			// Effectif
			$pdf->Cell(10, 6, array_sum($effFille), 1, 0, 'C',true);
			$pdf->Cell(10, 6, array_sum($effMasc), 1, 0, 'C',true);
			$pdf->Cell(10, 6, array_sum($effTotal), 1, 0, 'C',true);
			// Evalués
			$pdf->Cell(10, 6, array_sum($evalFille), 1, 0, 'C',true);
			$pdf->Cell(10, 6, array_sum($evalMasc), 1, 0, 'C',true);
			$pdf->Cell(10, 6, array_sum($evalTotal), 1, 0, 'C',true);
			// Nb Moy
			$pdf->Cell(10, 6, array_sum($moyFille), 1, 0, 'C',true);
			$pdf->Cell(10, 6, array_sum($moyMasc), 1, 0, 'C',true);
			$pdf->Cell(10, 6, array_sum($moyTotal), 1, 0, 'C',true);
			// Taux
			$tauxFille = array_sum($moyFille) * 100 / array_sum($evalFille);
			$tauxMasc = array_sum($moyMasc) * 100 / array_sum($evalMasc);
			$tauxTotal = array_sum($moyTotal) * 100 / array_sum($evalTotal);
			$pdf->Cell(12, 6, round($tauxFille, 2), 1, 0, 'C',true);
			$pdf->Cell(13, 6, round($tauxMasc, 2), 1, 0, 'C',true);
			$pdf->Cell(15, 6, round($tauxTotal, 2), 1, 0, 'C',true);
			// Forte Moyenne
			$pdf->Cell(12, 6, max($noteForteFille), 1, 0, 'C',true);
			$pdf->Cell(13, 6, max($noteForteMasc), 1, 0, 'C',true);
			$pdf->Cell(15, 6, max($noteForteTotal), 1, 0, 'C',true);
			// Faible Moyenne
			$pdf->Cell(10, 6, min($noteFaibleFille), 1, 0, 'C',true);
			$pdf->Cell(10, 6, min($noteFaibleMasc), 1, 0, 'C',true);
			$pdf->Cell(10, 6, min($noteFaibleTotal), 1, 0, 'C',true);
			// Moyenne Générale
			$pdf->Cell(12, 6, '', 1, 0, 'C',true);
			$pdf->Cell(13, 6, '', 1, 0, 'C',true);
			$pdf->Cell(15, 6, '', 1, 0, 'C',true);

			$nomFichier = "Statistiques du Trimestre ".$info['periode'].".pdf";
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
	