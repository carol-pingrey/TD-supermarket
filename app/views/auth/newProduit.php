<?php
require_once("header.php"); 
?>

<section>
  
    <h1>Ajouter un Produit</h1>
    <form id="achatForm" method="post" action="/newProduit" novalidate>

        <div class="form-group">
            <label for="caisse">Produit</label>
            <input type="text" name="designation" placeholder="Pomme" class="field">
        </div>

        <div class="form-group">
            <label for="caisse">Prix Unitaire</label>
            <input type="number" name="prix_unitaire" placeholder="500" class="field">
        </div>

        <div class="form-group">
            <label for="quantite">Quantité</label>
            <input type="number" name="quantite_stock" placeholder="10" class="field">
        </div>

        <button type="submit" class="btn btn-green">Valider</button>
    </form>

</section>

<?php require_once("footer.php"); ?>