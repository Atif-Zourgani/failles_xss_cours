<?php
// Connexion à la base MySQL
$db = new mysqli('localhost', 'root', '', 'security_test');

// Création de la table si besoin (à faire une seule fois)
$db->query('CREATE TABLE IF NOT EXISTS messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type VARCHAR(20),
    username VARCHAR(50),
    bio TEXT,
    website VARCHAR(255),
    recipient VARCHAR(50),
    subject VARCHAR(100),
    comment TEXT,
    message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)');

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Protection 1: Nettoyage des entrées
    $username = trim($_POST['username'] ?? '');
    $comment = trim($_POST['comment'] ?? '');
    // Protection 2: Validation des longueurs
    if (strlen($username) > 50) {
        $username = substr($username, 0, 50);
    }
    if (strlen($comment) > 1000) {
        $comment = substr($comment, 0, 1000);
    }
    // Protection 3: Requête préparée
    $stmt = $db->prepare('INSERT INTO messages (type, username, comment) VALUES (?, ?, ?)');
    $stmt->bind_param('sss', $type, $username, $comment);
    $type = 'comment';
    $stmt->execute();
}
// Récupération des commentaires
$result = $db->query("SELECT * FROM messages WHERE type='comment' ORDER BY created_at DESC");
// Protection 4: En-têtes de sécurité
header('Content-Type: text/html; charset=UTF-8');
header('X-XSS-Protection: 1; mode=block');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Exercice 1 - Système de Commentaires (Sécurisé)</title>
    <meta charset="UTF-8">
    <!-- Protection 5: Content Security Policy -->
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'">
</head>
<body>
    <h1>Système de Commentaires</h1>
    <p>Objectif: Comprendre les XSS stockés dans un système de commentaires</p>
    
    <form method="POST">
        <div>
            <label>Nom d'utilisateur:</label>
            <input type="text" name="username" maxlength="50" required>
        </div>
        <div>
            <label>Commentaire:</label>
            <textarea name="comment" maxlength="1000" required></textarea>
        </div>
        <button type="submit">Publier</button>
    </form>

    <h2>Commentaires récents:</h2>
    <?php while ($row = $result->fetch_assoc()): ?>
    <div class="comment">
        <!-- Protection 6: Échappement des données -->
        <h3><?php echo htmlspecialchars($row['username'], ENT_QUOTES, 'UTF-8'); ?></h3>
        <p><?php echo htmlspecialchars($row['comment'], ENT_QUOTES, 'UTF-8'); ?></p>
        <small>Posté le <?php echo htmlspecialchars($row['created_at'], ENT_QUOTES, 'UTF-8'); ?></small>
    </div>
    <?php endwhile; ?>
</body>
</html> 