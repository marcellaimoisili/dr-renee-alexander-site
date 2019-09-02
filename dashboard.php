<?php
// INCLUDE ON EVERY TOP-LEVEL PAGE!
include("includes/init.php");
$title = "Dashboard";
$events = exec_sql_query($db, "SELECT * FROM projects_images;")->fetchAll();
$slideshow = exec_sql_query($db, "SELECT * FROM about_images;")->fetchAll();
function print_record($record, $db)
{
  ?>
  <tr>
    <td>
      <?php echo htmlspecialchars($record["event_type"]); ?>
    </td>
    <td>
      <?php echo htmlspecialchars($record["event_name"]); ?>
    </td>
    <td>
      <?php
      $tag = $record['id'];
      $query = "SELECT * FROM tags LEFT OUTER JOIN project_tag ON tags.id = project_tag.tag_id WHERE project_tag.projects_image_id= $tag";
      $image_tags = exec_sql_query($db, $query)->fetchAll();
      foreach ($image_tags as $i) {
        echo '<div class="imagetags"><p class="tags"> - ' . $i['tag_name'] . '</p>';
        ?>
        <form class="deleteTag" action="dashboard.php" method="post">
          <input type="hidden" name="recordID" value=<?php echo $record['id'] ?> />
          <input type="hidden" name="file_ext" value="<?php echo $record['file_ext']; ?>" />
          <button class="deleteTagButton" name="delete_tag" type="submit" value=<?php echo $i['tag_id'] ?>>
            X</button>
        </form>
        </div>
      <?php
    }
    ?>
    </td>
    <td>
      <form class="addTag" action="dashboard.php" method="post">
        <input type="text" name="tag_input">
        <input type="hidden" name="recordID" value=<?php echo $record['id'] ?> />
        <button class="delete" name="add_tag" type="submit" value=<?php echo $record['id'] ?>>Add Tag </button>
      </form>
    </td>
    <td>
      <form class="deleteEvent" action="dashboard.php" method="post">
        <input type="hidden" name="name_file" value=<?php echo $record['file_name'] ?> />
        <input type="hidden" name="recordID" value=<?php echo $record['id'] ?> />
        <input type="hidden" name="file_ext" value="<?php echo $record['file_ext']; ?>" />
        <button class="delete" name="delete" type="submit" value=<?php echo $record['id'] ?>>Delete</button>
      </form>
    </td>
  </tr>
<?php }
function print_slide($record, $db)
{
  echo '<tr>';
  echo '<td>';
  echo '<img class="printslide" src="uploads/about_images/' . $record["id"] . "." . $record["img_ext"] . '" alt="' . htmlspecialchars($record['caption']) . '"/>';
  echo '</td>';
  echo '<td>';
  ?>
  <form class="delImage" action="dashboard.php" method="post">
    <button class="delete" name="del_image" value=<?php echo $record['id'] ?> type="submit" ?> Delete Image </button>
  </form>
  <?php
  echo '</td>';
  echo '<tr>';
}
// Upload Event Form
const MAX_FILE_SIZE = 10000000;
if (isset($_POST['upload'])) {
  $db->beginTransaction();
  $valid_form = true;
  $type_event = $_POST['event_type'];
  if ($type_event == '') {
    $valid_form = false;
    $show_type_event_error = true;
  }
  $event_name = trim($_POST['eventname']);
  if ($event_name == '') {
    $valid_form = false;
    $show_event_name_error = true;
  }
  if (!isset($_FILES['image_file']) || $_FILES['image_file']['error'] == UPLOAD_ERR_NO_FILE) {
    $valid_form = false;
    $show_image_file_error = true;
  }
  $event_descr = trim($_POST['description']);
  if ($event_descr == '') {
    $valid_form = false;
    $show_event_desc_error = true;
  }
  $db->commit();
}
// Upload Slideshow form
if (isset($_POST['upload2'])) {
  $db->beginTransaction();
  $valid_form2 = true;
  if (!isset($_FILES['image_file2']) || $_FILES['image_file2']['error'] == UPLOAD_ERR_NO_FILE) {
    $valid_form2 = false;
    $show_image_file_error2 = true;
  }
  $image_descr = trim($_POST['description2']);
  if ($image_descr == '') {
    $valid_form2 = false;
    $show_image_desc_error = true;
  }
  $db->commit();
}
// Adding image to slidshow
if (isset($_POST["upload2"]) && is_user_logged_in() && $valid_form2) {
  $db->beginTransaction();
  $image_file2 = $_FILES["image_file2"];
  $description2 = filter_input(INPUT_POST, 'description2', FILTER_SANITIZE_STRING);
  if ($_FILES["image_file"]["error"] == UPLOAD_ERR_OK) {
    $file_name2 = basename($image_file2["name"]);
    $file_ext2 = strtolower(pathinfo($file_name2, PATHINFO_EXTENSION));
    $sql = "INSERT INTO about_images (img_ext, caption) VALUES (:img_ext, :caption)";
    $params = array(
      ':img_ext' => $file_ext2,
      ':caption' => $description2,
    );
    $result = exec_sql_query($db, $sql, $params);
    if ($result) {
      $new_path = "uploads/about_images/" . $db->lastInsertId("id") . "." . $file_ext2;
      move_uploaded_file($_FILES["image_file2"]["tmp_name"], $new_path);
    }
    header('location:dashboard.php');
  }
  $db->commit();
}

//ADD TAGS
if (isset($_POST['add_tag'])) {
  $db->beginTransaction();
  if ($_POST['tag_input'] != "") {
    $id = filter_input(INPUT_POST, 'recordID', FILTER_SANITIZE_STRING);
    $tag = ucwords($_POST['tag_input']);
    $tag = filter_var($tag, FILTER_SANITIZE_STRING);
    $sql1 = "SELECT * FROM tags;";
    $tags_array2 = (exec_sql_query($db, $sql1, $params = array()))->fetchAll();
    $is_already_tag = false;
    $sql2 = "SELECT tags.tag_name FROM tags LEFT OUTER JOIN project_tag WHERE project_tag.projects_image_id = :id AND project_tag.tag_id = tags.id;";
    $tags_array = (exec_sql_query($db, $sql2, $params = array(':id' => $id)))->fetchAll();
    foreach ($tags_array as $t) {
      if ($tag == $t['tag_name']) {
        $is_already_tag = true;
      }
    }
    // the photo already has this tag
    if ($is_already_tag) {
      //do nothing
    } else {
      $is_tag_table = false;
      foreach ($tags_array2 as $t) {
        if ($tag == $t['tag_name']) {
          $is_tag_table = true;
        }
      }
      // tag is already in the table
      if ($is_tag_table) {
        $tag_sql = "SELECT * FROM tags WHERE tag_name=:tag;";
        $tag_records = (exec_sql_query($db, $tag_sql, $params = array(':tag' => $tag)))->fetchAll();
        $tag_records = $tag_records[0];
      }
      //tag is not already in table
      else {
        $sql_init = "INSERT INTO tags(tag_name) VALUES (:tag);";
        $query = exec_sql_query($db, $sql_init, $params = array(':tag' => $tag));
        $sql_final = "SELECT * FROM tags WHERE tag_name=:tag;";
        $tag_records = (exec_sql_query($db, $sql_final, $params = array(':tag' => $tag)))->fetchAll();
        $tag_records = $tag_records[0];
      }
      // add tag to project_tag
      if ($tag_records) {
        $sql_insert = "INSERT INTO project_tag(tag_id, projects_image_id) VALUES (:tag_id, :image_id);";
        $query2 = (exec_sql_query($db, $sql_insert, $params = array(':tag_id' => $tag_records['id'], ':image_id' => $id)))->fetchAll();
      }
    }
  }
  $db->commit();
}

// Delete event
if (isset($_POST["delete"]) && is_user_logged_in()) {
  $db->beginTransaction();
  // $delete_id = $_POST['delete'];
  $image_id1 = filter_input(INPUT_POST, 'recordID', FILTER_SANITIZE_STRING);
  $upload_ext1 = filter_input(INPUT_POST, 'file_ext', FILTER_SANITIZE_STRING);
  $file_name = filter_input(INPUT_POST, 'name_file', FILTER_SANITIZE_STRING);
  $delete_sql1 = "DELETE FROM projects_images WHERE id = :image_id";
  $delete_params1 = array(
    ':image_id' => $image_id1
  );
  $delete_img1 = exec_sql_query($db, $delete_sql1, $delete_params1);
  $path1 = 'uploads/projects_images/' . $file_name . '.' . $upload_ext1;
  // var_dump($path1);
  unlink($path1);
  header('location: dashboard.php');
  // $file_ext = "SELECT file_ext FROM projects_images WHERE :id = :id";
  // $params = array(
  //     ':id' => $delete_id
  // );
  // $get_ext = exec_sql_query($db, $file_ext, $params);
  // foreach ($get_ext as $e) {
  //     $sql = "DELETE FROM projects_images WHERE id= :id";
  //     $params2 = array(
  //         ':id' => $delete_id
  //     );
  //     $image_path = "uploads/projects_images/" . $delete_id . $e['file_ext'];
  //     $delete = exec_sql_query($db, $sql, $params2);
  //     unlink($image_path);
  //     header('location:dashboard.php');
  // }
  $db->commit();
}
// Deleting about images from slideshow
if (isset($_POST["del_image"]) && is_user_logged_in()) {
  $db->beginTransaction();
  $image_id = filter_input(INPUT_POST, 'image_id', FILTER_SANITIZE_STRING);
  $upload_ext = filter_input(INPUT_POST, 'image_ext', FILTER_SANITIZE_STRING);
  $delete_sql = "DELETE FROM about_images WHERE id = :image_id";
  $delete_params = array(
    ':image_id' => $image_id
  );
  $delete_img = exec_sql_query($db, $delete_sql, $delete_params);
  $path = 'uploads/about_images/' . $image_id . '.' . $upload_ext;
  unlink($path);
  header('location: dashboard.php');
  $db->commit();
}

//Gets rid of extensions
function file_ext_strip($filename)
{
  return preg_replace('/.[^.]*$/', '', $filename);
}

// Upload event
if (isset($_POST["upload"]) && is_user_logged_in() && $valid_form) {
  $db->beginTransaction();
  $image_file = $_FILES["image_file"];
  $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
  $event_name = filter_input(INPUT_POST, 'eventname', FILTER_SANITIZE_STRING);
  $event_type = $_POST["event_type"];
  if ($_FILES["image_file"]["error"] == UPLOAD_ERR_OK) {
    $file_name = file_ext_strip($image_file["name"]);
    $file_ext = strtolower(pathinfo($image_file["name"], PATHINFO_EXTENSION));
    $sql = "INSERT INTO projects_images (file_name, file_ext, description, event_type, event_name) VALUES (:file_name, :file_ext, :description, :event_type, :event_name)";
    $params = array(
      ':file_name' => $file_name,
      ':file_ext' => $file_ext,
      ':description' => $description,
      ':event_type' => $event_type,
      ':event_name' => $event_name
    );
    $result = exec_sql_query($db, $sql, $params);
    if ($result) {
      $new_path = "uploads/projects_images/" . $file_name . '.' . $file_ext;
      move_uploaded_file($_FILES["image_file"]["tmp_name"], $new_path);
    }
    header('location:dashboard.php');
  }
  $db->commit();
}
// Delete Tags
if (isset($_POST['delete_tag'])) {
  $db->beginTransaction();
  $imageid = $_POST['recordID'];
  $tag_to_delete = $_POST['delete_tag'];
  $sql = "DELETE FROM project_tag WHERE projects_image_id=:image_id AND tag_id = :tag_id;";
  $query = exec_sql_query($db, $sql, $params = array(':image_id' => $imageid, 'tag_id' => $tag_to_delete));
  header('location:dashboard.php');
  $db->commit();
}
?>
<!DOCTYPE html>
<html lang="en">

<?php include("includes/head.php"); ?>

<body>
  <?php include("includes/navTop.php"); ?>
  <div class="content-wrap" id="top_page">
    <?php
    if (is_user_logged_in()) {
      ?>
      <h1>Dashboard</h1>
      <div class="dashContainer">
        <div class="dash1">
          <form id="uploadEvent" action="dashboard.php" method="post" enctype="multipart/form-data">
            <fieldset id="eventForm">
              <legend>Upload Event to Projects</legend>
              <div>
                <label>*Type of Event: </label>
                <select name="event_type">
                  <option value="Upcoming" <?php if (isset($_POST['event_type']) && $_POST['event_type'] == "upcoming") {
                                              echo 'selected';
                                            } ?>>Upcoming</option>
                  <option value="Past" <?php if (isset($_POST['event_type']) && $_POST['event_type'] == "past") {
                                          echo 'selected';
                                        } ?>>Past</option>
                </select>
              </div>
              <p class="form_error <?php if (!$show_event_type_error || $valid_form) {
                                      echo 'hidden';
                                    }
                                    ?>">Please select whether your event is upcoming or was in the past.</p>
              <div>
                <label for="event_name">*Event Name: </label>
                <input type="text" id="event_name" name="eventname" value="<?php if (isset($event_name)) {
                                                                              echo htmlspecialchars($event_name);
                                                                            } ?>" />
              </div>
              <p class="form_error
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          if (!$show_event_name_error || $valid_form) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            echo 'hidden';
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          } ?>">Please provide an event name for the request.</p>
              <div>
                <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>" />
                <label for="image_file">*Image of Event: </label>
                <input id="image_file" type="file" name="image_file">
              </div>
              <p class="form_error
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  <?php
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  if (!$show_image_file_error || $valid_form) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    echo 'hidden';
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  } ?>">Please upload an image for your event.</p>
              <div>
                <label for="event_desc">*Description: </label>
                <textarea id="event_desc" name="description" cols="25" rows="5"><?php if (isset($event_descr)) {
                                                                                  echo htmlspecialchars($event_descr);
                                                                                } ?> </textarea>
              </div>
              <p class="form_error
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 <?php
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  if (!$show_event_desc_error || $valid_form) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    echo 'hidden';
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  } ?>">Please provide a description for your event.</p>
              <div id="upload-button">
                <input type="submit" name="upload" value="Upload" />
              </div>
            </fieldset>
          </form>
        </div>
        <div class="dash2">
          <form id="uploadSlideshow" action="dashboard.php" method="post" enctype="multipart/form-data">
            <fieldset id="eventForm2">
              <legend>Upload Image to Slideshow</legend>
              <div class="input1">
                <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>" />
                <label for="image_file2">*Image</label>
                <input id="image_file2" type="file" name="image_file2">
              </div>
              <p class="form_error <?php if (!$show_image_file_error2 || $valid_form2) {
                                      echo 'hidden';
                                    } ?>">Please upload an image.</p>
              <div>
                <label for="event_desc2">*Description: </label>
                <textarea id="event_desc2" name="description2" cols="25" rows="5"><?php if (isset($image_desc)) {
                                                                                    echo htmlspecialchars($image_descr);
                                                                                  } ?> </textarea>
              </div>
              <p class="form_error <?php if (!$show_image_desc_error || $valid_form2) {
                                      echo 'hidden';
                                    } ?>">Please provide a description for your image.</p>
              <div id="upload-button2">
                <input type="submit" name="upload2" value="Upload" />
              </div>
            </fieldset>
          </form>
        </div>
      </div>
      <div id="eventsPosted">
        <h1>Events Posted</h1>
        <table id="eventstable">
          <tr>
            <th>Event Type</th>
            <th id="namecol">Event Name</th>
            <th id="tagscol"> Tags </th>
            <th> Add Tag </th>
            <th>Delete Event</th>
          </tr>

          <?php
          foreach ($events as $record) {
            print_record($record, $db);
          }
          ?>
        </table>
      </div>

      <div>
        <h1> Current Slides </h1>
        <?php
        // Photos provided by Dr. Renee
        $sql = "SELECT * FROM about_images;";
        $images = (exec_sql_query($db, $sql, $params = array()))->fetchAll();
        function print_image($images)
        {
          echo '<div class="picstyle"><img class ="pic" src="uploads/about_images/' .  $images['id'] . '.' . $images['img_ext'] .  '" alt ="' . htmlspecialchars($images['caption']) . '"/>
          ' . PHP_EOL;
        }
        foreach ($images as $i) {
          print_image($i);
          ?><div class="formbutton">
            <form class="delImage" action="dashboard.php" method="post">
              <input type="hidden" name="image_id" value="<?php echo $i['id']; ?>" />
              <input type="hidden" name="image_ext" value="<?php echo $i['img_ext']; ?>" />
              <button class="deleteImageButton" name="del_image" type="submit"> Delete Image </button>
            </form>
          </div>
        </div>
      <?php
    } ?>
    </div>
  <?php } else { ?>
    <?php include("includes/login.php");
  }
  ?>
  </div>

  <?php include("includes/footer.php"); ?>
</body>

</html>
