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
    $username = $_POST['username'] ?? '';
    $comment = $_POST['comment'] ?? '';
    // Insertion vulnérable
    $query = "INSERT INTO messages (type, username, comment) VALUES ('comment', '$username', '$comment')";
    $db->query($query);
}
// Récupération des commentaires
$result = $db->query("SELECT * FROM messages WHERE type='comment' ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Exercice 1 - Système de Commentaires (Vulnérable)</title>
    <meta charset="UTF-8">
</head>
<body>
    <h1>Système de Commentaires</h1>
    <form method="POST">
        <div>
            <label>Nom d'utilisateur:</label>
            <input type="text" name="username" required>
        </div>
        <div>
            <label>Commentaire:</label>
            <textarea name="comment" required></textarea>
        </div>
        <button type="submit">Publier</button>
    </form>
    <h2>Commentaires récents:</h2>
    <?php while ($row = $result->fetch_assoc()): ?>
    <div class="comment">
        <h3><?php echo $row['username']; ?></h3>
        <p><?php echo $row['comment']; ?></p>
        <small>Posté le <?php echo $row['created_at']; ?></small>
    </div>
    <?php endwhile; ?>
</body>
</html> 