<?php
require_once "db.php";
require_once "auth.php";

$search = "";

if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
}

if ($search != "") {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE ? OR description LIKE ? ORDER BY id DESC");
    $stmt->execute(["%$search%", "%$search%"]);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Produits - Amadon</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header>
    <div class="container">
        <h1>Produits</h1>
        <nav>
            <a href="index.php">Accueil</a>
            <?php if (isLogged()) { ?>
                <a href="add_product.php">Ajouter produit</a>
                <a href="logout.php">Logout</a>
            <?php } else { ?>
                <a href="login.php">Login</a>
                <a href="register.php">Inscription</a>
            <?php } ?>
        </nav>
    </div>
</header>

<main class="container">
    <h2>Rechercher un produit</h2>

    <form method="get" action="" class="search-form">
        <input type="text" name="search" placeholder="Ex : support PC, webcam, souris..." value="<?php echo htmlspecialchars($search); ?>">
        <input type="submit" value="Rechercher">
    </form>

    <?php if ($search != "") { ?>
        <p>Résultat pour : <strong><?php echo htmlspecialchars($search); ?></strong></p>
    <?php } ?>

    <div class="grid">
        <?php if (count($products) > 0) { ?>
            <?php foreach($products as $product) { ?>
                <div class="card">
                    <a href="product_detail.php?id=<?php echo $product['id']; ?>">
                        <img src="uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="Produit">
                    </a>

                    <h3>
                        <a href="product_detail.php?id=<?php echo $product['id']; ?>" class="product-link">
                            <?php echo htmlspecialchars($product['name']); ?>
                        </a>
                    </h3>

                    <p><?php echo htmlspecialchars($product['description']); ?></p>
                    <p class="price"><?php echo number_format($product['price'], 2); ?> €</p>

                    <?php if (isLogged()) { ?>
                        <p>
                            <a href="edit_product.php?id=<?php echo $product['id']; ?>">Modifier</a>
                            |
                            <a href="delete_product.php?id=<?php echo $product['id']; ?>" onclick="return confirm('Supprimer ce produit ?');">Supprimer</a>
                        </p>
                    <?php } ?>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p>Aucun produit trouvé.</p>
        <?php } ?>
    </div>
</main>

</body>
</html>