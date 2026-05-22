<?php
declare(strict_types=1);

// On charge l'autoloader pour avoir accès à la base de données
spl_autoload_register(function ($class) {
    $classPath = str_replace('\\', '/', $class);
    $file = __DIR__ . '/src/' . $classPath . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

use config\Database;

try {
    $pdo = Database::getConnection();

    // 1. On prépare la requête d'insertion
    // (Ajuste les noms des colonnes selon ta table 'users')
    $sql = "INSERT INTO users (firstname, lastname, email, password, id_role, points) 
            VALUES (:firstname, :lastname, :email, :password, :id_role, :points)";

    $stmt = $pdo->prepare($sql);

    // 2. Définition des utilisateurs à créer
    $usersToInsert = [
        [
            'firstname'  => 'hassan',
            'lastname'   => 'ali',
            'email'      => 'hassan@gmail.com',
            'password'   => password_hash('realmadrid123', PASSWORD_BCRYPT),
            'id_role' => 2,
            'points'     => 0
        ]
    ];

    // 3. Exécution de l'insertion
    foreach ($usersToInsert as $user) {
        $stmt->execute($user);
        echo "Utilisateur {$user['firstname']} créé avec succès !<br>";
    }

} catch (\PDOException $e) {
    echo "Erreur d'insertion : " . $e->getMessage();
}