<?php

// Configuration de la base de données en local
const DB_HOST = '127.0.0.1';
const DB_NAME = 'congo_explorer_hub';
const DB_USER = 'root';
const DB_PASS = '';
const DB_CHARSET = 'utf8mb4';

// Configuration de la base de données en Ligne
// const DB_HOST = '127.0.0.1';
// const DB_NAME = 'congo2849127';
// const DB_USER = 'congo2849127';
// const DB_PASS = 'wiuggsjv4s';
// const DB_CHARSET = 'utf8mb4';


// Chemin de base du projet (sous-dossier)
if (!defined('BASE_URL')) {
    $basePath = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
    $basePath = $basePath === '/' ? '/' : rtrim($basePath, '/') . '/';
    define('BASE_URL', $basePath);
}

// Paramètres MVC
const DEFAULT_CONTROLLER = 'Home';
const DEFAULT_METHOD = 'index';
