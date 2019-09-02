<?php
// Source: Course materials: Lab 8 in INFO 2300
?>

<?php
foreach ($session_messages as $message) {
  echo "<p><strong>" . htmlspecialchars($message) . "</strong></p>\n";
}
?>

<form id="loginForm" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
<fieldset id="signIn">
  <legend>Administrative Login</legend>
  <div>
    <label for="username">Username:</label>
    <input id="username" type="text" name="username" />
  </div>
  <div>
    <label for="password">Password:</label>
    <input id="password" type="password" name="password" />
  </div>
  <div id="logIn-button">
        <input type="submit" name = "login" value="Login"/>
      </div>
</fieldset>
</form>
