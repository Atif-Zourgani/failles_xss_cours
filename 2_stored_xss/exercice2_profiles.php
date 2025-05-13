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
    $bio = $_POST['bio'] ?? '';
    $website = $_POST['website'] ?? '';
    // Insertion vulnérable
    $query = "INSERT INTO messages (type, username, bio, website) VALUES ('profile', '" . addslashes(
        $username
    ) . "', '" . addslashes(
        $bio
    ) . "', '" . addslashes(
        $website
    ) . "')";
    $db->query($query);
}
// Récupération des profils
$result = $db->query("SELECT * FROM messages WHERE type='profile' ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Exercice 2 - Système de Profils (Vulnérable)</title>
    <meta charset="UTF-8">
</head>
<body>
    <h1>Système de Profils</h1>
    <form method="POST">
        <div>
            <label>Nom d'utilisateur:</label>
            <input type="text" name="username" required>
        </div>
        <div>
            <label>Bio:</label>
            <textarea name="bio" required></textarea>
        </div>
        <div>
            <label>Site web:</label>
            <input type="text" name="website" required>
        </div>
        <button type="submit">Créer Profil</button>
    </form>
    <h2>Profils récents:</h2>
    <?php while ($row = $result->fetch_assoc()): ?>
    <div class="profile">
        <h3><?php echo $row['username']; ?></h3>
        <p><?php echo $row['bio']; ?></p>
        <p>Site web: <a href="<?php echo $row['website']; ?>"><?php echo $row['website']; ?></a></p>
        <small>Créé le <?php echo $row['created_at']; ?></small>
    </div>
    <?php endwhile; ?>
</body>
</html> 