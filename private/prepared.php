<?php

function execute_prepared_statement($query, $params = [], $types = "") {
    global $connection;

    $statement = $connection->prepare($query);

    if (!$statement) {
        die("Preparation failed: " . $connection->error);
    }

    if (!empty($params)) {
        $statement->bind_param($types, ...$params);
    }

    if (!$statement->execute()) {
        die("Execution failed: " . $statement->error);
    }

    if (str_starts_with(strtolower($query), "select")) {
        return $statement->get_result();
    }

    return true;
}

function get_all_travel_destinations() {
    $query = "SELECT * FROM travel_destinations;";
    $result = execute_prepared_statement($query);

    return $result->fetch_all(MYSQLI_ASSOC);
}

function select_destinations_by_id($destination_id) {
    $query = "SELECT * FROM travel_destinations WHERE destination_id = ?;";
    $result = execute_prepared_statement($query, [$destination_id], "i");

    return $result->fetch_assoc();
}


 function insert_destination($filename, $image_source, $destination_title, $description, $destination_category, $region, $popular_activity, $visited, $best_time_to_visit, $currency, $language, $season_type, $local_cuisine) {
    $query = "INSERT INTO travel_destinations (filename, image_source, destination_title, description, destination_category, region, popular_activity, visited, best_time_to_visit, currency, language, season_type, local_cuisine) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
    return execute_prepared_statement($query, [$filename, $image_source, $destination_title, $description, $destination_category, $region, $popular_activity, $visited, $best_time_to_visit, $currency, $language, $season_type, $local_cuisine], "sssssssisssss");
 }

function update_destination($filename, $image_source, $destination_title, $description, $destination_category, $region, $popular_activity, $visited, $best_time_to_visit, $currency, $language, $season_type, $local_cuisine, $destination_id) {
    $query = "UPDATE travel_destinations SET filename= ?, image_source = ?, destination_title = ?, description = ?, destination_category = ?, region = ?, popular_activity = ?, visited = ?, best_time_to_visit = ?, currency = ?, language = ?, season_type = ?, local_cuisine = ? WHERE destination_id = ?;";
    return execute_prepared_statement($query, [$filename, $image_source, $destination_title, $description, $destination_category, $region, $popular_activity, $visited, $best_time_to_visit, $currency, $language, $season_type, $local_cuisine, $destination_id], "sssssssisssssi");
}

function delete_destination($destination_id) {
    $query = "DELETE FROM travel_destinations WHERE destination_id = ?;";
    return execute_prepared_statement($query, [$destination_id], "i");
}

function get_all_fun_facts() {
    $query = "SELECT * FROM fun_facts;";
    $result = execute_prepared_statement($query);

    return $result->fetch_all(MYSQLI_ASSOC);
}

function select_facts_by_id($fact_id) {
    $query = "SELECT * FROM fun_facts WHERE fact_id = ?;";
    $result = execute_prepared_statement($query, [$fact_id], "i");

    return $result->fetch_assoc();
}


 function insert_facts($destination, $fact) {
    $query = "INSERT INTO fun_facts (destination, fact) VALUES (?, ?);";
    return execute_prepared_statement($query, [$destination, $fact], "ss");
 }

function update_facts($destination, $fact, $fact_id) {
    $query = "UPDATE fun_facts SET destination= ?, fact = ? WHERE fact_id = ?;";
    return execute_prepared_statement($query, [$destination, $fact, $fact_id], "ssi");
}

function delete_facts($fact_id) {
    $query = "DELETE FROM fun_facts WHERE fact_id = ?;";
    return execute_prepared_statement($query, [$fact_id], "i");
}

?>