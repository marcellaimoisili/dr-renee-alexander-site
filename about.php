<?php
// INCLUDE ON EVERY TOP-LEVEL PAGE!
include("includes/init.php");
$title = "About";
$navTitle = "ABOUT";
?>
<!DOCTYPE html>
<html lang="en">

<?php include("includes/head.php"); ?>

<body>
    <?php include("includes/navTop.php"); ?>
    <div class="content-wrap" id="about_page">
        <h1> About </h1>
        <?php
        $records = exec_sql_query($db, "SELECT * FROM about_images")->fetchAll(PDO::FETCH_ASSOC);

        foreach ($records as $record) {
            echo ' <div class="slideshowImage fade">';
            echo '<div class="timeline"><img class="slide_image"  src="uploads/about_images/' . $record["id"] . "." . $record["img_ext"] . '" alt="' . htmlspecialchars($record['caption']) . '"/>    <p class="citation"> Source: Dr. Renee Alexander </p></div>';
            echo '<div class="bio"><p class="about-text">' . htmlspecialchars($record['caption']) . '</p></div>';
            echo '</div>';
        } ?>
        <div class="button">
            <button id="slideshowNext" class="next" onclick="plusSlides(-1)">&#10094;</button>
            <button id="slideshowPrevious" class="previous" onclick="plusSlides(1)">&#10095;</button>
        </div>

    </div>
    <?php include("includes/footer.php"); ?>

</body>

</html>
