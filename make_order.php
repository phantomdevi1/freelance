<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Размещение</title>
    <link rel="stylesheet" href="style.css">
    <style>
      .toolbar_drop {
    
      }
    </style>
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
        <a href=""><?php echo isset($_GET['username']) ? $_GET['username'] : 'Имя'; ?></a>
        <button>Выход</button>
    </div>
    
    <center>
        <div class="content_make_order">
            <span class="title_make_order">
                
            </span>
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
