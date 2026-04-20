<?php
require_once "db.php";
require_once "auth.php";
requireLogin();

$message = "";

if (isset($_POST['name']) && isset($_POST['description']) && isset($_POST['price'])) {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = trim($_POST['price']);
    $image = "";

    if ($name != "" && $description != "" && $price != "") {
        if (isset($_FILES['image']) && $_FILES['image']['name'] != "") {
            $image = basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $image);
        }

        $stmt = $pdo->prepare("INSERT INTO products(name, description, price, image) VALUES(?, ?, ?, ?)");
        $stmt->execute([$name, $description, $price, $image]);

        $message = "Produit ajouté avec succès.";
    } else {
        $message = "Tous les champs sont obligatoires.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ajouter produit</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="form-box">
    <h1>Ajouter un produit</h1>

    <form method="post" enctype="multipart/form-data" action="">
        <label>Nom</label>
        <input type="text" name=\"name\">

        <label>Description</label>
        <textarea name="description"></textarea>

        <label>Prix</label>
        <input type="text" name="price">

        <label>Image</label>
        <input type="file" name="image">

        <input type="submit" value="Ajouter">
    </form>

    <p><?php echo $message; ?></p>
    <p><a href="products.php">Retour aux produits</a></p>
</div>

</body>
</html>