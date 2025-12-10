<?php
// Fichier : index.php
require 'db.php'; 

$stmt = $bdd->query("SELECT * FROM plats");
$plats = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bistro Débutant - Les Délices de Lael</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="wrap">
    <header>
      <div class="brand">
        <div class="logo">L-TWELVE</div>
        <div>
          <div style="font-weight:700">Les delices de lael</div>
          <div class="small">Cuisine locale & rapide</div>
        </div>
      </div>
      <nav>
        <a href="#menu">Menu</a>
        <a href="#about">À propos</a>
        <a href="connexion.php">Admin</a> </nav>
    </header>

    <main>
      <section class="hero">
        <div class="left">
          <h1>Bienvenue chez les delices de lael</h1>
          <p><strong>Des plats simples, frais et savoureux — parfait pour déjeuner ou dîner</strong></p>
          <a class="btn" href="#menu">Voir le menu</a>
        </div>
        <div class="right">
          <img src="background-header.jpg" height="200px" alt="Bannière">
        </div>
      </section>

      <section id="menu">
        <h2>Notre Menu</h2>
        <div class="menu-grid">
          
          <?php foreach ($plats as $plat): ?>
          <article class="card">
            <img src="<?= htmlspecialchars($plat['image']) ?>" alt="<?= htmlspecialchars($plat['nom']) ?>">
            
            <h3><?= htmlspecialchars($plat['nom']) ?></h3>
            <div class="muted"><?= htmlspecialchars($plat['description']) ?></div>
            
            <div class="price"><?= number_format($plat['prix'], 0, ',', ' ') ?> F</div>
          </article>
          <?php endforeach; ?>
          </div>
      </section>

      <section id="about">
        <h2>À propos</h2>
        <p class="muted">Petit restaurant local avec des plats faits maison.</p>
      </section>

      <section id="contact">
        <h2>Contact</h2>
        <form>
          <label>Nom</label>
          <input type="text" required>
          <label>Email</label>
          <input type="email" required>
          <label>Message</label>
          <textarea required></textarea>
          <button class="btn" type="submit">Envoyer</button>
        </form>
      </section>
    </main>

    <footer>
      © Les delices de Lael — Tous droits réservés
    </footer>
  </div>
</body>
</html>