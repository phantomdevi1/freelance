<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заказы</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .toolbar_drop {
            display: none; /* Скрываем блок изначально */
            position: absolute;
            width: 242px;
            height: 122px;
            left: 1661px;
            top: 143px;
            background: #8294C4;
            border-radius: 0px 0px 10px 10px;
        }

        .no-orders-message {
            color: white;
            font-size: 18px;
        }

        .concret_order {
            width: 263px;
            height: 76px;
            background: #FFEAD2;
            border-radius: 10px;
            font-weight: 400;
            font-size: 32px;
            color: #000000;
            text-decoration: none;
        }
    </style>
</head>
<body>
<h1 class="key_word">freelance, все заказы</h1>
<header>
    <ul>
        <li>
            <a href="main.php">Главная</a>
            <a href="all_order.php">Заказы</a>
            <a href="make_order.php">Разместить заказ</a>
        </li>
    </ul>

    <button class="toolbar"></button>
</header>

<div class="toolbar_drop">
<a href="profile.php" class="acount_dropdown"><?=$_COOKIE['name']?></a>
    <a href="deletecookie.php" class="exit_btn">Выход</a>
</div>

<div class="content_all_order">
    <div class="title_make_order">
        <h3 class="title_all_order">Заказы</h3>
    </div>

    <?php
    // Получение данных из базы данных
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

    $stmt = $pdo->query('SELECT * FROM jobs');
    $hasOrders = false; // Переменная для отслеживания наличия заказов

   
    while ($row = $stmt->fetch()) {
        $hasOrders = true; // Устанавливаем значение true, если найдены заказы в базе данных

        $orderId = $row['id'];
        $title = $row['title'];
        $description = $row['description'];
        $budget = $row['budget'];
        $created_at = $row['created_at'];

        echo '<div class="div_order">';
        echo '<div class="display_flex">';
        echo '<div class="flex_column description_order">';
        echo '<h4 class="title_order">' . $title . '</h4>';
        echo '<span class="description-order">' . $description . '</span>';
        echo '<span class="created_order">' . $created_at . '</span>';
        echo '</div>';
        echo '<div class="flex_column price_btn_order">';
        echo '<span class="price_order">' . $budget . ' ₽/заказ</span>';
        echo '<a href="concret_order.php?id=' . $orderId . '" class="concret_order">Взять</a>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }

    // Если база данных не содержит заказов, выводим сообщение "Нет заказов"
    if (!$hasOrders) {
        echo '<div class="div_order">';
        echo '<span class="no-orders-message">Нет заказов</span>';
        echo '</div>';
    }
    if (isset($_GET['id'])) {
      
      $orderId = $_GET['id'];
      
    }
    ?>
</div>

<script>
    const toolbarButton = document.querySelector('.toolbar');
    const toolbarDrop = document.querySelector('.toolbar_drop');
    let isToolbarDropVisible = false;

    toolbarButton.addEventListener('click', function () {
        isToolbarDropVisible = !isToolbarDropVisible;
        toolbarDrop.style.display = isToolbarDropVisible ? 'flex' : 'none';
    });

    document.addEventListener('click', function (event) {
        if (!toolbarButton.contains(event.target) && !toolbarDrop.contains(event.target)) {
            isToolbarDropVisible = false;
            toolbarDrop.style.display = 'none';
        }
    });
</script>

</body>
</html>
