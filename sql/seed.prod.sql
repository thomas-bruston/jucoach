-- ============================================================
-- JU COACH SPORTIF — Données d'initialisation PRODUCTION
-- ============================================================
-- Contrairement à seed.sql (dev), ce fichier ne contient AUCUNE
-- donnée de test : pas de comptes utilisateurs (admin compris),
-- pas de questionnaire/commande/contact factices.
--
-- Le compte administrateur doit être créé après déploiement via :
--   docker compose -f docker-compose.prod.yml exec app php bin/create-admin.php
-- ============================================================

USE ju_coach;

SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;

-- ------------------------------------------------------------
-- Rôles
-- ------------------------------------------------------------

INSERT INTO role (id, libelle) VALUES
    (1, 'utilisateur'),
    (2, 'administrateur');

-- ------------------------------------------------------------
-- Programmes (catalogue réel)
-- ------------------------------------------------------------

INSERT INTO programme (id, type, titre, description, objectifs, inclut, tarifs, prix) VALUES
(
    1, 'domicile_salle', 'Programme à Domicile ou en Salle',
    'Programme mensuel 100% personnalisé, adapté à l''objectif, au niveau et à l''environnement.',
    'Perte de poids\nPrise de masse\nRemise en forme\nCourse à pied / cardio',
    'Programme d''entraînement personnalisé\nSuivi hebdomadaire via WhatsApp\nAjustements selon les résultats\nConseils nutritionnels',
    '50€ le premier mois\n40€ / mois en cas de prolongation',
    50.00
),
(
    2, 'nutritionnel', 'Suivi Nutritionnel',
    'Accompagnement personnalisé pour améliorer l''alimentation selon l''objectif.',
    'Perte de poids\nPrise de masse\nRemise en forme',
    'Plan nutritionnel personnalisé\nSuivi via WhatsApp\nAjustements en fonction des résultats\nConseils adaptés au mode de vie',
    '1 mois : 70€\n3 mois : 180€',
    70.00
),
(
    3, 'pack', 'Pack Sport + Nutrition',
    'Accompagnement complet combinant entraînement et alimentation pour des résultats optimisés.',
    'Renforcement musculaire / cardio\nPerfectionnement technique\nOrganisation des entraînements\nConseils diététiques',
    'Programme sportif personnalisé\nPlan nutritionnel personnalisé\nSuivi WhatsApp\nAjustements réguliers',
    '1 mois : 100€',
    100.00
),
(
    4, 'transformation', 'Transformation 3 Mois',
    'Programme complet sur 3 mois pour une transformation physique durable.',
    'Renforcement musculaire / cardio\nPerfectionnement technique\nOrganisation des entraînements\nConseils diététiques',
    'Programme sportif personnalisé (évolutif)\nPlan nutritionnel personnalisé\nSuivi WhatsApp hebdomadaire\nAjustements réguliers\nAccompagnement global',
    '210€ les 3 mois',
    210.00
),
(
    5, 'visio', 'Coaching Visio (45 minutes)',
    'Séance en direct avec accompagnement personnalisé.',
    'Renforcement musculaire / cardio\nPilates\nPerfectionnement technique\nOrganisation des entraînements\nConseils diététiques',
    NULL,
    '1 personne : 25€\n2 personnes : 35€\n10 séances (1 personne) : 200€\n10 séances (2 personnes) : 300€',
    25.00
),
(
    6, 'complet', 'Coaching Complet (Suivi + Visio)',
    'Accompagnement mensuel avec suivi + séances en direct.',
    'Renforcement musculaire / cardio\nPilates\nPerfectionnement technique\nOrganisation des entraînements\nConseils diététiques',
    'Programme personnalisé\nPlan nutritionnel\nSuivi WhatsApp\n4 séances en visio (1/semaine)',
    '140€ / mois',
    140.00
),
(
    7, 'intensif', 'Suivi Intensif Premium',
    'Accompagnement renforcé pour des résultats rapides et un suivi poussé.',
    'Renforcement musculaire / cardio\nPilates\nPerfectionnement technique\nOrganisation des entraînements\nConseils diététiques',
    'Programme personnalisé\nPlan nutritionnel\nSuivi WhatsApp prioritaire\nAjustements plusieurs fois par semaine\nFeedback régulier',
    '170€ / mois',
    170.00
);
