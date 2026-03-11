<?php 
	$structure[0] = "CREATE TABLE IF NOT EXISTS absence( ";
	$structure[0] .= "id int(11) auto_increment primary key, ";
	$structure[0] .= "id_eleve int(11) not null, ";
	$structure[0] .= "date_absence date, ";
	$structure[0] .= "nombre_heure int(11) not null, ";
	$structure[0] .= "justification varchar(100) not null comment 'AJ ou ANJ' ";
	$structure[0] .= ");";
	
	
	$structure[1] = "CREATE TABLE IF NOT EXISTS appreciation( ";
	$structure[1] .= "id int(11) auto_increment primary key, ";
	$structure[1] .= "nom_appreciation_fr varchar(100) not null, ";
	$structure[1] .= "nom_appreciation_en varchar(100) not null, ";
	$structure[1] .= "cote varchar(5) not null, ";
	$structure[1] .= "interv_ouvert int(2), ";
	$structure[1] .= "interv_fermet int(2) ";
	$structure[1] .= ");";
	
	
	$structure[2] = "CREATE TABLE IF NOT EXISTS classe( ";
	$structure[2] .= "id int(11) auto_increment primary key, ";
	$structure[2] .= "section varchar(5) not null, ";
	$structure[2] .= "sous_section varchar(5) not null, ";
	$structure[2] .= "nom_classe varchar(100) not null, ";
	$structure[2] .= "code_classe varchar(10) not null, ";
	$structure[2] .= "niveau_classe int(2) not null, ";
	$structure[2] .= "etat_classe varchar(10) not null ";	
	$structure[2] .= ");";
	
	
	$structure[3] = "CREATE TABLE IF NOT EXISTS annee_scolaire( ";
	$structure[3] .= "id int(11) auto_increment primary key, ";
	$structure[3] .= "`libelle_annee` varchar(100) NOT NULL, ";
	$structure[3] .= "`statut` varchar(100) NOT NULL COMMENT 'actif, inactif' ";
	$structure[3] .= ");";
	
	
	$structure[4] = "CREATE TABLE IF NOT EXISTS `classe_principale` ( ";
	$structure[4] .= "`id` int(11) NOT NULL AUTO_INCREMENT primary key, ";
	$structure[4] .= "`prof` int(11) NOT NULL, ";
	$structure[4] .= "`classe` int(11) NOT NULL ";
	$structure[4] .= ");";
	
	
	$structure[5] = "CREATE TABLE IF NOT EXISTS eleve(";
	$structure[5] .= "id int(11) auto_increment primary key, ";
	$structure[5] .= "rne int(11) not null, ";
	$structure[5] .= "nom_complet varchar(255) not null, ";
	$structure[5] .= "sexe varchar(1) not null, ";
	$structure[5] .= "date_naissance date, ";
	$structure[5] .= "lieu_naissance varchar(255), ";
	$structure[5] .= "matricule varchar(20), ";
	$structure[5] .= "classe int(11) not null, ";
	$structure[5] .= "adresse_parent varchar(255) not null, ";
	$structure[5] .= "statut varchar(1) not null, ";
	$structure[5] .= "num_rand int(11), ";
	$structure[5] .= "etat varchar(15) not null, ";
	$structure[5] .= "nom_pere varchar(255), ";
	$structure[5] .= "nom_mere varchar(255) not null, ";
	$structure[5] .= "photo varchar(255) not null, ";
	$structure[5] .= "add_by int(11) not null, ";
	$structure[5] .= "add_date datetime, ";
	$structure[5] .= "a_s int(11) not null ";
	$structure[5] .= ");";
	
	
	$structure[6] = "CREATE TABLE IF NOT EXISTS date_absences(";
	$structure[6] .= "id int(11) auto_increment primary key, ";
	$structure[6] .= "id_periode int(11) not null, ";
	$structure[6] .= "open_date date not null, ";
	$structure[6] .= "close_date date not null ";
	$structure[6] .= ");";
	
	
	$structure[7] = "CREATE TABLE IF NOT EXISTS enseignant(";
	$structure[7] .= "id int(11) auto_increment primary key, ";
	$structure[7] .= "nom varchar(255) not null, ";
	$structure[7] .= "sexe varchar(1) not null comment 'Mr ou Mme', ";
	$structure[7] .= "poste int(11) not null, ";
	$structure[7] .= "login varchar(100) not null, ";
	$structure[7] .= "mdp varchar(255) not null, ";
	$structure[7] .= "etat varchar(20) not null, ";
	$structure[7] .= "image varchar(255) null";
	$structure[7] .= ");";
	
	
	$structure[8] = "CREATE TABLE IF NOT EXISTS `information`( ";
	$structure[8] .= "annee_scolaire varchar(11) not null, ";
	$structure[8] .= "nom_pays_fr varchar(255) not null, ";
	$structure[8] .= "nom_pays_en varchar(255) not null, ";
	$structure[8] .= "nom_devise_fr varchar(255) not null, ";
	$structure[8] .= "nom_devise_en varchar(255) not null, ";
	$structure[8] .= "nom_ministere_fr varchar(255) not null, ";
	$structure[8] .= "nom_ministere_en varchar(255) not null, ";
	$structure[8] .= "region int(11) not null, ";
	$structure[8] .= "departement int(11) not null, ";
	$structure[8] .= "nom_etablissement_fr varchar(255) not null, ";
	$structure[8] .= "nom_etablissement_en varchar(255) not null, ";
	$structure[8] .= "type_ets varchar(255) not null, ";
	$structure[8] .= "chef_ets varchar(255) not null, ";
	$structure[8] .= "signataire_fr varchar(255) not null, ";
	$structure[8] .= "signataire_en varchar(255) not null, ";
	$structure[8] .= "arrondissement varchar(255) not null, ";
	$structure[8] .= "ville varchar(255) not null, ";
	$structure[8] .= "email varchar(255) not null, ";
	$structure[8] .= "bp varchar(255) not null, ";
	$structure[8] .= "sexe_signataire varchar(5) not null, ";
	$structure[8] .= "contact varchar(25) null";
	$structure[8] .= ");";
	
	
	$structure[9] = "CREATE TABLE IF NOT EXISTS journal_connexion( ";
	$structure[9] .= "id int(11) auto_increment primary key, ";
	$structure[9] .= "utilisateur int(11), ";
	$structure[9] .= "adresse_ip varchar(100) not null, ";
	$structure[9] .= "periode_de_connexion DATETIME, ";
	$structure[9] .= "navigateur varchar(100) not null, ";
	$structure[9] .= "os varchar(100) not null ";
	$structure[9] .= ");";
	
	
	$structure[10] = "CREATE TABLE IF NOT EXISTS matiere( ";
	$structure[10] .= "id int(11) auto_increment primary key, ";
	$structure[10] .= "nom_matiere varchar(100), ";
	$structure[10] .= "code_matiere varchar(10), ";
	$structure[10] .= "etat varchar(20) ";
	$structure[10] .= ");";


	$structure[11] = "CREATE TABLE IF NOT EXISTS niveau_classe( ";
	$structure[11] .= "id int(11) auto_increment primary key, ";
	$structure[11] .= "nom_niveau varchar(100) not null, ";
	$structure[11] .= "code_niveau varchar(100) ";
	$structure[11] .= ");";


	$structure[12] = "CREATE TABLE IF NOT EXISTS note( ";
	$structure[12] .= "id int(11) auto_increment primary key, ";
	$structure[12] .= "id_eleve int(11), ";
	$structure[12] .= "id_matiere int(11), ";
	$structure[12] .= "id_classe int(11), ";
	$structure[12] .= "id_periode int(11), ";
	$structure[12] .= "note decimal(4,2) null, ";
	$structure[12] .= "observation varchar(100) ";
	$structure[12] .= ");";


	$structure[13] = "CREATE TABLE IF NOT EXISTS note_saisie( ";
	$structure[13] .= "id int(11) auto_increment primary key, ";
	$structure[13] .= "id_classe int(11), ";
	$structure[13] .= "id_enseignant int(11), ";
	$structure[13] .= "id_matiere int(11), ";
	$structure[13] .= "id_periode int(11), ";
	$structure[13] .= "add_by int(11), ";
	$structure[13] .= "competence TEXT, ";
	$structure[13] .= "date_saisie datetime, ";
	$structure[13] .= "date_modification datetime, ";
	$structure[13] .= "navigateur varchar(100), ";
	$structure[13] .= "ip varchar(100), ";
	$structure[13] .= "os varchar(100) ";
	$structure[13] .= ");";


	$structure[14] = "CREATE TABLE IF NOT EXISTS periode( ";
	$structure[14] .= "id int(11) auto_increment primary key, ";
	$structure[14] .= "nom_periode varchar(255) not null, ";
	$structure[14] .= "date_ouvert date, ";
	$structure[14] .= "date_fermet date ";
	$structure[14] .= ");";


	$structure[15] = "CREATE TABLE IF NOT EXISTS prof_classe( ";
	$structure[15] .= "id int(11) auto_increment primary key, ";
	$structure[15] .= "id_prof int(11), ";
	$structure[15] .= "id_classe int(11), ";
	$structure[15] .= "id_matiere int(11), ";
	$structure[15] .= "coef decimal(2,1), ";
	$structure[15] .= "groupe varchar(100) ";
	$structure[15] .= ");";


	$structure[16] = "CREATE TABLE IF NOT EXISTS bull_trim( ";
	$structure[16] .= "id int(11) auto_increment primary key, ";
	$structure[16] .= "classe int(11) null, ";
	$structure[16] .= "pret varchar(5) null, ";
	$structure[16] .= "trimestre int(11) null ";
	$structure[16] .= ");";


	$structure[17] = "CREATE TABLE IF NOT EXISTS bull_annuel( ";
	$structure[17] .= "id int(11) auto_increment primary key, ";
	$structure[17] .= "classe int(11) null, ";
	$structure[17] .= "pret varchar(5) null ";
	$structure[17] .= ");";

	
	$structure[18] = "CREATE TABLE IF NOT EXISTS bull_seq( ";
	$structure[18] .= "id int(11) auto_increment primary key, ";
	$structure[18] .= "classe int(11) null, ";
	$structure[18] .= "pret varchar(5) null, ";
	$structure[18] .= "sequence int(11) null ";
	$structure[18] .= ");";

	
	$structure[19] = "CREATE TABLE IF NOT EXISTS section( ";
	$structure[19] .= "id int(11) auto_increment primary key, ";
	$structure[19] .= "code_section varchar(5) not null ";
	$structure[19] .= ");";
	
	
	$structure[20] = "CREATE TABLE IF NOT EXISTS poste( ";
	$structure[20] .= "id int(11) auto_increment primary key, ";
	$structure[20] .= "code_poste varchar(100) not null, ";
	$structure[20] .= "libelle_poste varchar(255) not null ";
	$structure[20] .= ");";
	
	
	$structure[21] = "CREATE TABLE IF NOT EXISTS groupe( ";
	$structure[21] .= "id int(11) auto_increment primary key, ";
	$structure[21] .= "nom_groupe varchar(255) not null, ";
	$structure[21] .= "code_groupe varchar(255) not null ";
	$structure[21] .= ");";


	$structure[22] = "CREATE TABLE IF NOT EXISTS rubrique_finance( ";
	$structure[22] .= "id int(11) auto_increment primary key, ";
	$structure[22] .= "nom_rubrique text not null, ";
	$structure[22] .= "code_rubrique text not null, ";
	$structure[22] .= "etat varchar(25) not null ";
	$structure[22] .= ");";


	$structure[23] = "CREATE TABLE IF NOT EXISTS rubrique_classe( ";
	$structure[23] .= "id int(11) auto_increment primary key, ";
	$structure[23] .= "rubrique int(11), ";
	$structure[23] .= "classe int(11), ";
	$structure[23] .= "montant int(11) ";
	$structure[23] .= ");";


	$structure[24] = "CREATE TABLE IF NOT EXISTS rubrique_payement( ";
	$structure[24] .= "id int(11) auto_increment primary key, ";
	$structure[24] .= "id_eleve int(11), ";
	$structure[24] .= "num_recu int(11), ";
	$structure[24] .= "rubrique int(11), ";
	$structure[24] .= "montant int(11), ";
	$structure[24] .= "date_payement date, ";
	$structure[24] .= "date_enregistrement datetime, ";
	$structure[24] .= "agent int(11),  ";
	$structure[24] .= "observation varchar(100)  ";
	$structure[24] .= ");";