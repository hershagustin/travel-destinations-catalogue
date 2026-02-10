<?php

$title = "Advanced Search";
include('includes/header.php');

$regions = array(
    1 => "Europe",
    2 => "Asia",
    3 => "North America",
    4 => "Africa",
    5 => "South America",
    6 => "Oceania",

);

// Keyword
$keyword_search = isset($_GET['keyword-search']) ? trim($_GET['keyword-search']) : "";

// Title
$title_search = isset($_GET['title-search']) ? trim($_GET['title-search']) : "";

//category
$category_search = isset($_GET['category-search']) ? trim($_GET['category-search']) : "";

// regions
$selected_regions = isset($_GET['regions']) ? $_GET['regions'] : array();


?>

<main class="container">
    <section class="row justify-content-center mb-5">
        <div class="col col-md-10 col-xl-8">
            <h2 class="display-5 mb-5">Advanced Search</h2>

            <form action="search-results.php" method="GET" class="mb-5 p-3">

                <!-- Keyword Search -->
                <fieldset class="my-4">
                    <div class="mb-3">
                        <label for="keyword-search" class="form-label fs-5">Search for Keywords:</label>
                        <input type="text" id="keyword-search" name="keyword-search" placeholder="Enter keywords.." value="<?php echo $keyword_search; ?>" class="form-control">
                    </div>
                </fieldset>

                <!-- Title Search -->
                <fieldset class="my-4">
                    <div class="mb-3">
                        <label for="title-search" class="form-label fs-5">Search by Destination Name:</label>
                        <input type="text" id="title-search" name="title-search" placeholder="Enter Destination Name.." value="<?php echo $title_search; ?>" class="form-control">
                    </div>
                </fieldset>

                <!-- regions - Checkbox-->
                <fieldset class="my-4">
                    <legend class="fs-5">Filter by region:</legend>
                    <div class="form-check">
                        <input type="checkbox" id="region-all" name="regions[]" class="form-check-input" value="" <?php echo in_array("", $selected_regions) ? "checked" : ""; ?>>
                        <label for="region-all" class="form-check-label">All regions</label>
                    </div>

                    <!-- Loop through each region to create a checkbox. -->
                    <?php foreach ($regions as $destination_id => $name): ?>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="region-<?php echo $destination_id; ?>" name="regions[]" value="<?php echo $name; ?>" <?php echo in_array($name, $selected_regions) ? "checked" : ""; ?>>
                            <label class="form-check-label" for="region-<?php echo $destination_id; ?>"><?php echo $name; ?></label>
                        </div>
                    <?php endforeach; ?>
                </fieldset>

                <!-- category - Dropdown -->
                <fieldset class="my-4">
                    <div class="mb-3">
                        <label for="category-search" class="form-label fs-5">Search by Category:</label>
                        <select id="category-search" name="category-search" class="form-select">
                            <option value="">Select a Category</option>
                            <?php
                            $categories = [];
                            $sql = "SELECT DISTINCT destination_category FROM travel_destinations ORDER BY destination_category ASC";
                            $result = mysqli_query($connection, $sql);

                            if ($result) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $categories[] = $row['destination_category'];
                                }
                            }

                            foreach ($categories as $category) {

                                echo "<option value=\"$category\" " . ($category == $category_search ? "selected" : "") . ">$category</option>";
                            }
                            ?>
                        </select>
                    </div>
                </fieldset>

                <!-- Sorting -->
               <fieldset class="my-4">

                    <div class="mb-3">

                        <label class="form-label fs-5">Sort Order:</label>

                        <div class="form-check">
                            <input type="radio" id="sort-order-asc" name="sort-order" value="ASC" class="form-check-input" <?php echo isset($_GET['sort-order']) && $_GET['sort-order'] == 'ASC' ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="sort-order-asc">Ascending (A-Z, 0-9)</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" id="sort-order-desc" name="sort-order" value="DESC" class="form-check-input" <?php echo isset($_GET['sort-order']) && $_GET['sort-order'] == 'DESC' ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="sort-order-desc">Descending (Z-A, 9-0)</label>
                        </div>

                    </div>
                </fieldset>
                    

                <!-- Submit -->
                <div class="mb-4">
                    <input type="submit" id="submit" name="submit" class="btn btn-success" value="Search">
                </div>
            </form>
        </div>
    </section>
</main>


<?php

include('includes/footer.php');

?>