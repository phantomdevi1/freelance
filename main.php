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
    <center>
        
    <div class="content_main">
         <a href="all_order.php" class="take_order">Взять заказ</a>
          <a href="make_order.php" class="make_order">Разместить заказ</a>  
        </div> 
    </center>
    
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
