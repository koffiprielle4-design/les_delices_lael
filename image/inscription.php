<?php
// Fichier : inscription.php
require 'db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $mdp_clair = $_POST['password'];

    // Hachage du mot de passe pour la sécurité
    $mdp_hache = password_hash($mdp_clair, PASSWORD_DEFAULT);

    $sql = "INSERT INTO utilisateurs (email, password) VALUES (?, ?)";
    $stmt = $bdd->prepare($sql);
    
    try {
        $stmt->execute([$email, $mdp_hache]);
        $message = "Inscription réussie ! <a href='connexion.php'>Connectez-vous</a>.";
    } catch (Exception $e) {
        $message = "Erreur : Cet email est déjà utilisé.";
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Inscription Admin</title></head>
<body>
    <h1>Inscription Administrateur</h1>
    <?php if (!empty($message)) { echo "<p style='color: green;'>$message</p>"; } ?>
    
    <form method="POST">
        <label>Email :</label>
        <input type="email" name="email" required><br><br>
        
        <label>Mot de passe :</label>
        <input type="password" name="password" required><br><br>
        
        <button type="submit">S'inscrire</button>
    </form>
    <p>Déjà un compte ? <a href="connexion.php">Connectez-vous</a></p>
</body>
</html>