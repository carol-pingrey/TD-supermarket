<?php
class achatController {

    public static function getAchat() {
        $pdo = Flight::db();
        $r_produit = new produitRepository($pdo);
        
        session_start();
        if (!isset($_SESSION['achat'])) {
            Flight::redirect('/accueil'); 
            return;
        }

        $error = null;
        if (isset($_SESSION['achat_error'])) {
            $error = $_SESSION['achat_error'];
            unset($_SESSION['achat_error']); 
        }
        
        $id_achat = $_SESSION['achat']['id_achat'];

        Flight::render('auth/achat', [
            'produits' => $r_produit->getProduitsValides(),
            'produits_achat' => $r_produit->getAllByIdAchat($id_achat),
            'total' => $r_produit->getSumMontantByIdAchat($id_achat),
            'error' => $error 
        ]);
    }

    public static function postAchat() {
        $pdo  = Flight::db();
        $r_produit = new produitRepository($pdo);

        $req = Flight::request();

        $id_produit = $req->data->id_produit_stock;
        $quantite_achat = $req->data->quantite;

        session_start();
        $achat = $_SESSION['achat'];

        try {
            $r_produit->createProduit_achat($achat['id_achat'], $id_produit, $quantite_achat);
            Flight::redirect('/ChoixAchat');
            return;
        } catch (Exception $e) {
            $_SESSION['achat_error'] = $e->getMessage();
            Flight::redirect('/ChoixAchat'); 
            return;
        }

    }

    public static function clotureAchat() {
            $pdo  = Flight::db();
            $r_achat = new achatRepository($pdo);
            $r_caisse = new caisseRepository($pdo);
            $r_produit = new produitRepository($pdo);
    
            session_start();
            $achat = $_SESSION['achat'];
            $caisse = $_SESSION['caisse'];

            $total = $r_produit->getSumMontantByIdAchat($achat['id_achat']);
            $r_caisse->updateMontant($caisse['id_caisse'], $total);
    
            $r_achat->clotureAchat($achat['id_achat']);
            unset($_SESSION['achat']);

            Flight::render('auth/accueil', [
                'caisses' => $r_caisse->getAll()
            ]);
    }

}