<?php
require_once "db.php";
require_once "auth.php";
requireLogin();

$stmt = $pdo->query("SELECT * FROM homepage_content WHERE id = 1");
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$message = "";

if (isset($_POST['content'])) {
    $content = $_POST['content'];

    $stmt = $pdo->prepare("UPDATE homepage_content SET content = ? WHERE id = 1");
    $stmt->execute([$content]);

    $message = "Contenu mis à jour.";
    $row['content'] = $content;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Modifier accueil</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
</head>
<body>

<div class="form-box large">
    <h1>Modifier la page d'accueil</h1>

    <form method="post" action="">
        <textarea name="content" id="content" rows="10"><?php echo htmlspecialchars($row['content']); ?></textarea>
        <script>
            CKEDITOR.replace('content');
        </script>

        <input type="submit" value="Enregistrer">
    </form>

    <p><?php echo $message; ?></p>
    <p><a href="index.php">Retour accueil</a></p>
</div>

</body>
</html>