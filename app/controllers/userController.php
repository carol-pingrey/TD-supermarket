<?php
class userController {

  public static function showLogin() {
    Flight::render('auth/login', [
      'values' => ['prenom'=>''],
      'errors' => ['prenom'=>'','password'=>''],
      'success' => false
    ]);
  }

  public static function showAccueil() {
    $pdo  = Flight::db();
    $r_caisse = new caisseRepository($pdo);
    $caisses = $r_caisse->getAll();

    Flight::render('auth/accueil', [
      'caisses' => $caisses
    ]);
  }

  public static function postLogin() {
    $pdo  = Flight::db();
    $r_user = new userRepository($pdo);
    $r_caisse = new caisseRepository($pdo);

    $req = Flight::request();

    $prenom = $req->data->prenom;
    $password = $req->data->password;

    $user = $r_user->verifyUser($prenom, $password);
    $caisses = $r_caisse->getAll();

    if ($user['ok']) {
      session_start();
      $_SESSION['user'] = $user['user'];
      Flight::render('auth/accueil', [
        'caisses' => $caisses
      ]);
      return;
    }

    Flight::render('auth/login', [
      'values' => $user['values'],
      'errors' => $user['errors'],
      'success' => false
    ]);
  }

}
