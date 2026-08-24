<?php 
	session_start();
	require_once('inc/pdf.class.php');
	
	$pdf = new pdf('P', 'mm', 'A4');
	$pdf->SetFillColor(200,205,180);
	
	
	
	
	
	
	if(isset($_SESSION['print'])){
		if($_SESSION['print']=='certificatScolarite'){
			$eleve = $_SESSION['eleve'];
			$classe = $_SESSION['class'];
			$information = $_SESSION['information'];
			$pdf->SetFillColor(155, 150, 149);
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
			$pdf->SetFillColor(155, 150, 149);
			// La page doit s'afficher en fonction de la section 
			if($classe['section']=='en'){
				$pdf->addPage();
				$titre = 'Student List of ';
				$titre.= $classe['libelle_classe'];
				$pdf->Titre($titre);
				
				$pdf->SetFont('Times','',8);
				$pdf->Cell(90);
				$pdf->Cell(14, 7, 'Sex', 1, 0 , 'C');
				$pdf->Cell(12, 7, 'Female', 1, 0 , 'C');
				$pdf->Cell(14, 7, 'Male', 1, 0 , 'C');
				$pdf->Cell(10, 7, 'Global', 1, 0 , 'C');
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
				// $pdf->Cell(20, 6, $pdf->convert('Matricule'), 1, 0 , 'C');
				$pdf->Cell(75, 6, $pdf->convert('Full Name'), 1, 0 , 'C',true);
				$pdf->Cell(9, 6, $pdf->convert('Sex'), 1, 0 , 'C',true);
				$pdf->Cell(13, 6, $pdf->convert('Status'), 1, 0 , 'C',true);
				$pdf->Cell(55, 6, $pdf->convert('Date and place of birth'), 1, 0 , 'C',true);
				$pdf->SetFont('Times','',10);
				$pdf->Ln(6);
				$a = 1;
				for($i=0;$i<count($classe['eleve']);$i++){
					$pdf->Cell(10, 6, $a, 1, 0 , 'C');
					$pdf->Cell(28, 6, $pdf->convert($classe['eleve'][$i]['matricule']), 1, 0 , 'C');
					$pdf->Cell(75, 6, $pdf->convert($classe['eleve'][$i]['nom_complet']), 1, 0 , 'L');
					$pdf->Cell(9, 6, $pdf->convert($classe['eleve'][$i]['sexe']), 1, 0 , 'C');
					$pdf->Cell(13, 6, $pdf->convert($classe['eleve'][$i]['statut']), 1, 0 , 'C');
					$dateNaiss = $classe['eleve'][$i]['date_naissance'].' at '.ucwords($classe['eleve'][$i]['lieu_naissance']);
					$pdf->Cell(55, 6, $pdf->convert($dateNaiss), 1, 0 , 'C');
					$pdf->Ln(6);
					$a++;
				}
				$texte = 'Done at '.ucwords($_SESSION['information']['ville']);
				$texte.= ', on the '.DATE('Y-m-d');
				$pdf->Cell(190,10, $texte,0,0,'R');
				
				$pdf->Ln(5);
				// $pdf->Cell(130,30, ' ');
				$pdf->SetFont('Arial','BI',10);
				$pdf->Cell(190,10, 'The Director,',0,0,'R');
				
				$fileName='student_List_';
				$fileName.= strtoupper(str_replace(' ','_',$classe['libelle_classe']));
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
					$pdf->Cell(75, 6, $pdf->convert(stripslashes($classe['eleve'][$i]['nom_complet'])), 1, 0 , 'L');
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





		if($_SESSION['print']=='listeElevePhoto'){
			$classe = $_SESSION['classe'];
			$pdf->SetFillColor(155, 150, 149);
			// La page doit s'afficher en fonction de la section 
			if($classe['section']=='en'){
				$pdf->addPage();
				$titre = 'Student List of ';
				$titre.= $classe['libelle_classe'];
				$pdf->Titre($titre);
				
				$pdf->SetFont('Times','',8);
				$pdf->Cell(90);
				$pdf->Cell(14, 7, 'Sex', 1, 0 , 'C');
				$pdf->Cell(12, 7, 'Female', 1, 0 , 'C');
				$pdf->Cell(14, 7, 'Male', 1, 0 , 'C');
				$pdf->Cell(10, 7, 'Global', 1, 0 , 'C');
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
				// $pdf->Cell(20, 6, $pdf->convert('Matricule'), 1, 0 , 'C');
				$pdf->Cell(75, 6, $pdf->convert('Full Name'), 1, 0 , 'C',true);
				$pdf->Cell(9, 6, $pdf->convert('Sex'), 1, 0 , 'C',true);
				$pdf->Cell(13, 6, $pdf->convert('Status'), 1, 0 , 'C',true);
				$pdf->Cell(55, 6, $pdf->convert('Date and place of birth'), 1, 0 , 'C',true);
				$pdf->SetFont('Times','',10);
				$pdf->Ln(6);
				$a = 1;
				for($i=0;$i<count($classe['eleve']);$i++){
					$pdf->Cell(10, 6, $a, 1, 0 , 'C');
					$pdf->Cell(28, 6, $pdf->convert($classe['eleve'][$i]['matricule']), 1, 0 , 'C');
					$pdf->Cell(75, 6, $pdf->convert($classe['eleve'][$i]['nom_complet']), 1, 0 , 'L');
					$pdf->Cell(9, 6, $pdf->convert($classe['eleve'][$i]['sexe']), 1, 0 , 'C');
					$pdf->Cell(13, 6, $pdf->convert($classe['eleve'][$i]['statut']), 1, 0 , 'C');
					$dateNaiss = $classe['eleve'][$i]['date_naissance'].' at '.ucwords($classe['eleve'][$i]['lieu_naissance']);
					$pdf->Cell(55, 6, $pdf->convert($dateNaiss), 1, 0 , 'C');
					$pdf->Ln(6);
					$a++;
				}
				$texte = 'Done at '.ucwords($_SESSION['information']['ville']);
				$texte.= ', on the '.DATE('Y-m-d');
				$pdf->Cell(190,10, $texte,0,0,'R');
				
				$pdf->Ln(5);
				// $pdf->Cell(130,30, ' ');
				$pdf->SetFont('Arial','BI',10);
				$pdf->Cell(190,10, 'The Director,',0,0,'R');
				
				$fileName='student_List_';
				$fileName.= strtoupper(str_replace(' ','_',$classe['libelle_classe']));
				$fileName.= '.pdf';
			}elseif($classe['section']=='fr'){
				$pdf->addPage();
				$pdf->Entete();
				$titre = 'Liste des eleves de la ';
				$titre.= $classe['eleve'][0]['nom_classe'];
				$pdf->Titre($titre);
				
				$pdf->SetFont('Times','B',8);
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
				$pdf->Cell(23, 6, $pdf->convert('Photo'), 1, 0 , 'C',true);
				$pdf->Cell(25, 6, $pdf->convert('Matricule'), 1, 0 , 'C',true);
				$pdf->Cell(65, 6, $pdf->convert('Nom Complet'), 1, 0 , 'C',true);
				$pdf->Cell(9, 6, $pdf->convert('Sexe'), 1, 0 , 'C',true);
				$pdf->Cell(13, 6, $pdf->convert('Statut'), 1, 0 , 'C',true);
				$pdf->Cell(50, 6, $pdf->convert('Date et lieu de naissance'), 1, 0 , 'C',true);
				$pdf->SetFont('Times','',10);
				$pdf->Ln(6);
				$a = 1;
				for($i=0;$i<count($classe['eleve']);$i++){
					$pdf->Cell(10, 12, $a, 1, 0 , 'C');
					// Positionnement de la photo 
					if(empty($classe['eleve'][$i]['photo'])){
						$image = 'images/student/no_name.png';
					}else{
						$image = $classe['eleve'][$i]['photo'];
					}
					$photo = array(
						'nom'=>$classe['eleve'][$i]['photo'],
						'valeur'=>'photoEleve',
						'image'=>$image
					);
					$cellWidth = 25;
					$cellHeight = 14;
					$imgSize = 10;
					$x = $pdf->GetX();
					$y = $pdf->GetY();
					$pdf->Cell(23, 12,'', 1, 0);
					$pdf->Image(
						$photo['image'],
						$x + ($cellWidth - $imgSize)/2,
						$y + ($cellHeight - $imgSize)/2,
						$imgSize,
						$imgSize
					);
					$pdf->Cell(25, 12, $pdf->convert($classe['eleve'][$i]['rne']), 1, 0 , 'C');
					$pdf->Cell(65, 12, $pdf->convert(stripslashes($classe['eleve'][$i]['nom_complet'])), 1, 0 , 'L');
					$pdf->Cell(9, 12, $pdf->convert($classe['eleve'][$i]['sexe']), 1, 0 , 'C');
					$pdf->Cell(13, 12, $pdf->convert($classe['eleve'][$i]['statut']), 1, 0 , 'C');
					$dateNaiss = $classe['eleve'][$i]['date_fr'].' à '.ucwords($classe['eleve'][$i]['lieu_naissance']);
					$pdf->Cell(50, 12, $pdf->convert($dateNaiss), 1, 0 , 'L');
					$pdf->Ln(12);
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
			$pdf->SetFillColor(155, 150, 149);
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
			$pdf->SetFillColor(155, 150, 149);
			// La page doit s'afficher en fonction de la section 
			if($classe['section']=='en'){
				$pdf->addPage();
				$titre = 'Student List of ';
				$titre.= $classe['libelle_classe'];
				$pdf->Titre($titre);
				
				$pdf->SetFont('Times','',8);
				$pdf->Cell(90);
				$pdf->Cell(14, 7, 'Sex', 1, 0 , 'C');
				$pdf->Cell(12, 7, 'Female', 1, 0 , 'C');
				$pdf->Cell(14, 7, 'Male', 1, 0 , 'C');
				$pdf->Cell(10, 7, 'Global', 1, 0 , 'C');
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
				// $pdf->Cell(20, 6, $pdf->convert('Matricule'), 1, 0 , 'C');
				$pdf->Cell(75, 6, $pdf->convert('Full Name'), 1, 0 , 'C',true);
				$pdf->Cell(9, 6, $pdf->convert('Sex'), 1, 0 , 'C',true);
				$pdf->Cell(13, 6, $pdf->convert('Status'), 1, 0 , 'C',true);
				$pdf->Cell(55, 6, $pdf->convert('Date and place of birth'), 1, 0 , 'C',true);
				$pdf->SetFont('Times','',10);
				$pdf->Ln(6);
				$a = 1;
				for($i=0;$i<count($classe['eleve']);$i++){
					$pdf->Cell(10, 6, $a, 1, 0 , 'C');
					$pdf->Cell(28, 6, $pdf->convert($classe['eleve'][$i]['matricule']), 1, 0 , 'C');
					$pdf->Cell(75, 6, $pdf->convert($classe['eleve'][$i]['nom_complet']), 1, 0 , 'L');
					$pdf->Cell(9, 6, $pdf->convert($classe['eleve'][$i]['sexe']), 1, 0 , 'C');
					$pdf->Cell(13, 6, $pdf->convert($classe['eleve'][$i]['statut']), 1, 0 , 'C');
					$dateNaiss = $classe['eleve'][$i]['date_naissance'].' at '.ucwords($classe['eleve'][$i]['lieu_naissance']);
					$pdf->Cell(55, 6, $pdf->convert($dateNaiss), 1, 0 , 'C');
					$pdf->Ln(6);
					$a++;
				}
				$texte = 'Done at '.ucwords($_SESSION['information']['ville']);
				$texte.= ', on the '.DATE('Y-m-d');
				$pdf->Cell(190,10, $texte,0,0,'R');
				
				$pdf->Ln(5);
				// $pdf->Cell(130,30, ' ');
				$pdf->SetFont('Arial','BI',10);
				$pdf->Cell(190,10, 'The Director,',0,0,'R');
				
				$fileName='student_List_';
				$fileName.= strtoupper(str_replace(' ','_',$classe['libelle_classe']));
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
			$pdf->SetFillColor(155, 150, 149);
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
			$pdf->SetFillColor(155, 150, 149);
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
				$pdf->SetFillColor(155, 150, 149);
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





		/*
		elseif($_SESSION['print']=='ficheEleve'){
			$eleve = $_SESSION['eleve'];
			$pdf->SetFillColor(155, 150, 149);
			$pdf->addPage();
			$titre = "Fiche d'identification de l'eleve ";
			$pdf->Titre($titre);
			$sousTitre = 'Classe : '.$eleve['identification']['libelle_classe'];
			$pdf->sousTitre($sousTitre);
			
			// Je positionne la photo de l'élève
			$photo = $eleve['identification']['photo'];
			if(empty($photo)){$photo = 'images/student/no_name.png';}
			$pdf->Image($photo, 170, 66, 20);
			$nom = $eleve['identification']['nom_complet'];
			$matricule = $eleve['identification']['matricule'];
			$sexeEleve = $eleve['identification']['sexe'];
			if($sexeEleve==='F'){
				$sexe='Feminin';
			}elseif($sexeEleve==='M'){
				$sexe='Masculin';
			}
			$statutEleve = $eleve['identification']['statut'];
			if($statutEleve==='N'){
				$statut='Nouveau';
			}elseif($statutEleve==='R'){
				$statut='Redoublant';
			}
			$dateNaissance = $eleve['identification']['date_fr'];
			$lieuNaissance = $eleve['identification']['lieu_naissance'];
			$nomPere = $eleve['identification']['nom_pere'];
			$nomMere = $eleve['identification']['nom_mere'];
			$contactParent = $eleve['identification']['contact_parent'];
			
			// Pour l'expression française
			$pdf->setFont('Times', '', 14);
			$pdf->Text(25, 100, "Nom de l'eleve : ");
			$pdf->Text(25, 115, "Matricule : ");
			$pdf->Text(25, 130, "Sexe : ");
			$pdf->Text(125, 130, "Statut : ");
			$pdf->Text(25, 145, "Date de Naissance : ");
			$pdf->Text(25, 160, "Lieu de Naissance : ");
			$pdf->Text(25, 175, "Nom du Pere : ");
			$pdf->Text(25, 190, "Nom de la Mere : ");
			$pdf->Text(25, 205, "Contact des Parents : ");
			
			
			// Pour l'expression anglaise
			$pdf->setFont('Times', 'I', 12);
			$pdf->Text(25, 105, "Student Name : ");
			$pdf->Text(25, 120, "Identifier : ");
			$pdf->Text(25, 135, "Sex : ");
			$pdf->Text(125, 135, "Status : ");
			$pdf->Text(25, 150, "Date of birth : ");
			$pdf->Text(25, 165, "Place of birth : ");
			$pdf->Text(25, 180, "Father's Name : ");
			$pdf->Text(25, 195, "Mother's Name : ");
			$pdf->Text(25, 210, "Parent's Contact : ");
			
			
			// Affichage des informations
			$pdf->setFont('Times', 'BI', 18);
			$pdf->Text(65, 100, $nom);
			$pdf->Text(65, 115, $matricule);
			$pdf->Text(65, 130, $sexe);
			$pdf->Text(145, 130, $statut);
			$pdf->Text(75, 145, $dateNaissance);
			$pdf->Text(75, 160, $lieuNaissance);
			$pdf->Text(75, 175, $nomPere);
			$pdf->Text(75, 190, $nomMere);
			$pdf->Text(75, 205, $contactParent);
			
			$fileName='fiche_Identification_Eleve_';
			$fileName.= strtoupper(str_replace(' ','_',$nom));
			$fileName.= '.pdf';
			$pdf->setAuthor('Nyambi Computer Services');
			$pdf->Output($fileName, 'I');
		}*/
		
		
		



		
		if($_SESSION['print']=='bulletinMensuel'){
			$classe = $_SESSION['classe'];
			$pdf->SetFillColor(155, 150, 149);
			// La section Anglophone 
			if($classe['section']=='en'){
				// Un bulletin par élève
				$bulletin = $classe['bulletin'];
				$eleve = $classe['eleve'];
				$infoClasse = $classe['infoClasse'];
				$mois = $classe['moisCourant'];
				for($i=0;$i<count($bulletin);$i++){
					
					
					
					$pdf->addPage();
					$photo = $eleve[$i]['photo'];
					// On gère l'affichage de la photo d'élève ici 
					if($photo=='images/student/'){
						$image = $photo.'no_name.png';
					}else{$image = $photo;}
					// ENTETE DU BULLETIN 
					$pdf->SetFont('Times','',13);
					$pdf->Image($image, 180, 65, 15);
					$pdf->Text(20,75,'Level : ');
					$pdf->Text(60,75,'Class : ');
					$pdf->Text(100,75,'Month : ');
					$pdf->Text(20,80,'Name of pupil: ');
					$pdf->Text(20,85,'Class Teacher: ');
					$pdf->SetFont('Times','B',13);
					$pdf->Text(35,75,$infoClasse['niveau_classe']);
					$pdf->Text(75,75,$pdf->convert(strtoupper($infoClasse['libelle_classe'])));
					$pdf->Text(115,75,$pdf->convert(strtoupper($mois['code_periode_en'])));
					$pdf->Text(50,80,$eleve[$i]['nom_complet']);
					$pdf->SetFont('Times','BI',12);
					$pdf->Text(50,85,$classe['enseignant']['nom']);
					$pdf->Ln(30);
					
					// GESTION DES MATIERES 
					$listeMatiere = $classe['listeMatiere'];
					for($a=0;$a<count($listeMatiere);$a++){
						$pdf->SetFont('Times','BI',11);
						$codeMatiere = $listeMatiere[$a]['code_competence'];
						$idMatiere = $listeMatiere[$a]['id_competence'];
						$libelleMatiere = $listeMatiere[$a]['libelle_competence_en'];
						$pdf->Cell(180,5,$pdf->convert('Competence : '.strtoupper($libelleMatiere)), 1, 0, 'C', true);
						$pdf->Ln(5);
						// On gère les sous Matières ici
						$sousMatiere = $classe['listeSousMatiere'][$idMatiere];
						$valeurCell = 90 / count($sousMatiere);
						$pdf->SetFont('Times','',9);
						foreach($sousMatiere as $cle=>$valeur){
							
							$valeurMatiere = ucwords($valeur['libelle_sous_competence_en']);
							$pdf->Cell($valeurCell,5,$valeurMatiere,1,0,'C');
						}
						$valeurTotale = $bulletin[$i][$codeMatiere];
						$pdf->Cell(30,5,'Total : '.$valeurTotale,1,0,'C');
						$pdf->Cell(30,5,'Grade',1,0,'C');
						$pdf->Cell(30,5,'Appreciation',1,0,'C');
						$pdf->Ln(5);
					}
				}
				$fileName='Mensual_reported_marks_';
				$fileName .=str_replace(' ', '_', $infoClasse['libelle_classe']);
				$fileName.= '.pdf';
				$pdf->Output($fileName, 'I');
				/*
				for($i=0;$i<count($classe['eleve']);$i++){
					$eleve = $classe['eleve'];
					$mois = $classe['moisCourant'];
					$noteEleve = $classe['noteEleve'][$i];
					$pdf->addPage();
					$titre = 'Mensual Reported Marks of ';
					$titre .= $eleve[$i]['libelle_classe'];
					$pdf->Titre($titre);
					
					
					
					$pdf->Ln(20);
					// On gère la liste des Matières ici
					$pdf->SetFont('Times','B',9);
					for($x=0;$x<count($classe['listeMatiere']);$x++){
						$libCompetence = 'Competence : ';
						$libCompetence .= $classe['listeMatiere'][$x]['libelle_competence_en'];
						
						
						
						
						for($a=0;$a<count($classe['noteEleve']);$a++){
							foreach($sousMatiere as $cle=>$valeur){
								if($valeur['id']==$classe['noteEleve'][$i][$a]['matiere'] AND 
									$eleve[$i]['id']==$classe['noteEleve'][$i][$a]['eleve']){
									
									$pdf->Cell($valeurCell,5,$classe['noteEleve'][$i][$a]['note'],1,0,'C');
								}
							}
							
						}
						$pdf->Ln(5);
					}
				}
				*/
				
				/**/
			}
			
			
			// La section Francophnoe
			elseif($classe['section']=='fr'){
				$pdf->addPage();
				$titre = 'Liste des eleves de la classe de ';
				$titre.= $classe['libelle_classe'];
				$pdf->Titre($titre);
				
				$pdf->SetFont('Times','',8);
				$pdf->Cell(90);
				$pdf->Cell(14, 7, 'Sexe', 1, 0 , 'C');
				$pdf->Cell(12, 7, 'Feminin', 1, 0 , 'C');
				$pdf->Cell(14, 7, 'Masculin', 1, 0 , 'C');
				$pdf->Cell(10, 7, 'Total', 1, 0 , 'C');
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
					$pdf->Cell(28, 6, $pdf->convert($classe['eleve'][$i]['matricule']), 1, 0 , 'C');
					$pdf->Cell(75, 6, $pdf->convert($classe['eleve'][$i]['nom_complet']), 1, 0 , 'L');
					$pdf->Cell(9, 6, $pdf->convert($classe['eleve'][$i]['sexe']), 1, 0 , 'C');
					$pdf->Cell(13, 6, $pdf->convert($classe['eleve'][$i]['statut']), 1, 0 , 'C');
					$dateNaiss = $classe['eleve'][$i]['date_fr'].' a '.ucwords($classe['eleve'][$i]['lieu_naissance']);
					$pdf->Cell(55, 6, $pdf->convert($dateNaiss), 1, 0 , 'C');
					$pdf->Ln(6);
					$a++;
				}
				$texte = 'Fait a '.ucwords($_SESSION['information']['ville']);
				$texte.= ', le '.DATE('d / m / Y');
				$pdf->Cell(190,10, $texte,0,0,'R');
				
				$pdf->Ln(5);
				// $pdf->Cell(130,30, ' ');
				$pdf->SetFont('Arial','BI',10);
				$titre = $classe['information']['titre'];
				$pdf->Cell(190,10, $titre.' Le Directeur',0,0,'R');
				
				$fileName='liste_Eleve_';
				$fileName.= strtoupper(str_replace(' ','_',$classe['libelle_classe']));
				$fileName.= '.pdf';
			} 
			
			$pdf->setAuthor('Nyambi Computer Services');
			$pdf->Output($fileName, 'I');
			
			
			
			
		}









		elseif($_SESSION['print']=='BulletinSequentiel'){
			$eleve = $_SESSION['eleve'];
			$ville = strtoupper($_SESSION['information']['ville']);
			
			// $pdf->pvSequentielAlpha($_SESSION['section']);
			// $pdf->pvSequentielMerite($_SESSION['section']);
			/*for($i=0;$i<count($eleve['eleve']);$i++){
				$pdf->bulletinSequentiel($eleve['eleve'][$i], $_SESSION['section']);
			}*/
			$pdf->bulletinSequentiel($eleve, $_SESSION['section']);
			$nomFichier = "Bulletin_Sequence_".$_SESSION['sequence']."_".$_SESSION['eleve']['eleve'][0]['nom_classe'].".pdf";
			$pdf->Output($nomFichier, 'I');
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
		

		elseif($_SESSION['print']=='BulletinAnnuel'){
			$info = $_SESSION['info'];  //Les données propres au bulletin 
			$information = $_SESSION['information'];  // Les données propres à la connexion.
			
			// On positionne les PV 
			$pdf->pvAnnuelAlpha($info, $information);
			$pdf->pvAnnuelMerite($info, $information);
			// On positionne les bulletins
			for($i=0;$i<count($info['eleve']);$i++){
				$pdf->bulletinAnnuel($info, $information, $info['eleve'][$i]);
			}
			$nomFichier = "Bulletin_Annuel_".$info['nomClasse']['nom_classe'].".pdf";
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
	unset($_SESSION['info']);
	// unset($_SESSION['groupe']);
	// unset($_SESSION['matiereGroupe']);
	