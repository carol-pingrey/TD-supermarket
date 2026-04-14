<?php
function e($v){ return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8'); }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Connexion utilisateur</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/validation-ajax.js" defer></script>
</head>
<body>

  <main>

    <div>
      <div>
        <div>
          <div>
            <div><h1>Connexion utilisateur</h1></div>
            <div>

              <?php if (!empty($success)): ?>
                <div>Connexion réussie</div>
              <?php endif; ?>

              <form id="loginForm" method="post" action="/login" novalidate>
                <div id="formStatus"></div>

                <div class="form-group">
                  <label for="prenom">Prénom</label>
                  <input id="prenom" name="prenom" value="<?= e($values['prenom'] ?? '') ?>" placeholder="User" class="field">
                  <div id="prenomError"><?= e($errors['prenom'] ?? '') ?></div>
                </div>

                <div class="form-group">
                  <label for="password">Mot de passe</label>
                  <input id="password" name="password" type="password" value="<?= e($values['password'] ?? '') ?>" placeholder="123" class="field">
                  <div id="passwordError"><?= e($errors['password'] ?? '') ?></div>
                </div>

                <button type="submit" class="btn btn-green">Valider</button>
              </form>

              <script src="js/validation-ajax.js" defer></script>
            </div>
          </div>
        </div>
      </div>
    </div>

  </main>

    <footer> 
        <div>
            <p>&copy; 2026 market ETU4287-ETU4072</p>
        </div>
    </footer>

</body>
</html>