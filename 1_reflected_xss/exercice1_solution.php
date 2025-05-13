<?php
// Protection 1: On échappe les caractères spéciaux pour éviter l'injection de code
// Ex: <script> devient &lt;script&gt;
$query = isset($_GET['q']) ? htmlspecialchars($_GET['q'], ENT_QUOTES, 'UTF-8') : '';

// Protection 2: On ajoute des en-têtes de sécurité pour le navigateur
header('Content-Type: text/html; charset=UTF-8');
header('X-XSS-Protection: 1; mode=block');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Exercice 1 - Solution</title>
    <meta charset="UTF-8">
    <!-- Protection 3: On bloque l'exécution de scripts externes -->
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'">
</head>
<body>
    <h1>Exercice 1: Solution XSS Réfléchi</h1>
    <p>Objectif: Protéger contre l'injection de code JavaScript malveillant</p>
    
    <!-- Protection 4: On limite la taille de l'entrée -->
    <form method="GET" autocomplete="off">
        <input type="text" name="q" placeholder="Rechercher..." maxlength="100">
        <button type="submit">Rechercher</button>
    </form>

    <?php if ($query): ?>
    <!-- Les données sont sécurisées grâce à htmlspecialchars() -->
    <h2>Résultats pour: <?php echo $query; ?></h2>
    <p>Aucun résultat trouvé.</p>
    <?php endif; ?>
</body>
</html> 