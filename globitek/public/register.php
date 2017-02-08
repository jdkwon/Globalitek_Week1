<?php
  require_once('../private/initialize.php');
  
  // Set default values for all variables the page needs.
  $first_name = "";
  $last_name = "";
  $email = "";
  $username = "";
  $errors = [];

  // if this is a POST request, process the form
  // Hint: private/functions.php can help
  if(is_post_request()) {
    // Confirm that POST values are present before accessing them.
    $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
    $last_name = isset($_POST['last_name']) ? $_POST['last_name']: '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $username = isset($_POST['username']) ? $_POST['username']:  '';
    $errors = [];

    // Perform Validations
    // Hint: Write these in private/validation_functions.php

    // Validate first name
    if(is_blank($first_name)) {
      $errors[] = "First name cannot be blank.";
    } 
    elseif (!has_length($_POST['first_name'], ['min' => 2, 'max' => 255])) {
      $errors[] = "First name must be between 2 and 255 characters.";
    }
    elseif(!has_valid_name($first_name)) {
      $errors[] = "First name can only contain letters, spaces, and the following symbols: - , . '";
    }

    // Validate last name
    if (is_blank($_POST['last_name'])) {
      $errors[] = "Last name cannot be blank.";
    } 
    elseif (!has_length($_POST['last_name'], ['min' => 2, 'max' => 255])) {
      $errors[] = "Last name must be between 2 and 255 characters.";
    }
    elseif(!has_valid_name($last_name)) {
      $errors[] = "Last name can only contain letters, spaces, and the following symbols: - , . '";
    }

    // Validate email
    if(is_blank($email)) {
      $errors[] = "Email cannot be blank.";
    } 
    elseif (!has_valid_email_format($email)) {
      $errors[] = "Email must be a valid format. e.g. test@test.com";
    }
    elseif (!has_length($_POST['email'], ['max' => 255])) {
      $errors[] = "Email must be less than 255 characters.";
    }

    // Validate username
    if(is_blank($username) {
      $errors[] = "Username cannot be blank.";
    }
    elseif(!has_length($username, ['min' => 8, 'max' => 255])) {
      $errors[] = "Username must be at least 8 characters and less than 255 characters.";
    }
    elseif(!has_unique_username($username)) {
      $errors[] = "Username is already being used.";
    }
    elseif(!has_valid_username($first_name)) {
      $errors[] = "Username can only contain letters, numbers, and the following symbol: _";
    }

    // if there were no errors, submit data to database
    if(empty($errors)) {
      // Write SQL INSERT statement
      // $sql = "";
      $first_name = filter_var($first_name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $last_name = filter_var($last_name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $email = filter_var($email, FILTER_SANITIZE_EMAIL);
      $username = filter_var($username, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $date = date("Y-m-d H:i:s");

      $sql = "INSERT INTO users(first_name, last_name, email, username, created_at) VALUES ('{$first_name}', '{$last_name}', '{$email}', '{$username}', '{$date}')";
      // For INSERT statments, $result is just true/false
      $result = db_query($db, $sql);

      if($result) {
        db_close($db);
        redirect_to('registration_success.php');
      } 
      else {
        // The SQL INSERT statement failed.
        // Just show the error, not the form
        echo db_error($db);
        db_close($db);
        exit;
      }
    }
  }
?>

<?php $page_title = 'Register'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <h1>Register</h1>
  <p>Register to become a Globitek Partner.</p>

  <?php
    // Display errors
    echo display_errors($errors);
    // echo "firstname: $first_name";
  ?>

  <!-- TODO: HTML form goes here -->
  <section>
    <form action="register.php" method="post">
      First Name: <input type="text" name="first_name" value="<?php echo (isset($first_name)) ? h($first_name):'';?>" /><br />
      Last Name: <input type="text" name="last_name" value="<?php echo (isset($last_name)) ? h($last_name):'';?>" /><br />
      Email: <input type="text" name="email" value="<?php echo (isset($email)) ? h($email):'';?>" /><br />
      Username: <input type="text" name="username" value="<?php echo (isset($username)) ? h($username):'';?>" /><br />
      <input type="submit" name="submit" value="Sumit" />
    </form>
  </section>

  </body>
</html>

<?php include(SHARED_PATH . '/footer.php'); ?>