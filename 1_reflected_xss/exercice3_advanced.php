<?php
$submitted = false;
$username = '';
$comment = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submitted = true;
    $username = $_POST['username'] ?? '';
    $comment = $_POST['comment'] ?? '';
    
    // Validation basique
    if (empty($username) || empty($comment)) {
        $error = "Tous les champs sont obligatoires";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Exercice 3 - XSS Avancé</title>
    <style>
        .error { color: red; }
        .comment { margin: 10px 0; padding: 10px; border: 1px solid #ccc; }
    </style>
</head>
<body>
    <h1>Exercice 3: XSS Réfléchi Avancé</h1>
    <p>Objectif: Trouver et exploiter plusieurs vecteurs d'attaque XSS</p>
    
    <form method="POST">
        <div>
            <label>Nom d'utilisateur:</label>
            <input type="text" name="username" value="<?php echo $username; ?>">
        </div>
        <div>
            <label>Commentaire:</label>
            <textarea name="comment"><?php echo $comment; ?></textarea>
        </div>
        <button type="submit">Publier</button>
    </form>

    <?php if ($error): ?>
    <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if ($submitted && !$error): ?>
    <div class="comment">
        <h3>Commentaire de <?php echo $username; ?>:</h3>
        <p><?php echo $comment; ?></p>
        <small>Posté le <?php echo date('d/m/Y H:i'); ?></small>
    </div>
    <?php endif; ?>

    <script>
        // Fonction pour afficher les commentaires récents
        function displayRecentComments() {
            const comments = [
                { user: "<?php echo $username; ?>", text: "<?php echo $comment; ?>" }
            ];
            
            let html = '<h2>Commentaires récents:</h2>';
            comments.forEach(comment => {
                html += `<div class="comment">
                    <h3>${comment.user}</h3>
                    <p>${comment.text}</p>
                </div>`;
            });
            document.write(html);
        }
        
        // Afficher les commentaires si disponibles
        <?php if ($submitted && !$error): ?>
        displayRecentComments();
        <?php endif; ?>
    </script>
</body>
</html> 