<?php

require_once '../private/authentication.php';

$title = "Home";
include 'includes/header.php';



    $per_page = $_POST['number-of-results'] ?? $_GET['number-of-results'] ?? 6;

    $total_count = count_records();

    $total_pages = ceil($total_count / $per_page);

    $current_page = (int) ($_GET['page'] ?? 1);

    if ($current_page < 1 || $current_page > $total_pages || !is_int($current_page)) {

        $current_page = 1;
    }

    $offset = $per_page * ($current_page - 1);
?>
    <!-- Introduction -->
    <section class="row justify-content-between">
        <div class="col-md-10 col-lg-8 col-xxl-6 mb-4"> 
            <h2 class="display-4">Welcome to <span class="d-block text-success">The Travel Destinations Catalogue</span></h2>
            <p>Find your next adventure with our easy-to-use travel destination catalogue. Search, sort, and filter through a wide range of places. Learn about each location, what to do there, and the best times to visit. Whether you're a seasoned traveler or planning your first trip, this cagtalogue helps you find the perfect spot to explore. </p>
            <p>Here you can see all the Travel Destinations we have listed. This page is open to everyone. If you have an account, just click the login button to access your account. If you're not logged in, you won't be able to use the admin features. Enjoy browsing!</p>
        
        </div>
        <!-- Random Fun Facts -->
        <div
            class="col col-lg-4 col-xxl-3 m-4 m-md-0 mb-md-4 border border-success rounded p-3 d-flex flex-column justify-content-center align-items-center">
            <h2 class="fw-bold text-success mb-3">Fun Facts</h2>
            <?php
                $random_number = rand(1, $total_count);

                $query = "SELECT * FROM fun_facts WHERE fact_id = ? LIMIT 1";

                if ($statement = $connection->prepare($query)) {
                    $statement->bind_param("i", $random_number); 
                    $statement->execute();
                    $result = $statement->get_result();

                    if ($row = $result->fetch_assoc()) {
                
                        echo "
                            <p><strong>Destination:</strong> " . htmlspecialchars($row['destination']) . "</p>
                            <p><strong>Fun Fact:</strong> " . htmlspecialchars($row['fact']) . "</p>
                        ";
                    } else {
                        echo "<p>No fun fact found.</p>";
                    }
                } else {
                    echo "<p>Error fetching fun fact.</p>";
                }
            ?>
            <div>
                        <?php if (isset($_SESSION['user_id'])) : ?>
                        <a href="add-facts.php" class="btn btn-primary">Add</a>
                            <a href="edit-facts.php" class="btn btn-warning">Edit</a>
                            <a href="delete-facts.php" class="btn btn-danger">Delete</a>
    
                        <?php
                        $current_file = basename($_SERVER['PHP_SELF']);
                        if ($current_page !== 'add-facts.php' && $current_page !== 'edit-facts.php' && $current_page !== 'delete-facts.php') {
                        ?>
                
                        <?php
                        }
                        ?>
    
                        <?php else : ?>
                        <a href="login.php" class="btn btn-success">Log In</a>
                        <?php endif; ?>
                    </div>
                
            </div>
    </section>
    
    <!--Results per Page-->
    <aside class="my-3">
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <div class="input-group">
                <label for="number-of-results" class="input-group-text">Destination Per Page: </label>
                <select name="number-of-results" id="number-of-results" class="form-select" aria-label="Destination Per Page">
                    <?php foreach ([6, 12, 18] as $value) : ?>
                        <option value="<?= $value; ?>" <?= ($per_page == $value) ? 'selected' : ''; ?>><?= $value; ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="submit" name="submit-page-number" id="submit-page-number" value="Submit" class="btn btn-success">
            </div>
        </form>
    </aside>

    <?php

    $result = find_records($per_page, $offset);

    if ($connection->error) : 
    
    ?>

    <!-- If there's an issue, we'll display an error message to the user. -->
    <p>Oh no! There was an issue retrieving the data.</p>

    <?php elseif ($result->num_rows > 0): ?>    

        <div class="row g-4"> 
        <?php
        // $query = "SELECT * FROM travel_destinations;";
        // $result = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_array($result)) {
        $destination_title = $row['destination_title'];
        $destination_category = $row['destination_category'];
        $description = $row['description'];
        $filename = $row['filename'];
        $image_source = $row['image_source'];
        ?>
            <div class="col-md-4">
                <div class="card p-0 shadow-sm">
                    <img src="images/thumbs/<?= $filename; ?>" alt="<?= $description; ?>" class="card-img-top">
                        <div class="card-body d-flex flex-column">
                            <h2 class="card-text display-6"><?= $destination_title; ?></h2>
                            <p class="mb-2"><strong>Destination Category:</strong> <?= $destination_category; ?></p>
                            <p class="mb-2"><strong>Image Source:</strong> <?= $image_source; ?></p>             
                            <a href="single-record.php?destination_title=<?= urlencode($destination_title); ?>" class="btn btn-success">View</a>
                        </div>
                </div>
            </div>
        <?php } // end of while loop ?>
    </div>

    <!-- Pagination Navigation -->

        <nav aria-label="Page Number">
            <ul class="pagination justify-content-center mt-5">
                    <!-- If the current page is greater than 1, we'll include the previous button. -->
                    <?php if ($current_page > 1) : ?>
                        <li class="page-item">
                            <a href="index.php?page=<?= $current_page - 1; ?>&number-of-results=<?= $per_page; ?>" class="page-link link-success">Previous</a>
                        </li>
                    <?php endif; 
                        // If we have a massive amount of pages, we don't want to generate a link for each individual page. Instead, we want to obscure some of these pages with a gap (...).
                        $gap = FALSE;
                        // The window is how many pages on either side of the current page we would like our user to see. 
                        $window = 1;

                        for ($i = 1; $i <= $total_pages; $i++) {
                            if ($i > 1 + $window && $i < $total_pages - $window && abs($i - $current_page) > $window) {
                                if (!$gap) : ?>

                                    <li class="page-item"><span class="page-link link-success">...</span></li>

                                <?php endif;
                                $gap = TRUE; 
                                continue;
                            }

                            $gap = FALSE; 
                            // If we're printing the current page, let's highlight it so that the user knows what page they're on.
                            if ($current_page == $i) : 
                    ?>
                                <li class="page-item bg-success active">
                                    <a href="#" class="page-link bg-success link-white border border-success"><?= $i; ?></a>
                                </li>
                            <?php else: ?>
                                <li class="page-item">
                                    <a href="index.php?page=<?= $i; ?>&number-of-results=<?= $per_page; ?>" class="page-link link-success"><?= $i; ?></a>
                                </li>
                            <?php endif;
                        }
                            ?>
                    <!-- If the current page is less than the total number of pages, we'll include the next button. -->
                    <?php if ($current_page < $total_pages) : ?>
                        <li class="page-item">
                            <a href="index.php?page=<?= $current_page + 1; ?>&number-of-results=<?= $per_page; ?>" class="page-link link-success">Next</a>
                        </li>
                    <?php endif; ?>
            </ul>
        </nav>
        <?php endif; ?>
<?php
include 'includes/footer.php';

?>