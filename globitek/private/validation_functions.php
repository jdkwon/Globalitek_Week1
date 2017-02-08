<?php

  // is_blank('abcd')
  function is_blank($value='') {
    // TODO
    return !isset($value) || trim($value) == '';
  }

  // has_length('abcd', ['min' => 3, 'max' => 5])
  function has_length($value, $options=array()) {
    $length = strlen($value);
    if(isset($options['max']) && ($length > $options['max'])) {
      return false;
    }
    elseif(isset($options['min']) && ($length < $options['min'])) {
      return false;
    }
    elseif(isset($options['exact']) && ($length != $options['exact'])) {
      return false;
    }
    else return true;
  }

  // has_valid_email_format('test@test.com')
  function has_valid_email_format($value) {
    return filter_var($value, FILTER_VALIDATE_EMAIL);
  }

  // return TRUE if it is unique, FALSE when there exists
  function has_unique_username($value) {
    $value = filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    global $db;
    $sql = "SELECT * FROM users WHERE username='" . $value . "';";
    $query = db_query($db, $sql);

    while($result = $query->fetch_assoc()) {
      if($value == $result['username']) return false;
    }
    return true;
  }

  function has_valid_name($value) {
    return preg_match('/\A[A-Za-z\s\-,\.\']+\Z/', $value);
  }

  function has_valid_username($value) {
    return preg_match('/\A[A-Za-z0-9_]+\Z/', $value);
  }

?>
