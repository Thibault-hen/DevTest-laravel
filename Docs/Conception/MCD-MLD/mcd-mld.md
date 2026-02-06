# Conception MCD-MLD

## MCD

![image mcd](./MCD.svg)

## MLD

![image mcd](./MLD.excalidraw.png)

### mocodo

```
POSSEDE1, 11 NOTE, 0N QUIZ
THEME: num_theme, titre
POSSEDE, 0N QUIZ, 0N THEME
POSSEDE3, 11 QUIZ, 0N DIFFICULTE
DIFFICULTE: num_difficulte, niveau, couleur
:
:

NOTE: num_avis, commentaire, note
CREER, 11 QUIZ, 0N UTILISATEUR
QUIZ: num_quiz, titre, identification_lien, description, durée_minutes, lien_image, est_publié
POSSEDE9, 11 QUIZ, 0N CATEGORIE
CATEGORIE: num_cat, titre
:
:

CREER2, 11 NOTE, 0N UTILISATEUR
UTILISATEUR: num_utilisateur, nom, prenom, email, mot de passe, est_admin, email_vérifié_a
POSSEDE5, 0N QUIZ, 11 RESULTAT
APPARTIENT, 0N QUIZ, 11 QUESTION
QUESTION: num_question, description, durée_secondes, est_multiple
POSSEDE2, 0N QUESTION, 11 REPONSE
REPONSE: num_reponse, description, est_correct

SPECIALISATION: num_spe, nom
POSSEDE4, 11 UTILISATEUR, 0N SPECIALISATION
APPARTIENT2, 0N UTILISATEUR,  11 RESULTAT
RESULTAT: num_resultat, nombre_réponses_correctes score, durée_quiz, date creation
POSSEDE6, 1N RESULTAT, 11 RESULTAT_REPONSE_UTILISATEUR
RESULTAT_REPONSE_UTILISATEUR: num_reponse_utilisateur
POSSEDE8, 0N REPONSE, 11 RESULTAT_REPONSE_UTILISATEUR
```
