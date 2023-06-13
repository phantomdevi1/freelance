<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                <a href="">Главная</a>
                <a href="">Заказы</a>
                <a href="">Разместить заказ</a>
            </li>
        </ul>

        <button class="toolbar"></button>
    </header>
    
    <div class="toolbar_drop">
        <a href=""><?php echo isset($_GET['username']) ? $_GET['username'] : 'Имя'; ?></a>

        <button>Выход</button>
    </div>
    
    <center>
    <div class="content_main">
         <a href="take_order" class="take_order">Взять заказ</a>
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
