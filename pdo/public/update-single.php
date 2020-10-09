<?php

/**
 * Use an HTML form to edit an entry in the
 * users table.
 *
 */

require "../config.php";
require "../common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try {
    $connection = new PDO($dsn, $username, $password, $options);

    $user =[
      "email" => $_POST['email'],
      "firstname" => $_POST['firstname'],
      "designation" => $_POST['designation'],
      "address1" => $_POST['address1'],
      "address2" => $_POST['address2'],
      "city" => $_POST['city'],
      "livingstate" => $_POST['livingstate'],
    ];

    $sql = "UPDATE users 
            SET email = :email, 
              firstname = :firstname, 
              designation = :designation, 
              address1 = :address1, 
              address2 = :address2, 
              city = :city, 
              livingstate = :livingstate 
            WHERE email = :email";
  
  $statement = $connection->prepare($sql);
  $statement->execute($user);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}
  
if (isset($_GET['email'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $id = $_GET['email'];

    $sql = "SELECT * FROM users WHERE email= :email";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':email', $id);
    $statement->execute();
    
    $user = $statement->fetch(PDO::FETCH_ASSOC);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
} else {
    echo "Something went wrong!";
    exit;
}
?>

<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) : ?>
	<blockquote><?php echo escape($_POST['firstname']); ?> successfully updated.</blockquote>
<?php endif; ?>

<h2>Edit a user</h2>

<form method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
    <?php foreach ($user as $key => $value) : ?>
      <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label>
	    <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo escape($value); ?>" <?php echo ($key === 'email' ? 'readonly' : null); ?>>
    <?php endforeach; ?> 
    <input type="submit" name="submit" value="Submit">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
