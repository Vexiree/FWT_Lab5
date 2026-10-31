<?php
include 'db.php';
include 'header.html';

$items = [];

if ($db_connected) {
    $query = "SELECT * FROM `terms` ORDER BY `id` ASC";
    $result = mysqli_query($mysql, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $items[] = $row;
        }
    }
}
?>

<main class="main-container">

  <section class="content-section">
    <div class="box">
      <?php foreach ($items as $item): ?>
        <div class="filters__img">
          <img title="<?php echo htmlspecialchars($item['term']); ?>" 
               src="images/<?php echo htmlspecialchars($item['image']); ?>" 
               alt="<?php echo htmlspecialchars($item['term']); ?>" />
          <div class="img-overlay">
            <span class="img-title"><?php echo htmlspecialchars($item['term']); ?></span>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

</main>

<?php
include 'footer.html';
?>
