-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mer 01 Octobre 2025 à 13:06
-- Version du serveur :  10.1.16-MariaDB
-- Version de PHP :  7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `tech`
--

-- --------------------------------------------------------

--
-- Structure de la table `absence`
--

CREATE TABLE `absence` (
  `id` int(11) NOT NULL,
  `id_eleve` int(11) NOT NULL,
  `date_absence` date DEFAULT NULL,
  `nombre_heure` int(11) NOT NULL,
  `justification` varchar(100) NOT NULL COMMENT 'AJ ou ANJ'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `annee_scolaire`
--

CREATE TABLE `annee_scolaire` (
  `id` int(11) NOT NULL,
  `libelle_annee` varchar(100) NOT NULL,
  `statut` varchar(100) NOT NULL COMMENT 'actif, inactif'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `appreciation`
--

CREATE TABLE `appreciation` (
  `id` int(11) NOT NULL,
  `nom_appreciation_fr` varchar(100) NOT NULL,
  `nom_appreciation_en` varchar(100) NOT NULL,
  `cote` varchar(5) NOT NULL,
  `interv_ouvert` int(2) DEFAULT NULL,
  `interv_fermet` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `bull_annuel`
--

CREATE TABLE `bull_annuel` (
  `id` int(11) NOT NULL,
  `classe` int(11) DEFAULT NULL,
  `pret` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `bull_seq`
--

CREATE TABLE `bull_seq` (
  `id` int(11) NOT NULL,
  `classe` int(11) DEFAULT NULL,
  `pret` varchar(5) DEFAULT NULL,
  `sequence` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `bull_trim`
--

CREATE TABLE `bull_trim` (
  `id` int(11) NOT NULL,
  `classe` int(11) DEFAULT NULL,
  `pret` varchar(5) DEFAULT NULL,
  `trimestre` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `classe`
--

CREATE TABLE `classe` (
  `id` int(11) NOT NULL,
  `section` varchar(5) NOT NULL,
  `sous_section` varchar(5) NOT NULL,
  `nom_classe` varchar(100) NOT NULL,
  `code_classe` varchar(10) NOT NULL,
  `niveau_classe` int(2) NOT NULL,
  `etat_classe` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `classe_principale`
--

CREATE TABLE `classe_principale` (
  `id` int(11) NOT NULL,
  `prof` int(11) NOT NULL,
  `classe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `date_absences`
--

CREATE TABLE `date_absences` (
  `id` int(11) NOT NULL,
  `id_periode` int(11) NOT NULL,
  `open_date` date NOT NULL,
  `close_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `departement`
--

CREATE TABLE `departement` (
  `id` int(11) NOT NULL,
  `nom_court_fr` varchar(255) NOT NULL,
  `nom_court_en` varchar(255) NOT NULL,
  `libelle_departement_fr` varchar(255) NOT NULL,
  `libelle_departement_en` varchar(255) NOT NULL,
  `id_region` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `eleve`
--

CREATE TABLE `eleve` (
  `id` int(11) NOT NULL,
  `rne` int(11) NOT NULL,
  `nom_complet` varchar(255) NOT NULL,
  `sexe` varchar(1) NOT NULL,
  `date_naissance` date DEFAULT NULL,
  `lieu_naissance` varchar(255) DEFAULT NULL,
  `matricule` varchar(20) DEFAULT NULL,
  `classe` int(11) NOT NULL,
  `adresse_parent` varchar(255) NOT NULL,
  `statut` varchar(1) NOT NULL,
  `num_rand` int(11) DEFAULT NULL,
  `etat` varchar(15) NOT NULL,
  `nom_pere` varchar(255) DEFAULT NULL,
  `nom_mere` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `add_by` int(11) NOT NULL,
  `add_date` datetime DEFAULT NULL,
  `a_s` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `enseignant`
--

CREATE TABLE `enseignant` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `sexe` varchar(1) NOT NULL COMMENT 'Mr ou Mme',
  `poste` int(11) NOT NULL,
  `login` varchar(100) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `etat` varchar(20) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `groupe`
--

CREATE TABLE `groupe` (
  `id` int(11) NOT NULL,
  `nom_groupe` varchar(255) NOT NULL,
  `code_groupe` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `information`
--

CREATE TABLE `information` (
  `annee_scolaire` varchar(11) NOT NULL,
  `nom_pays_fr` varchar(255) NOT NULL,
  `nom_pays_en` varchar(255) NOT NULL,
  `nom_devise_fr` varchar(255) NOT NULL,
  `nom_devise_en` varchar(255) NOT NULL,
  `nom_ministere_fr` varchar(255) NOT NULL,
  `nom_ministere_en` varchar(255) NOT NULL,
  `region` int(11) NOT NULL,
  `departement` int(11) NOT NULL,
  `nom_etablissement_fr` varchar(255) NOT NULL,
  `nom_etablissement_en` varchar(255) NOT NULL,
  `type_ets` varchar(255) NOT NULL,
  `chef_ets` varchar(255) NOT NULL,
  `signataire_fr` varchar(255) NOT NULL,
  `signataire_en` varchar(255) NOT NULL,
  `arrondissement` varchar(255) NOT NULL,
  `ville` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `bp` varchar(255) NOT NULL,
  `sexe_signataire` varchar(5) NOT NULL,
  `contact` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `journal_connexion`
--

CREATE TABLE `journal_connexion` (
  `id` int(11) NOT NULL,
  `utilisateur` int(11) DEFAULT NULL,
  `adresse_ip` varchar(100) NOT NULL,
  `periode_de_connexion` datetime DEFAULT NULL,
  `navigateur` varchar(100) NOT NULL,
  `os` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `matiere`
--

CREATE TABLE `matiere` (
  `id` int(11) NOT NULL,
  `nom_matiere` varchar(100) DEFAULT NULL,
  `code_matiere` varchar(10) DEFAULT NULL,
  `etat` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `niveau_classe`
--

CREATE TABLE `niveau_classe` (
  `id` int(11) NOT NULL,
  `nom_niveau` varchar(100) NOT NULL,
  `code_niveau` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `note`
--

CREATE TABLE `note` (
  `id` int(11) NOT NULL,
  `id_eleve` int(11) DEFAULT NULL,
  `id_matiere` int(11) DEFAULT NULL,
  `id_classe` int(11) DEFAULT NULL,
  `id_periode` int(11) DEFAULT NULL,
  `note` decimal(4,2) DEFAULT NULL,
  `observation` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `note_saisie`
--

CREATE TABLE `note_saisie` (
  `id` int(11) NOT NULL,
  `id_classe` int(11) DEFAULT NULL,
  `id_enseignant` int(11) DEFAULT NULL,
  `id_matiere` int(11) DEFAULT NULL,
  `id_periode` int(11) DEFAULT NULL,
  `add_by` int(11) DEFAULT NULL,
  `competence` text,
  `date_saisie` datetime DEFAULT NULL,
  `date_modification` datetime DEFAULT NULL,
  `navigateur` varchar(100) DEFAULT NULL,
  `ip` varchar(100) DEFAULT NULL,
  `os` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `periode`
--

CREATE TABLE `periode` (
  `id` int(11) NOT NULL,
  `nom_periode` varchar(255) NOT NULL,
  `date_ouvert` date DEFAULT NULL,
  `date_fermet` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `poste`
--

CREATE TABLE `poste` (
  `id` int(11) NOT NULL,
  `code_poste` varchar(100) NOT NULL,
  `libelle_poste` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `prof_classe`
--

CREATE TABLE `prof_classe` (
  `id` int(11) NOT NULL,
  `id_prof` int(11) DEFAULT NULL,
  `id_classe` int(11) DEFAULT NULL,
  `id_matiere` int(11) DEFAULT NULL,
  `coef` decimal(2,1) DEFAULT NULL,
  `groupe` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `region`
--

CREATE TABLE `region` (
  `id` int(11) NOT NULL,
  `nom_court_fr` varchar(255) NOT NULL,
  `nom_court_en` varchar(255) NOT NULL,
  `libelle_region_fr` varchar(255) NOT NULL,
  `libelle_region_en` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `rubrique_classe`
--

CREATE TABLE `rubrique_classe` (
  `id` int(11) NOT NULL,
  `rubrique` int(11) DEFAULT NULL,
  `classe` int(11) DEFAULT NULL,
  `montant` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `rubrique_finance`
--

CREATE TABLE `rubrique_finance` (
  `id` int(11) NOT NULL,
  `nom_rubrique` text NOT NULL,
  `code_rubrique` text NOT NULL,
  `etat` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `rubrique_payement`
--

CREATE TABLE `rubrique_payement` (
  `id` int(11) NOT NULL,
  `id_eleve` int(11) DEFAULT NULL,
  `num_recu` int(11) DEFAULT NULL,
  `rubrique` int(11) DEFAULT NULL,
  `montant` int(11) DEFAULT NULL,
  `date_payement` date DEFAULT NULL,
  `date_enregistrement` datetime DEFAULT NULL,
  `agent` int(11) DEFAULT NULL,
  `observation` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `section`
--

CREATE TABLE `section` (
  `id` int(11) NOT NULL,
  `code_section` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `absence`
--
ALTER TABLE `absence`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `annee_scolaire`
--
ALTER TABLE `annee_scolaire`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `appreciation`
--
ALTER TABLE `appreciation`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `bull_annuel`
--
ALTER TABLE `bull_annuel`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `bull_seq`
--
ALTER TABLE `bull_seq`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `bull_trim`
--
ALTER TABLE `bull_trim`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `classe`
--
ALTER TABLE `classe`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `classe_principale`
--
ALTER TABLE `classe_principale`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `date_absences`
--
ALTER TABLE `date_absences`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `departement`
--
ALTER TABLE `departement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_region` (`id_region`);

--
-- Index pour la table `eleve`
--
ALTER TABLE `eleve`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `enseignant`
--
ALTER TABLE `enseignant`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `groupe`
--
ALTER TABLE `groupe`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `journal_connexion`
--
ALTER TABLE `journal_connexion`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `matiere`
--
ALTER TABLE `matiere`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `niveau_classe`
--
ALTER TABLE `niveau_classe`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `note_saisie`
--
ALTER TABLE `note_saisie`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `periode`
--
ALTER TABLE `periode`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `poste`
--
ALTER TABLE `poste`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `prof_classe`
--
ALTER TABLE `prof_classe`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `region`
--
ALTER TABLE `region`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `rubrique_classe`
--
ALTER TABLE `rubrique_classe`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `rubrique_finance`
--
ALTER TABLE `rubrique_finance`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `rubrique_payement`
--
ALTER TABLE `rubrique_payement`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `absence`
--
ALTER TABLE `absence`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `annee_scolaire`
--
ALTER TABLE `annee_scolaire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `appreciation`
--
ALTER TABLE `appreciation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `bull_annuel`
--
ALTER TABLE `bull_annuel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `bull_seq`
--
ALTER TABLE `bull_seq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `bull_trim`
--
ALTER TABLE `bull_trim`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `classe`
--
ALTER TABLE `classe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `classe_principale`
--
ALTER TABLE `classe_principale`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `date_absences`
--
ALTER TABLE `date_absences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `departement`
--
ALTER TABLE `departement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
--
-- AUTO_INCREMENT pour la table `eleve`
--
ALTER TABLE `eleve`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `enseignant`
--
ALTER TABLE `enseignant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `groupe`
--
ALTER TABLE `groupe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `journal_connexion`
--
ALTER TABLE `journal_connexion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `matiere`
--
ALTER TABLE `matiere`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `niveau_classe`
--
ALTER TABLE `niveau_classe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT pour la table `note`
--
ALTER TABLE `note`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `note_saisie`
--
ALTER TABLE `note_saisie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `periode`
--
ALTER TABLE `periode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `poste`
--
ALTER TABLE `poste`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `prof_classe`
--
ALTER TABLE `prof_classe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `region`
--
ALTER TABLE `region`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT pour la table `rubrique_classe`
--
ALTER TABLE `rubrique_classe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `rubrique_finance`
--
ALTER TABLE `rubrique_finance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `rubrique_payement`
--
ALTER TABLE `rubrique_payement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `section`
--
ALTER TABLE `section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `departement`
--
ALTER TABLE `departement`
  ADD CONSTRAINT `departement_ibfk_1` FOREIGN KEY (`id_region`) REFERENCES `region` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
