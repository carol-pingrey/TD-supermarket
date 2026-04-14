<?php
require_once("header.php"); 
$caisse = $_SESSION['caisse'];
?>

<section>
    <h1>Achat dans <?= $caisse['num_caisse'] ?></h1>
    <form id="achatForm" method="post" action="/ChoixAchat" novalidate>

        <div class="form-group">
            <label for="caisse">Produit disponible</label>
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

        <?php if (isset($error) && !empty($error)): ?>
            <div><?= $error ?></div>
        <?php endif; ?>

        <button type="submit" class="btn btn-green">Valider</button>
    </form>

    <?php if (isset($produits_achat) && !empty($produits_achat)): ?>
        <table>
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Prix Unitaire</th>
                    <th>Quantité</th>
                    <th>Montant</th>
                </tr>
            </thead>
            <tbody id="achatTableBody">

                <?php foreach ($produits_achat as $produit) :?>

                    <tr>
                        <td><?= $produit['designation'] ?></td>
                        <td><?= $produit['prix_unitaire'] ?></td>
                        <td><?= $produit['quantite_achat'] ?></td>
                        <td><?= $produit['montant_achat'] ?></td>
                    </tr>

                <?php endforeach;?>
                
            </tbody>
        </table>

        <div>
            <strong>Total :</strong> <?= $total ?>
            <a type="button" class="btn btn-green" href="/clotureAchat">
                Clôturer achat
            </a>
        </div>
    <?php endif; ?>

</section>

<?php require_once("footer.php"); ?>