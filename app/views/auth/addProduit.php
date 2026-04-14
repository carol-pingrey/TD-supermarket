<?php
require_once("header.php"); 
?>

<section>
    
    <h1>Changer la quantité du produit dans le stock</h1>
    <form id="achatForm" method="post" action="/addProduit" novalidate>

        <!-- <div class="form-group2">
            <input type="radio" name="action" value="add" checked>
            <label for="add">Ajouter</label>
            <input type="radio" name="action" value="remove">
            <label for="remove">Retirer</label>
        </div> -->

        <div class="form-group">
            <label for="caisse">Produit</label>
            <select name="id_produit_stock" class="field">
                <?php foreach ($produits as $produit): ?>
                    <option value="<?= $produit['id_produit_stock'] ?>"><?= $produit['designation'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="quantite">Quantité</label>
            <input id="quantite" name="quantite" type="number" class="field">
        </div>

        <button type="submit" class="btn btn-green">Valider</button>
    </form>

</section>

<?php require_once("footer.php"); ?>