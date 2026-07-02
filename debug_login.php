<?php
// Script de diagnostic pour tester la connexion
require_once __DIR__ . '/app/config/config.php';
require_once __DIR__ . '/app/Core/Database.php';
require_once __DIR__ . '/app/Core/Model.php';
require_once __DIR__ . '/app/Models/Utilisateur.php';

echo "<h1>Debug Login - Diagnostic</h1>";

try {
    // Test de connexion Ã  la base de donnÃ©es
    $db = Database::getInstance();
    echo "<p style='color: green;'>âœ“ Connexion Ã  la base de donnÃ©es rÃ©ussie</p>";
    
    // Lister tous les utilisateurs
    echo "<h2>Utilisateurs dans la base de donnÃ©es :</h2>";
    $stmt = $db->prepare('SELECT id, email, mot_de_passe FROM utilisateurs WHERE supprimer = 0');
    $stmt->execute();
    $users = $stmt->fetchAll();
    
    if (empty($users)) {
        echo "<p style='color: red;'>âš  Aucun utilisateur trouvÃ© dans la base de donnÃ©es</p>";
    } else {
        echo "<table border='1' cellpadding='10'>";
        echo "<tr><th>ID</th><th>Email</th><th>Mot de passe (premiÃ¨re partie)</th><th>Longueur hash</th><th>Type (bcrypt?)</th></tr>";
        foreach ($users as $user) {
            $hash = $user['mot_de_passe'];
            $isBcrypt = (substr($hash, 0, 4) === '$2y$' || substr($hash, 0, 4) === '$2a$' || substr($hash, 0, 4) === '$2b$');
            echo "<tr>";
            echo "<td>" . htmlspecialchars($user['id'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . "</td>";
            echo "<td>" . htmlspecialchars($user['email'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . "</td>";
            echo "<td>" . htmlspecialchars(substr($hash, 0, 20) . '...', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . "</td>";
            echo "<td>" . strlen($hash) . "</td>";
            echo "<td>" . ($isBcrypt ? "Oui (Bcrypt)" : "Non - Texte brut?") . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
    // Test de password_verify avec un utilisateur
    if (!empty($users)) {
        echo "<h2>Test password_verify :</h2>";
        $testEmail = $users[0]['email'];
        $testPassword = "test"; // Ã€ changer selon votre mot de passe de test
        
        echo "<p>Email de test : " . htmlspecialchars($testEmail, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . "</p>";
        echo "<p>Mot de passe de test : " . htmlspecialchars($testPassword, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . "</p>";
        
        $model = new Utilisateur();
        $user = $model->findByEmail($testEmail);
        $hash = $user['mot_de_passe'];
        
        $verifyResult = password_verify($testPassword, $hash);
        echo "<p>RÃ©sultat password_verify : " . ($verifyResult ? "VRAI" : "FAUX") . "</p>";
        
        if ($testPassword === $hash) {
            echo "<p>Comparaison directe : VRAI (mot de passe non hashÃ©)</p>";
        } else {
            echo "<p>Comparaison directe : FAUX (mot de passe hashÃ©)</p>";
        }
    }
    
    echo "<h2>CrÃ©er un utilisateur de test :</h2>";
    echo "<form method='post'>";
    echo "<input type='hidden' name='action' value='create_user'>";
    echo "<label>Email : <input type='email' name='email' value='test@congoexplorerhub.com'></label><br>";
    echo "<label>Mot de passe : <input type='password' name='password' value='test123'></label><br>";
    echo "<input type='submit' value='CrÃ©er utilisateur'>";
    echo "</form>";
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'create_user') {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        
        $hash = password_hash($password, PASSWORD_BCRYPT);
        
        $stmt = $db->prepare('INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, role) VALUES (:nom, :prenom, :email, :hash, :role)');
        $result = $stmt->execute([
            'nom' => 'Test',
            'prenom' => 'User',
            'email' => $email,
            'hash' => $hash,
            'role' => 'Journaliste'
        ]);
        
        if ($result) {
            echo "<p style='color: green;'>âœ“ Utilisateur crÃ©Ã© avec succÃ¨s !</p>";
            echo "<p>Email : " . htmlspecialchars($email, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . "</p>";
            echo "<p>Hash : " . htmlspecialchars($hash, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . "</p>";
        } else {
            echo "<p style='color: red;'>âœ— Erreur lors de la crÃ©ation</p>";
        }
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Erreur : " . htmlspecialchars($e->getMessage(), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . "</p>";
}
?>
