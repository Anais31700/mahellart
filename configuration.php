<?php

/* FICHIER DE CONFIGURATION DU SITE ! */

/* MISE EN PLACE DE LA SESSION */

session_start();

/* CONFIGURATION DE LA BASE DE DONNEES */
const DB_HOST = "localhost";
const DB_USER = "testeur";
const DB_PASSWORD = "Azerty1992@";
const DB_NAME = "testeur_mahellart";


const SECRETKEY = 'mysecretkey1234';

/* LISTE DES TABLES de LA BDD */

const T_USERS = "users";
const T_REALISATIONS = "realisations";
const T_THEMES = "themes";
const T_CONTACTS = "contacts";
