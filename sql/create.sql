-- ============================================================
-- JU COACH SPORTIF — Création de la base de données
-- ============================================================
-- Exécution : automatique via Docker (01_create.sql)
-- Compte utilisé : root (init uniquement, jamais par l'app)
-- ============================================================

CREATE DATABASE IF NOT EXISTS ju_coach
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE ju_coach;

-- ------------------------------------------------------------
-- Utilisateurs MySQL avec droits restreints (CP5)
-- L'application n'utilise jamais le compte root
-- ------------------------------------------------------------

-- Compte applicatif (lecture + écriture)
CREATE USER IF NOT EXISTS 'app_user'@'%' IDENTIFIED BY 'app_user_password';
GRANT SELECT, INSERT, UPDATE, DELETE ON ju_coach.* TO 'app_user'@'%';

FLUSH PRIVILEGES;

-- ============================================================
-- TABLES
-- ============================================================

-- ------------------------------------------------------------
-- Rôles
-- ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS role (
    id      INT UNSIGNED    NOT NULL AUTO_INCREMENT,
    libelle VARCHAR(50)     NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uq_role_libelle (libelle)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Utilisateurs
-- ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS utilisateur (
    id         INT UNSIGNED    NOT NULL AUTO_INCREMENT,
    email      VARCHAR(255)    NOT NULL,
    password   VARCHAR(255)    NOT NULL,
    prenom     VARCHAR(100)    NOT NULL,
    nom        VARCHAR(100)    NOT NULL,
    telephone  VARCHAR(30)              DEFAULT NULL,
    adresse    TEXT                     DEFAULT NULL,
    statut     ENUM('actif','inactif')  NOT NULL DEFAULT 'actif',
    role_id    INT UNSIGNED    NOT NULL,
    created_at DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_utilisateur_email (email),
    CONSTRAINT fk_utilisateur_role
        FOREIGN KEY (role_id) REFERENCES role (id)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Réinitialisation de mot de passe
-- ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS password_reset (
    id             INT UNSIGNED NOT NULL AUTO_INCREMENT,
    utilisateur_id INT UNSIGNED NOT NULL,
    token          VARCHAR(64)  NOT NULL,
    expire_at      DATETIME     NOT NULL,
    utilise        TINYINT(1)   NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    UNIQUE KEY uq_password_reset_token (token),
    CONSTRAINT fk_password_reset_utilisateur
        FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)
        ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Programmes
-- ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS programme (
    id          INT UNSIGNED        NOT NULL AUTO_INCREMENT,
    type        ENUM('domicile_salle','nutritionnel','pack','transformation','visio','complet','intensif') NOT NULL,
    titre       VARCHAR(255)        NOT NULL,
    description TEXT                NOT NULL,
    objectifs   TEXT                         DEFAULT NULL,
    inclut      TEXT                         DEFAULT NULL,
    tarifs      TEXT                         DEFAULT NULL,
    prix        DECIMAL(8,2)        NOT NULL,
    created_at  DATETIME            NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Questionnaire sportif
-- ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS questionnaire (
    id                          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    utilisateur_id              INT UNSIGNED NOT NULL,

    -- Informations personnelles
    age                         TINYINT UNSIGNED          DEFAULT NULL,
    genre                       ENUM('homme','femme','non_binaire','autre','non_precise') DEFAULT NULL,
    taille                      SMALLINT UNSIGNED         DEFAULT NULL COMMENT 'en cm',
    poids                       DECIMAL(5,2)              DEFAULT NULL COMMENT 'en kg',

    -- Objectifs
    objectif_principal          ENUM('perte_de_poids','prise_de_masse','remise_en_forme','cardio_course') NOT NULL,
    objectif_description        TEXT                      DEFAULT NULL,
    objectif_delai              VARCHAR(255)              DEFAULT NULL,
    objectif_importance         TEXT                      DEFAULT NULL,

    -- Conditions physiques
    condition_physique          TINYINT UNSIGNED          DEFAULT NULL COMMENT 'de 1 à 10',
    pratique_sport              ENUM('oui','non')         DEFAULT NULL,
    historique_sport            TEXT                      DEFAULT NULL,
    ressenti_corps              TEXT                      DEFAULT NULL,
    ressenti_corps_note         TINYINT UNSIGNED          DEFAULT NULL COMMENT 'de 1 à 10',
    changement_prioritaire      TEXT                      DEFAULT NULL,
    blessures_douleurs          TEXT                      DEFAULT NULL,
    problemes_sante             TEXT                      DEFAULT NULL,
    qualite_sommeil             ENUM('mauvaise','moyenne','bonne') DEFAULT NULL,
    qualite_sommeil_description TEXT                      DEFAULT NULL,
    niveau_stress               TINYINT UNSIGNED          DEFAULT NULL COMMENT 'de 1 à 10',
    niveau_stress_description   TEXT                      DEFAULT NULL,
    activite_professionnelle    ENUM('sedentaire','active','physique') DEFAULT NULL,
    profession                  VARCHAR(255)              DEFAULT NULL,

    -- Nutrition
    alimentation                ENUM('saine','moyenne','mauvaise') DEFAULT NULL,
    alimentation_note           TINYINT UNSIGNED          DEFAULT NULL COMMENT 'de 1 à 10',
    hydratation_note            TINYINT UNSIGNED          DEFAULT NULL COMMENT 'de 1 à 10',
    tendance_alimentaire        ENUM('grignoter','manger_sucre','sauter_repas','manger_sur_le_pouce','aucune') DEFAULT NULL,
    consommation_alcool         ENUM('jamais','occasionnelle','reguliere') DEFAULT NULL,
    difficulte_alimentaire      TEXT                      DEFAULT NULL,
    regime_particulier          ENUM('oui','non')         DEFAULT NULL,
    allergies                   TEXT                      DEFAULT NULL,

    -- Entraînement
    programme_structure_suivi   ENUM('oui','non')         DEFAULT NULL,
    programme_ce_qui_fonctionne TEXT                      DEFAULT NULL,
    programme_ce_qui_echoue     TEXT                      DEFAULT NULL,
    sentiment_blocage           TEXT                      DEFAULT NULL,
    blocage_raison              TEXT                      DEFAULT NULL,
    pratique_irreguliere        TEXT                      DEFAULT NULL,
    duree_seance                VARCHAR(100)              DEFAULT NULL,
    lieu_entrainement           ENUM('salle','domicile','exterieur') DEFAULT NULL,
    niveau_motivation           TINYINT UNSIGNED          DEFAULT NULL COMMENT 'de 1 à 10',
    accompagnement_serieux      ENUM('oui','non')         DEFAULT NULL,
    changements_mode_vie        ENUM('non','un_peu','beaucoup','oui_tout_changer') DEFAULT NULL,
    date_debut_souhaitee        ENUM('immediatement','cette_semaine','ce_mois_ci','plus_tard') DEFAULT NULL,

    date_rempli                 DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    UNIQUE KEY uq_questionnaire_utilisateur (utilisateur_id),
    CONSTRAINT fk_questionnaire_utilisateur
        FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)
        ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Plans nutritionnels
-- ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS plan_nutritionnel (
    id            INT UNSIGNED NOT NULL AUTO_INCREMENT,
    nom           VARCHAR(255) NOT NULL,
    date_creation DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Association utilisateur <-> plan nutritionnel
-- ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS utilisateur_plan (
    utilisateur_id   INT UNSIGNED NOT NULL,
    plan_id          INT UNSIGNED NOT NULL,
    date_assignation DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    envoye           TINYINT(1)   NOT NULL DEFAULT 0,
    PRIMARY KEY (utilisateur_id, plan_id),
    CONSTRAINT fk_utilisateur_plan_utilisateur
        FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)
        ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_utilisateur_plan_plan
        FOREIGN KEY (plan_id) REFERENCES plan_nutritionnel (id)
        ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Commandes
-- ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS commande (
    id             INT UNSIGNED   NOT NULL AUTO_INCREMENT,
    utilisateur_id INT UNSIGNED   NOT NULL,
    programme_id   INT UNSIGNED   NOT NULL,
    date           DATETIME       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    montant        DECIMAL(8,2)   NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT fk_commande_utilisateur
        FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT fk_commande_programme
        FOREIGN KEY (programme_id) REFERENCES programme (id)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Galerie photos
-- ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS galerie_photo (
    id        INT UNSIGNED NOT NULL AUTO_INCREMENT,
    fichier   VARCHAR(255) NOT NULL,
    legende   VARCHAR(255)          DEFAULT NULL,
    ordre     INT UNSIGNED NOT NULL DEFAULT 0,
    date_ajout DATETIME   NOT NULL  DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Galerie vidéos YouTube
-- ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS galerie_video (
    id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    url_youtube VARCHAR(255) NOT NULL,
    titre       VARCHAR(255) NOT NULL,
    description TEXT                  DEFAULT NULL,
    ordre       INT UNSIGNED NOT NULL DEFAULT 0,
    date_ajout  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Messages de contact
-- ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS contact (
    id         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    nom        VARCHAR(100) NOT NULL,
    email      VARCHAR(255) NOT NULL,
    message    TEXT         NOT NULL,
    date_envoi DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    lu         TINYINT(1)   NOT NULL DEFAULT 0,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
