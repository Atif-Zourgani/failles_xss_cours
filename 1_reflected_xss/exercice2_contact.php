<?php
$submitted = false;
$name = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submitted = true;
    $name = $_POST['name'] ?? '';
    $message = $_POST['message'] ?? '';
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Exercice 2 - Contact</title>
</head>
<body>
    <h1>Exercice 2: XSS Réfléchi Avancé</h1>
    <p>Objectif: Injecter du code JavaScript via le formulaire de contact</p>
    
    <form method="POST">
        <div>
            <label>Nom:</label>
            <input type="text" name="name">
        </div>
        <div>
            <label>Email:</label>
            <input type="email" name="email">
        </div>
        <div>
            <label>Message:</label>
            <textarea name="message"></textarea>
        </div>
        <button type="submit">Envoyer</button>
    </form>

    <?php if ($submitted): ?>
    <div class="confirmation">
        <h2>Message envoyé!</h2>
        <p>Merci <?php echo $name; ?> pour votre message:</p>
        <p><?php echo $message; ?></p>
    </div>
    <?php endif; ?>
</body>
</html> 