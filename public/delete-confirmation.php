<?php

require_once '../private/authentication.php';
require_login();

$destination_title = isset($_GET['destination_title']) ? $_GET['destination_title'] : "";
$destination_id = NULL;
$introduction = "";
$message = "";

if (isset($_GET['destinations']) && is_numeric($_GET['destinations']) && $_GET['destinations'] > 0) {
    $destination_id = $_GET['destinations'];
    $message = "<p class=\"lead text-center\">Are you sure that you want to delete " . $destination_title . "?</p>";
} else {
    $introduction = "Please return to the 'delete' page and select an option from the table.";
}

$title = "Delete Confirmation";
include 'includes/header.php';

if (isset($_POST['confirm'])) {
    $hidden_id = $_POST['hidden-id'];
    $hidden_name = $_POST['hidden-destinations'];

    delete_destination($hidden_id);
    $message = "<p class=\"lead text-center\">" . $hidden_name . " was deleted from the database.</p>";
}

?>

<?php if ($message != "") {
    echo $message;
} ?>

<?php if ($destination_id != NULL) : ?>

<form action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">

     <input type="hidden" id="hidden-id" name="hidden-id" value="<?php echo $destination_id; ?>">
     <input type="hidden" id="hidden-destinations" name="hidden-destinations" value="<?php echo $destination_title; ?>">

      <input type="submit" id="confirm" name="confirm" value="Yes, I'm sure." class="btn btn-danger d-block mx-auto">
</form>
<?php endif; ?>


 <p class="text-center my-5">
    <a href="delete.php" class="btn btn-secondary">Return to 'Delete a Travel Destination'</a>
 </p>

<?php include 'includes/footer.php'; ?>