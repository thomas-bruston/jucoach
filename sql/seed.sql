-- ============================================================
-- JU COACH SPORTIF — Données d'initialisation et comptes de test
-- ============================================================
-- Exécution : automatique via Docker (02_seed.sql)
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
-- Comptes de test
-- Mots de passe hashés avec password_hash() / bcrypt
-- Mot de passe en clair pour les tests : Test12345!
-- ------------------------------------------------------------

INSERT INTO utilisateur (id, email, password, prenom, nom, telephone, adresse, statut, role_id) VALUES
(
    1,
    'ju@jucoachsportif.com',
    '$2y$10$NWpsQU6LnX9mtF5JBvECzu27ok2ZCfNeZCtP8VUNt3Tr/21b1.ZDq',
    'Julien',
    'Coach',
    '+261 32 00 00 00',
    'Nosy Be, Madagascar',
    'actif',
    2
),
(
    2,
    'client@test.com',
    '$2y$10$NWpsQU6LnX9mtF5JBvECzu27ok2ZCfNeZCtP8VUNt3Tr/21b1.ZDq',
    'Marie',
    'Dupont',
    '+33 6 12 34 56 78',
    '12 rue de la Paix, 75001 Paris',
    'actif',
    1
),
(
    3,
    'client2@test.com',
    '$2y$10$NWpsQU6LnX9mtF5JBvECzu27ok2ZCfNeZCtP8VUNt3Tr/21b1.ZDq',
    'Thomas',
    'Martin',
    '+33 6 98 76 54 32',
    NULL,
    'actif',
    1
);

-- ------------------------------------------------------------
-- Programmes
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

-- ------------------------------------------------------------
-- Questionnaire (client de test)
-- ------------------------------------------------------------

INSERT INTO questionnaire (
    utilisateur_id,
    age, genre, taille, poids,
    objectif_principal, objectif_description, objectif_delai, objectif_importance,
    condition_physique, pratique_sport, historique_sport,
    ressenti_corps, ressenti_corps_note, changement_prioritaire,
    blessures_douleurs, problemes_sante,
    qualite_sommeil, qualite_sommeil_description,
    niveau_stress, niveau_stress_description,
    activite_professionnelle, profession,
    alimentation, alimentation_note, hydratation_note,
    tendance_alimentaire, consommation_alcool,
    difficulte_alimentaire, regime_particulier, allergies,
    programme_structure_suivi, programme_ce_qui_fonctionne, programme_ce_qui_echoue,
    sentiment_blocage, blocage_raison, pratique_irreguliere,
    duree_seance, lieu_entrainement,
    niveau_motivation, accompagnement_serieux, changements_mode_vie, date_debut_souhaitee
) VALUES (
    2,
    28, 'femme', 165, 62.5,
    'remise_en_forme', 'Je souhaite retrouver de l''énergie et me sentir mieux dans mon corps.', '3 mois', 'Je me sens fatiguée et manque de confiance en moi.',
    5, 'oui', 'J''ai fait de la danse pendant 5 ans et du yoga occasionnellement.',
    'Je me sens bien mais manque d''endurance.', 6, 'Mon ventre et mes cuisses.',
    'Légère douleur au genou droit.', 'Aucun.',
    'moyenne', 'Je me réveille souvent la nuit.',
    6, 'Stress au travail principalement.',
    'sedentaire', 'Développeuse web',
    'moyenne', 5, 6,
    'grignoter', 'occasionnelle',
    'J''ai du mal à résister aux grignotages le soir.', 'non', NULL,
    'non', NULL, NULL,
    NULL, NULL, NULL,
    '45 minutes', 'domicile',
    7, 'oui', 'beaucoup', 'cette_semaine'
);

-- ------------------------------------------------------------
-- Commande de test
-- ------------------------------------------------------------

INSERT INTO commande (utilisateur_id, programme_id, montant) VALUES
(2, 1, 50.00);

-- ------------------------------------------------------------
-- Plan nutritionnel de test
-- ------------------------------------------------------------

INSERT INTO plan_nutritionnel (id, nom) VALUES
(1, 'Plan Prise de Masse - Marie Dupont - Janvier 2025');

INSERT INTO utilisateur_plan (utilisateur_id, plan_id, envoye) VALUES
(2, 1, 0);

-- ------------------------------------------------------------
-- Photos de galerie (placeholders)
-- ------------------------------------------------------------

INSERT INTO galerie_photo (fichier, legende, ordre) VALUES
('placeholder_1.jpg', 'Séance de coaching en salle',    1),
('placeholder_2.jpg', 'Entraînement fonctionnel',        2),
('placeholder_3.jpg', 'Coaching à Nosy Be, Madagascar', 3);

-- ------------------------------------------------------------
-- Vidéos YouTube
-- ------------------------------------------------------------

INSERT INTO galerie_video (url_youtube, titre, description) VALUES
(
    'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
    'Présentation du coach Ju',
    'Découvrez la philosophie et la méthode de coaching de Ju.'
),
(
    'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
    'Exercice du mois : Squat',
    'Technique et conseils pour bien réaliser le squat.'
);

-- ------------------------------------------------------------
-- Message de contact de test
-- ------------------------------------------------------------

INSERT INTO contact (nom, email, message, lu) VALUES
(
    'Jean Testeur',
    'jean@test.com',
    'Bonjour, je souhaiterais avoir plus d''informations sur le programme de musculation. Merci !',
    0
);
