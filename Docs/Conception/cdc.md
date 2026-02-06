# Web APP DevTest

## 1. Objectif du projet

Développer une application web de quiz en ligne dédiée à l’évaluation des connaissances en programmation et développement.
L’application permettra aux utilisateurs de s’authentifier, de sélectionner des thématiques techniques (JavaScript, SQL, HTML, etc.) et de répondre à des questionnaires.
Un espace administrateur offrira la possibilité de gérer les utilisateurs,les thèmes, les questionnaires, les questions et de consulter les résultats

## 2. Fonctionnalités principales

2.1. Utilisateur

Inscription et connexion : Création de compte avec validation email

Participation aux questionnaires : Questions à choix multiples par thèmes (une ou plusieurs réponses correctes).

Profil utilisateur : Historique des quiz et scores / gestion du compte

2.2. Administrateur

Visualisation des statistiques : Graphiques résultat quiz/moyenne/catégorie

Gestion des utilisateurs : Visualisation, modification, suppression

Gestion des contenus : Ajout, modification, suppression de thèmes, quiz, questions et réponses

## 3. Technologies

Frontend : VueJS - tailwind

Backend : PHP - Laravel

Bibliothèques UI: Shadcn-vue

BDD: PostgreSQL

## 4. Spécifications techniques

Architecture : Monolithe SSR Laravel & Inertia VueJS

### MVP

- Authentification (Inscription, Connexion, Déconnexion)
- Visualisation des quiz par thème
- Participation aux quiz (QCM)
- Résultats détaillés à la fin de chaque quiz
- Système de calcul de score basé sur les réponses correctes et temps écoulé
- Système de commentaires et évaluation pour les quiz
- Espace administrateur pour la gestion des quiz, thèmes, catégories, difficultés, résultats et utilisateurs

### Fonctionnalités futures

- Classement des utilisateurs sur un leaderboard
- Système de notifications pour les nouveaux quiz et résultats
- Gestion avancée des utilisateurs (rôles, permissions)
- Espace utilisateur avec statistiques personnelles
- Espace administrateur avec statistiques globales et export des données
