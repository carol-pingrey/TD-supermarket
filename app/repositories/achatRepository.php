<?php
class achatRepository {
    private $pdo;
    public function __construct(PDO $pdo) { $this->pdo = $pdo; }

    public function getAll() {
        $st = $this->pdo->prepare("SELECT * FROM achat");
        $st->execute();
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $st = $this->pdo->prepare("SELECT * FROM achat WHERE id_achat = ? LIMIT 1");
        $st->execute([(int)$id]);
        return $st->fetch(PDO::FETCH_ASSOC); 
    }

    public function deleteById($id) {
        $st = $this->pdo->prepare("DELETE FROM achat WHERE id_achat = ?");
        $st->execute([(int)$id]);
    }

    public function getLastAchat() {
        $st = $this->pdo->prepare("SELECT * FROM achat ORDER BY id_achat DESC LIMIT 1");
        $st->execute();
        return $st->fetch(PDO::FETCH_ASSOC); 
    }

    public function createAchat($id_caisse, $date_achat) {
        $lastId = $this->getLastAchat()['id_achat'] ?? 0;
        $num_achat = "ACHAT-0" . ($lastId + 1);
        $st = $this->pdo->prepare("INSERT INTO achat(num_achat, id_caisse, date_achat) VALUES(?, ?, ?)");
        $st->execute([(string)$num_achat, (int)$id_caisse, (string)$date_achat]);

    }

    public function clotureAchat($id_achat) {
        $st = $this->pdo->prepare("UPDATE achat SET cloture_achat = TRUE WHERE id_achat = ?");
        $st->execute([(int)$id_achat]);
    }

}
?>