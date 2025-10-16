# Projet API for users Management and modules

Ce projet est l'API de **pour le management des users et pour leurs modules** permettant d'évaluer mes connaissances en **Laravel (PHP)**.

## Fonctionnalités

-   CRUD User
-   CRUD Modules

---

## Installation

Voici les étapes pour installer et lancer le projet en local :

### 1. Cloner le dépôt

```bash
git clone git@github.com:Juppe-styve/useful_api_juppe-styve.hagbe.git
cd useful_api_juppe-styve.hagbe
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
