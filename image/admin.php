<?php
// Fichier : admin.php
session_start();
require 'db.php';

// --- PROTECTION DE LA PAGE ---
if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit();
}

// --- LOGIQUE D'AJOUT (CREATE) ---
if (isset($_POST['ajouter_plat'])) {
    $nom = $_POST['nom'];
    $desc = $_POST['description'];
    $prix = $_POST['prix'];
    $img = $_POST['image']; 

    $sql = "INSERT INTO plats (nom, description, prix, image) VALUES (?, ?, ?, ?)";
    $stmt = $bdd->prepare($sql);
    $stmt->execute([$nom, $desc, $prix, $img]);
    header("Location: admin.php"); // Rechargement
    exit();
}

// --- LOGIQUE DE SUPPRESSION (DELETE) ---
if (isset($_GET['supprimer'])) {
    $id = $_GET['supprimer'];
    $bdd->prepare("DELETE FROM plats WHERE id = ?")->execute([$id]);
    header("Location: admin.php"); 
    exit();
}

// Récupération de la liste pour l'affichage
$plats = $bdd->query("SELECT * FROM plats")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Administration - Les Délices de Lael</title>
    <link rel="stylesheet" href="style.css"> 
    <style>
        .admin-container { max-width: 800px; margin: 0 auto; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .btn-danger { color: red; text-decoration: none; }
        form input { padding: 8px; margin-bottom: 10px; border: 1px solid #ccc; }
    </style>
</head>
<body>
    <header>
        <div class="brand"><div class="logo">ADMINISTRATION</div></div>
        <nav>
            <a href="index.php">Voir le site public</a>
            <a href="logout.php">Se déconnecter</a>
        </nav>
    </header>

    <div class="admin-container">
        <h2>Ajouter un nouveau plat</h2>
        <form method="POST" style="background: #f4f4f4; padding: 20px;">
            <label>Nom du plat</label><br>
            <input type="text" name="nom" required style="width: 100%"><br>

            <label>Description</label><br>
            <input type="text" name="description" required style="width: 100%"><br>

            <label>Prix (FCFA)</label><br>
            <input type="number" name="prix" required><br>

            <label>Nom de l'image (ex: poulet.jpg)</label><br>
            <input type="text" name="image" required placeholder="nom-du-fichier.jpg"><br><br>

            <button type="submit" name="ajouter_plat" class="btn">Ajouter au menu</button>
        </form>

        <hr>

        <h2>Menu actuel</h2>
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Nom</th>
                    <th>Prix</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($plats as $plat): ?>
                <tr>
                    <td><img src="<?= $plat['image'] ?>" width="50" alt="<?= $plat['nom'] ?>"></td>
                    <td><?= htmlspecialchars($plat['nom']) ?></td>
                    <td><?= number_format($plat['prix'], 0, ',', ' ') ?> F</td>
                    <td>
                        <a href="admin.php?supprimer=<?= $plat['id'] ?>" class="btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce plat ?')">Supprimer</a>
                        </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>