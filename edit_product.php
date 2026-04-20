<?php
require_once "db.php";
require_once "auth.php";
requireLogin();

if (!isset($_GET['id'])) {
    die("ID manquant.");
}

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Produit introuvable.");
}

$message = "";

if (isset($_POST['name']) && isset($_POST['description']) && isset($_POST['price'])) {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = trim($_POST['price']);
    $image = $product['image'];

    if (isset($_FILES['image']) && $_FILES['image']['name'] != "") {
        $image = basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $image);
    }

    $stmt = $pdo->prepare("UPDATE products SET name = ?, description = ?, price = ?, image = ? WHERE id = ?");
    $stmt->execute([$name, $description, $price, $image, $id]);

    header("Location: products.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Modifier produit</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="form-box">
    <h1>Modifier produit</h1>

    <form method="post" enctype="multipart/form-data" action="">
        <label>Nom</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>">

        <label>Description</label>
        <textarea name="description"><?php echo htmlspecialchars($product['description']); ?></textarea>

        <label>Prix</label>
        <input type="text" name="price" value="<?php echo htmlspecialchars($product['price']); ?>">

        <label>Nouvelle image (facultatif)</label>
        <input type="file" name="image">

        <input type="submit" value="Modifier">
    </form>

    <p><a href="products.php">Retour</a></p>
</div>

</body>
</html>