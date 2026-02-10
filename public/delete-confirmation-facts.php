<?php

require_once '../private/authentication.php';
require_login();

$destination= isset($_GET['destination']) ? $_GET['destination'] : "";
$fact_id = NULL;
$introduction = "";
$message = "";

if (isset($_GET['facts']) && is_numeric($_GET['facts']) && $_GET['facts'] > 0) {
    $fact_id = $_GET['facts'];
    $message = "<p class=\"lead text-center\">Are you sure that you want to delete " . $destination . "?</p>";
} else {
    $introduction = "Please return to the 'delete' page and select an option from the table.";
}

$title = "Delete Fact Confirmation";
include 'includes/header.php';

if (isset($_POST['confirm'])) {
    $hidden_id = $_POST['hidden-id'];
    $hidden_name = $_POST['hidden-facts'];

    delete_destination($hidden_id);
    $message = "<p class=\"lead text-center\">" . $hidden_name . " was deleted from the database.</p>";
}

?>

<?php if ($message != "") {
    echo $message;
} ?>

<?php if ($fact_id != NULL) : ?>

<form action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">

     <input type="hidden" id="hidden-id" name="hidden-id" value="<?php echo $fact_id; ?>">
     <input type="hidden" id="hidden-facts" name="hidden-facts" value="<?php echo $destination; ?>">

      <input type="submit" id="confirm" name="confirm" value="Yes, I'm sure." class="btn btn-danger d-block mx-auto">
</form>
<?php endif; ?>


 <p class="text-center my-5">
    <a href="delete.php" class="btn btn-secondary">Return to 'Delete a Fun Fact'</a>
 </p>

<?php include 'includes/footer.php'; ?>