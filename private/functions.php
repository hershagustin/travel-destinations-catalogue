<?php
/**
 * This counts the number of records we currently have in our table (in case any have been added or removed).
 * @return int number of records in table
 */
function count_records() {
    global $connection;
    $sql = "SELECT COUNT(*) FROM travel_destinations;";
    $result = mysqli_query($connection, $sql);
    $fetch = mysqli_fetch_row($result);
    return $fetch[0];
}

/**
 * This function lets us grab only the records that we need for one page of paginated results. 
 * @param int $limit
 * @param int $offset
 * @return bool|mysqli_result
 */
function find_records($limit = 0, $offset = 0) {
    global $connection;
    // Our SQL statement should look something like this: 
    // SELECT rank, country FROM happiness_index LIMIT XX OFFSET YY;
    $sql = "SELECT destination_title, destination_category, description, filename, image_source FROM travel_destinations";

    // If a limit is provided (and in our case, it is defaulted to 12), we need to include this clause. 
    if ($limit > 0) {
        $sql .= " LIMIT ?";

        // If there's an offset value greater than 0, we'll also include it in our query.
        if ($offset > 0) {
            $sql .= " OFFSET ?";

            // This statement will have two parameters / values. 
            $statement = $connection->prepare($sql);
            $statement->bind_param("ii", $limit, $offset);
        } else {
            // If there isn't an offset value (or it's 0), we will use just the limit.
            $statement = $connection->prepare($sql);
            $statement->bind_param("i", $limit);
        }
        
        // The following steps will be the same whether there's only one or two values.
        $statement->execute();
        return $statement->get_result();
    }
}

?>
<?php

function generate_table($button_callback = null, $is_home_page =true) {

    $travel_destinations = get_all_travel_destinations();

    if (count($travel_destinations) > 0) {
        
        echo "<table class=\"table table-bordered table-hover \"> \n
            <thead> \n
             <tr> \n";
        if ($is_home_page) {
            echo "<div class='container'>\n"; 
                echo "<div class='row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3'>\n"; 

                    foreach ($travel_destinations as $destinations) {
                        extract($destinations);

                        echo "<div class='col mb-4'>\n"; 
                            echo "<div class='card '>\n"; 
                                echo "<div class='card-header bg-success text-white text-center fw-bold'>\n";
                                echo "$destination_title\n";
                                echo "</div>\n"; 
                                
                                    echo "<div class='card-body'>\n";
                                        echo "<p class='card-text'><strong>Image Filename:</strong> $filename</p>\n";
                                        echo "<p class='card-text'><strong>Image Source:</strong> $image_source</p>\n";
                                        echo "<p class='card-text'><strong>Description:</strong> $description</p>\n";
                                        echo "<p class='card-text'><strong>Destination Category:</strong> $destination_category</p>\n";
                                        echo "<p class='card-text'><strong>Region:</strong> $region</p>\n";
                                        echo "<p class='card-text'><strong>Popular Activity:</strong> $popular_activity</p>\n";
                                        echo "<p class='card-text'><strong>Visited:</strong> " . ($visited ? 'Yes' : 'No') . "</p>\n";
                                        echo "<p class='card-text'><strong>Best Time to Visit:</strong> $best_time_to_visit</p>\n";
                                        echo "<p class='card-text'><strong>Currency:</strong> $currency</p>\n";
                                        echo "<p class='card-text'><strong>Language:</strong> $language</p>\n";
                                        echo "<p class='card-text'><strong>Season Type:</strong> $season_type</p>\n";
                                        echo "<p class='card-text'><strong>Local Cuisine:</strong> $local_cuisine</p>\n";
                                    echo "</div>\n"; 
                            echo "</div>\n";
                        echo "</div>\n";       
                    }
                echo "</div>\n";
            echo "</div>\n";
        } else {
            
            echo "<table class=\"table table-bordered table-hover\">\n
                <thead>\n
                <tr>\n
                <th scope=\"col\">Destination Title</th>\n
                <th scope=\"col\">Region</th>\n
                <th scope=\"col\">Description</th>\n
                <th scope=\"col\">Image Source</th>\n";

        if ($button_callback !== null) {
          echo "<th scope=\"col\">Actions</th>\n";
        }

        echo "</tr>\n
            </thead>\n
            <tbody>\n";

        foreach ($travel_destinations as $destinations) {
            extract($destinations);
            echo "<tr>\n";
            echo "<td>$destination_title</td>\n
                    <td>$region</td>\n
                    <td>$description</td>\n
                    <td>$image_source</td>\n";

            if ($button_callback !== null) {
                $buttons = call_user_func($button_callback, $destinations);
                echo "<td>$buttons</td>\n";
            }
            echo "</tr>\n";
        }
        echo "</tbody>\n</table>";
    }

    } else {
    echo "<h2 class='fw-light'>Oh no!</h2>";
    echo "<p>We're sorry, but we weren't able to find anything.</p>";
    }
}
function validate_destination_input($filename, $image_source, $destination_title, $description, $destination_category, $region, $popular_activity, $visited, $best_time_to_visit, $currency, $language, $season_type, $local_cuisine) {
    global $connection;

    $errors = [];
    $validated_data = [];

        // Validate filename
        if (!empty($filename)) {
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

            if (!in_array($extension, $allowed_extensions)) {
                $errors[] = "Invalid image format. Allowed formats: JPG, JPEG, PNG, GIF, WEBP.";
            } else {
                $safe_filename = preg_replace("/[^a-zA-Z0-9\._-]/", "", basename($filename));
                $validated_data['filename'] = $safe_filename;
            }
        } else {
            
            $validated_data['filename'] = NULL;
        }

        // Validate image_source
        $image_source = trim($image_source);
        if (empty($image_source)) {
            $errors[] = "Image Source is required.";
        } elseif (!filter_var($image_source, FILTER_VALIDATE_URL)) {
            $errors[] = "Image Source must be a valid URL.";
        } else {
            $image_source = mysqli_real_escape_string($connection, $image_source);
        }
        $validated_data['image_source'] = $image_source;

        // Validate destination_title
        $destination_title = trim($destination_title);
        if (empty($destination_title)) {
            $errors[] = "Destination Name is required.";
        } elseif (strlen($destination_title) < 2 || strlen($destination_title) > 30) {
            $errors[] = "Destination name must be between 2 and 30 characters.";
        } elseif (preg_match('/["\']/', $destination_title)) {
            $destination_title = mysqli_real_escape_string($connection, $destination_title);
        }

        $validated_data['destination_title'] = $destination_title;

        // Validate description
        $description = trim($description);
        if (empty($description)) {
            $errors[] = "Destination description is required.";
        } elseif (strlen($description) < 2 || strlen($description) > 255) {
            $errors[] = "Destination description must be between 2 and 255 characters.";
        } elseif (preg_match('/["\']/', $description)) {
            $description = mysqli_real_escape_string($connection, $description);
        }
        $validated_data['description'] = $description;

        // Validate destination_category
        $destination_category = trim($destination_category);
        $valid_destination_categories = ['City', 'Landmark', 'Nature', 'Cultural Site']; 

        if (empty($destination_category)) {
            $errors[] = "Media type is required.";
        } elseif (!in_array($destination_category, $valid_destination_categories)) {
            $errors[] = "Invalid media type. Please select a valid media type.";
        } else {
            $destination_category = mysqli_real_escape_string($connection, $destination_category);
        }
        $validated_data['destination_category'] = $destination_category;

        // Validate region
        $region = trim($region);
        $valid_regions = ['Africa', 'Asia', 'Europe', 'North America', 'South America', 'Oceania', 'Antarctica']; 

        if (empty($region)) {
            $errors[] = "Region is required.";
        } elseif (!in_array($region, $valid_regions)) {
            $errors[] = "Invalid region. Please select a valid region.";
        } else {
            $region = mysqli_real_escape_string($connection, $region);
        }
        $validated_data['region'] = $region;
        
        // Validate popular_activity
        $popular_activity = trim($popular_activity);
        if (empty($popular_activity)) {
            $errors[] = "Popular activity is required.";
        } elseif (strlen($popular_activity) < 2 || strlen($popular_activity) > 30) {
            $errors[] = "Popular activity must be between 2 and 255 characters.";
        } elseif (preg_match('/["\']/', $popular_activity)) {
            $popular_activity = mysqli_real_escape_string($connection, $popular_activity);
        }
        $validated_data['popular_activity'] = $popular_activity;

        // Validate visited (boolean)
        $visited = trim($visited);
        if ($visited === '') { 
            $errors[] = "visited field is required.";
        } elseif ($visited !== '0' && $visited !== '1') {
            $errors[] = "Invalid visited option selected.";
        } else {
            $visited = mysqli_real_escape_string($connection, $visited);
        }
        $validated_data['visited'] = (int) $visited;

        // Validate best_time_to_visit
        $best_time_to_visit = trim($best_time_to_visit);
        if (empty($best_time_to_visit)) {
            $errors[] = "Best time to visit is required.";
        } elseif (strlen($best_time_to_visit) < 2 || strlen($best_time_to_visit) > 50) {
            $errors[] = "Best time to visit  must be between 2 and 50 characters.";
        } elseif (preg_match('/["\']/', $best_time_to_visit)) {
            $best_time_to_visit = mysqli_real_escape_string($connection, $best_time_to_visit);
        }
        $validated_data['best_time_to_visit'] = $best_time_to_visit;

        // Validate currency
        $currency = trim($currency);
        if (empty($currency)) {
            $errors[] = "Currency is required.";
        } elseif (strlen($currency) < 2 || strlen($currency) > 50) {
            $errors[] = "Currency must be between 2 and 50 characters.";
        } elseif (preg_match('/["\']/', $currency)) {
            $currency = mysqli_real_escape_string($connection, $currency);
        }
        $validated_data['currency'] = $currency;

        // Validate language
        $language = trim($language);
        if (empty($language)) {
            $errors[] = "Language is required.";
        } elseif (strlen($language) < 2 || strlen($language) > 50) {
            $errors[] = "Language must be between 2 and 50 characters.";
        } elseif (preg_match('/["\']/', $language)) {
            $language = mysqli_real_escape_string($connection, $language);
        }
        $validated_data['language'] = $language;

        // Validate season_type
        $season_type = trim($season_type);
        $valid_season_types = ['Tropical', 'Four Seasons', 'Dry/Wet', 'Monsoon', 'Arid', 'Polar']; 

        if (empty($season_type)) {
            $errors[] = "Season type is required.";
        } elseif (!in_array($season_type, $valid_season_types)) {
            $errors[] = "Invalid season type. Please select a valid season type.";
        } else {
            $season_type = mysqli_real_escape_string($connection, $season_type);
        }
        $validated_data['season_type'] = $season_type;

        // Validate local_cuisine
        $local_cuisine = trim($local_cuisine);
        if (empty($local_cuisine)) {
            $errors[] = "Local cuisine is required.";
        } elseif (strlen($local_cuisine) < 2 || strlen($local_cuisine) > 255) {
            $errors[] = "Local cuisine must be between 2 and 255 characters.";
        } elseif (preg_match('/["\']/', $local_cuisine)) {
            $local_cuisine = mysqli_real_escape_string($connection, $local_cuisine);
        }
        $validated_data['local_cuisine'] = $local_cuisine;
  
    return [
        'is_valid' => empty($errors),
        'errors' => $errors,
        'data' => $validated_data
    ];
}

?>
<?php
function validate_facts_input($destination, $fact) {
    global $connection;

    $errors = [];
    $validated_data = [];

        // Validate destination
        $destination = trim($destination);
        if (empty($destination)) {
            $errors[] = "Destination is required.";
        } elseif (strlen($destination) < 2 || strlen($destination) > 30) {
            $errors[] = "Destination must be between 2 and 30 characters.";
        } elseif (preg_match('/["\']/', $destination)) {
            $destination = mysqli_real_escape_string($connection, $destination);
        }

        $validated_data['destination'] = $destination;

        // Validate description
        $fact = trim($fact);
        if (empty($fact)) {
            $errors[] = "Fact is required.";
        } elseif (strlen($fact) < 2 || strlen($fact) > 255) {
            $errors[] = "Fact must be between 2 and 255 characters.";
        } elseif (preg_match('/["\']/', $fact)) {
            $description = mysqli_real_escape_string($connection, $fact);
        }
        $validated_data['fact'] = $fact;

    return [
        'is_valid' => empty($errors),
        'errors' => $errors,
        'data' => $validated_data
    ];
}
function generate_fact_table($button_callback = null, $is_home_page =true) {

    $fun_facts = get_all_fun_facts();

    if (count($fun_facts) > 0) {
        
        echo "<table class=\"table table-bordered table-hover \"> \n
            <thead> \n
             <tr> \n";
        if ($is_home_page) {
            echo "<div class='container'>\n"; 
                echo "<div class='row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3'>\n"; 

                    foreach ($fun_facts as $facts) {
                        extract($facts);

                        echo "<div class='col mb-4'>\n"; 
                            echo "<div class='card '>\n"; 
                                echo "<div class='card-header bg-success text-white text-center fw-bold'>\n";
                                echo "$destination_title\n";
                                echo "</div>\n"; 
                                
                                    echo "<div class='card-body'>\n";
                                        echo "<p class='card-text'><strong>Destination:</strong> $destination</p>\n";
                                        echo "<p class='card-text'><strong>Fact:</strong> $fact</p>\n";
                                    echo "</div>\n"; 
                            echo "</div>\n";
                        echo "</div>\n";       
                    }
                echo "</div>\n";
            echo "</div>\n";
        } else {
            
            echo "<table class=\"table table-bordered table-hover\">\n
                <thead>\n
                <tr>\n
                <th scope=\"col\">Destination</th>\n
                <th scope=\"col\">Fact</th>\n";

        if ($button_callback !== null) {
          echo "<th scope=\"col\">Actions</th>\n";
        }

        echo "</tr>\n
            </thead>\n
            <tbody>\n";

        foreach ($fun_facts as $facts) {
            extract($facts);
            echo "<tr>\n";
            echo "<td>$destination</td>\n
                    <td>$fact</td>\n";

            if ($button_callback !== null) {
                $buttons = call_user_func($button_callback, $facts);
                echo "<td>$buttons</td>\n";
            }
            echo "</tr>\n";
        }
        echo "</tbody>\n</table>";
    }

    } else {
    echo "<h2 class='fw-light'>Oh no!</h2>";
    echo "<p>We're sorry, but we weren't able to find anything.</p>";
    }
}

?>