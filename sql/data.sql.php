<?php 
	$data[] = "INSERT INTO 
				 annee_scolaire(libelle_annee,
								statut)
				 VALUES('$anneeScolaire',
						'actif')";
	
	
	$data[] = "INSERT INTO 
				appreciation(nom_appreciation_fr, 
								nom_appreciation_en, 
								cote, 
								interv_ouvert, 
								interv_fermet)
				VALUES('CNA','CNA','D','0','10')";
	
	
	$data[] = "INSERT INTO 
				appreciation(nom_appreciation_fr, 
								nom_appreciation_en, 
								cote, 
								interv_ouvert, 
								interv_fermet)
				VALUES('CMA','CAA','C','10','12')";
	
	
	$data[] = "INSERT INTO 
				appreciation(nom_appreciation_fr, 
								nom_appreciation_en, 
								cote, 
								interv_ouvert, 
								interv_fermet)
				VALUES('CA','CA','C+','12','14')";
	
	
	$data[] = "INSERT INTO 
				appreciation(nom_appreciation_fr, 
								nom_appreciation_en, 
								cote, 
								interv_ouvert, 
								interv_fermet)
				VALUES('CBA','CWA','B','14','15')";
	
	
	$data[] = "INSERT INTO 
				appreciation(nom_appreciation_fr, 
								nom_appreciation_en, 
								cote, 
								interv_ouvert, 
								interv_fermet)
				VALUES('CBA','CWA','B+','15','16')";
	
	
	$data[] = "INSERT INTO 
				appreciation(nom_appreciation_fr, 
								nom_appreciation_en, 
								cote, 
								interv_ouvert, 
								interv_fermet)
				VALUES('CTBA','CVWA','A','16','18')";
	
	
	$data[] = "INSERT INTO 
				appreciation(nom_appreciation_fr, 
								nom_appreciation_en, 
								cote, 
								interv_ouvert, 
								interv_fermet)
				VALUES('CTBA','CVWA','A+','18','20')";
	$mdpCell = sha1('cell');
	$mdpAdmin = sha1('admin');
	$data[] = "INSERT INTO 
				enseignant(nom, sexe, poste, login, mdp, etat)
				VALUES('Cellule Informatique','M','2','cell','$mdpCell','actif')";
	$data[] = "INSERT INTO 
				enseignant(nom, sexe, poste, login, mdp, etat)
				VALUES('Administrateur Principal','M','1','admin','$mdpAdmin','actif')";
	$data[] = "INSERT INTO 
				information(annee_scolaire, nom_pays_fr, nom_pays_en, 
							nom_devise_fr, nom_devise_en, nom_ministere_fr, nom_ministere_en,
							region, departement, nom_etablissement_fr, nom_etablissement_en, 
							type_ets, chef_ets, signataire_fr, signataire_en, arrondissement, 
							ville, sexe_signataire, contact, email, bp) 
				VALUES('$anneeScolaire','$paysFr','$paysEn',
					'$deviseFr','$deviseEn','$ministereFr','$ministereEn',
					'$region','$departement','$etablissementFr','$etablissementEn',
					'$typeEts','$chef','$signataireFr','$signataireEn','$arrondissement',
					'$ville','$sexe','$contact', '$email', '$bp')";
	for($a=0;$a<count($niveau);$a++){
		$data[] = "INSERT INTO niveau_classe(nom_niveau, code_niveau)
					VALUES('$niveau[$a]','$niveau[$a]')";
	}
	
	for($b=1;$b<=6;$b++){
		$valSeq = 'Sequence '.$b;
		$data[] = "INSERT INTO periode(nom_periode)
					VALUES('$valSeq')";
	}
	
	for($c=0;$c<count($section);$c++){
		$data[] = "INSERT INTO section(code_section)
					VALUES('$section[$c]')";
	}
	
	$data[] = "INSERT INTO poste(code_poste, libelle_poste)
				VALUES('admin','Administrateur')";
	$data[] = "INSERT INTO poste(code_poste, libelle_poste)
				VALUES('cell','Cellule Informatique')";
	$data[] = "INSERT INTO poste(code_poste, libelle_poste)
				VALUES('chef','Proviseur / Principal / Directeur')";
	$data[] = "INSERT INTO poste(code_poste, libelle_poste)
				VALUES('censeur','Censeur')";
	$data[] = "INSERT INTO poste(code_poste, libelle_poste)
				VALUES('sg','Surveillant General')";
	$data[] = "INSERT INTO poste(code_poste, libelle_poste)
				VALUES('eco','Econome / Intendant')";
	$data[] = "INSERT INTO poste(code_poste, libelle_poste)
				VALUES('prof','Enseignant')";

	$data[] = "INSERT INTO groupe(nom_groupe, code_groupe) VALUES('Groupe 1','gp1')";
	$data[] = "INSERT INTO groupe(nom_groupe, code_groupe) VALUES('Groupe 2','gp2')";
	$data[] = "INSERT INTO groupe(nom_groupe, code_groupe) VALUES('Groupe 3','gp3')";
	$data[] = "INSERT INTO groupe(nom_groupe, code_groupe) VALUES('Groupe 4','gp4')";
	$data[] = "INSERT INTO groupe(nom_groupe, code_groupe) VALUES('Groupe 5','gp5')";