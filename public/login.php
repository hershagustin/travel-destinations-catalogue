<?php

require_once '../private/authentication.php';


if (is_logged_in()) {
   header("Location: admin.php");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
   $username = trim($_POST['username']);
   $password = $_POST['password'];

   if (authenticate($username, $password)) {
       header("Location: admin.php");
       exit();
   } else {
       $error = "Invalid username or password.";
   }
}

$title = "Login Page";

include 'includes/header.php';

?>

<?php if (!empty($error)) echo "<p class=\"text-center text-danger\">$error</p>"; ?>
<div class="container">
    <div class="row justify-content-center">
    <p class = mb-5>Please log in with your credentials to access your Travel Destinations Catalogue. If the details are incorrect, you'll see an error message. Once logged in, you'll be redirected to the admin area where you can manage your catalogue.</p>
        <div class="col-md-6 col-lg-5">
           <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="border border-secondary-subtle shadow-sm rounded m-3 p-3">
               <h2 class="fw-light mb-3">Login Form</h2>
           
               <!-- Username -->
                <div class="mb-3">
                   <label for="username" class="form-label">Username</label>
                   <input type="text" id="username" name="username" class="form-control" required>
                </div>
           
               <!-- Password -->
                <div class="mb-3">
                   <label for="password" class="form-label">Password</label>
                   <input type="password" id="password" name="password" class="form-control" required>
                </div>
           
               <!-- Submit -->
                <div class="text-center">
                   <input type="submit" id="submit" name="submit" value="Log In" class="btn btn-success my-3">
                </div>
           </form>

        </div>
      </div>
   </div>

<?php include 'includes/footer.php'; ?>

 <!-- The username is: instructor -->
 <!-- The password is: Password2! -->