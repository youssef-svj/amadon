<?php
require_once "db.php";
require_once "auth.php";

if (!isset($_GET['id'])) {
    die("Produit introuvable.");
}

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Produit introuvable.");
}

$message = "";

if (isset($_POST['payment_method'])) {
    $payment_method = $_POST['payment_method'];
    $message = "Paiement de démonstration sélectionné : " . htmlspecialchars($payment_method) . ". Aucun vrai paiement n'a été effectué.";
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Détail produit - Amadon</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header>
    <div class="container">
        <h1>Amadon</h1>
        <nav>
            <a href="index.php">Accueil</a>
            <a href="products.php">Produits</a>
            <?php if (isLogged()) { ?>
                <a href="logout.php">Logout</a>
            <?php } else { ?>
                <a href="login.php">Login</a>
                <a href="register.php">Inscription</a>
            <?php } ?>
        </nav>
    </div>
</header>

<main class="container">
    <div class="detail-box">
        <div class="detail-image">
            <img src="uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="Produit">
        </div>

        <div class="detail-info">
            <h2><?php echo htmlspecialchars($product['name']); ?></h2>
            <p><?php echo htmlspecialchars($product['description']); ?></p>
            <p class="price"><?php echo number_format($product['price'], 2); ?> €</p>

            <h3>Méthode de paiement</h3>

            <form method="post" action="">
                <label><input type="radio" name="payment_method" value="MasterCard" required> 💳 MasterCard</label><br>
                <label><input type="radio" name="payment_method" value="Visa"> 💳 Visa</label><br>
                <label><input type="radio" name="payment_method" value="American Express"> 💳 American Express</label><br>
                <label><input type="radio" name="payment_method" value="PayPal"> 💻 PayPal</label><br>
                <label><input type="radio" name="payment_method" value="Apple Pay"> 📱 Apple Pay</label><br>
                <label><input type="radio" name="payment_method" value="Google Pay"> 📱 Google Pay</label><br>
                <label><input type="radio" name="payment_method" value="Virement bancaire"> 💸 Virement bancaire</label><br>
                <label><input type="radio" name="payment_method" value="Paiement à la livraison"> 💵 Paiement à la livraison</label><br><br>

                <input type="submit" value="Payer maintenant">
            </form>

            <?php if ($message != "") { ?>
                <p class="success-msg"><?php echo $message; ?></p>
            <?php } ?>
        </div>
    </div>
</main>

</body>
</html>