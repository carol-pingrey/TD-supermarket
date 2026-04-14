<?php
require_once("header.php"); 
?>

<section>
  
    <h1>Rapport des Ventes</h1>
    <form id="achatForm" method="post" action="/montant" novalidate>

        <div class="form-group">
            <label for="filtre">Filtrer le montant par</label>
            <select name="id_produit_stock" class="field">
                <option value="1" <?= (isset($filtre) && $filtre == 1) ? 'selected' : '' ?>>Ventes totales</option>
                <option value="2" <?= (isset($filtre) && $filtre == 2) ? 'selected' : '' ?>>Ventes par article</option>
                <option value="3" <?= (isset($filtre) && $filtre == 3) ? 'selected' : '' ?>>Ventes par jour</option>
            </select>
        </div>

        <button type="submit" class="btn btn-green">Valider</button>
    </form>

    <?php if (isset($results) && $results !== null): ?>

        <?php if ($filtre == 1): ?>
            <!-- Filtre 1 : Total global -->
            <div class="stats-grid mt-3">
                <div class="stat-card">
                    <div class="stat-label">Montant total des ventes</div>
                    <div class="stat-value"><?= number_format($results[0]['total'] ?? 0, 2, ',', ' ') ?></div>
                    <div class="stat-sub">Ar — toutes caisses confondues</div>
                </div>
            </div>

        <?php elseif ($filtre == 2): ?>
            <!-- Filtre 2 : Par article -->
            <table>
                <thead>
                    <tr>
                        <th>Article</th>
                        <th>Quantité vendue</th>
                        <th>Montant total (Ar)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['designation']) ?></td>
                            <td><?= $row['total_quantite'] ?></td>
                            <td><?= number_format($row['total_montant'], 2, ',', ' ') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        <?php elseif ($filtre == 3): ?>
            <!-- Filtre 3 : Par jour -->
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Nb achats</th>
                        <th>Montant total (Ar)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['jour']) ?></td>
                            <td><?= $row['nb_achats'] ?></td>
                            <td><?= number_format($row['total_montant'], 2, ',', ' ') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        <?php endif; ?>

    <?php endif; ?>

</section>

<?php require_once("footer.php"); ?>