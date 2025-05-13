<?php
// Initialisation des variables
$submitted = false;
$username = '';
$comment = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submitted = true;
    
    // Protection 1: Nettoyage des entrées
    $username = trim($_POST['username'] ?? '');
    $comment = trim($_POST['comment'] ?? '');
    
    // Protection 2: Limitation de la taille
    if (strlen($username) > 50) {
        $username = substr($username, 0, 50);
    }
    if (strlen($comment) > 1000) {
        $comment = substr($comment, 0, 1000);
    }
    
    // Protection 3: Échappement des caractères spéciaux
    $username = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
    $comment = htmlspecialchars($comment, ENT_QUOTES, 'UTF-8');
    
    // Protection 4: Validation des champs obligatoires
    if (empty($username) || empty($comment)) {
        $error = "Tous les champs sont obligatoires";
    }
}

// Protection 5: En-têtes de sécurité
header('Content-Type: text/html; charset=UTF-8');
header('X-XSS-Protection: 1; mode=block');
header('X-Content-Type-Options: nosniff');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Exercice 3 - Solution XSS Avancé</title>
    <meta charset="UTF-8">
    <!-- Protection 6: Blocage des scripts externes -->
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self'">
    <style>
        .error { color: red; }
        .comment { margin: 10px 0; padding: 10px; border: 1px solid #ccc; }
    </style>
</head>
<body>
    <h1>Exercice 3: Solution XSS Réfléchi Avancé</h1>
    <p>Objectif: Protéger contre plusieurs vecteurs d'attaque XSS</p>
    
    <!-- Protection 7: Formulaire sécurisé -->
    <form method="POST" autocomplete="off">
        <div>
            <label>Nom d'utilisateur:</label>
            <input type="text" name="username" maxlength="50" required 
                   value="<?php echo $username; ?>">
        </div>
        <div>
            <label>Commentaire:</label>
            <textarea name="comment" maxlength="1000" required><?php echo $comment; ?></textarea>
        </div>
        <button type="submit">Publier</button>
    </form>

    <?php if ($error): ?>
    <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if ($submitted && !$error): ?>
    <div class="comment">
        <!-- Les données sont déjà sécurisées -->
        <h3>Commentaire de <?php echo $username; ?>:</h3>
        <p><?php echo $comment; ?></p>
        <small>Posté le <?php echo date('d/m/Y H:i'); ?></small>
    </div>
    <?php endif; ?>

    <script>
        // Protection 8: Sécurisation des données JavaScript
        function displayRecentComments() {
            const comments = [
                { 
                    // On utilise json_encode pour échapper les données
                    user: <?php echo json_encode($username); ?>, 
                    text: <?php echo json_encode($comment); ?>
                }
            ];
            
            let html = '<h2>Commentaires récents:</h2>';
            comments.forEach(comment => {
                html += `<div class="comment">
                    <h3>${comment.user}</h3>
                    <p>${comment.text}</p>
                </div>`;
            });
            // On utilise innerHTML au lieu de document.write
            document.getElementById('comments').innerHTML = html;
        }
        
        <?php if ($submitted && !$error): ?>
        displayRecentComments();
        <?php endif; ?>
    </script>
    <div id="comments"></div>
</body>
</html> 