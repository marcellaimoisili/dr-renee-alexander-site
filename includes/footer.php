<footer>
    <div id="footerDiv">
        <div id="footer_text">
            <p class="links"> <a href='#top_page'>Return to top of page</a> </p>
            <div id="last_line_footer">
                <p class="links"> <a href='../dashboard.php'>Dashboard</a>
                <?php
                if (is_user_logged_in()) {
                    $logout_url = htmlspecialchars($_SERVER['PHP_SELF']) . '?' . http_build_query(array('logout' => ''));
                    echo ' ◈ <a id="logout" href="' . $logout_url . '">Sign Out ' . htmlspecialchars($current_user['username']) . '</a></p>';
                }else{
                    echo '</p>';
                }
                ?>
            </div>
            <p class="copyright"> © <?php echo date('Y'); ?> Dr. Renee Alexander</p>
        </div>
    </div>
</footer>
