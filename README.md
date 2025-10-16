# YOWL API – Projet Laravel

Ce projet est l'API de **la communauté YOWL** permettant de centraliser les commentaires d'internet dans la communauté**YOWL**. Il a été développé avec **Laravel (PHP)**.

## Fonctionnalités

-   CRUD User
-   CRUD Post
-   CRUD commentaire

---

## Installation

Voici les étapes pour installer et lancer le projet en local :

### 1. Cloner le dépôt

```bash
git clone git@github.com:Juppe-styve/YOWL-API.git
cd YOWL-API
```

### 2. Installer les dépendances

```bash
composer install
```

### 3. Configurer

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Lancer la migration

```bash
php artisan migrate --seed
```

### 5. Lancer le server local

```bash
php artisan serve
```
