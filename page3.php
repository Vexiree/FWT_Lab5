<?php
include 'db.php';

$message = '';
$is_success = false;
$added_term = '';
$added_definition = '';
$added_image = '';

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $term = trim($_POST['term'] ?? '');
    $definition = trim($_POST['definition'] ?? '');
    $image = trim($_POST['image'] ?? 'Salad1.svg');

    if ($term === '' || $definition === '') {
        $message = 'Ошибка: Пожалуйста, заполните все обязательные поля (название и определение).';
        $is_success = false;
    } else {
        if ($db_connected) {
            $safe_term = $mysql->real_escape_string($term);
            $safe_definition = $mysql->real_escape_string($definition);
            $safe_image = $mysql->real_escape_string($image);

            $insert_sql = "INSERT INTO `terms` (`term`, `definition`, `image`) VALUES ('$safe_term', '$safe_definition', '$safe_image')";
            $query_result = $mysql->query($insert_sql);

            if ($query_result) {
                $is_success = true;
                $message = 'Данные были успешно занесены в БД!';
                $added_term = $term;
                $added_definition = $definition;
                $added_image = $image;
            } else {
                $is_success = false;
                $message = 'Ошибка при выполнении запроса к БД: ' . $mysql->error;
            }
        } else {
            $is_success = true;
            $message = 'Данные успешно проверены! (Сервер MySQL не запущен, запись обработана в демонстрационном режиме)';
            $added_term = $term;
            $added_definition = $definition;
            $added_image = $image;
        }
    }
}

include 'header.html';
?>

<main class="main-container">
  
  <div class="response-wrapper">
    <?php if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST'): ?>
      
      <div class="response-card">
        <h2>Результат добавления в базу данных</h2>

        <?php if ($is_success): ?>
          <div class="success-message">
            ✓ <?php echo htmlspecialchars($message); ?>
          </div>

          <div class="added-details">
            <div class="detail-row">
              <span class="detail-label">Добавленный термин:</span>
              <span class="detail-value"><strong><?php echo htmlspecialchars($added_term); ?></strong></span>
            </div>

            <div class="detail-row">
              <span class="detail-label">Определение:</span>
              <p class="detail-value"><?php echo nl2br(htmlspecialchars($added_definition)); ?></p>
            </div>

            <div class="detail-row">
              <span class="detail-label">Выбранное изображение:</span>
              <div class="detail-thumb-box">
                <img src="images/<?php echo htmlspecialchars($added_image); ?>" 
                     alt="<?php echo htmlspecialchars($added_term); ?>"
                     title="<?php echo htmlspecialchars($added_term); ?>">
                <span><?php echo htmlspecialchars($added_image); ?></span>
              </div>
            </div>
          </div>

        <?php else: ?>
          <div class="error-message">
            ✕ <?php echo htmlspecialchars($message); ?>
          </div>
        <?php endif; ?>

        <div class="action-buttons">
          <a class="btn" href="page1.php">Вернуться на главную страницу</a>
          <a class="btn btn-secondary" href="page3.php">Добавить еще салат</a>
        </div>
      </div>

    <?php else: ?>
      
      <form class="form add-form" action="page3.php" method="POST">
        <h2>Добавление нового салата в БД</h2>
        <p style="text-align: center; color: #ffffff; margin-bottom: 20px;">
          Заполните форму для отправки данных в таблицу <code>terms</code> базы данных <code>lab5_data</code>:
        </p>

        <div class="form-group">
          <label for="term">Название (термин):</label>
          <input type="text" id="term" name="term" class="form-control" placeholder="Например: Салат Мимоза" required>
        </div>

        <div class="form-group-textarea">
          <label for="definition">Определение (состав):</label>
          <textarea id="definition" name="definition" class="form-control" rows="4" placeholder="Подробное описание ингредиентов, заправки и истории..." required></textarea>
        </div>

        <div class="form-group">
          <label for="image">Изображение:</label>
          <select id="image" name="image" class="form-control" required>
            <option value="Salad1.svg">Салат Цезарь (Salad1.svg)</option>
            <option value="Salad2.svg">Греческий салат (Salad2.svg)</option>
            <option value="Salad3.svg">Салат Капрезе (Salad3.svg)</option>
            <option value="Salad4.svg">Салат Оливье (Salad4.svg)</option>
            <option value="Salad5.svg">Салат Нисуаз (Salad5.svg)</option>
            <option value="Salad6.svg">Салат Вальдорф (Salad6.svg)</option>
            <option value="Salad7.svg">Салат Винегрет (Salad7.svg)</option>
            <option value="Salad8.svg">Салат Табуле (Salad8.svg)</option>
            <option value="Salad9.svg">Салат Кобб (Salad9.svg)</option>
            <option value="Salad10.svg">Салат Чука (Salad10.svg)</option>
            <option value="Salad11.svg">Салат Панцанелла (Salad11.svg)</option>
            <option value="Salad12.svg">Фруктовый салат (Salad12.svg)</option>
          </select>
        </div>

        <div class="submit-group" style="display: flex; gap: 15px; align-items: center;">
          <input type="submit" value="Добавить в базу данных">
          <a class="btn btn-secondary" href="page1.php">Отмена</a>
        </div>
      </form>

    <?php endif; ?>
  </div>

</main>

<?php
include 'footer.html';
?>
