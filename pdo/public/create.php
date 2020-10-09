<?php

/**
 * Use an HTML form to create a new entry in the
 * users table.
 *
 */

require "../config.php";
require "../common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try  {
    $connection = new PDO($dsn, $username, $password, $options);
    
    $new_user = array(
      "email" => $_POST['email'],
      "firstname" => $_POST['firstname'],
      "designation" => $_POST['designation'],
      "address1" => $_POST['address1'],
      "address2" => $_POST['address2'],
      "city" => $_POST['city'],
      "livingstate" => $_POST['livingstate'],
    );

    $sql = sprintf(
      "INSERT INTO %s (%s) values (%s)",
      "users",
      implode(", ", array_keys($new_user)),
      ":" . implode(", :", array_keys($new_user))
    );
    
    $statement = $connection->prepare($sql);
    $statement->execute($new_user);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}
?>
<?php require "templates/header.php"; ?>

  <?php if (isset($_POST['submit']) && $statement) : ?>
    <blockquote><?php echo escape($_POST['firstname']); ?> successfully added.</blockquote>
  <?php endif; ?>

  <h2>Add a user</h2>

  <form method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
    <label for="email">Email Address</label>
    <input type="text" name="email" id="email">
    <label for="firstname">First Name</label>
    <input type="text" name="firstname" id="firstname">
    <label for="designation">Designation</label>
    <input type="text" name="designation" id="designation">
    <label for="address1">Address1</label>
    <input type="text" name="address1" id="address1">
    <label for="address2">Address2</label>
    <input type="text" name="address2" id="address2">
    <label for="city">City</label>
    <input type="text" name="city" id="city">
    <label for="livingstate">State</label>
    <input type="text" name="livingstate" id="livingstate">
    <input type="submit" name="submit" value="Submit">
  </form>

  <a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
