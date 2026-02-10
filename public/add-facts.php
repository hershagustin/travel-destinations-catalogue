<?php

require_once '../private/authentication.php';
require_login();

$title = "Add a Fun Fact";

include 'includes/header.php';

$message = "";
$alert_class = "alert-danger";

$destination = isset($_POST['destination']) ? trim($_POST['destination']) : "";
$fact = isset($_POST['fact']) ? trim($_POST['fact']) : "";


if (isset($_POST['submit'])) {
    $validation_result = validate_facts_input($destination, $fact);

    if ($validation_result['is_valid']) {
        $data = $validation_result['data'];

        if (insert_facts($data['destination'], $data['fact'],)) {

            $message = "Fun fact was successfully added to our catalogue!";
            $alert_class = "alert-success";

             $destination = $fact = "";

        } else {
            $message = "There was a problem adding the fun fact: " . $connection->error;
        }

    } else {
        $message = implode("</p><p>", $validation_result['errors']);
    }
}

?>

<h2 class="fw-light mb-3">Fun Fact Details</h2>

<p>To add a Fun Fact to the catalogue, just fill out the form below and click 'Save'.</p>

<?php if ($message != "") : ?>
    <div class="p-3 alert <?php echo $alert_class; ?>" role="alert">
        <p><?php echo $message; ?></p>
    </div>
<?php endif; ?>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">

        <!-- Destination Name -->
         <div class="mb-3">
            <label for="destination" class="form-label">Destination Name:</label>
            <input type="text" name="destination" id="destination" class="form-control" value="<?php echo $destination; ?>">
         </div>

        <!-- fact-->
        <div class="mb-3">
            <label for="fact" class="form-label">Fact:</label>
            <input type="text" name="fact" id="fact" class="form-control" value="<?php echo $fact; ?>">
         </div>

        <!-- Submit -->
        <input type="submit" name="submit" id="submit" value="Save" class="btn btn-success">
</form>


<?php

include 'includes/footer.php';

?>