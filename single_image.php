<?php
// INCLUDE ON EVERY TOP-LEVEL PAGE!
include("includes/init.php");


// Find image by ID.
//Code Source from Lecture 18: Kyle Harms
if (isset($_GET['id'])) {
  $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
  $sql = "SELECT * FROM projects_images WHERE id = :id;";
  $params = array(
    ':id' => $id
  );
  $result = exec_sql_query($db, $sql, $params);
  if ($result) {
    $images = $result->fetchAll();
    if (count($images) > 0) {
      $images = $images[0];
    }
  }
}
$title = $images['event_name']
?>
<!DOCTYPE html>
<html lang="en">

<?php include("includes/head.php"); ?>

<body>
  <?php include("includes/navTop.php"); ?>
  <div class="content-wrap">

    <a class="return" href="projects.php"> Return to Projects Page</a>

    <div class="image_info_part">
      <?php if (isset($images)) {

        $sql = "SELECT * FROM project_tag INNER JOIN projects_images ON projects_images.id = project_tag.projects_image_id INNER JOIN tags on tags.id = project_tag.tag_id WHERE projects_images.id =" . $images['id'];

        $tag_records = exec_sql_query($db, $sql)->fetchAll(PDO::FETCH_ASSOC); ?>


        <div>

          <img class="single_image" src="uploads/projects_images/<?php echo $images['file_name']; ?>.<?php echo $images['file_ext']; ?>" alt="<?php echo htmlspecialchars($images['file_name']); ?>" />
        </div>
      <?php
    }  ?>


      <div class="eventinfo">
        <h1 class="image_title"><?php echo $images['event_name'] ?></h1>
        <h2 class="event_info_title"> Event Information </h2>
        <div class="info">
          <p class="pic_info"> <?php echo htmlspecialchars($images['description']); ?></p>
          <p class="pic_info1"><span class="statement1">Tags</span> </p>
          <?php
          echo '<ul class="single_tags">';
          foreach ($tag_records as $t) {
            echo '<li>' . $t['tag_name'] . '</li>';
          }
          echo '</ul>';
          echo '<p class="citation"> Source: Dr. Renee Alexander </p>';
          ?>
        </div>
        <div>
        </div>
      </div>
    </div>

  </div>
  <?php include("includes/footer.php"); ?>
</body>

</html>
