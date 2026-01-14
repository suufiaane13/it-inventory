# 📦 IT Inventory - Système de Gestion de Parc Informatique

[![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)

Système complet de gestion et de traçabilité de parc informatique développé avec Laravel 12. Gérez vos équipements, employés, affectations et maintenances en toute simplicité.

## ✨ Fonctionnalités

- 🔐 **Authentification complète** avec Laravel Breeze
- 👥 **Gestion des utilisateurs** avec rôles (Super Admin / Technicien)
- 💻 **Gestion des équipements** avec upload d'images, statuts et garanties
- 👨‍💼 **Gestion des employés** et départements
- 📦 **Affectations** d'équipements avec historique complet
- 🔧 **Maintenances** avec suivi des coûts et statuts
- 📊 **Dashboard** avec KPIs et alertes
- 🌙 **Mode sombre** avec persistance
- 📱 **Design responsive** avec Tailwind CSS

## 🛠️ Technologies

- **Backend**: Laravel 12, PHP 8.2+
- **Frontend**: Blade Templates, Tailwind CSS, Alpine.js
- **Base de données**: MySQL
- **Authentification**: Laravel Breeze

## 🚀 Installation

### 1. Cloner le dépôt

### 2. Installer les dépendances PHP

```bash
composer install
```

### 3. Configuration de l'environnement

Créez un fichier `.env` à partir de `.env.example` :

```bash
cp .env.example .env
```

Éditez le fichier `.env` et configurez :

```env
APP_NAME="IT Inventory"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

# Base de données MySQL

# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=it_inventory
# DB_USERNAME=root
# DB_PASSWORD=
```

### 4. Générer la clé d'application

```bash
php artisan key:generate
```

### 5. Exécuter les migrations

```bash
php artisan migrate
```

### 6. Remplir la base de données avec des données de test

```bash
php artisan db:seed
```

Cela créera :
- 1 Super Admin (email: `admin@example.com`, password: `password`)
- 10 Techniciens
- 5 Départements
- Plusieurs catégories
- 30 Employés
- 50 Équipements
- Des affectations et maintenances

### 7. Installer les dépendances Node.js

```bash
npm install
```

### 8. Compiler les assets

```bash
npm run build
```

### 9. Créer le lien symbolique pour le stockage

```bash
php artisan storage:link
```
### 10. Démarrer le serveur de développement

Dans deux terminaux séparés, lancez :

```bash
php artisan serve
```
et dans un autre :
```bash
npm run dev
```

L'application sera accessible à l'adresse : **http://localhost:8000**

## 👤 Comptes par défaut

Après avoir exécuté les seeders, vous pouvez vous connecter avec :

**Super Admin :**
- Email: `admin@example.com`
- Password: `password`

**Technicien :**
- Utilisez n'importe quel compte technicien créé par le seeder
- Password: `password`

## 📁 Structure du Projet

```
it-inventory/
├── app/
│   ├── Http/
│   │   ├── Controllers/      # Contrôleurs (CRUD)
│   │   ├── Middleware/       # Middleware personnalisés
│   │   └── Requests/         # Form Requests (validation)
│   ├── Models/               # Modèles Eloquent
│   ├── View/Components/       # Composants Blade
│   └── Providers/            # Service Providers
├── database/
│   ├── migrations/           # Migrations de la base de données
│   └── seeders/              # Seeders pour données de test
├── resources/
│   ├── views/                # Templates Blade
│   ├── css/                  # Styles Tailwind
│   └── js/                   # JavaScript/Alpine.js
├── routes/
│   ├── web.php               # Routes web principales
│   └── auth.php              # Routes d'authentification
└── public/                   # Fichiers publics
```

## 🎯 Utilisation

### Accès à l'application

1. Ouvrez votre navigateur et allez sur `http://localhost:8000`
2. Cliquez sur **Connexion**
3. Connectez-vous avec les identifiants du Super Admin

### Rôles et Permissions

**Super Admin** peut :
- Gérer les départements
- Gérer les catégories
- Gérer les techniciens
- Accéder à toutes les fonctionnalités

**Technicien** peut :
- Gérer les équipements
- Gérer les employés
- Créer des affectations
- Gérer les maintenances
- Voir le dashboard

### Commandes utiles

```bash
# Démarrer le serveur de développement
php artisan serve

# Compiler les assets en mode développement (avec hot reload)
npm run dev

# Compiler les assets pour la production
npm run build

# Exécuter les migrations
php artisan migrate

# Exécuter les seeders
php artisan db:seed

# Réinitialiser la base de données
php artisan migrate:fresh --seed

# Vider le cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Créer un nouveau contrôleur
php artisan make:controller NomController

# Créer une nouvelle migration
php artisan make:migration nom_de_la_migration
```

## 🧪 Tests

```bash
# Exécuter tous les tests
php artisan test
```

## 🔒 Sécurité

- Les mots de passe sont hashés avec bcrypt
- Protection CSRF sur tous les formulaires
- Validation des données avec Form Requests
- Middleware d'authentification sur les routes protégées
- Protection contre les injections SQL avec Eloquent ORM

## 🌙 Mode Sombre

L'application inclut un mode sombre complet :
- Toggle dans la navigation
- Persistance de la préférence dans le localStorage
- Détection automatique de la préférence système
- Support complet sur toutes les pages

