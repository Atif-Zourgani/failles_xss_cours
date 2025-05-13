<?php
// Initialisation des variables
$submitted = false;
$name = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submitted = true;
    
    // Protection 1: On nettoie les entrées (supprime les espaces inutiles)
    $name = trim($_POST['name'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    // Protection 2: On limite la taille du nom
    if (strlen($name) > 100) {
        $name = substr($name, 0, 100);
    }
    
    // Protection 3: On échappe le nom pour éviter l'injection
    $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
    
    // Protection 4: On nettoie le message en deux étapes
    // 1. On garde uniquement les balises HTML autorisées
    $message = strip_tags($message, '<p><br><strong><em>');
    // 2. On échappe les caractères spéciaux restants
    $message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
}

// Protection 5: En-têtes de sécurité pour le navigateur
header('Content-Type: text/html; charset=UTF-8');
header('X-XSS-Protection: 1; mode=block');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Exercice 2 - Solution</title>
    <meta charset="UTF-8">
    <!-- Protection 6: On bloque les scripts externes -->
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'">
</head>
<body>
    <h1>Exercice 2: Solution XSS Réfléchi Avancé</h1>
    <p>Objectif: Protéger le formulaire de contact contre les XSS</p>
    
    <!-- Protection 7: Formulaire sécurisé -->
    <form method="POST" autocomplete="off">
        <div>
            <label>Nom:</label>
            <!-- On limite la taille et on force la validation -->
            <input type="text" name="name" maxlength="100" required>
        </div>
        <div>
            <label>Email:</label>
            <!-- On force un format email valide -->
            <input type="email" name="email" required>
        </div>
        <div>
            <label>Message:</label>
            <!-- On limite la taille du message -->
            <textarea name="message" maxlength="1000" required></textarea>
        </div>
        <button type="submit">Envoyer</button>
    </form>

    <?php if ($submitted): ?>
    <div class="confirmation">
        <!-- Les données sont déjà sécurisées -->
        <h2>Message envoyé!</h2>
        <p>Merci <?php echo $name; ?> pour votre message:</p>
        <p><?php echo $message; ?></p>
    </div>
    <?php endif; ?>
</body>
</html> 