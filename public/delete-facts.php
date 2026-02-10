<?php

require_once '../private/authentication.php';
require_login();

$title = "Delete a Fun Fact";"";

include 'includes/header.php';

echo "<h2 class=\"fw-light mb-3\">Current Travel Destinations in our Catalogue</h2>
<p>To delete a record, click the 'Delete' button next to the Travel Destination you want to remove. You will then be taken to a confirmation page to complete the deletion.</p>";

generate_fact_table(function($fact) {
    $fact_id = $fact['fact_id'];
    $destination= $fact['destination'];

    return "<a href=\"delete-confirmation-facts.php?facts=" . urlencode($fact_id) . "&destination=" . urlencode($destination) . "\" class=\"btn btn-danger\">Delete</a>";
}, false);

include 'includes/footer.php';

?>