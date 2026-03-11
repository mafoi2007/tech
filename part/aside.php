<?php 
/**********************************************************************
*********   A S I D E   CELLULE ***************************************
**********************************************************************/
$menu['cell']['etat']['libelle'] = array("certificat de scolarité",
										 "liste des élèves",
										 "Vue d'ensemble des effectifs",
										 "Relevé de Notes des Enseignants",
										 "Liste des Professeurs Principaux",
										 "Conseil de classe",
										 "editer les bulletins séquentiels",
										 "editer les bulletins trimestriels",
										 "editer les bulletins annuels",
										 "recapitulatif trimestriel",
										 "PV des notes par matière",
										 "Relevé de Notes Annuelles");
$menu['cell']['etat']['lien'] = array("certif", 
									"listeEleve",
									"vueEff",
									"relNote",
									"listePP",
									"conseil",
									"bullseq",
									"bullTrim",
									"bullAnn",
									"recapTrim",
									"recapMatiere",
									"relNoteAnnuelle");

$menu['cell']['parametre']['libelle'] = array("modifier un mot de passe",
												"ajouter des photos",
												"insérer des matricules nationaux",
												"Attribuer une matière à la classe",
												"Attribuer plusieurs matières à une classe",
												"Modifier une matière de la classe",
												'Retirer une matière de la classe',
												"Créer les dates pour les absences",
												"Attribuer une matière à un enseignant",
												"Désigner un professeur principal");
$menu['cell']['parametre']['lien'] = array("allpwd",
											"addPicture",
											"stdNoMat",
											"addmatcls",
											"addmatclss",
											"updMatiereClasse",
											"rmMatiereClasse",
											"createDate",
											"addprofcls",
											"addPP");

$menu['cell']['eleve']['libelle'] = array('ajouter un élève', 'rechercher un nom', "preparer les listes");
$menu['cell']['eleve']['lien'] = array('addEleve', 'findEleve', 'prepaListe');

$menu['cell']['classe']['libelle'] = array('ajouter une classe',
											'visualiser une classe',
											"liste des classes");
$menu['cell']['classe']['lien'] = array('addClasse',
										'viewClasse',
										"listClasse");

$menu['cell']['matiere']['libelle'] = array('ajouter une matière',
											'visualiser une matière',
											"liste des matières");
$menu['cell']['matiere']['lien'] = array('addMatiere',
										'viewMatiere',
										"listMatiere");

$menu['cell']['periode']['libelle'] = array('activer une séquence',
											'verouiller une séquence',
											"consulter les séquences");
$menu['cell']['periode']['lien'] = array('openSeq',
										'closeSeq',
										"viewDate");

$menu['cell']['enseignant']['libelle'] = array('ajouter un enseignant',
											'visualiser un enseignant',
											"liste des enseignants");
$menu['cell']['enseignant']['lien'] = array('addProf',
										'findProf',
										"listProf");

$menu['cell']['finance']['libelle'] = array("créer une rubrique",
											"liste des rubriques",
											"Ajouter une rubrique à la classe",
											"retirer une rubrique de la classe",
											"rubriques de la classe");
$menu['cell']['finance']['lien'] = array("addrub",
										"viewrub",
										"insertrub",
										"rmrub",
										"listrub");

$menu['cell']['traitement']['libelle'] = array('vue globale des notes',
													'traiter les notes séquentielles', 
													'traiter les moyennes séquentielles',
													'traiter les notes trimestrielles',
													"traiter les moyennes trimestrielles",
													"traiter les notes annuelles",
													"traiter les moyennes annuelles"
													);
$menu['cell']['traitement']['lien'] = array('vueNote',
											'traitNtSeq',
											'traitMoySeq',
											'traitNtTrim',
											'traitMoyTrim',
											'traitNtAnn',
											'traitMoyAnn');














/****************************************************************************
***********  A S I D E  Administrateur **************************************
****************************************************************************/
/*$menu['admin']['utilisateur']['libelle'] = array('créer un utilisateur',
															'liste des utilisateurs',
															'affecter à la classe',
															'enseignants de la classe');
$menu['admin']['utilisateur']['lien'] = array('add', 'viewall', 'addprofcls',
														'profcls');*/

/*$menu['admin']['matiere']['libelle'] = array('Ajouter une matière',
													'modifier ponderation');
$menu['admin']['matiere']['lien'] = array('addmatcls','updpondcls');*/

$menu['admin']['journal']['libelle'] = array('Journal des Notes', 'Journal des Finances',
												'Journal des Elèves');
$menu['admin']['journal']['lien'] = array('note','finance', 'eleve');

$menu['admin']['bd']['libelle'] = array('Année Scolaire', 'Appréciation', 'classe',
												'periode', 'type utilisateur');
$menu['admin']['bd']['lien'] = array('as','appr','cls','per','usert');

$menu['admin']['archives']['libelle'] = array();
$menu['admin']['archives']['lien'] = array();

$menu['admin']['parametres']['libelle'] = array("Cloturer l'année", "Sauvegarder les données");
$menu['admin']['parametres']['lien'] = array('close', 'save');
/*$menu['admin']['bd']['libelle'] = array('Année Scolaire', 'Appréciation', 'classe',
												'periode', 'type utilisateur');
$menu['admin']['bd']['lien'] = array('as','appr','cls','per','usert');*/

/**************************************************************************************
*****************  A S I D E   ENSEIGNANT *********************************************
**************************************************************************************/

$menu['prof']['note']['libelle'] = array('Insérer des Notes', 
												'Modifier des Notes',
												'Supprimer les notes',
												'Consulter ses notes');
$menu['prof']['note']['lien'] = array('addnt','updnt','delnt','viewnt');


$menu['prof']['stat']['libelle'] = array('Statistiques séquentielles', 
													'Statistiques Trimestrielles',
													'Statistiques Annuelles');
$menu['prof']['stat']['lien'] = array('sequentiel','trimestriel', 'annuel');






/**************************************************************************************
*****************  A S I D E   CENSEUR *********************************************
**************************************************************************************/

$menu['censeur']['note']['libelle'] = array('Insérer des Notes', 
												'Modifier des Notes',
												'Supprimer les notes',
												'Consulter ses notes');
$menu['censeur']['note']['lien'] = array('addnt','updnt','delnt','viewnt');


$menu['censeur']['stat']['libelle'] = array('Statistiques Mensuelles', 
													'Statistiques Trimestrielles',
													'Statistiques Annuelles');
$menu['censeur']['stat']['lien'] = array('mensuel','trimestriel', 'annuel');









/**************************************************************************************
*****************  A S I D E   CHEF(Provsieur, Directeur, Principal) *********************************************
**************************************************************************************/

$menu['chef']['finance']['libelle'] = array('listing de payement', 
												'liste des insolvables',
												'liste des élèves solvables');
$menu['chef']['finance']['lien'] = array('liste','paid','unpaid');



$menu['chef']['liste']['libelle'] = array('Liste des élèves', 
												'Vue des effectifs',
												'Liste des enregistreurs');
$menu['chef']['liste']['lien'] = array('liste','vueEff','enreg');


$menu['chef']['note']['libelle'] = array('Insérer des Notes', 
												'Modifier des Notes',
												'Supprimer les notes',
												'Consulter ses notes');
$menu['chef']['note']['lien'] = array('addnt','updnt','delnt','viewnt');


$menu['chef']['stat']['libelle'] = array('Statistiques séquentielles', 
													'Statistiques Trimestrielles',
													'Statistiques Annuelles');
$menu['chef']['stat']['lien'] = array('sequentiel','trimestriel', 'annuel');



/**************************************************************************************
*****************  A S I D E   AGENT FINANCIER  *********************************************
**************************************************************************************/

$menu['eco']['etats']['libelle'] = array('Insérer des Notes', 
												'Modifier des Notes',
												'Supprimer les notes',
												'Consulter ses notes');
$menu['eco']['etats']['lien'] = array('addnt','updnt','delnt','viewnt');


$menu['eco']['finances']['libelle'] = array('Insérer des Notes', 
												'Modifier des Notes',
												'Supprimer les notes',
												'Consulter ses notes');
$menu['eco']['finances']['lien'] = array('addnt','updnt','delnt','viewnt');


$menu['eco']['note']['libelle'] = array('Insérer des Notes', 
												'Modifier des Notes',
												'Supprimer les notes',
												'Consulter ses notes');
$menu['eco']['note']['lien'] = array('addnt','updnt','delnt','viewnt');


$menu['eco']['stat']['libelle'] = array('Statistiques Mensuelles', 
													'Statistiques Trimestrielles',
													'Statistiques Annuelles');
$menu['eco']['stat']['lien'] = array('mensuel','trimestriel', 'annuel');


/**************************************************************************************
*****************  A S I D E   SG  *********************************************
**************************************************************************************/

$menu['sg']['discipline']['libelle'] = array('Saisie des Absences', 
												'Justification des absences',
												'Consultation des absences',
												'Suppression des absences');
$menu['sg']['discipline']['lien'] = array('addAbs','justAbs','viewAbs','delAbs');

$menu['sg']['note']['libelle'] = array('Insérer des Notes', 
												'Modifier des Notes',
												'Supprimer les notes',
												'Consulter ses notes');
$menu['sg']['note']['lien'] = array('addnt','updnt','delnt','viewnt');


$menu['sg']['stat']['libelle'] = array('Statistiques Mensuelles', 
													'Statistiques Trimestrielles',
													'Statistiques Annuelles');
$menu['sg']['stat']['lien'] = array('mensuel','trimestriel', 'annuel');

