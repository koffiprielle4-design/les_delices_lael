<?php
// Fichier : connexion.php
session_start();
require 'db.php';

$erreur = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $mdp_clair = $_POST['password'];

    $stmt = $bdd->prepare("SELECT * FROM utilisateurs WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($mdp_clair, $user['password'])) {
        // Connexion réussie : on enregistre l'info dans la session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        header("Location: admin.php"); // Redirection vers la zone admin
        exit();
    } else {
        $erreur = "Email ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Connexion Admin</title></head>
<body>
    <h1>Connexion Administrateur</h1>
    <?php if (!empty($erreur)) { echo "<p style='color: red;'>$erreur</p>"; } ?>
    
    <form method="POST">
        <label>Email :</label>
        <input type="email" name="email" required><br><br>
        
        <label>Mot de passe :</label>
        <input type="password" name="password" required><br><br>
        
        <button type="submit">Se connecter</button>
    </form>
    <p>Pas de compte ? <a href="inscription.php">Créez-en un</a></p>
</body>
</html>