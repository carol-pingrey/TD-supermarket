<?php
class caisseRepository {
  private $pdo;
  public function __construct(PDO $pdo) { $this->pdo = $pdo; }

  public function getAll() {
    $st = $this->pdo->prepare("SELECT * FROM caisse");
    $st->execute();
    return $st->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getById($id) {
    $st = $this->pdo->prepare("SELECT * FROM caisse WHERE id_caisse = ? LIMIT 1");
    $st->execute([(int)$id]);
    return $st->fetch(PDO::FETCH_ASSOC); 
  }

  public function updateMontant($id_caisse, $montant_achat) {
    $st = $this->pdo->prepare("UPDATE caisse SET montant = montant + ? WHERE id_caisse = ?");
    $st->execute([(float)$montant_achat, (int)$id_caisse]);
  }

  public function deleteById($id) {
    $st = $this->pdo->prepare("DELETE FROM caisse WHERE id_caisse = ?");
    $st->execute([(int)$id]);
  }

  public function getLastCaisse() {
    $st = $this->pdo->prepare("SELECT * FROM caisse ORDER BY id_caisse DESC LIMIT 1");
    $st->execute();
    return $st->fetch(PDO::FETCH_ASSOC); 
  }

  public function createCaisse($montant) {
    $lastId = $this->getLastCaisse()['id_caisse'] ?? 0;
    $num_caisse = "CAISSE-0" . ($lastId + 1);
    $st = $this->pdo->prepare("INSERT INTO caisse(num_caisse, montant) VALUES(?, ?)");
    $st->execute([(string)$num_caisse, (float)$montant]);
    return $this->pdo->lastInsertId();
  }

  // ── Travaux 5a — Montant total de toutes les ventes ──────
  public function getTotalVentes() {
    $st = $this->pdo->prepare("
      SELECT SUM(pa.montant_achat) AS total
      FROM produit_achat pa
      JOIN achat a ON pa.id_achat = a.id_achat
      WHERE a.cloture_achat = TRUE
    ");
    $st->execute();
    return $st->fetchAll(PDO::FETCH_ASSOC);
  }

  // ── Travaux 5b — Montant total par article ───────────────
  public function getTotalVentesParArticle() {
    $st = $this->pdo->prepare("
      SELECT 
        ps.designation,
        SUM(pa.quantite_achat)  AS total_quantite,
        SUM(pa.montant_achat)   AS total_montant
      FROM produit_achat pa
      JOIN produit_stock ps ON pa.id_produit_stock = ps.id_produit_stock
      JOIN achat a           ON pa.id_achat = a.id_achat
      WHERE a.cloture_achat = TRUE
      GROUP BY ps.id_produit_stock, ps.designation
      ORDER BY total_montant DESC
    ");
    $st->execute();
    return $st->fetchAll(PDO::FETCH_ASSOC);
  }

  // ── Travaux 5c — Montant total par jour ──────────────────
  public function getTotalVentesParJour() {
    $st = $this->pdo->prepare("
      SELECT 
        DATE(a.date_achat)      AS jour,
        SUM(pa.montant_achat)   AS total_montant,
        COUNT(DISTINCT a.id_achat) AS nb_achats
      FROM produit_achat pa
      JOIN achat a ON pa.id_achat = a.id_achat
      WHERE a.cloture_achat = TRUE
      GROUP BY DATE(a.date_achat)
      ORDER BY jour DESC
    ");
    $st->execute();
    return $st->fetchAll(PDO::FETCH_ASSOC);
  }
}