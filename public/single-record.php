<?php
    // The user should have a title name in their query string. Let's start by seeing what they've got.
    $destination_title = isset($_GET['destination_title']) ? urldecode($_GET['destination_title']) : "Oh no!";
    // Because it's a query string, let's make sure the user isn't doing anything weird to it.
    $destination_title = htmlspecialchars($_GET['destination_title'], ENT_QUOTES, 'UTF-8');

    $title = "Travel Destination Details";
    include 'includes/header.php';
?>
    <div class="container d-flex justify-content-center my-5">

        <div>
        <?php
        if ($destination_title == "Oh no!") {
            echo "<h2 class='display-5 fw-light'>$destination_title</h2>";
            echo "<p class='lead'>We couldn't find the title you were looking for.</p>";
        } else {
            $query = "SELECT * FROM travel_destinations WHERE destination_title = ?";

            if ($statement = $connection->prepare($query)) {
                $statement->bind_param("s", $destination_title);
                $statement->execute();
                $result = $statement->get_result();

                if ($row = $result->fetch_assoc()) {

                    $filename = $row['filename'];
                    $image_source = $row['image_source'];
                    $description = $row['description'];
                    $destination_category = $row['destination_category'];
                    $region = $row['region'];
                    $popular_activity = $row['popular_activity'];
                    $visited = $row['visited'] ? "Yes" : "No";
                    $best_time_to_visit = $row['best_time_to_visit'];
                    $currency = $row['currency'];
                    $language = $row['language'];
                    $season_type = $row['season_type'];
                    $local_cuisine = $row['local_cuisine'];
        ?>

                    <img src="images/full/<?= $filename; ?>" alt="<?= $description; ?>" class="img-fluid">
                    
                        <h2 class="mt-4"><?= htmlspecialchars($destination_title); ?></h2>
                        <p class="mt-2"><?= htmlspecialchars($description); ?></p>
                        <ul class="list-unstyled mt-3">
                            <li><strong>Category:</strong> <?= htmlspecialchars($destination_category); ?></li>
                            <li><strong>Region:</strong> <?= htmlspecialchars($region); ?></li>
                            <li><strong>Popular Activity:</strong> <?= htmlspecialchars($popular_activity); ?></li>
                            <li><strong>Visited:</strong> <?= $visited; ?></li>
                            <li><strong>Best Time to Visit:</strong> <?= htmlspecialchars($best_time_to_visit); ?></li>
                            <li><strong>Currency:</strong> <?= htmlspecialchars($currency); ?></li>
                            <li><strong>Language:</strong> <?= htmlspecialchars($language); ?></li>
                            <li><strong>Season Type:</strong> <?= htmlspecialchars($season_type); ?></li>
                            <li><strong>Local Cuisine:</strong> <?= htmlspecialchars($local_cuisine); ?></li>
                        </ul>
                    </div>
        <?php
                } else {
                    echo "<p class='p-4'>No data found for the selected title.</p>";
                }
            } else {
                echo "<p class='p-4'>Database query failed to prepare.</p>";
            }
        }
        ?>
        </div>
    </div>
            <!-- Let's give the user a clear pathway back to the index. -->
        <div class="container d-flex justify-content-center my-5">
            <p><a href="index.php" class="btn btn-success mt-4">Return to Index</a></p>
        </div>

<?php 
include('includes/footer.php');
?>


