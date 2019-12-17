<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Rocket Business Test Junior</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="icon" type="image/png" href="img/rocket-business.png">
  <link href="https://fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&display=swap" rel="stylesheet">
</head>
<body>
  <header>
    <nav class="nav-top">
      <ul>
        <li class="nav-top-list">
          <a href="#" class="nav-top-item">О компании</a>
        </li>
        <li class="nav-top-list">
          <a href="#" class="nav-top-item">Доставка</a>
        </li>
        <li class="nav-top-list">
          <a href="#" class="nav-top-item">Оплата</a>
        </li>
        <li class="nav-top-list">
          <a href="#" class="nav-top-item">Сервис</a>
        </li>
        <li class="nav-top-list">
          <a href="#" class="nav-top-item">Возврат</a>
        </li>
        <li class="nav-top-list">
          <a href="#" class="nav-top-item">Статьи</a>
        </li>
        <li class="nav-top-list">
          <a href="#" class="nav-top-item">Контакты</a>
        </li>
      </ul>
    </nav>
    <div class="header-middle">
      <a href="#"><img src="img/logo.png" alt="лого"></a>
      <div class="search">
        <img src="img/find.png" alt="поиск" class="search">
        <img src="img/array-forward.png" alt="перейти" class="array-right">
        <input class="header-input" type="search" placeholder="Поиск по товарам">
      </div>
      <div class="phone">
        <a class="phone-top" href="tel:+78007079924">8 (800) 707-99-24</a>
        <p class="phone-time">9.00 - 20.00 ежедневно</p>
      </div>
      <div class="icons">
        <img src="img/charts.png" class="top-icon" alt="диаграмма">
        <span>0</span>
        <img src="img/heart.png" class="top-icon" alt="лайк">
        <span>6</span>
        <img src="img/shop.png" class="top-icon" alt="корзина">
        <span>17</span>
      </div>
    </div>
    <nav class="tabs">
      <ul class="tabs-list">
          <li class="product">
            <a href="#"><span class="product-item">Продукция</span>
            <img src="img/energotech.png" alt="энерготех"></a>
          </li>
          <li class="tabs-item">
            <a href="#">Стабилизаторы 220В</a>
          </li>
          <li class="tabs-item">
            <a href="#">Стабилизаторы 380В</a>
          </li>
          <li class="tabs-item">
            <a href="#">Генераторы 220В</a>
          </li>
          <li class="tabs-item">
            <a href="#">Генераторы 380В</a>
          </li>
          <li class="tabs-item">
            <a href="#">ИБП и батареи</a>
          </li>
          <li class="tabs-item">
            <a href="#">Прочая техника</a>
          </li>
          <li class="tabs-item">
            <a href="#">Услуги</a>
          </li>
          <li class="sale">
            <a href="#" class="sale-item">Акции</a>
          </li>
        </ul>
    </nav>
    <p class="breadcrumbs">Главная<span class="breadcrumbs-arrow">  →  </span>Статьи</p>
  </header>
  <section>
    <h1 class="useful">Полезная информация</h1>
    <?php
      $pageNum = 1;
      if (isset($_GET['page'])) {
        $pageNum = (int)$_GET['page'];
      }
      $pagesCount = 0;
      $postCountOnPage = 6;
      $pdo = null;
      try {
        $pdo = new PDO('mysql:host=localhost;dbname=electroprestige', 'root', '');
        $pdo->exec('SET NAMES "utf8"');
        $numPosts = $pdo->query('select count(*) from articles')->fetchColumn();
        $pagesCount = $numPosts / $postCountOnPage;
        if ($numPosts % $postCountOnPage != 0) {
          $pagesCount += 1;
        }
      } catch (PDOException $e) {
        // echo 'Не удалось подключиться к базе данных';
      }
      // $pagesCount = 10;
      function printPaginationOnPage ($pageNum, $pagesCount) {
        if ($pageNum == 1) {
          echo '<a href="?page=' . 1 . '"><span class="page-num active-page-num">' . 1 . '</span></a>';
        } else echo '<a href="?page=' . 1 . '"><span class="page-num">' . 1 . '</span></a>';
        $isSetPoints = false;
        for ($i = 2; $i < $pagesCount; $i++) {
          if (abs($pageNum - $i) < 3) {
            $isSetPoints = false;
            if ($pageNum == $i) {
                echo '<a href="?page=' . $i . '"><span class="page-num active-page-num">' . $i . '</span></a>';
            } else {
                echo '<a href="?page=' . $i . '"><span class="page-num">' . $i . '</span></a>';
            }
          } else if (!$isSetPoints) {
            $isSetPoints = true;
            echo '<span class="num-points">...</span>';
          }
        }
        if ($pageNum == $pagesCount) {
          echo '<a href="?page=' . $pagesCount . '"><span class="page-num active-page-num">' . $pagesCount . '</span></a>';
        } else echo '<a href="?page=' . $pagesCount . '"><span class="page-num">' . $pagesCount . '</span></a>';
      }
    ?>
    <div class="pagination">
      <?php
        printPaginationOnPage($pageNum, $pagesCount);
      ?>
    </div>
    <?php
      try {
        if ($pdo != null) {
          $sql = 'SELECT * FROM articles';
          $result = $pdo->query($sql);
          $skipPostCount = $postCountOnPage * ($pageNum - 1);
          $lastPostCount = $skipPostCount + $postCountOnPage;
          $postCount = 0;
          // echo 'pageNum' . $pageNum;
          echo '<div class="cards">';
          while ($row = $result->fetch()) {
              // print_r($row);
              $postCount++;
              if ($postCount <= $skipPostCount) {
                  continue;
              }
              if ($postCount > $lastPostCount) {
                  break;
              }
              echo '<div class="card">';
              echo '<img class="preview" src="' . $row['preview'] . '">';
              echo '<div class="card-text">';
                echo '<h3 class="title">' . $row['title'] . "</h3>";
                echo '<div class="description">' . $row['description'] . "</div>";
              echo '</div>';
              echo '</div>';
          }
          echo '</div>';
        }
      } catch (PDOException $e) {
        // echo 'Не удалось подключиться к базе данных';
      }
    ?>
    <div class="pagination">
      <?php
        printPaginationOnPage($pageNum, $pagesCount);
      ?>
    </div>
  </section>
  <footer class="footer">
    <div class='address'>
      <p class="footer-text address-text">121471, г.Москва ул. Рябиновая 55 стр. 28</p>
      <p class="footer-text address-text"><a href="mailto:prestizh06@mail.ru">prestizh06@mail.ru</a></p>
      <p class="footer-text address-text phone-bottom"><a href="tel:+78007079924">8 (800) 707-99-24</a></p>
      <p><a class="footer-text address-text contact" href="#">контакты</a></p>
    </div>
    <div class="working-hours">
      <p class="footer-text">Режим работы:</p> 
      <p class="footer-text">Пн-чт с 8.00 до 19.00</p> 
      <p class="footer-text">Пт с 8.00 до 17.00</p>
      <p class="footer-text">Сб с 10.00 до 15.00</p>
      <p class="footer-text">Вс (по предварительной договоренности).</p>
    </div>
    <div>
      <nav class="nav-bottom">
        <ul class="menu-bottom">
          <li>
            <a class="footer-text nav-bottom-item" href="#">О компании</a>
          </li>
          <li>
            <a class="footer-text nav-bottom-item" href="#">Акции</a>
          </li>
          <li>
            <a class="footer-text nav-bottom-item" href="#">Доставка</a>
          </li>
        </ul>
        <ul class="menu-bottom menu-bottom-right">
          <li>
            <a class="footer-text nav-bottom-item" href="#">Оплата</a>
          </li>
          <li>
            <a class="footer-text nav-bottom-item" href="#">Сервис</a>
          </li>
          <li>
            <a class="footer-text nav-bottom-item" href="#">Возврат</a>
          </li>
        </ul>
      </nav>
      <p class="policy"><a href="#" class="footer-text">Политика обработки персональных данных</a></p>
    </div>
    <div class="development">
      <img src="img/rocket-business.png" alt="разработка">
      <p class="footer-text">Разработка</p>
      <p class="footer-text">и продвижение сайта</p>
    </div>
  </footer>
</body>
</html>