# 📋 Cahier des Charges - IT Inventory

## 1. Vue d'ensemble

**IT Inventory** est un système de gestion de parc informatique permettant de suivre, gérer et maintenir l'inventaire des équipements informatiques d'une organisation.

### Objectifs principaux
- Centraliser la gestion du parc informatique
- Suivre les affectations d'équipements aux employés
- Gérer les maintenances et pannes
- Fournir une vue d'ensemble via un dashboard
- Assurer la traçabilité complète des équipements

---

## 2. Rôles et Permissions

### Super Administrateur
- Accès complet à toutes les fonctionnalités
- Gestion des départements
- Gestion des catégories d'équipements
- Gestion des comptes techniciens
- Toutes les fonctionnalités du technicien

### Technicien
- Gestion des équipements (CRUD)
- Gestion des employés (CRUD)
- Création et gestion des affectations
- Signalement et suivi des maintenances
- Consultation du dashboard
- Gestion de son profil

---

## 3. Modules Fonctionnels

### 3.1 Authentification
- Connexion / Déconnexion
- Récupération de mot de passe
- Vérification d'email (optionnelle)
- Inscription publique désactivée (création par admin uniquement)

### 3.2 Gestion des Équipements
**Fonctionnalités :**
- Création, modification, suppression d'équipements
- Upload d'images pour chaque équipement
- Gestion des statuts : Disponible, Affecté, En Panne, Rebut
- Suivi des garanties avec calcul automatique de l'expiration
- Recherche par numéro de série, modèle, nom
- Filtrage par catégorie et statut
- Affichage détaillé avec historique des affectations et maintenances

**Informations stockées :**
- Nom, marque, modèle
- Numéro de série (unique)
- Catégorie
- Date d'achat
- Durée de garantie (en mois)
- Date d'expiration de garantie (calculée automatiquement)
- Image
- Détails additionnels (JSON)

### 3.3 Gestion des Employés
**Fonctionnalités :**
- Création, modification, suppression d'employés
- Association à un département
- Affichage des affectations actuelles et historiques
- Recherche par nom, prénom, email
- Filtrage par département

**Informations stockées :**
- Prénom, nom
- Email
- Téléphone
- Département

### 3.4 Affectations
**Fonctionnalités :**
- Affecter un équipement disponible à un employé
- Retour d'équipement (check-in)
- Historique complet des affectations
- Mise à jour automatique du statut de l'équipement
- Notes sur les affectations

**Règles métier :**
- Seuls les équipements "Disponibles" peuvent être affectés
- Lors d'une affectation, le statut passe automatiquement à "Affecté"
- Lors d'un retour, le statut repasse à "Disponible"
- Traçabilité de l'utilisateur ayant effectué l'affectation

### 3.5 Maintenances
**Fonctionnalités :**
- Signalement de pannes
- Suivi des statuts : Ouvert, En Cours, Résolu
- Enregistrement des coûts de maintenance (en DH)
- Dates de signalement et de résolution
- Description détaillée du problème
- Mise à jour automatique du statut de l'équipement si nécessaire

**Règles métier :**
- Lorsqu'une maintenance est signalée, l'équipement peut passer en "En Panne"
- Traçabilité de l'utilisateur ayant signalé la maintenance
- Coûts enregistrés uniquement pour les maintenances résolues

### 3.6 Départements (Super Admin uniquement)
**Fonctionnalités :**
- Création, modification, suppression de départements
- Description des départements
- Affichage du nombre d'employés par département
- Protection contre la suppression si des employés sont associés

### 3.7 Catégories (Super Admin uniquement)
**Fonctionnalités :**
- Création, modification, suppression de catégories
- Types : Hardware ou Accessoire
- Description des catégories
- Affichage du nombre d'équipements par catégorie
- Protection contre la suppression si des équipements sont associés

### 3.8 Gestion des Utilisateurs (Super Admin uniquement)
**Fonctionnalités :**
- Création de comptes techniciens uniquement
- Modification des informations des techniciens
- Suppression de techniciens
- Recherche par nom, prénom, email
- Affichage des statistiques (nombre d'affectations, maintenances signalées)

### 3.9 Dashboard
**Fonctionnalités :**
- KPIs principaux :
  - Total d'équipements
  - Équipements disponibles
  - Équipements affectés
  - Équipements en panne
- Alertes garanties expirant dans moins de 30 jours
- Activités récentes (dernières affectations)
- Maintenances actives (ouvertes ou en cours)

### 3.10 Profil Utilisateur
**Fonctionnalités :**
- Consultation et modification des informations personnelles
- Modification du mot de passe
- Suppression du compte (avec confirmation)

---

## 4. Exigences Techniques

### 4.1 Technologies
- **Framework** : Laravel 12
- **Langage** : PHP 8.2+
- **Base de données** : MySQL
- **Frontend** : Blade Templates, Tailwind CSS, Alpine.js
- **Authentification** : Laravel Breeze

### 4.2 Fonctionnalités Frontend
- Design responsive (mobile, tablette, desktop)
- Mode sombre avec persistance
- Interface moderne et intuitive
- Composants réutilisables
- Pagination sur toutes les listes
- Recherche et filtres avancés

### 4.3 Performance
- Pagination (15 éléments par page)
- Eager loading pour éviter les requêtes N+1
- Optimisation des requêtes de base de données

### 4.4 Sécurité
- Hashage des mots de passe (bcrypt)
- Protection CSRF sur tous les formulaires
- Validation des données avec Form Requests
- Middleware d'authentification
- Protection contre les injections SQL (Eloquent ORM)
- Gestion des permissions par rôle

---

## 5. Structure de Données

### 5.1 Entités Principales

**Users** (Utilisateurs)
- Super Admin / Technicien
- Informations personnelles (nom, prénom, email, téléphone)

**Departments** (Départements)
- Nom, description

**Categories** (Catégories)
- Nom, type (Hardware/Accessoire), description

**Employees** (Employés)
- Prénom, nom, email, téléphone
- Lien vers département

**Equipments** (Équipements)
- Informations techniques (nom, marque, modèle, numéro de série)
- Statut, catégorie
- Informations de garantie
- Image, détails additionnels

**Assignments** (Affectations)
- Lien équipement → employé
- Dates d'affectation et de retour
- Utilisateur ayant effectué l'affectation
- Notes

**Maintenances** (Maintenances)
- Lien vers équipement
- Description, statut
- Coûts, dates
- Utilisateur ayant signalé

### 5.2 Relations
- Un département a plusieurs employés
- Une catégorie a plusieurs équipements
- Un employé appartient à un département
- Un équipement appartient à une catégorie
- Un équipement peut avoir plusieurs affectations (historique)
- Un équipement peut avoir plusieurs maintenances
- Un utilisateur peut effectuer plusieurs affectations
- Un utilisateur peut signaler plusieurs maintenances

---

## 6. Interface Utilisateur

### 6.1 Navigation
- Menu principal avec accès rapide aux modules
- Menu déroulant "Gestion" (Affectations, Maintenances)
- Menu déroulant "Administration" (Super Admin uniquement)
- Menu utilisateur avec profil et déconnexion
- Toggle mode sombre

### 6.2 Pages Principales
- **Page d'accueil** : Présentation du système
- **Dashboard** : Vue d'ensemble avec KPIs
- **Listes** : Équipements, Employés, Maintenances, etc.
- **Détails** : Fiche complète de chaque élément
- **Formulaires** : Création et édition
- **Profil** : Gestion du compte utilisateur

### 6.3 Composants Réutilisables
- En-têtes de page
- Cartes d'information
- Boutons (primaire, secondaire, danger)
- Tableaux avec actions
- Badges de statut
- Alertes de notification
- Modales de confirmation

---

## 7. Règles Métier

### 7.1 Équipements
- Le numéro de série doit être unique
- Le statut change automatiquement lors des affectations/retours
- La date d'expiration de garantie est calculée automatiquement
- Un équipement ne peut être affecté que s'il est "Disponible"

### 7.2 Affectations
- Un équipement ne peut avoir qu'une seule affectation active à la fois
- Le retour d'un équipement libère son statut
- Traçabilité complète de qui a fait quoi et quand

### 7.3 Maintenances
- Une maintenance peut être signalée pour n'importe quel équipement
- Les coûts ne sont enregistrés que pour les maintenances résolues
- Le statut de l'équipement peut être mis à jour lors du signalement

### 7.4 Suppressions
- Impossible de supprimer un département s'il contient des employés
- Impossible de supprimer une catégorie s'il contient des équipements
- Impossible de supprimer son propre compte utilisateur

---

## 8. Données de Test

Le système inclut des seeders pour générer :
- 1 Super Admin (admin@example.com / password)
- 10 Techniciens
- 5 Départements
- Plusieurs catégories (Hardware et Accessoires)
- 30 Employés
- 50 Équipements
- Affectations et maintenances

---

## 9. Contraintes

### 9.1 Techniques
- PHP 8.2+ requis
- MySQL pour la base de données
- Node.js et npm pour les assets frontend
- Composer pour les dépendances PHP

### 9.2 Fonctionnelles
- L'inscription publique est désactivée
- Seuls les super admins peuvent créer des comptes
- Les techniciens ne peuvent créer que des comptes techniciens
- Les équipements doivent avoir un numéro de série unique

---

## 10. Évolutions Possibles

- Export de données (Excel, PDF)
- Notifications par email
- Historique détaillé des modifications
- Gestion des fournisseurs
- Gestion des commandes
- Rapports avancés
- Application mobile

---

## 11. Livrables

- Code source complet
- Base de données avec migrations
- Documentation technique (GUIDE_PROJET.html)
- README avec instructions d'installation
- Tests unitaires et fonctionnels
- Données de test (seeders)

---

