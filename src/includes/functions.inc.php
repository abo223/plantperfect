<?php

$result = '';

/* ------ cart ------ */

function addToCart($conn, $userId, $item, $price) {
  $sql = "INSERT INTO cart (user_id, plant_name, plant_price) VALUES (?, ?, ?);";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: ../home?error=stmtfailed");
    exit();
  }

  mysqli_stmt_bind_param($stmt, "sss", $userId, $item, $price);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
  header ("location: ../cart");
  exit();
}

function deleteFromCart ($conn, $cartId) {
  $conn->query('DELETE FROM cart WHERE cart . cart_id = \'' . $cartId . ' \';');
  header("location: ../cart");
}

/* ------------------ */

/* ------ login ----- */

function loginUser($conn, $email, $pwd) {
  $uidExists = uidExists($conn, $email, $email);

  if ($uidExists === false) {
    header("location: ../login?error=wronglogin");
    exit();
  }

  $pwdHashed = $uidExists["user_pwd"];
  $checkPwd = password_verify($pwd, $pwdHashed);

  if ($checkPwd === false) {
    header("location: ../login?error=wrongpassword");
    exit();
  }

  else if ($checkPwd === true) {
    session_start();
    $_SESSION["user-id"] = $uidExists["user_id"];
    $_SESSION["user-uid"] = $uidExists["user_uid"];
    header("location: ../home");
    exit();
  }
}

function loginCheck() {
  if (!isset($_SESSION['user-uid'])) {
    header("location: login");
  }
}

/* ------------------ */

/* ---- register ---- */

function createUser($conn, $name, $username, $email, $pwd) {
  $sql = "INSERT INTO users (user_name, user_email, user_uid, user_pwd) VALUES (?, ?, ?, ?);";
  $stmt = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: ../register?error=stmtfailed");
    exit();
  }

  $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

  mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $username, $hashedPwd);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
  header ("location: ../login?error=none");
  exit();
}

function uidExists($conn, $username, $email) {
  $sql = "SELECT * FROM users WHERE user_uid =? OR user_email =?;";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: ../register?error=stmtfailed");
    exit();
  }
  mysqli_stmt_bind_param($stmt, "ss", $username, $email);
  mysqli_stmt_execute($stmt);

  $resultData = mysqli_stmt_get_result($stmt);

  if ($row = mysqli_fetch_assoc($resultData)){
    return $row;
  } else {
    $result = false;
    return $result;
  }
  mysqli_stmt_close($stmt);
}

function invalidUid($username) {
  if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
    $result = true;
  } else {
    $result = false;
  }
  return $result;
}

function invalidEmail($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function pwdMatch($pwd, $pwdRepeat) {
    if ($pwd !== $pwdRepeat) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

/* ------------------ */
