<?php

require_once '../private/authentication.php';
require_login();

$title = "Delete a Travel Destination";"";

include 'includes/header.php';

echo "<h2 class=\"fw-light mb-3\">Current Travel Destinations in our Catalogue</h2>
<p>To delete a record, click the 'Delete' button next to the Travel Destination you want to remove. You will then be taken to a confirmation page to complete the deletion.</p>";

generate_table(function($destinations) {
    $wid = $destinations['destination_id'];
    $destination_title = $destinations['destination_title'];

    return "<a href=\"delete-confirmation.php?destinations=" . urlencode($wid) . "&destination_title=" . urlencode($destination_title) . "\" class=\"btn btn-danger\">Delete</a>";
}, false);

include 'includes/footer.php';

?>