<?php

$title = "Browse by Region";
include('includes/header.php');

// If the user has already selected any filter(s), we need to keep track of it. 
$active_filters = [];

foreach ($_GET as $filter => $values) {
    if ($filter === 'region') { 
    // If any of the values in our query string are not arrays, too bad: let's make them one.
    $values = is_array($values) ? $values : [$values];

    // Now, let's sanitise each value.
    $active_filters[$filter] = array_map(fn($v) => htmlspecialchars($v, ENT_QUOTES | ENT_HTML5, 'UTF-8'), $values);
}
}

function build_query_url($base_url, $filters, $filter, $value)
{
    // We're just creating a copy of $updated_filters here so that we can mess around with it without overwriting or losing the original. 
    $updated_filters = $filters;
    // Now, we need to see if the user already has this one particular value that they just chose already in the query string. If so, and they clicked it *again*, this means they want to toggle it off. 
    if (isset($updated_filters[$filter]) && in_array($value, $updated_filters[$filter])) {
        // This method takes whatever was already in the query string and what the user _just clicked on_ and sees if there's any difference between the two things. 
        $updated_filters[$filter] = array_diff($updated_filters[$filter], [$value]);

        // If there is no difference, this means that they user clicked the same button *again*, and wants to toggle it OFF. We'll unset it here.
        if (empty($updated_filters[$filter])) {
            unset($updated_filters[$filter]);
        }
    } else {
        // But is there IS a difference, this means that the user clicked on something new, and wants to toggle it ON. We'll add it to the query string here. 
        $updated_filters[$filter][] = $value;
    }
    // Now, we can return the new query string to the caller of this function.
    return $base_url . '?' . http_build_query($updated_filters);
}

?>

<main class="container">
    <section class="row justify-content-center mb-5">
        <div class="col col-md-10 col-xl-8 text-center">
        <h2 class="display-5">Browse by Region</h2>
        <p class="lead mb-5">Click any of the buttons below to browse the Travel Destinations in our catalogue by the destination category. </p>
        </div>

        <?php
        $category_query = "SELECT DISTINCT region FROM travel_destinations WHERE region IS NOT NULL";
        $category_result = $connection->query($category_query);

        $category = [];
        while ($row = $category_result->fetch_assoc()) {
            $category[] = $row['region'];
        }

        if (count($category) > 0) {
            echo "<div class=\"container\">";  
            echo "<div class=\"row justify-content-center\">"; 
            $counter = 0;  
            
            foreach ($category as $region) {
                if ($counter % 5 == 0 && $counter > 0) {
            
                    echo "</div><div class=\"row justify-content-center\">";
                }
                 // Is this button currently 'pressed'?
                $is_active = in_array($region, $active_filters['region'] ?? []);
                // Let's use our custom function to build the query string we need and retain any values we have. 
                $url = build_query_url($_SERVER['PHP_SELF'], $active_filters, 'region', $region);

                echo "<div class=\"col-2 mb-2\">"; 
                echo "<a href=\"$url\" class=\"btn " . ($is_active ? 'btn-outline-success' : 'btn-success') . " w-100\" aria-pressed=\"" . ($is_active ? 'true' : 'false') . "\">$region</a>";
                echo "</div>";

                $counter++;
            }
            echo "</div>"; 
            echo "</div>";
        } else {
            echo "<p>No category found in the database.</p>";
        }
        ?>

        <?php if (!empty($active_filters)) : ?>
            <div class="mt-4 mb-5">
                <a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="btn btn-success">Clear Filters</a>
            </div>
        <div class="m-6">
            <h2 class="display-4 mb-3">Results</h2>
            <p class="lead">Here's what we found.</p>

            <?php 
                // Let's start building our dynamic query. 
                $sql = "SELECT * FROM travel_destinations WHERE 1 = 1";
                $types = "";
                $parameters = [];

                if (isset($active_filters['region'])) {
                    $region_values = $active_filters['region'];
                    $placeholders = str_repeat("?,", count($region_values) - 1) . "?";
                    $sql .= " AND region IN ($placeholders)";
                    $types .= str_repeat("s", count($region_values));
                    $parameters = array_merge($parameters, $region_values);
                }

                if (!empty($active_filters)) {
                $statement = $connection->prepare($sql);

                    if ($statement === FALSE) {
                        echo "<p>Error retrieving data. Please try again later.</p>";
                        exit();
                    }

                    $statement->bind_param($types, ...$parameters);

                    if (!$statement->execute()) {
                        echo "<p>Error executing statements. Please try again later.</p>";
                        exit();
                    }

                    $result = $statement->get_result();
                    // If we get anything back, let's generate our cards.
                    
                    if ($result && $result->num_rows > 0): ?>
                            <div class="list-group">
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <div class="list-group-item">
                                            <h5 class="mb-1"><?php echo htmlspecialchars($row['destination_title']); ?></h5>
                                            <p class="mb-1"><strong>Region:</strong> <?php echo htmlspecialchars($row['region']); ?></p>
                                            <p class="mb-1"><strong>Category:</strong> <?php echo htmlspecialchars($row['destination_category']); ?></p>
                                            <p class="mb-1"><strong>Season Type:</strong> <?php echo htmlspecialchars($row['season_type']); ?></p>
                                            <a href="single-record.php?destination_title=<?php echo urlencode($row['destination_title']); ?>" class="text-success">View</a>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        <?php else: ?>
                            <p>We weren't able to find anything matching your selected filters.</p>
                        <?php endif; ?>
                    <?php 
                } ?>
            <div>
            <a href="index.php" class="btn btn-success mt-5">Back to All Travel Destinations</a>
            </div>
        </div>
        <?php endif;  ?>
    </section>
</main>

<?php include('includes/footer.php'); ?>