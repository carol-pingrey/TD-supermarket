<?php
require_once __DIR__ . '/controllers/userController.php';
require_once __DIR__ . '/repositories/userRepository.php';
require_once __DIR__ . '/controllers/caisseController.php';
require_once __DIR__ . '/repositories/caisseRepository.php';
require_once __DIR__ . '/repositories/produitRepository.php';
require_once __DIR__ . '/repositories/achatRepository.php';
require_once __DIR__ . '/controllers/achatController.php';
require_once __DIR__ . '/controllers/produitController.php';

Flight::route('GET /', ['userController', 'showLogin']);
Flight::route('POST /login', ['userController', 'postLogin']);
Flight::route('POST /ChoixCaisse', ['caisseController', 'postCaisse']);
Flight::route('GET /ChoixAchat', ['achatController', 'getAchat']);
Flight::route('POST /ChoixAchat', ['achatController', 'postAchat']);
Flight::route('GET /clotureAchat', ['achatController', 'clotureAchat']);
Flight::route('GET /addProduit', ['produitController', 'getProduit']);
Flight::route('POST /addProduit', ['produitController', 'postProduit']);
Flight::route('GET /newProduit', ['produitController', 'getNewProduit']);
Flight::route('POST /newProduit', ['produitController', 'postNewProduit']);
Flight::route('GET /accueil', ['userController', 'showAccueil']);
Flight::route('GET /montant', ['caisseController', 'getMontant']);
Flight::route('POST /montant', ['caisseController', 'postMontant']);