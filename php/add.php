<?php

	// include database connection
	include('config/db_connect.php');

  $title = $email = $ingredients = '';
  $errors = array(
    'email' => '',
    'title' => '',
    'ingredients' => ''
  );

  if(isset($_POST['submit'])) {
    $email        = $_POST['email'];
    $title        = $_POST['title'];
    $ingredients  = $_POST['ingredients'];

    // check email
    if(empty($email)) {
      $errors['email'] = 'An email is required <br />';
    } else {
      if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email must be a valid email address.';
      }
    }

    // check title
    if(empty($title)) {
      $errors['title'] = 'An title is required <br />';
    } else {
      if(!preg_match('/^[a-zA-Z\s]+$/', $title)) {
        $errors['title'] = 'Title must be letters and spaces only.';
      }
    }

    // check ingredients
    if(empty($ingredients)) {
      $errors['ingredients'] = 'An ingredients is required <br />';
    } else {
      if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredients)) {
        $errors['ingredients'] = 'Ingredients must be a comma separated list.';
      }
    }

    if(array_filter($errors)) {

    } else {

      $email        = mysqli_real_escape_string($conn, $email);
      $title        = mysqli_real_escape_string($conn, $title);
      $ingredients  = mysqli_real_escape_string($conn, $ingredients);

      // create sql
      $sql = "INSERT INTO pizzas(title, email, ingredients) VALUES('$title', '$email', '$ingredients')";

      // save to db and check
      if(mysqli_query($conn, $sql)){
        // success
        header('Location: index.php');
      } else {
        // error
        echo 'query error: ' . mysqli_error($conn);
      }
    }

  }
?>

<!DOCTYPE html>
<html lang="en">

	<?php include('templates/header.php')?>

	<section class="container grey-text">

		<h4 class="center">Add a Pizza</h4>
		<form action="add.php" class="white" method="POST">

			<label for="">Your Email:</label>
			<input type="text" name="email" value="<?php htmlspecialchars($email) ?>">
      <div class="red-text"><?php echo $errors['email'] ?></div>

			<label for="">Pizza Title:</label>
			<input type="text" name="title" value="<?php htmlspecialchars($title) ?>">
      <div class="red-text"><?php echo $errors['title'] ?></div>

			<label for="">Ingredients (comma separated):</label>
			<input type="text" name="ingredients" value="<?php htmlspecialchars($ingredients) ?>">
      <div class="red-text"><?php echo $errors['ingredients'] ?></div>

			<div class="center">
				<input type="submit" name="submit" value="submit" class="btn brand z-depth-0">
			</div>
		</form>

	</section>

	<?php include('templates/footer.php')?>

</html>
