 <?php
  $db_username = "root";
  $db_password = "";
  $dsn = 'mysql:host=localhost;dbname=loginpage;charset=utf8mb4';

  try {
    $pdo = new PDO($dsn, $db_username, $db_password);
  } catch (PDOException $e) {
    print "Error: " . $e->getMessage() . "<br/>";
    die();
  }
