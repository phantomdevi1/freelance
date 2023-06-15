<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заказ</title>
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
<h1 class="key_word">freelance, конкретный заказ, работа</h1>
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

<div class="content_concret_order">
    <div class="title_concret_order">
        <h3>Заказ</h3>
    </div>

    <?php
    if (isset($_GET['id'])) {
        $orderId = $_GET['id'];

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

        $stmt = $pdo->prepare('SELECT jobs.*, users.nickname FROM jobs INNER JOIN users ON jobs.employer_id = users.id WHERE jobs.id = ?');
        $stmt->execute([$orderId]);
        $order = $stmt->fetch();

        if ($order) {
            $title = $order['title'];
            $customer = $order['nickname']; // Получение значения столбца nickname
            $description = $order['description'];
            $budget = $order['budget'];
            $created_at = $order['created_at'];

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['take_order'])) {
                $userNickname = $_COOKIE['name'];
                $stmt = $pdo->prepare('SELECT id FROM users WHERE nickname = ?');
                $stmt->execute([$userNickname]);
                $user = $stmt->fetch();

                if ($user) {
                    $userId = $user['id'];

                    $stmt = $pdo->prepare('INSERT INTO user_jobs (user_id, job_id) VALUES (?, ?)');
                    $stmt->execute([$userId, $orderId]);

                    echo '<script> alert("Заказ успешно взят!")</script>';
                }
            }

            ?>
            <div class="order_info">
                <h4><?= $title ?></h4>
                <a href="" class="name_customer"><?= $customer ?></a>
                <span class="created_date_order"><?= $created_at ?></span>
            </div>

            <div class="price_order-order">
                <span>Оплата: <?= $budget ?> ₽/заказ</span>
            </div>

            <div class="div_description_order-order">
                <h3>Описание</h3>
                <span class="description_order-order"><?= $description ?></span>
            </div>

            <form method="POST">
                <center>
                    <input type="submit" class="take_order_btn" name="take_order" value="Взять"/>
                </center>
            </form>

            <?php
        } else {
            echo '<div class="no-orders-message">Заказ не найден</div>';
        }
    } else {
        echo '<div class="no-orders-message">Некорректный идентификатор заказа</div>';
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
