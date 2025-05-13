<?php
$query = isset($_GET['q']) ? $_GET['q'] : '';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Exercice 1 - Recherche</title>
</head>
<body>
    <h1>Exercice 1: XSS Réfléchi</h1>
    <p>Objectif: Injecter du code JavaScript malveillant via le champ de recherche</p>
    
    <form method="GET">
        <input type="text" name="q" placeholder="Rechercher...">
        <button type="submit">Rechercher</button>
    </form>

    <?php if ($query): ?>
    <h2>Résultats pour: <?php echo $query; ?></h2>
    <p>Aucun résultat trouvé.</p>
    <?php endif; ?>
</body>
</html> 