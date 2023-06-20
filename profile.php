<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Freelance - найдите надежных и квалифицированных фрилансеров для выполнения любых задач. Мы предлагаем широкий спектр услуг, от веб-разработки до дизайна и маркетинга. Безопасная платформа для поиска и общения с профессионалами, готовыми помочь вам реализовать любой проект.">
    <title>Профиль</title>
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
<h1 class="key_word">freelance, профиль, работа, личный кабинет</h1>
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
    <a href="profile.php" class="acount_dropdown"><?=$_COOKIE['name']?></a>
        <a href="deletecookie.php" class="exit_btn">Выход</a>
    </div>
    
    <div class="content_profile">

    <div class="avatarka-div">
      <div class="flex">
      <img src="img/bed.svg" alt="" class="avatarka" width="273px">
      </div>
      <span class="name_profile">
      <?=$_COOKIE['name']?>
      </span>
      </div>
      
    
      </div>

      <div class="makes_order-profile margin50">
        <div class="makes_order-profile-title">
          <h3>Выполненные заказы</h3>
        </div>
        <div class="makes_order-profile-content">
        <?php
// Параметры подключения к базе данных
$host = "localhost";
$username = "root";
$password = "root";
$database = "freelance";

// Подключение к базе данных
$connection = mysqli_connect($host, $username, $password, $database);

if (!$connection) {
    die("Ошибка подключения к базе данных: " . mysqli_connect_error());
}

// Получение идентификатора пользователя по его nickname из $_COOKIE['name']
$nickname = $_COOKIE['name'];
$query = "SELECT id FROM users WHERE username = '$nickname'";
$result = mysqli_query($connection, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $user_id = $row['id'];

    // Получение выполненных заказов для данного пользователя
    $query = "SELECT j.title, cj.rating, cj.job_id 
              FROM completed_jobs cj
              JOIN jobs j ON cj.job_id = j.id
              WHERE cj.freelancer_id = '$user_id'";
    $result = mysqli_query($connection, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            // Формирование строки с выполненными заказами
            $completedJobs = '';
            while ($row = mysqli_fetch_assoc($result)) {
                $title = $row['title'];
                $rating = $row['rating'];
                $job_id = $row['job_id'];

                // Формирование информации о выполненном заказе
                $completedJobs .= "<div class='completed-job'>
                                     <div class='job-title'>$title</div>
                                     <div class='job-rating'>$rating/5</div>
                                     <div class='job-link'><a href='concret_order.php?id=$job_id'>Ссылка на заказ</a></div>
                                   </div>";
            }
            // Вывод выполненных заказов
            echo $completedJobs;
        } else {
            // Если у пользователя нет выполненных заказов
            echo "Пользователь ещё не выполнял никакие заказы.";
        }
    } else {
        // Если произошла ошибка при выполнении запроса
        echo "Ошибка при выполнении запроса.";
    }
} else {
    // Если пользователь не найден в базе данных
    echo "Пользователь не найден или не выполнял не выполнял никаких заказов.";
}

// Закрытие соединения с базой данных
mysqli_close($connection);
?>


        </div>
      </div>

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
