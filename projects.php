<?php
// INCLUDE ON EVERY TOP-LEVEL PAGE!
include("includes/init.php");
$title = "Projects";
$navTitle = "PROJECTS";
?>
<!DOCTYPE html>
<html lang="en">

<?php include("includes/head.php"); ?>

<body>
    <?php include("includes/navTop.php"); ?>
    <div class="content-wrap" id="top_page">
        <h1> Projects </h1>

        <div class="top_info">
            <div>
                <img id="bblogo" src="images/bblogo.jpg" alt="Breaking Bread Logo">
                <!-- Photo is owned by Dr. Renee -->
                <p class="citation"> Source: Dr. Renee Alexander </p>
            </div>

            <div>
                <p id="projectsparagraph"> Dr. Renee is most famous for leading the Breaking Bread initiative – which brings participants together for a special meal and facilitated conversation. In 2017, it won the Perkins Prize for its significant impact towards furthering the ideal of university community while respecting the values of racial and cultural diversity. Relating to this topic, she has also given a TED Talk on Breaking Bread and its effect on campus climate. Other things she is currently involved in include the Fresh Air Fund, as well as the College Discovery Program in Ithaca. </p>
            </div>
        </div>

        <div class="forms">
            <div class=" firstForm">
                <form class="searchform" id="searchTags" action="projects.php" method="post" enctype="multipart/form-data">
                    <p class="search_form">
                        Filter by tag:
                        <select name="tag">
                            <option value="all"> All </option>
                            <?php $tags = exec_sql_query($db, "SELECT * FROM tags;")->fetchAll();
                            foreach ($tags as $a) {
                                echo '<option value= "' . $a['tag_name'] . '">' . $a['tag_name'] . "</option>";
                            }
                            ?>
                        </select>

                        <button name="search_tag" type="submit"> Filter </button>
                    </p>
                </form>
            </div>
            <div>
                <p class='searchparagraph'> or </p>
            </div>

            <div class="secondForm">
                <form class="searchform" id="searchword" action="projects.php" method="post" enctype="multipart/form-data">
                    <p> Search by keyword:
                        <input type="text" name="keyword">
                        <button name="search_word" type="submit"> Search </button>
                </form>
            </div>
        </div>

        <?php
        if (isset($_POST["search_word"])) {
            $keyword = $_POST["keyword"];
            $keyword = filter_var($keyword, FILTER_SANITIZE_STRING);
            $keyword2 = '%' . $keyword . '%';
            $query = "SELECT * FROM projects_images WHERE description LIKE :keyword2";
            $params = array(
                ':keyword2' => $keyword2
            );

            $result = exec_sql_query($db, $query, $params)->fetchAll();

            echo "<p class='searchparagraph'> Filter by: " . $keyword . "</p>";
            echo '<table class="projectstable">';
            foreach ($result as $i) {
                echo "<tr>";
                $tag = $i['id'];
                $query = "SELECT tags.tag_name FROM tags LEFT OUTER JOIN project_tag ON tags.id = project_tag.tag_id WHERE project_tag.projects_image_id= $tag";
                $image_tags = exec_sql_query($db, $query)->fetchAll();

                echo '
                <td class=projectstd><a href= "single_image.php?' . http_build_query(array('id' => $i['id'])) . '"> <img class="project_images" src="uploads/projects_images/' . $i['file_name'] . '.' . $i['file_ext'] . '" alt="' . $i['file_name'] . '"></a></td>';
                echo '<td class="project_descr">' . $i['description'] . '<br>';
                echo ' <br> Tags: ';
                foreach ($image_tags as $t) {
                    echo '<br>' . $t['tag_name'];
                }

                echo '<br> <br> <a class="moreinfo" href= "single_image.php?' . http_build_query(array('id' => $i['id'])) . '"> View Details</a>';
                echo '<p class="citation"> Source: Dr. Renee Alexander </p>';
                echo '</td>';
                echo "</tr>";
            }

            echo '</table>';
        } elseif (isset($_POST["search_tag"]) && ($_POST['tag'] != "all")) {
            $tag = $_POST['tag'];
            $tag = filter_var($tag, FILTER_SANITIZE_STRING);
            $query = "SELECT project_tag.projects_image_id FROM project_tag LEFT OUTER JOIN tags ON project_tag.tag_id = tags.id WHERE tags.tag_name = :tag";
            $params = array(
                ':tag' => $tag
            );

            $result = exec_sql_query($db, $query, $params)->fetchAll();

            echo "<p class='searchparagraph'> Filter by: " . $tag . "</p>";

            echo "<table class='projectstable'>";
            foreach ($result as $a) {
                echo "<tr>";
                $tag = $a['projects_image_id'];
                $query = "SELECT tags.tag_name FROM tags LEFT OUTER JOIN project_tag ON tags.id = project_tag.tag_id WHERE project_tag.projects_image_id= $tag";
                $image_tags = exec_sql_query($db, $query)->fetchAll();

                $query2 = "SELECT * FROM projects_images WHERE id=$tag";
                $result2 = exec_sql_query($db, $query2)->fetchAll();
                foreach ($result2 as $r) {
                    echo '<td class=projectstd> <a href= "single_image.php?' . http_build_query(array('id' => $r['id'])) . '"><img class="project_images" src="uploads/projects_images/' . $r['file_name'] . '.' . $r['file_ext'] . '" alt="' . $r['file_name'] . '"></a> </td>';
                    echo '<td class="project_descr">' . $r['description'] . '<br>';
                    echo ' <br> Tags: ';
                    foreach ($image_tags as $t) {
                        echo '<br>' . $t['tag_name'];
                    }

                    echo '<br> <br> <a class="moreinfo" href= "single_image.php?' . http_build_query(array('id' => $r['id'])) . '"> View Details</a>';

                    echo '</td>';
                    echo "</tr>";
                }
            }
            echo "</table>";
        } else {

            echo '<h2 class="projectsh2"> Upcoming Events </h2>';

            $upcoming_images = exec_sql_query($db, "SELECT * FROM projects_images WHERE event_type='Upcoming'")->fetchAll();

            if (count($upcoming_images) > 0) { ?>
                <table class="projectstable">
                    <?php
                    foreach ($upcoming_images as $i) {
                        echo "<tr>";
                        $tag = $i['id'];
                        $query = "SELECT tags.tag_name FROM tags LEFT OUTER JOIN project_tag ON tags.id = project_tag.tag_id WHERE project_tag.projects_image_id= $tag";
                        $image_tags = exec_sql_query($db, $query)->fetchAll();

                        echo '<td class=projectstd> <a href= "single_image.php?' . http_build_query(array('id' => $i['id'])) . '"><img class="project_images" src="uploads/projects_images/' . $i['file_name'] . '.' . $i['file_ext'] . '" alt="' . $i['file_name'] . '"></a> </td>';
                        // echo '<td class="project_descr">' . $i['event_name'].'<br>';
                        echo '<td class="project_descr">' . $i['description'] . '<br>';

                        echo ' <br> Tags: ';
                        foreach ($image_tags as $t) {
                            echo '<br>' . $t['tag_name'];
                        }

                        echo '<br> <br> <a class="moreinfo" href= "single_image.php?' . http_build_query(array('id' => $i['id'])) . '"> View Details</a>';
                        echo '<p class="citation"> Source: Dr. Renee Alexander </p>';
                        echo '</td>';
                        echo "</tr>";
                    }

                    ?>
                </table>
            <?php
        } else {
            echo '<p class="projectsp"> No upcoming events at the moment. Stay tuned! </p>';
        }


        echo '<h2 class="projectsh2"> Past Events </h2>';


        $past_images = exec_sql_query($db, "SELECT * FROM projects_images WHERE event_type='Past'")->fetchAll();
        if (count($past_images) > 0) { ?>
                <table class="projectstable">
                    <?php

                    foreach ($past_images as $i) {
                        echo "<tr>";
                        $tag = $i['id'];
                        $query = "SELECT tags.tag_name FROM tags LEFT OUTER JOIN project_tag ON tags.id = project_tag.tag_id WHERE project_tag.projects_image_id= $tag";
                        $image_tags = exec_sql_query($db, $query)->fetchAll();


                        echo '<td class="projectstd"> <a href= "single_image.php?' . http_build_query(array('id' => $i['id'])) . '"><img class="project_images" src="uploads/projects_images/' . $i['file_name'] . '.' . $i['file_ext'] . '" alt="' . $i['file_name'] . '"> </a></td>';
                        // echo '<td class="project_descr">' . $i['event_name'].'<br>';
                        echo '<td class="project_descr">' . $i['description'] . '<br>';
                        echo ' <br> <span class="statement1">Tags:</span> ';
                        foreach ($image_tags as $t) {
                            echo '<br>' . $t['tag_name'];
                        }

                        echo '<br> <br> <a class="moreinfo" href= "single_image.php?' . http_build_query(array('id' => $i['id'])) . '"> View Details</a>';
                        echo '<p class="citation"> Source: Dr. Renee Alexander </p>';

                        echo '</td>';
                        echo "</tr>";
                    } ?>
                </table> <?php
                    } else {
                        echo "<p> No past events at the moment. </p>";
                    }
                }
                ?>


    </div>

    <?php include("includes/footer.php"); ?>
</body>

</html>
