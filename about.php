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
    
    <!--

    <div class="cards-container">
      <section class="card-single active" period="period1">
        <h4 class="year">1816</h4>
        <h2 class="title">Lorem ipsum dolor sit amet.</h2>
        <div class="content">
          <img src="https://ununsplash.imgix.net/photo-1421284621639-884f4129b61d?fit=crop&fm=jpg&h=700&q=75&w=1050" alt="" />
          <p>Lol.</p>
        </div>
      </section> 
    </div>
    -->
    <div class="content-wrap" id="about_page">
        <h1> About </h1>

        <div class="pres-timeline" id="this-timeline">
            <?php
            $records = exec_sql_query($db, "SELECT * FROM about_images")->fetchAll(PDO::FETCH_ASSOC);

            /*foreach ($records as $record) {
                echo ' <div class="slideshowImage fade">';
                echo '<div class="timeline"><img class="slide_image"  src="uploads/about_images/' . $record["id"] . "." . $record["img_ext"] . '" alt="' . htmlspecialchars($record['caption']) . '"/>    <p class="citation"> Source: Dr. Renee Alexander </p></div>';
                echo '<div class="bio"><p class="about-text">' . htmlspecialchars($record['caption']) . '</p></div>';
                echo '</div>';
            } ?>*/
            foreach ($records as $record) {
                echo '<div class="cards-container">';
                echo '<section class="card-single active" period="period1">';
                echo '<h4 class="year">1816</h4>';
                echo '<h2 class="title">Lorem ipsum dolor sit amet.</h2>';
                echo '<div class="content">';
                echo '<img src="uploads/about_images/' . $record["id"] . "." . $record["img_ext"] . '" alt="'  . htmlspecialchars($record['caption']) . '" />';
                echo '<p>Lol.</p>';
                echo '</div>';
                echo '</section>';
                echo '</div>';
            } ?>

            <div class="button">
                <button id="slideshowNext" class="next" onclick="plusSlides(-1)">&#10094;</button>
                <button id="slideshowPrevious" class="previous" onclick="plusSlides(1)">&#10095;</button>
            </div>
        </div> 

    </div>
    <?php include("includes/footer.php"); ?>

</body>

</html>
