<?php

require_once '../private/authentication.php';

require_login();

$title = "Edit a Travel Destination";

include 'includes/header.php';

$message = "";
$alert_class = "alert-danger";

$destination_id = $_GET['destination_id'] ?? $_POST['destination_id'] ?? "";

$destinations = $destination_id ? select_destinations_by_id($destination_id) : NULL;

$existing_filename= $destinations['filename'] ?? "";
$existing_image_source = $destinations['image_source'] ?? "";
$existing_destination_title = $destinations['destination_title'] ?? "";
$existing_description = $destinations['description'] ?? "";
$existing_destination_category = $destinations['destination_category'] ?? "";
$existing_region = $destinations['region'] ?? "";
$existing_popular_activity = $destinations['popular_activity'] ?? "";
$existing_visited = $destinations['visited'] ?? "";
$existing_best_time_to_visit = $destinations['best_time_to_visit'] ?? "";
$existing_currency = $destinations['currency'] ?? "";
$existing_language = $destinations['language'] ?? "";
$existing_season_type = $destinations['season_type'] ?? "";
$existing_local_cuisine = $destinations['local_cuisine'] ?? "";

$user_filename= $_POST['filename'] ?? "";
$user_image_source = $_POST['image_source'] ?? "";
$user_destination_title = $_POST['destination_title'] ?? "";
$user_description = $_POST['description'] ?? "";
$user_destination_category = $_POST['destination_category'] ?? "";
$user_region = $_POST['region'] ?? "";
$user_popular_activity = $_POST['popular_activity'] ?? "";
$user_visited = $_POST['visited'] ?? "";
$user_best_time_to_visit = $_POST['best_time_to_visit'] ?? "";
$user_currency = $_POST['currency'] ?? "";
$user_language = $_POST['language'] ?? "";
$user_season_type = $_POST['season_type'] ?? "";
$user_local_cuisine = $_POST['local_cuisine'] ?? "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $validation_result = validate_destination_input($user_filename, $user_image_source, $user_destination_title, $user_description, $user_destination_category, $user_region, $user_popular_activity, $user_visited, $user_best_time_to_visit, $user_currency, $user_language, $user_season_type, $user_local_cuisine);

    if ($validation_result['is_valid']) {
        if (update_destination($user_filename, $user_image_source, $user_destination_title, $user_description, $user_destination_category, $user_region, $user_popular_activity, $user_visited, $user_best_time_to_visit, $user_currency, $user_language, $user_season_type, $user_local_cuisine, $destination_id)) {
           
            $message = "{$user_destination_title} was updated successfully.";
            $alert_class = "alert-success";
        } else {
            $message = "There was an error updating the Travel Destination Catalogue.";
        }
    } else { // If we fail validation ...
        $message = $validation_result['message'];
    }
}
?>

<?php if($destination_id) : ?>

    <section class="my-5 p-3 border">
        <h2 class="fw-light mb-3">Edit <?= $existing_destination_title; ?></h2>

        <?php if ($message != "") : ?>
            <div class="alert <?= $alert_class; ?>" role="alert">
                <?= $message; ?>
            </div>
        <?php endif; ?>

        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">

        <?php if (isset($file_name_new)): ?>
            <div class="card text-bg-dark">
                <img src="images/thumbs/<?php echo $file_name_new; ?>" alt="<?php echo $img_description; ?>">
            </div>
        <?php endif; ?>

        <!-- Image Upload -->
        <div class="mb-3">
            <label for="img-file" class="form-label">Image File</label>
            <input type="file" id="img-file" name="img-file" class="form-control" >
        </div>

        <!-- Image Source -->
        <div class="mb-3">
            <label for="image_source" class="form-label">Image Source</label>
            <input type="text" name="image_source" id="image_source" class="form-control" value="<?= $user_image_source ?: $existing_image_source; ?>">
        </div>

        <!-- Destination title -->
        <div class="mb-3">
            <label for="destination_title" class="form-label">Destination Name</label>
            <input type="text" name="destination_title" id="destination_title" class="form-control" value="<?= $user_destination_title ?: $existing_destination_title; ?>">
        </div>

        <!-- Description -->
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <input type="text" name="description" id="description" class="form-control" value="<?= $user_description ?: $existing_description; ?>">
        </div>

        <!--Destination Category -->
        <div class="mb-3 column">
            <label for="destination_category" class="form-label">Destination Category</label>
            <select id="destination_category" name="destination_category" class="form-select">
                    <option value="">-- Select Destination Category --</option>
                    <option value="City" <?php echo ($user_destination_category == "City" || $existing_destination_category == "City") ? "selected" : ""; ?>>City</option>
                    <option value="Landmark" <?php echo ($user_destination_category == "Landmark" || $existing_destination_category == "Landmark") ? "selected" : ""; ?>>Landmark</option>
                    <option value="Nature" <?php echo ($user_destination_category == "Nature" || $existing_destination_category == "Nature") ? "selected" : ""; ?>>Nature</option>
                    <option value="Cultural Site" <?php echo ($user_destination_category == "Cultural Site" || $existing_destination_category == "Cultural Site") ? "selected" : ""; ?>>Cultural Site</option>
                </select>
        </div>

        <!-- region-->
        <div class="mb-3">
            <label for="region" class="form-label">Region</label>
                <select id="region" name="region" class="form-select">
                    <option value="">--Select Region--</option>
                    <option value="Africa" <?php echo ($user_region == "Africa" || $existing_region == "Africa") ? "selected" : ""; ?>>Africa</option>
                    <option value="Asia" <?php echo ($user_region == "Asia" || $existing_region == "Asia") ? "selected" : ""; ?>>Asia</option>
                    <option value="Europe" <?php echo ($user_region == "Europe" || $existing_region == "Europe") ? "selected" : ""; ?>>Europe</option>
                    <option value="North America" <?php echo ($user_region == "North America" || $existing_region == "North America") ? "selected" : ""; ?>>North America</option>
                    <option value="South America" <?php echo ($user_region == "South America" || $existing_region == "South America") ? "selected" : ""; ?>>South America</option>
                    <option value="Oceania" <?php echo ($user_region == "Oceania" || $existing_region == "Oceania") ? "selected" : ""; ?>>Oceania</option>
                    <option value="Antarctica" <?php echo ($user_region == "Antarctica" || $existing_region == "Antarctica") ? "selected" : ""; ?>>Antarctica</option>
                </select>        
        </div>                   

        <!-- popular_activity -->
        <div class="mb-3">
            <label for="popular_activity" class="form-label">Popular Activity</label>
            <input type="text" name="popular_activity" id="popular_activity" class="form-control" value="<?= $user_popular_activity ?: $existing_popular_activity;?>">
        </div>

        <!-- visited -->
        <div class="mb-3">
            <label for="visited" class="form-label">Visited</label>
                <div class="form-check">
                    <input type="radio" id="have_visited" name="visited" value="1" class="form-check-input" 
                    <?php 
                        echo (isset($_POST['visited']) && $_POST['visited'] == '1') || $user_visited == '1' || $existing_visited == '1' ? 'checked' : ''; 
                    ?>>
                    <label for="have_visited" class="form-check-label">Yes</label>
                </div>
                
                <div class="form-check">
                    <input type="radio" id="not_visited" name="visited" value="0" class="form-check-input" 
                    <?php 
                        echo (isset($_POST['visited']) && $_POST['visited'] == '0') || $user_visited == '0' || $existing_visited == '0' ? 'checked' : ''; 
                    ?>>
                    <label for="not_visited" class="form-check-label">No</label>
                </div>
        </div>

        <!-- best_time_to_visit -->
        <div class="mb-3">
            <label for="best_time_to_visit" class="form-label">Best Time to Visit</label>
            <input type="text" name="best_time_to_visit" id="best_time_to_visit" class="form-control" value="<?= $user_best_time_to_visit ?: $existing_best_time_to_visit; ?>">
        </div>

        <!--Currency -->
        <div class="mb-3">
            <label for="currency" class="form-label">Currency</label>
            <input type="text" name="currency" id="currency" class="form-control" value="<?= $user_currency ?: $existing_currency; ?>">
        </div>

        <!--Language -->
        <div class="mb-3">
            <label for="language" class="form-label">Language</label>
            <input type="text" name="language" id="language" class="form-control" value="<?= $user_language ?: $existing_language; ?>">
        </div>

        <!--Season Type -->
        <div class="mb-3 column">
            <label for="season_type" class="form-label">Season Type</label>
                <select id="season_type" name="season_type" class="form-select">
                    <option value="">-- Select Season Type --</option>
                    <option value="Tropical" <?php echo ($user_season_type == "Tropical" || $existing_season_type == "Tropical") ? "selected" : ""; ?>>Tropical</option>
                    <option value="Four Seasons" <?php echo ($user_season_type == "Four Seasons" || $existing_season_type == "Four Seasons") ? "selected" : ""; ?>>Four Seasons</option>
                    <option value="Dry/Wet" <?php echo ($user_season_type == "Dry/Wet" || $existing_season_type == "Dry/Wet") ? "selected" : ""; ?>>Dry/Wet</option>
                    <option value="Monsoon" <?php echo ($user_season_type == "Monsoon" || $existing_season_type == "Monsoon") ? "selected" : ""; ?>>Monsoon</option>
                </select>
        </div>

        <!-- Local Cuisine -->
        <div class="mb-3">
            <label for="local_cuisine" class="form-label">Local Cuisine</label>
            <input type="text" name="local_cuisine" id="local_cuisine" class="form-control" value="<?= $user_local_cuisine ?: $existing_local_cuisine; ?>">
        </div>

           

            <!-- Retaining the Primary Key -->
            <input type="hidden" id="destination_id" name="destination_id" value="<?= $destination_id; ?>">

            <!-- Submit -->
             <input type="submit" id="submit" name="submit" value="Save" class="btn btn-warning mt-5">
        </form>
    </section>

<?php endif; ?>


<h2 class="fw-light mb-3">Current Travel Destinations in Our System</h2>
<p>To edit a record, click the 'Edit' button next to the item you want to change. Then, make your updates in the form and click 'Save' to save your changes.</p>

<?php

generate_table(function($destinations) {
    $destination_id = $destinations['destination_id'];
    return "<a href=\"edit.php?destination_id=" . urlencode($destination_id) . "\" class=\"btn btn-warning\">Edit</a>";
}, false);

include 'includes/footer.php';

?>