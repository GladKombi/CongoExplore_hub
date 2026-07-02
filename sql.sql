CREATE DATABASE IF NOT EXISTS congo_explorer_hub DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE congo_explorer_hub;

-- =========================================================================
-- MODULE 4 : UTILISATEURS & ÉQUIPE
-- =========================================================================

CREATE TABLE IF NOT EXISTS utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE, -- nom-prenom@congoexplorerhub.com
    mot_de_passe VARCHAR(255) NOT NULL,
    role ENUM('Admin', 'Journaliste', 'Community Manager' ) NOT NULL DEFAULT 'Journaliste',
    supprimer int DEFAULT 0, -- 0 = actif, 1 = supprimé (soft delete)
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS profils_utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT UNIQUE NOT NULL,
    nom_complet VARCHAR(150) NOT NULL,
    biographie TEXT,
    secteur ENUM('Art', 'Tech', 'Entrepreneuriat', 'Culture', 'Autre') NOT NULL,
    liens_reseaux JSON NULL, -- Permet de stocker les liens (LinkedIn, Instagram, etc.) de manière flexible
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =========================================================================
-- MODULE 1 : GESTION DU CONTENU MÉDIA
-- =========================================================================

CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL UNIQUE,
    supprimer int DEFAULT 0, -- 0 = actif, 1 = supprimé (soft delete)
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS contenus (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    corps_text LONGTEXT,
    statut ENUM('Brouillon', 'Publie', 'Archive') NOT NULL DEFAULT 'Brouillon',
    vues INT DEFAULT 0,
    categorie_id INT NOT NULL,
    auteur_id INT NOT NULL,
    date_publication DATETIME NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    supprimer int DEFAULT 0 -- 0 = actif, 1 = supprimé (soft delete)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS media_galleries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contenu_id INT NOT NULL,
    type_media ENUM('Photo', 'Video', 'Interview', 'Reportage') NOT NULL,
    url_fichier VARCHAR(255) NOT NULL,
    supprimer int DEFAULT 0, -- 0 = actif, 1 = supprimé (soft delete)
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS commentaires (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contenu_id INT NOT NULL,
    ip_address varchar(45) DEFAULT NULL,
    commentaire TEXT NOT NULL,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    supprimer int DEFAULT 0 -- 0 = actif, 1 = supprimé (soft delete)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS likes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contenu_id INT NOT NULL,
    ip_address varchar(45) DEFAULT NULL,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    supprimer int DEFAULT 0 -- 0 = actif, 1 = supprimé (soft delete)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS partages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contenu_id INT NOT NULL,
    plateforme ENUM('Facebook', 'Twitter', 'LinkedIn', 'WhatsApp', 'Email') NOT NULL,
    ip_address varchar(45) DEFAULT NULL,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    supprimer int DEFAULT 0 -- 0 = actif, 1 = supprimé (soft delete)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS favoris (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contenu_id INT NOT NULL,
    ip_address varchar(45) DEFAULT NULL,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    supprimer int DEFAULT 0 -- 0 = actif, 1 = supprimé (soft delete)
) ENGINE=InnoDB;

-- =========================================================================
-- MODULE 3 : CLIENTS, PROJETS & MARKETING
-- =========================================================================

CREATE TABLE IF NOT EXISTS clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom_entreprise VARCHAR(150) NOT NULL,
    secteur_activite VARCHAR(100),
    email_contact VARCHAR(150) NOT NULL,
    telephone VARCHAR(50),
    adresse TEXT,
    supprimer int DEFAULT 0, -- 0 = actif, 1 = supprimé (soft delete)
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS projets_marketing (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    type_campagne ENUM('Digital', 'Physique', 'Influence', 'Street Marketing', '360') NOT NULL,
    budget DECIMAL(10, 2) DEFAULT 0.00,
    date_debut DATE,
    date_fin DATE,
    statut ENUM('En attente', 'En cours', 'Termine', 'Annule') NOT NULL DEFAULT 'En attente',
    client_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    supprimer int DEFAULT 0 -- 0 = actif, 1 = supprimé (soft delete)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS livrables (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    description TEXT,
    date_echeance DATE NOT NULL,
    statut ENUM('A faire', 'En cours', 'Valide', 'Bloque') NOT NULL DEFAULT 'A faire',
    projet_id INT NOT NULL,
    supprimer int DEFAULT 0 -- 0 = actif, 1 = supprimé (soft delete)    
) ENGINE=InnoDB;

-- =========================================================================
-- MODULE 2 : ÉVÉNEMENTS & COUVERTURE (LIVE COVERAGE)
-- =========================================================================

CREATE TABLE IF NOT EXISTS evenements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    description TEXT,
    date_debut DATETIME NOT NULL,
    date_fin DATETIME NOT NULL,
    lieu VARCHAR(255) NOT NULL, -- Ex: "En ligne / Goma / Kinshasa"
    type_evenement ENUM('Interne', 'Client') NOT NULL DEFAULT 'Interne',
    client_id INT NULL, -- Si l'événement est organisé pour le compte d'un client
    supprimer int DEFAULT 0, -- 0 = actif, 1 = supprimé (soft delete)
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS media_evenements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    evenement_id INT NOT NULL,
    type_media ENUM('Photo', 'Video', 'Interview', 'Reportage') NOT NULL,
    url_fichier VARCHAR(255) NOT NULL,
    supprimer int DEFAULT 0, -- 0 = actif, 1 = supprimé (soft delete)
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

