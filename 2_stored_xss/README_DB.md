# Configuration de la base de données pour les exercices XSS stockés

Pour faire fonctionner les exercices de ce dossier, il est nécessaire de créer une base de données MySQL nommée `security_test` et d'y ajouter la table `messages`.

## Étapes à suivre

1. Ouvre phpMyAdmin ou ton outil de gestion MySQL.
2. Exécute la requête suivante pour créer la base de données et la table :

```sql
CREATE DATABASE IF NOT EXISTS security_test;
USE security_test;

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `type` varchar(20) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `recipient` varchar(50) DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
```

3. La table est maintenant prête à être utilisée par les exercices.

**Remarque :**
- L'utilisateur MySQL utilisé dans les scripts est généralement `root` sans mot de passe sur XAMPP. Si besoin, adapte la connexion dans les fichiers PHP.
- Si tu rencontres des erreurs de connexion, vérifie que la base et la table existent bien. 