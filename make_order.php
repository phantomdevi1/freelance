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
    $title = $_POST['title'];
    $description = $_POST['description'];
    $budget = $_POST['budget'];
    $readyAt = $_POST['ready_at'];

    // Получение идентификатора работодателя
    $employer_id = null;
    if (isset($_COOKIE['name'])) {
        $nickname = $_COOKIE['name'];
        $stmt = $pdo->prepare('SELECT id FROM users WHERE nickname = ?');
        $stmt->execute([$nickname]);
        $result = $stmt->fetch();
        if ($result) {
            $employer_id = $result['id'];
        }
    }

    // Проверка на заполненность всех полей
    if (!empty($title) && !empty($description) && !empty($budget) && !empty($readyAt) && $employer_id) {
        // Вставка данных в БД
        $stmt = $pdo->prepare('INSERT INTO jobs (employer_id, title, `description`, budget, created_at, ready_at) VALUES (?, ?, ?, ?, NOW(), ?)');
        $stmt->execute([$employer_id, $title, $description, $budget, $readyAt]);

        // Показать сообщение об успешном размещении заказа
        echo '<script>alert("Заказ успешно размещен!");</script>';
    } else {
        // Показать сообщение об ошибке незаполненных полей
        echo '<script>alert("Пожалуйста, заполните все поля!");</script>';
    }
}
?>

<!-- Остальной HTML-код -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Размещение</title>
    <link rel="stylesheet" href="style.css">
    
</head>
<body>
    <header>
        <ul>
            <li>
                <a href="main.php">Главная</a>
                <a href="">Заказы</a>
                <a href="make_order.php">Разместить заказ</a>
            </li>
        </ul>

        <button class="toolbar"></button>
    </header>
    
    <div class="toolbar_drop">
        <a href=""> <a href=""><?=$_COOKIE['name']?></a></a>
        <a href="deletecookie.php">Выход</a>
    </div>
    

    <div class="content_make_order">
        <form action="" method="POST">
            <center>
                <div class="title_make_order">
                    <h3>Размещение заказа</h3>
                </div>
                <h3 class="name_order_title">Название</h3>
                <input type="text" name="title" class="name_order_input" placeholder="Введите название" required>

                <h3 class="description_order">Описание</h3>
                <textarea name="description" cols="30" rows="10" placeholder="Напишите описание к заданию" required></textarea>      

                <div class="div_price_order">
                    <div class="div_price_order-price">
                    <h3>Введите оплату</h3>
                    <input type="number" name="budget" class="price_make_order" required>
                    <h3>₽/заказ</h3>
                    
                    </div>
                    <div class="">
                    <h3>До какого числа нужно выполнить заказ:</h3>
                    <input type="date" name="ready_at" class="date_last_order" required>
                    </div>
                </div>              
                
            </center>
            <center>
            <input type="submit" value="Разместить заказ" class="submit_make_order">
            </center>
        </form>
    </div>
        
    <script>
      const toolbarButton = document.querySelector('.toolbar');
      const toolbarDrop = document.querySelector('.toolbar_drop');
      let isToolbarDropVisible = false;

      toolbarButton.addEventListener('click', function() {
        isToolbarDropVisible = !isToolbarDropVisible;
        toolbarDrop.style.display = isToolbarDropVisible ? 'flex' : 'none';
      });

      document.addEventListener('click', function(event) {
        if (!toolbarButton.contains(event.target) && !toolbarDrop.contains(event.target)) {
          isToolbarDropVisible = false;
          toolbarDrop.style.display = 'none';
        }
      });
    </script>
</body>
</html>
