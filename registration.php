<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1 class="key_word">freelance, регистрация</h1>
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
    $email = $_POST['registration_mail'];
    $name = $_POST['registration_name'];
    $nickname = $_POST['nikname_registration'];
    $password = $_POST['password_registraation'];

    // Проверка на заполнение всех полей
    if (empty($email) || empty($name) || empty($nickname) || empty($password)) {
        echo '<script>alert("Заполните все поля!");</script>';
    } else {
        // Хеширование пароля
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Получение текущей даты и времени
        $createdAt = date('Y-m-d H:i:s');

        // Вставка данных в БД
        $stmt = $pdo->prepare('INSERT INTO users (username, nickname, password, email, created_at) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$name, $nickname, $hashedPassword, $email, $createdAt]);

        // Показать сообщение об успешной регистрации
        echo '<script>alert("Регистрация успешна!");</script>';
        
        // Перенаправление на страницу "autorization.php"
        header("Location: autorization.php");
        exit();
    }
}
?>

    <img src="img/bed.svg" alt="" class="bed_svg">
    <img src="img/drink.svg" alt="" class="drink_svg">
    <img src="img/freelance.svg" alt="" class="freelance_svg">
    <center>
        <form action="" method="POST">
        <div class="registration_div">
            
            <h1 class="autorization_title">Регистрация</h1>
            <input type="email" name="registration_mail" id="" class="registration_mail"  placeholder="Введите ваш email" required>
            <input type="text" name="registration_name" id="" class="registration_name" placeholder="Введите ваше имя" required>
            <input type="text" name="nikname_registration" id="" class="nikname_registration" placeholder="Введите ваш никнейм" required>
            <input type="password" name="password_registraation" class="password_registraation" placeholder="Введите ваш пароль" required>
            <input type="submit" value="Зарегистрироваться" class="registration_btn">
            <a href="autorization.php" class="input_ssilka">Назад</a>
            
        </div>
        </form>
    </center>
</body>
</html>
