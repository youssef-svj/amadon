<?php
require_once "db.php";
require_once "auth.php";

$message = "";

if (isset($_POST['login']) && isset($_POST['password'])) {
    $login = trim($_POST['login']);
    $password = trim($_POST['password']);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE login = ? AND password = ?");
    $stmt->execute([$login, $password]);

    if ($stmt->rowCount() == 1) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['login'] = $user['login'];

        header("Location: index.php");
        exit;
    } else {
        $message = "Identifiants incorrects.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login - Amadon</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="form-box">
    <h1>Connexion</h1>

    <form method="post" action="">
        <label>Login</label>
        <input type="text" name="login">

        <label>Mot de passe</label>
        <input type="password" name="password">

        <input type="submit" value="Se connecter">
    </form>

    <p><?php echo $message; ?></p>
    <p><a href="register.php">Créer un compte</a></p>
</div>

</body>
</html>