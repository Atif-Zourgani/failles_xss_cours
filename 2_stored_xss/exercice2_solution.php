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
    $bio = trim($_POST['bio'] ?? '');
    $website = trim($_POST['website'] ?? '');
    // Protection 2: Validation des longueurs
    if (strlen($username) > 50) {
        $username = substr($username, 0, 50);
    }
    if (strlen($bio) > 500) {
        $bio = substr($bio, 0, 500);
    }
    // Protection 3: Validation de l'URL
    if (!filter_var($website, FILTER_VALIDATE_URL)) {
        $website = '';
    }
    // Protection 4: Requête préparée
    $stmt = $db->prepare('INSERT INTO messages (type, username, bio, website) VALUES (?, ?, ?, ?)');
    $stmt->bind_param('ssss', $type, $username, $bio, $website);
    $type = 'profile';
    $stmt->execute();
}
// Récupération des profils
$result = $db->query("SELECT * FROM messages WHERE type='profile' ORDER BY created_at DESC");
// Protection 5: En-têtes de sécurité
header('Content-Type: text/html; charset=UTF-8');
header('X-XSS-Protection: 1; mode=block');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Exercice 2 - Système de Profils (Sécurisé)</title>
    <meta charset="UTF-8">
    <!-- Protection 6: Content Security Policy -->
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'">
</head>
<body>
    <h1>Système de Profils</h1>
    <p>Objectif: Comprendre les XSS stockés dans un système de profils</p>
    
    <form method="POST">
        <div>
            <label>Nom d'utilisateur:</label>
            <input type="text" name="username" maxlength="50" required>
        </div>
        <div>
            <label>Bio:</label>
            <textarea name="bio" maxlength="500" required></textarea>
        </div>
        <div>
            <label>Site web:</label>
            <input type="url" name="website" required>
        </div>
        <button type="submit">Créer Profil</button>
    </form>

    <h2>Profils récents:</h2>
    <?php while ($row = $result->fetch_assoc()): ?>
    <div class="profile">
        <!-- Protection 7: Échappement des données -->
        <h3><?php echo htmlspecialchars($row['username'], ENT_QUOTES, 'UTF-8'); ?></h3>
        <p><?php echo htmlspecialchars($row['bio'], ENT_QUOTES, 'UTF-8'); ?></p>
        <p>Site web: <a href="<?php echo htmlspecialchars($row['website'], ENT_QUOTES, 'UTF-8'); ?>">
            <?php echo htmlspecialchars($row['website'], ENT_QUOTES, 'UTF-8'); ?>
        </a></p>
        <small>Créé le <?php echo htmlspecialchars($row['created_at'], ENT_QUOTES, 'UTF-8'); ?></small>
    </div>
    <?php endwhile; ?>
</body>
</html> 