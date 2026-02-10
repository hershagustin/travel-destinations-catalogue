<?php

require_once '../private/authentication.php';

require_login();

$title = "Edit a Fun Fact";

include 'includes/header.php';

$message = "";
$alert_class = "alert-danger";

$fact_id = $_GET['fact_id'] ?? $_POST['fact_id'] ?? "";

$facts = $fact_id ? select_facts_by_id($fact_id) : NULL;

$existing_destination = $facts['destination'] ?? "";
$existing_fact = $facts['fact'] ?? "";

$user_destination = $_POST['destination'] ?? "";
$user_fact = $_POST['fact'] ?? "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $validation_result = validate_facts_input($user_destination, $user_fact);

    if ($validation_result['is_valid']) {
        if (update_facts($user_destination, $user_fact, $fact_id)) {
           
            $message = "{$user_destination} was updated successfully.";
            $alert_class = "alert-success";
        } else {
            $message = "There was an error updating the Fun Facts.";
        }
    } else { // If we fail validation ...
        $message = $validation_result['message'];
    }
}
?>

<?php if($fact_id) : ?>

    <section class="my-5 p-3 border">
        <h2 class="fw-light mb-3">Edit <?= $existing_destination; ?></h2>

        <?php if ($message != "") : ?>
            <div class="alert <?= $alert_class; ?>" role="alert">
                <?= $message; ?>
            </div>
        <?php endif; ?>

        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">


        <!-- Destination title -->
        <div class="mb-3">
            <label for="destination" class="form-label">Destination Name</label>
            <input type="text" name="destination" id="destination" class="form-control" value="<?= $user_destination ?: $existing_destination; ?>">
        </div>

        <!-- fact -->
        <div class="mb-3">
            <label for="fact" class="form-label">fact</label>
            <input type="text" name="fact" id="fact" class="form-control" value="<?= $user_fact ?: $existing_fact; ?>">
        </div>

            <!-- Retaining the Primary Key -->
            <input type="hidden" id="fact_id" name="fact_id" value="<?= $fact_id; ?>">

            <!-- Submit -->
             <input type="submit" id="submit" name="submit" value="Save" class="btn btn-warning mt-5">
        </form>
    </section>

<?php endif; ?>


<h2 class="fw-light mb-3">Current Fun Facts in our Catalogue</h2>
<p>To edit a record, click the 'Edit' button next to the item you want to change. Then, make your updates in the form and click 'Save' to save your changes.</p>

<?php

generate_fact_table(function($facts) {
    $fact_id = $facts['fact_id'];
    return "<a href=\"edit-facts.php?fact_id=" . urlencode($fact_id) . "\" class=\"btn btn-warning\">Edit</a>";
}, false);

include 'includes/footer.php';

?>