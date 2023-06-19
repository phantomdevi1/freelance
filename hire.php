<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Freelance - найдите надежных и квалифицированных фрилансеров для выполнения любых задач. Мы предлагаем широкий спектр услуг, от веб-разработки до дизайна и маркетинга. Безопасная платформа для поиска и общения с профессионалами, готовыми помочь вам реализовать любой проект.">
    <title>Главная</title>
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
    </style>
</head>
<body>
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
    <h1 class="key_word">freelance, сделать заказ, работа</h1>
    <div class="content_hire">
        <?php
            // Подключение к базе данных
            $servername = "localhost";
            $username = "root";
            $password = "root";
            $dbname = "freelance";

            $conn = new mysqli($servername, $username, $password, $dbname);

            // Проверка подключения
            if ($conn->connect_error) {
                die("Ошибка подключения: " . $conn->connect_error);
            }

            // Получение user_id из куки или из другого источника
            $user_id = $_COOKIE['user_id']; // Пример использования куки. Замените на ваш источник данных.
            $orderId = $_COOKIE['order_id'];
            
            // Выполнение запроса к базе данных для получения списка пользователей
            $sql = "SELECT users.nickname, user_jobs.user_id
                    FROM user_jobs
                    INNER JOIN users ON user_jobs.user_id = users.id
                    WHERE user_jobs.job_id = '$orderId' AND user_jobs.user_id != '$user_id'";
            $result = $conn->query($sql);
            $writing_hire = "INSERT INTO current_jobs (job_id, user_id)"
            if ($result->num_rows > 0) {
                // Вывод данных
                while($row = $result->fetch_assoc()) {
                    echo "<div class='hire_item'>";
                    echo "<p class='nickname'>" . $row["nickname"] . "</p>";
                    echo "<button class='hire_btn'>Нанять</button>";
                    echo "</div>";
                }
            } else {
                echo"<center>";
                echo "Никто ещё не откликнулся :(";
                echo "</center>";
            }

            $conn->close();
        ?>
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
