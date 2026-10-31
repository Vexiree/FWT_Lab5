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
    <div class="table-wrapper">
      <table class="styled-table">
        <thead>
          <tr>
            <th style="width: 50px;">№</th>
            <th style="width: 90px;">Фото</th>
            <th style="width: 200px;">Кулинарный термин</th>
            <th>Определение и традиционный состав</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($items as $item): ?>
            <tr>
              <td class="col-id"><?php echo htmlspecialchars($item['id']); ?></td>
              <td class="col-thumb">
                <img class="table-thumb" 
                     src="images/<?php echo htmlspecialchars($item['image']); ?>" 
                     alt="<?php echo htmlspecialchars($item['term']); ?>"
                     title="<?php echo htmlspecialchars($item['term']); ?>">
              </td>
              <td class="col-term"><strong><?php echo htmlspecialchars($item['term']); ?></strong></td>
              <td class="col-def"><?php echo htmlspecialchars($item['definition']); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </section>

</main>

<?php
include 'footer.html';
?>
