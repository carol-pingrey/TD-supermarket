<?php
class produitController {

    public static function getProduit() {
        $pdo  = Flight::db();
        $r_produit = new produitRepository($pdo);

        $produits = $r_produit->getAll();

        Flight::render('auth/addProduit', [
            'produits' => $produits
        ]);

    }

    public static function postProduit() {
        $pdo  = Flight::db();
        $r_produit = new produitRepository($pdo);

        $req = Flight::request();

        $id_produit = $req->data->id_produit_stock;
        $quantite_ajout = $req->data->quantite;

        $r_produit->addQuantite($id_produit, $quantite_ajout);
        $produits = $r_produit->getAll();

        Flight::redirect('/addProduit'); 

    }

    public static function getNewProduit() {
        $pdo  = Flight::db();
        $r_produit = new produitRepository($pdo);

        $produits = $r_produit->getAll();

        Flight::render('auth/newProduit', [
            'produits' => $produits
        ]);
    }

    public static function postNewProduit() {
        $pdo  = Flight::db();
        $r_produit = new produitRepository($pdo);

        $req = Flight::request();

        $designation = $req->data->designation;
        $prix_unitaire = $req->data->prix_unitaire;
        $quantite_stock = $req->data->quantite_stock;

        $r_produit->createProduit($designation, $prix_unitaire, $quantite_stock);
        
        Flight::redirect('/newProduit');
    }

}