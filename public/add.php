<?php

require_once '../private/authentication.php';
include 'includes/upload.php';
require_login();

$title = "Add a Travel Destination";


include 'includes/header.php';

$message = "";
$alert_class = "alert-danger";

$filename = isset($_POST['filename']) ? trim($_POST['filename']) : "";
$image_source = isset($_POST['image_source']) ? trim($_POST['image_source']) : "";
$destination_title = isset($_POST['destination_title']) ? trim($_POST['destination_title']) : "";
$description = isset($_POST['description']) ? trim($_POST['description']) : "";
$destination_category = isset($_POST['destination_category']) ? trim($_POST['destination_category']) : "";
$region = isset($_POST['region']) ? trim($_POST['region']) : "";
$popular_activity = isset($_POST['popular_activity']) ? trim($_POST['popular_activity']) : "";
$visited = $_POST['visited'] ?? '';
$best_time_to_visit = isset($_POST['best_time_to_visit']) ? trim($_POST['best_time_to_visit']) : "";
$currency = isset($_POST['currency']) ? trim($_POST['currency']) : "";
$language = isset($_POST['language']) ? trim($_POST['language']) : "";
$season_type = isset($_POST['season_type']) ? trim($_POST['season_type']) : "";
$local_cuisine = isset($_POST['local_cuisine']) ? trim($_POST['local_cuisine']) : "";

if (isset($_POST['submit'])) {
    $validation_result = validate_destination_input($filename, $image_source, $destination_title, $description, $destination_category, $region, $popular_activity, $visited, $best_time_to_visit, $currency, $language, $season_type, $local_cuisine);

    if ($validation_result['is_valid']) {
        $data = $validation_result['data'];

        if (insert_destination($data['filename'], $data['image_source'], $data['destination_title'], $data['description'], $data['destination_category'], $data['region'], $data['popular_activity'], $data['visited'], $data['best_time_to_visit'], $data['currency'],  $data['language'], $data['season_type'], $data['local_cuisine'])) {

            $message = "Your travel destination was successfully added to our catalogue!";
            $alert_class = "alert-success";

            
            $filename = $image_source = $destination_title = $description = $destination_category = $region = $popular_activity = $visited = $best_time_to_visit = $currency = $language = $season_type = $local_cuisine = "";

        } else {
            $message = "There was a problem adding the travel destination: " . $connection->error;
        }

    } else {
        $message = implode("</p><p>", $validation_result['errors']);
    }
}

?>

<h2 class="fw-light mb-3">Travel Destination Details</h2>

<p>To add a Travel Destination to the catalogue, just fill out the form below and click 'Save'.</p>

<?php if ($message != "") : ?>
    <div class="p-3 alert <?php echo $alert_class; ?>" role="alert">
        <p><?php echo $message; ?></p>
    </div>
<?php endif; ?>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
        <?php if (isset($file_name_new)): ?>
            <div class="card text-bg-dark">
                <img src="images/thumbs/<?php echo $file_name_new; ?>" alt="<?php echo $img_description; ?>">       
            </div>
        <?php endif; ?>

        <!-- Image Upload -->
        <div class="mb-3">
            <label for="img-file" class="form-label">Image File</label>
            <input type="file" id="img-file" name="img-file" class="form-control">
        </div>

        <!-- Image Source -->
        <div class="mb-3">
            <label for="image_source" class="form-label">Image Source</label>
            <input type="text" id="image_source" name="image_source" class="form-control" value="<?= $image_source; ?>">
        </div>

        <!-- Destination Name -->
         <div class="mb-3">
            <label for="destination_title" class="form-label">Destination Name:</label>
            <input type="text" name="destination_title" id="destination_title" class="form-control" value="<?php echo $destination_title; ?>">
         </div>

        <!-- Description-->
        <div class="mb-3">
            <label for="description" class="form-label">Description:</label>
            <input type="text" name="description" id="description" class="form-control" value="<?php echo $description; ?>">
         </div>
    
        <!--Destination Category -->
        <div class="mb-3">
            <label for="destination_category" class="form-label">Destination Category:</label>
            <select name="destination_category" id="destination_category" class="form-select">
                <option value="">-- Select Destination Category --</option>
                <option value="City" <?php echo ($destination_category == "City" ? "selected" : ""); ?>>City</option>
                <option value="Landmark" <?php echo ($destination_category == "Landmark" ? "selected" : ""); ?>>Landmark</option>
                <option value="Nature" <?php echo ($destination_category == "Nature" ? "selected" : ""); ?>>Nature</option>
                <option value="Cultural Site" <?php echo ($destination_category == "Cultural Site" ? "selected" : ""); ?>>Cultural Site</option>
            </select>
        </div>
    
         <!-- region -->
         <div class="mb-3">
            <label for="region" class="form-label">Region:</label>
            <select name="region" id="region" class="form-select">
                <option value="">-- Select Region --</option>
                <option value="Africa" <?php echo ($region == "Africa" ? "selected" : ""); ?>>Africa</option>
                <option value="Asia" <?php echo ($region == "Asia" ? "selected" : ""); ?>>Asia</option>
                <option value="Europe" <?php echo ($region == "Europe" ? "selected" : ""); ?>>Europe</option>
                <option value="North America" <?php echo ($region == "North America" ? "selected" : ""); ?>>North America</option>
                <option value="South America" <?php echo ($region == "South America" ? "selected" : ""); ?>>South America</option>
                <option value="Oceania" <?php echo ($region == "Oceania" ? "selected" : ""); ?>>Oceania</option>
                <option value="Antarctica" <?php echo ($region == "Antarctica" ? "selected" : ""); ?>>Antarctica</option>
            </select>
        </div>  
                
        <!-- popular_activity -->
        <div class="mb-3">
            <label for="popular_activity" class="form-label">Popular Activity:</label>
            <input type="text" name="popular_activity" id="popular_activity" class="form-control" value="<?php echo $popular_activity; ?>">
         </div>

        <!-- visited -->
        <div class="mb-3">
            <label for="visited" class="form-label">Visited:</label>
                <div class="form-check">
                    <input type="radio" id="have_visited" name="visited" value="1" class="form-check-input" <?php echo ($visited == '1') ? 'checked' : ''; ?>>
                    <label for="have_visited" class="form-check-label">Yes</label>
                </div>
                
                <div class="form-check">
                    <input type="radio" id="not_visited" name="visited" value="0" class="form-check-input" <?php echo ($visited == '0') ? 'checked' : ''; ?>>
                    <label for="not_visited" class="form-check-label">No</label>
                </div>
        </div>

        <!-- best_time_to_visit -->
        <div class="mb-3">
            <label for="best_time_to_visit" class="form-label">Best Time to Visit:</label>
            <input type="text" name="best_time_to_visit" id="best_time_to_visit" class="form-control" value="<?php echo $best_time_to_visit; ?>">
        </div>

        <!-- currency -->
        <div class="mb-3">
            <label for="currency" class="form-label">Currency:</label>
            <input type="text" name="currency" id="currencyt" class="form-control" value="<?php echo $currency; ?>">
        </div>

        <!-- language -->
        <div class="mb-3">
            <label for="language" class="form-label">Language:</label>
            <input type="text" name="language" id="language" class="form-control" value="<?php echo $language; ?>">
        </div>
    
        <!-- season_type -->
        <div class="mb-3">
            <label for="season_type" class="form-label">Season Type:</label>
            <select name="season_type" id="season_type" class="form-select">
                <option value="">-- Select Season Type --</option>
                <option value="Tropical" <?php echo ($season_type == "Tropicaln" ? "selected" : ""); ?>>Tropical</option>
                <option value="Four Seasons" <?php echo ($season_type == "Four Seasons" ? "selected" : ""); ?>>Four Seasons</option>
                <option value="Dry/Wet" <?php echo ($season_type == "Dry/Wet" ? "selected" : ""); ?>>Dry/Wet</option>
                <option value="Monsoon" <?php echo ($season_type == "Monsoon" ? "selected" : ""); ?>>Monsoon</option>
                <option value="Arid" <?php echo ($season_type == "Arid" ? "selected" : ""); ?>>Arid</option>
                <option value="Polar" <?php echo ($season_type == "Polar" ? "selected" : ""); ?>>Polar</option>
            </select>
         </div>
    
        <!-- local_cuisine -->
          <div class="mb-3">
            <label for="local_cuisine" class="form-label">Local Cuisine:</label>
            <input type="text" name="local_cuisine" id="local_cuisine" class="form-control" value="<?php echo $local_cuisine; ?>">
         </div>
        

        <!-- Submit -->
        <input type="submit" name="submit" id="submit" value="Save" class="btn btn-success">
</form>


<?php

include 'includes/footer.php';

?>