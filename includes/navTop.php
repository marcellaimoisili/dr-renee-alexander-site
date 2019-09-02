<div class="navigationTop">
    <?php
    $navItemsL = [["index.php", "HOME"], ["about.php", "ABOUT"]];
    $navItemsR = [["projects.php", "PROJECTS"], ["contact.php", "CONTACT"]];
    ?>
    <div class="navbarTop">
        <!-- <a href="index.php">HOME</a>
        <a href="about.php">ABOUT</a>
        <a class= "logohov" href="index.php"><img src="images/logo4.png" alt="Dr. Renee"></a>
        <a href="projects.php">PROJECTS</a>
        <a href="contact.php">CONTACT</a> -->
        <?php
        foreach ($navItemsL as $item) {
            echo ("<a");
            if ($item[1] == $navTitle) {
                echo (" class = 'active'");
            } else {
                echo (" class = 'can_hover'");
            }
            echo (" href=" . $item[0] . ">" . $item[1] . "</a>");
        }
        ?>
        <a class="logohov" href="index.php"><img src="images/logo4.png" alt="Dr. Renee"></a>
        <?php
        foreach ($navItemsR as $item) {
            echo ("<a");
            if ($item[1] == $navTitle) {
                echo (" class = 'active'");
            } else {
                echo (" class = 'can_hover'");
            }
            echo (" href=" . $item[0] . ">" . $item[1] . "</a>");
        }
        ?>
    </div>
</div>
