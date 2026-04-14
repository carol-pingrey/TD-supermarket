<?php
class produitRepository {
    private $pdo;
    public function __construct(PDO $pdo) { $this->pdo = $pdo; }

    public function getAll() {
        $st = $this->pdo->prepare("SELECT * FROM produit_stock");
        $st->execute();
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProduitsValides() {
        $st = $this->pdo->prepare("SELECT * FROM produit_stock WHERE quantite_stock > 0");
        $st->execute();
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllByIdAchat($id_achat) {
        $st = $this->pdo->prepare("SELECT * FROM v_produit WHERE id_achat = ?");
        $st->execute([(int)$id_achat]);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $st = $this->pdo->prepare("SELECT * FROM produit_stock WHERE id_produit_stock = ? LIMIT 1");
        $st->execute([(int)$id]);
        return $st->fetch(PDO::FETCH_ASSOC); 
    }

    public function deleteById($id) {
        $st = $this->pdo->prepare("DELETE FROM produit_stock WHERE id_produit_stock = ?");
        $st->execute([(int)$id]);
    }

    public function getPrixById($id) {
        $st = $this->pdo->prepare("SELECT prix_unitaire FROM produit_stock WHERE id_produit_stock = ? LIMIT 1");
        $st->execute([(int)$id]);
        return $st->fetch(PDO::FETCH_ASSOC)['prix_unitaire'] ?? null; 
    }

    public function getQuantiteById($id) {
        $st = $this->pdo->prepare("SELECT quantite_stock FROM produit_stock WHERE id_produit_stock = ? LIMIT 1");
        $st->execute([(int)$id]);
        return $st->fetch(PDO::FETCH_ASSOC)['quantite_stock'] ?? null; 
    }

    public function verificationQuantite($id_produit_stock, $quantite_achat) {
        $quantite_stock = $this->getQuantiteById($id_produit_stock);
        if ($quantite_achat > $quantite_stock) {
            return false; 
        }
        return true; 
    }

    public function UpdateQuantite($id_produit_stock, $quantite_achat) {
        $st = $this->pdo->prepare("UPDATE produit_stock SET quantite_stock = quantite_stock - ? WHERE id_produit_stock = ?");
        $st->execute([(int)$quantite_achat, (int)$id_produit_stock]);
    }

    public function addQuantite($id_produit_stock, $quantite_ajout) {
        $st = $this->pdo->prepare("UPDATE produit_stock SET quantite_stock = quantite_stock + ? WHERE id_produit_stock = ?");
        $st->execute([(int)$quantite_ajout, (int)$id_produit_stock]);
    }

    public function verifiExistenceProduitAchat($id_achat, $id_produit_stock) {
        $st = $this->pdo->prepare("SELECT * FROM produit_achat WHERE id_achat = ? AND id_produit_stock = ? LIMIT 1");
        $st->execute([(int)$id_achat, (int)$id_produit_stock]);
        if ($st->fetch(PDO::FETCH_ASSOC)) {
            return true; 
        }
        return false;
         
    }

    public function createProduit_achat($id_achat, $id_produit_stock, $quantite_achat) {
        $prix_unitaire = $this->getPrixById($id_produit_stock);
        $montant_achat = $prix_unitaire * $quantite_achat;

        $verif_quantite = $this->verificationQuantite($id_produit_stock, $quantite_achat);
        $verif_existence = $this->verifiExistenceProduitAchat($id_achat, $id_produit_stock);

        if($verif_quantite) {
            if($verif_existence) {
                $st = $this->pdo->prepare("UPDATE produit_achat SET quantite_achat = quantite_achat + ?, montant_achat = montant_achat + ? WHERE id_achat = ? AND id_produit_stock = ?");
                $st->execute([(int)$quantite_achat, (float)$montant_achat, (int)$id_achat, (int)$id_produit_stock]);
                $this->UpdateQuantite($id_produit_stock, $quantite_achat);
                return;
            }
            $st = $this->pdo->prepare("INSERT INTO produit_achat(id_achat, quantite_achat, id_produit_stock, montant_achat) VALUES(?, ?, ?, ?)");
            $st->execute([(int)$id_achat, (int)$quantite_achat, (int)$id_produit_stock, (float)$montant_achat]);
            $this->UpdateQuantite($id_produit_stock, $quantite_achat);
        }
        else {
            throw new Exception("Quantité d'achat dépasse la quantité en stock.");
        }
    }

    public function createProduit($designation, $prix_unitaire, $quantite_stock) {
        $st = $this->pdo->prepare("INSERT INTO produit_stock(designation, prix_unitaire, quantite_stock) VALUES(?, ?, ?)");
        $st->execute([(string)$designation, (float)$prix_unitaire, (int)$quantite_stock]);
        return $this->pdo->lastInsertId();
    }

    public function getSumMontantByIdAchat($id_achat) {
        $st = $this->pdo->prepare("SELECT SUM(montant_achat) as total FROM produit_achat WHERE id_achat = ?");
        $st->execute([(int)$id_achat]);
        return $st->fetch(PDO::FETCH_ASSOC)['total'] ?? 0; 
    }

}
?>