<?php
require_once "db.php";
require_once "auth.php";

$message = "";

if (isset($_POST['login']) && isset($_POST['password'])) {
    $login = trim($_POST['login']);
    $password = trim($_POST['password']);

    if ($login != "" && $password != "") {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE login = ?");
        $stmt->execute([$login]);

        if ($stmt->rowCount() > 0) {
            $message = "Ce login existe déjà.";
        } else {
            $stmt = $pdo->prepare("INSERT INTO users(login, password) VALUES(?, ?)");
            $stmt->execute([$login, $password]);
            $message = "Inscription réussie.";
        }
    } else {
        $message = "Veuillez remplir tous les champs.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Inscription - Amadon</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="form-box">
    <h1>Inscription</h1>

    <form method="post" action="">
        <label>Login</label>
        <input type="text" name="login">

        <label>Mot de passe</label>
        <input type="password" name="password">

        <input type="submit" value="S'inscrire">
    </form>

    <p><?php echo $message; ?></p>
    <p><a href="login.php">Déjà inscrit ? Se connecter</a></p>
</div>

</body>
</html>