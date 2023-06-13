<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<img src="img/bed.svg" alt="" class="bed_svg">
    <img src="img/drink.svg" alt="" class="drink_svg">
    <img src="img/freelance.svg" alt="" class="freelance_svg">
    <center>
        <form action="" method="POST">
            <div class="autorization_div">
                <h1 class="autorization_title">Авторизация</h1>
                <input type="text" name="username_autorization" class="email_autorization"  placeholder="Введите email или никнейм">
                <input type="password" name="password_autorization" class="password_autorization"  placeholder="Введите пароль">
                <input type="submit" value="Войти" class="autorization_btn">
                <a href="registration.php" class="registr_ssilka">Регистрация</a>
            </div>
        </form>
    </center>

    <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $host = 'localhost';
    $db   = 'freelance';
    $user = 'root';
    $pass = 'root';
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        $pdo = new PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }

    // Получение данных из формы
    $username = $_POST['username_autorization'];
    $password = $_POST['password_autorization'];

    // Поиск пользователя в БД по никнейму
    $stmt = $pdo->prepare('SELECT * FROM users WHERE nickname = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    // Проверка соответствия пароля
    if ($user && password_verify($password, $user['password'])) {
        // Передача имени пользователя через URL-параметр
        $redirectUrl = "main.php?username=" . urlencode($user['nickname']);
        echo '<script>window.location.href = "' . $redirectUrl . '";</script>';
    } else {
        // Неверные учетные данные
        echo '<script>alert("Неверный никнейм или пароль!");</script>';
    }
}
?>

</body>
</html>
