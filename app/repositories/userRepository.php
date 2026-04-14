<?php
class userRepository {
  private $pdo;
  public function __construct(PDO $pdo) { $this->pdo = $pdo; }

  public function emailExists($email) {
    $st = $this->pdo->prepare("SELECT 1 FROM users WHERE email=? LIMIT 1");
    $st->execute([(string)$email]);
    return (bool)$st->fetchColumn();
  }

  public function verifyUser($prenom, $password) {
    $st = $this->pdo->prepare("SELECT * FROM users WHERE prenom = ? AND password = ? LIMIT 1");
    $st->execute([(string)$prenom, (string)$password]);
    $user = $st->fetch(PDO::FETCH_ASSOC); 

    if (!$user) {
      return [
        'ok' => false,
        'values' => ['prenom' => $prenom],
        'errors' => ['prenom' => 'Aucun compte trouvé avec ce prénom.']
      ];
    }

    return [
      'ok' => true,
      'user' => $user
    ];
  }

  public function getByPrenom($prenom) {
      $st = $this->pdo->prepare("SELECT * FROM users WHERE prenom = ? LIMIT 1");
      $st->execute([(string)$prenom]);
      return $st->fetch(PDO::FETCH_ASSOC); 
  }

  public function createUser($nom, $prenom, $email, $password, $telephone) {
    $st = $this->pdo->prepare("
      INSERT INTO users(nom, prenom, email, password, telephone)
      VALUES(?,?,?,?,?)
    ");
    $st->execute([(string)$nom, (string)$prenom, (string)$email, (string)$password, (string)$telephone]);
    return $this->pdo->lastInsertId();
  }
}
