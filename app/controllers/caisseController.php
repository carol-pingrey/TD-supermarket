<?php
class caisseController {

     public static function getMontant() {
        $pdo  = Flight::db();

        Flight::render('auth/montant', [
            'results' => null,
            'filtre'  => null
        ]);
    }

    public static function postCaisse() {
        $pdo  = Flight::db();
        $r_caisse = new caisseRepository($pdo);
        $r_produit = new produitRepository($pdo);
        $r_achat = new achatRepository($pdo);

        $req = Flight::request();

        $id_caisse = $req->data->id_caisse;

        $caisse = $r_caisse->getById($id_caisse);

        $produits = $r_produit->getProduitsValides();

        $r_achat->createAchat($id_caisse, date('Y-m-d'));
        $achat = $r_achat->getLastAchat();

        if ($caisse) {
            session_start();
            unset($_SESSION['caisse']);

            $_SESSION['caisse'] = $caisse;
            $_SESSION['achat'] = $achat;
            Flight::render('auth/achat', [
                'produits' => $produits
            ]);
            return;
        }

        Flight::render('auth/accueil', [
        'values' => $caisse['values'],
        'errors' => $caisse['errors'],
        'success' => false
        ]);
    }

    /**
     * Travaux 5 — Afficher les montants selon le filtre choisi
     * Filtre 1 : montant total des ventes
     * Filtre 2 : montant total des ventes par article
     * Filtre 3 : montant total des ventes par jour
     */
    public static function postMontant() {
        $pdo      = Flight::db();
        $r_caisse = new caisseRepository($pdo);

        $req    = Flight::request();
        $filtre = (int) $req->data->id_produit_stock; // champ réutilisé pour le filtre

        $results = [];

        switch ($filtre) {
            case 1:
                // Total global des ventes
                $results = $r_caisse->getTotalVentes();
                break;
            case 2:
                // Total par article
                $results = $r_caisse->getTotalVentesParArticle();
                break;
            case 3:
                // Total par jour
                $results = $r_caisse->getTotalVentesParJour();
                break;
        }

        Flight::render('auth/montant', [
            'results' => $results,
            'filtre'  => $filtre
        ]);
    }

}