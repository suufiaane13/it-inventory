📑 PRD : Système de Gestion de Parc Informatique (IT Asset Manager)
1. Vision du Projet
Développer une application web centralisée permettant au service informatique de gérer l'inventaire matériel, de suivre les affectations aux employés et de monitorer les pannes. Objectif pédagogique : Maîtriser les relations Eloquent avancées, les composants Blade, et l'intégration UI avec Tailwind CSS.

2. Acteurs (Utilisateurs)
Super Admin : Accès total. Peut gérer les comptes des autres utilisateurs (techniciens).

Technicien IT (Utilisateur principal) :

Gère le stock (Entrées/Sorties).

Affecte le matériel aux employés.

Gère les tickets de maintenance.

3. Spécifications Fonctionnelles (Scope)
A. Tableau de Bord (Dashboard)
Une vue d'ensemble claire dès la connexion.

KPIs (Indicateurs clés) : Total équipements, Matériel en stock, Matériel affecté, Matériel en panne.

Liste des dernières activités : "Ordinateur Dell assigné à Jean Dupont il y a 2h".

Alertes visuelles : Liste des garanties expirant dans < 30 jours (Badge rouge Tailwind).

B. Gestion des Stocks (Inventaire)
CRUD Équipements : Ajout avec upload d'image (Photo du matériel).

Champs obligatoires : Nom, Marque, Modèle, Numéro de Série (Unique), Date d'achat, Durée garantie.

Statuts dynamiques :

🟢 Disponible (En stock)

🔵 Affecté (Chez un employé)

🔴 En Panne (En maintenance)

⚫ Rebut (Hors service)

Recherche & Filtres : Barre de recherche par numéro de série ou modèle. Filtre par Catégorie (PC, Écran, Souris).

C. Gestion des Employés & Affectations (Cœur du projet)
Annuaire Employés : Liste simple (Nom, Email, Département).

Workflow d'Affectation (Check-out) :

Formulaire : Sélectionner un matériel "Disponible" -> Sélectionner un Employé -> Valider.

Action Backend : Le statut du matériel passe à "Affecté". Une entrée est créée dans l'historique.

Workflow de Restitution (Check-in) :

Bouton "Restituer" sur la fiche d'un matériel.

Action Backend : Le statut repasse à "Disponible". La date de retour est enregistrée dans l'historique.

Historique : Sur la fiche d'un ordinateur, voir la liste : Utilisé par Alice (Jan-Mars), puis par Bob (Avril-Juin).

D. Module Maintenance
Signaler une panne sur un matériel.

Changer l'état de la maintenance : Ouvert -> En cours -> Résolu.

Historique des réparations (coût, description de la panne).

4. Spécifications Techniques
Backend (Laravel)
Framework : Laravel 10 ou 11.

Authentification : Laravel Breeze (Version Blade). C'est le starter kit parfait car il installe déjà Tailwind CSS.

Base de données : MySQL.

ORM : Eloquent (Utilisation des Accessors/Mutators pour formater les dates/prix).

Frontend (Blade + Tailwind)
Moteur de template : Blade.

CSS Framework : Tailwind CSS (Utilitaire-first).

Composants Blade (x-components) : Tu devras créer des composants réutilisables pour garder ton code propre :

<x-button-primary>

<x-table-layout>

<x-status-badge status="available" /> (Change de couleur selon le statut).

<x-alert> (Pour les messages de succès/erreur).

Interactivité légère : Alpine.js (souvent inclus avec Breeze) pour gérer les menus déroulants (dropdowns) et les fenêtres modales (ex: confirmation de suppression) sans écrire de JavaScript complexe.

5. Modèle de Données (Schéma DB)
Voici la structure recommandée pour gérer la logique "Intermédiaire" :

users : Les techniciens qui se connectent.

categories : id, name, type (ex: Hardware, Accessoire).

employees : id, first_name, last_name, email, department_id.

equipments :

id

serial_number (unique)

category_id (FK)

status (enum: available, assigned, broken)

details (text/json)

assignments (Table Pivot / Historique) :

id

equipment_id (FK)

employee_id (FK)

user_id (Qui a fait l'action ? FK vers la table users)

assigned_at (datetime)

returned_at (datetime, nullable - Si null, c'est que l'employé l'a encore)

notes

maintenances : id, equipment_id, description, cost, status.