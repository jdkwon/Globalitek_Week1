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
    // TODO
    $value = filter_var($value, FILTER_SANITIZE_EMAIL);

    if(!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
      return false;
    }
    else return true;
  }

  function unique_key($value) {
    return true;
  }

?>
