<?php
// INCLUDE ON EVERY TOP-LEVEL PAGE!
include("includes/init.php");
$title = "Contact";
$navTitle = "CONTACT";
$fn_error_show = "contact_form_required hidden";
$ln_error_show = "contact_form_required hidden";
$email_error_show = "contact_form_required hidden";
$subject_error_show = "contact_form_required hidden";
$msg_error_show = "contact_form_required hidden";

if (isset($_POST["send_email"])) {
  $valid_form = true;

  // get sender info
  $first_name = filter_input(INPUT_POST, "first_name", FILTER_SANITIZE_STRING);
  $last_name = filter_input(INPUT_POST, "last_name", FILTER_SANITIZE_STRING);
  $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);

  // get message
  $subject = filter_input(INPUT_POST, "subject", FILTER_SANITIZE_STRING);
  $message = filter_input(INPUT_POST, "message", FILTER_SANITIZE_STRING);

  if ($first_name == '' || $last_name == '' || $email == '' || $subject == '' || $message == '') {
    $valid_form = false;
    if ($first_name == '') {
      $fn_error_show = "contact_form_required";
    }
    if ($last_name == '') {
      $ln_error_show = "contact_form_required";
    }
    if ($email == '') {
      $email_error_show = "contact_form_required";
    }
    if ($subject == '') {
      $subject_error_show = "contact_form_required";
    }
    if ($message == '') {
      $msg_error_show = "contact_form_required";
    }
  }
  if ($subject == "mediator") {
    $subject = "Conflict Resolution / Conversation Mediator";
  } else if ($subject == "facilitator") {
    $subject = "Workshop Facilitator";
  } else if ($subject == "speaker") {
    $subject = "Event Speaker";
  } else if ($subject == "educator") {
    $subject = "Diversity Educator / Instructor";
  } else if ($subject == "other") {
    $subject = "Other";
  } else {
    $valid_form = false;
    $subject_error_show = "contact_form_required";
  }
  if ($valid_form) {
    // send email (plain text)
    $to = "drreneealexander@gmail.com";
    $msg_body =
      "Subject: Request for " . htmlspecialchars($subject) . "\r\n" .
      "Sender: " . htmlspecialchars($first_name) . " " . htmlspecialchars($last_name) . "\r\n" .
      "Email: " . htmlspecialchars($email) . "\r\n" .
      "\r\n" . htmlspecialchars($message) . "\r\n";
    $headers = "From: " . htmlspecialchars($email) . "\r\n" . "CC: " . htmlspecialchars($email);
    mail($to, $subject, $msg_body, $headers);
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<?php include("includes/head.php"); ?>

<body>
  <?php include("includes/navTop.php"); ?>
  <div class="content-wrap" id="top_page">

    <h1> Contact </h1>
    <?php if ($valid_form) {
      ?>
      <div class="contact_confirm">
        <p> Thanks! I will get back to you shortly.</p>
        <div class="confirm_row">
          <section class="input_field_col">
            <td class="col_left">
              <ul id="input_field">
                <li> First Name:</li>
                <li> Last Name:</li>
                <li> Email:</li>
                <li> Subject:</li>
                <li> Message:</li>
              </ul>
          </section>
          <section class="answer_col">
            <ul id="answer">
              <li><?php echo (htmlspecialchars($first_name)) ?></li>
              <li><?php echo (htmlspecialchars($last_name)) ?></li>
              <li><?php echo (htmlspecialchars($email)) ?></li>
              <li><?php echo (htmlspecialchars($subject)) ?></li>
              <li><?php echo ($message) ?></li>
            </ul>
          </section>
        </div>
      </div>
    <?php } else { ?>
      <div class="row">
        <section id="descrip_column">
          <p> If you are interested in having Dr. Renee Alexander as</p>
          <ul>
            <li> Conflict Resolution / Conversation Mediator </li>
            <li> Workshop Facilitator </li>
            <li> Event Speaker </li>
            <li> Diversity Educator / Instructor </li>
          </ul>
          <p> Please fill out the contact form!</p>

          <p class="before_button"> Check out her past work: </p>
          <p> <a class="page_link" href="projects.php">Projects</a> </p>
        </section>
        <section id="form_column">
          <form method="post" id="contact_form">

            <fieldset>
              <ul>
                <li class="contact_form_required"> *All Input Fields Required. </li>
                <li class=<?php echo $fn_error_show ?>> First Name Required. </li>
                <li class="contact_form_field">
                  <span class="required">*</span>First Name:
                  <input type="text" name="first_name" value="<?php echo htmlspecialchars($first_name) ?>">
                </li>
                <li class=<?php echo $ln_error_show ?>> Last Name Required. </li>
                <li class="contact_form_field">
                  <span class="required">*</span>Last Name:
                  <input type="text" name="last_name" value="<?php echo htmlspecialchars($last_name) ?>">
                </li>
                <li class=<?php echo $email_error_show ?>> Email Required. </li>
                <li class="contact_form_field">
                  <span class="required">*</span>Email:
                  <input type="text" name="email" value="<?php echo htmlspecialchars($email) ?>">
                </li>
                <li class=<?php echo $subject_error_show ?>> Select Your Subject. </li>
                <li class="contact_form_field">
                  <span class="required">*</span>Subject:
                  <select name="subject">
                    <option value="" disabled selected>Select Your Subject</option>
                    <option <?php if ($subject == "Conflict Resolution") echo 'selected="selected"'; ?> value="mediator">Conflict Resolution / Conversation Mediator</option>
                    <option <?php if ($subject == "Workshop Facilitator") echo 'selected="selected"'; ?> value="facilitator">Workshop Facilitator</option>
                    <option <?php if ($subject == "Event Speaker") echo 'selected="selected"'; ?> value="speaker">Event Speaker</option>
                    <option <?php if ($subject == "Diversity Educator / Instructor") echo 'selected="selected"'; ?> value="educator">Diversity Educator / Instructor</option>
                    <option <?php if ($subject == "Other") echo 'selected="selected"'; ?> value="other">Other</option>
                  </select>
                </li>
                <li class=<?php echo $msg_error_show ?>> Message Required. </li>
                <li class="contact_form_field">
                  <span class="required">*</span>Message:
                  <textarea id="message_box" name="message" rows="10"></textarea>
                </li>
              </ul>
              <input id="contact_form_button" type="submit" name="send_email" value="Send">
            </fieldset>
          </form>
        </section>

      </div>
    <?php } ?>
  </div>


  <?php include("includes/footer.php"); ?>
</body>

</html>
