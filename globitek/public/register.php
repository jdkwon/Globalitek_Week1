<?php
  require_once('../private/initialize.php');
  
  // Set default values for all variables the page needs.
  $first_name = "";
  $last_name = "";
  $email = "";
  $username = "";

  // if this is a POST request, process the form
  // Hint: private/functions.php can help
  if(is_post_request()) {
    // Confirm that POST values are present before accessing them.
    $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
    $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $errors = [];
    // Perform Validations
    // Hint: Write these in private/validation_functions.php

    // Validate first name
    if(is_blank($first_name)) {
      $errors[] = "First name cannot be blank.";
    } 
    elseif (!has_length($_POST['first_name'], ['min' => 2, 'max' => 20])) {
      $errors[] = "First name must be between 2 and 20 characters.";
    }

    // Validate last name
    if (is_blank($_POST['last_name'])) {
      $errors[] = "Last name cannot be blank.";
    } 
    elseif (!has_length($_POST['last_name'], ['min' => 2, 'max' => 30])) {
      $errors[] = "Last name must be between 2 and 30 characters.";
    }

    // Validate email
    if(is_blank($email)) {
      $errors[] = "Email cannot be blank.";
    } 
    elseif (!has_valid_email_format($email)) {
      $errors[] = "Email must be a valid format. e.g. test@test.com";
    }
    // elseif(!unique_key($email)) {
    //   $errors[] = "Email is already being used.";
    // }

    // Validate username
    if(is_blank($username) || !has_length($username, ['min' => 8, 'max' => 255])) {
      $errors[] = "Username must be at least 8 characters.";
    }
    // elseif(!unique_key($username)) {
    //   $errors[] = "Username is already being used.";
    // }

    // if there were no errors, submit data to database
    if(empty($errors)) {
      // Write SQL INSERT statement
      // $sql = "";
      $sql = "INSERT INTO user(first_name, last_name, email, username, password, created_at) VALUES ('" . $first_name . "', '" . $last_name . "', '" . $email . "', '" . $username . "', '" . date("Y-m-d H:i:s") . "')" ;
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
  <form action="register.php" method="post">
    First Name: <input type="text" name="first_name" value="<?php echo (isset($first_name)) ? $first_name:'';?>" /><br />
    Last Name: <input type="text" name="last_name" value="<?php echo (isset($last_name)) ? $last_name:'';?>" /><br />
    Email: <input type="text" name="email" value="<?php echo (isset($email)) ? $email:'';?>" /><br />
    Username: <input type="text" name="username" value="<?php echo (isset($username)) ? $username:'';?>" /><br />
    Password: <input type="password" name="password" value="<?php echo (isset($password)) ? $password:'';?>" /><br />
    <input type="submit" name="submit" value="Sumit" />
  </form>

  </body>
</html>

<?php include(SHARED_PATH . '/footer.php'); ?>