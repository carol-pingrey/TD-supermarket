<?php
require_once("header.php"); 
?>

<section>
    <h1>Accueil</h1>
    <form id="caisseForm" method="post" action="/ChoixCaisse" novalidate>

        <div class="form-group">
            <label for="caisse">Choisir le numéro de Caisse</label>
            <select id="caisse" name="id_caisse" class="field">
                <?php foreach ($caisses as $caisse): ?>
                    <option value="<?= $caisse['id_caisse'] ?>"><?= $caisse['num_caisse'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-green">Valider</button>
    </form>
</section>

<?php require_once("footer.php"); ?>