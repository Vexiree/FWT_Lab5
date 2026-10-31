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
    $image = '';

    if (!empty($_FILES['image']['name'])) {
        $image = basename($_FILES['image']['name']);
        $upload_dir = __DIR__ . '/images/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $image);
    } elseif (!empty($_POST['image'])) {
        $image = trim($_POST['image']);
    }

    if ($term === '' || $definition === '' || $image === '') {
        $message = 'Ошибка: Пожалуйста, заполните все обязательные поля.';
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
            $message = 'Сервер не запущен';
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
      
      <form class="form add-form" action="page3.php" method="POST" enctype="multipart/form-data">
        <h2>Добавление нового салата в БД</h2>

        <div class="form-group">
          <label for="term">Название:</label>
          <input type="text" id="term" name="term" class="form-control" placeholder="Салат цезарь" required>
        </div>

        <div class="form-group-textarea">
          <label for="definition">Определение:</label>
          <textarea id="definition" name="definition" class="form-control" rows="4" placeholder="Описание салата" required></textarea>
        </div>

        <div class="form-group">
          <label for="image">Изображение:</label>
          <input type="file" id="image" name="image" accept="image/*" required>
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
