<?php

    $title = "Search Results: The Comic Chronicler";
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

    //quick search 
    $quick_search = isset($_GET['quick-search']) ? trim($_GET['quick-search']) : "";

    //Quick Search results
    if (!empty($quick_search)) {
        //  SQL statement with multiple `OR` clauses (one for each column)
        $query = "SELECT * FROM travel_destinations WHERE destination_title LIKE ? OR destination_category LIKE ? OR region LIKE ? OR season_type LIKE ?";

        
        if ($statement = $connection->prepare($query)) {
            $search_term = '%' . $quick_search . '%';  
            $statement->bind_param("ssss", $search_term, $search_term, $search_term, $search_term);  
            $statement->execute();
            $result = $statement->get_result();
        } else {
            echo "<p>Error preparing the SQL query.</p>";
        }
    } else {
        $result = false;
    }

?>

<main class="container">
    <section class="row justify-content-center mb-5">
        <div class="col col-md-10 col-xl-8">
            
             <!-- Results -->
            <?php
                if (isset($_GET['submit'])) {

                    $query = "SELECT * FROM travel_destinations WHERE 1 = 1";

                    // Because we're building a dynamic query, we may have a different number of placeholders (?s) depending upon what the user chooses to fill out in the search form. Therefore, we're creating this little array to keep track of how many placeholders we need. 
                    $parameters = [];

                    // Similarly, we also need to say what data types all of our parameters are. This string will be appended with the correct data types whenever we add parameters. 
                    $types = '';

                    // Keywords Search
                    if (!empty($keyword_search)) {
                        $query .= " AND (destination_title LIKE CONCAT('%', ?, '%') OR destination_category LIKE CONCAT('%', ?, '%') OR region LIKE CONCAT('%', ?, '%'))";
                        $parameters[] = $keyword_search;
                        $parameters[] = $keyword_search;
                        $parameters[] = $keyword_search;
                    
                        $types .= 'sss';  // All parameters are strings
                    }

                    //  Title Search
                    if (!empty($title_search) || $title_search != "") {
                        // The concatenation SQL method will create the string we need for our wildcard search when the prepared statement is executed (%foo%).
                        $query .= " AND destination_title LIKE CONCAT('%', ?, '%')";

                        // Because this is an array, we can use the assignment operator here and PHP will know to append this value (i.e. add it to the end of the array) rather than overwrite the whole thing.
                        $parameters[] = $title_search;

                        // We'll also add the 'string' data type here.
                        $types .= 's';
                    }

                    //  category Search
                    if (!empty($category_search) || $category_search != "") {
                        // The concatenation SQL method will create the string we need for our wildcard search when the prepared statement is executed (%foo%).
                        $query .= " AND destination_category LIKE CONCAT('%', ?, '%')";

                        // Because this is an array, we can use the assignment operator here and PHP will know to append this value (i.e. add it to the end of the array) rather than overwrite the whole thing.
                        $parameters[] = $category_search;

                        // We'll also add the 'string' data type here.
                        $types .= 's';
                    }                    

                    // region Filter 
                    if (!empty($selected_regions)) {
                        $placeholders = implode(',', array_fill(0, count($selected_regions), '?'));
                        $query .= " AND region IN ($placeholders)";
                    
                        foreach ($selected_regions as $region) {
                            $parameters[] = $region;
                            $types .= 's';  
                        }
                    }
                

                    // Sorting 
                    if (isset($_GET['sort-order']) && ($_GET['sort-order'] == 'ASC' || $_GET['sort-order'] == 'DESC')) {
                        $query .= " ORDER BY destination_title " . $_GET['sort-order'];
                    }


                    // Prepare and execute the SQL statement (query).
                    if ($statement = $connection->prepare($query)) {
                        // Technically, the user can submit the search form without filling anything out (i.e. without any parameters or conditions). If they do, we don't need to bind our parameters, we just need to fetch the whole dang table. 
                        if ($types) {
                            $bind_names = [];
                            $bind_names[] = $types;
                            // Make sure each parameter is a variable so they can be passed by reference.
                            foreach ($parameters as $key => $value) {
                                $bind_names[] = &$parameters[$key];
                            }
                            call_user_func_array([$statement, 'bind_param'], $bind_names);
                        }

                        $statement->execute();
                        $result = $statement->get_result();
                    } else {

                        $result = false;
                    }
                }
            ?>
                <main class="container">
                    <section class="row justify-content-center mb-5">
                        <div class="col col-md-10 col-xl-8"></div>

                            <h2 class="display-5 mb-5">Search Results</h2>

                            <!-- Results table -->
                            <?php if ($result && $result->num_rows > 0): ?>
                                <table class="table  table-striped">
                                    <thead>
                                        <tr>
                                            <th>Destinatiion Name</th>
                                            <th>Destination Category</th>
                                            <th>Region</th>
                                            <th>Season Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = $result->fetch_assoc()): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($row['destination_title']); ?></td>
                                                <td><?php echo htmlspecialchars($row['destination_category']); ?></td>
                                                <td><?php echo htmlspecialchars($row['region']); ?></td>
                                                <td><?php echo htmlspecialchars($row['season_type']); ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <p>No results found for your query.</p>
                            <?php endif; ?>

                            <!-- Back to Advanced Search Button -->
                            <div class="mb-4 mt-4 text-center">
                                <a href="advanced-search.php" class="btn btn-success">Back to Advanced Search</a>
                            </div>
                            
                        </div>
                    </section>
                </main>

<?php

include('includes/footer.php');

?>