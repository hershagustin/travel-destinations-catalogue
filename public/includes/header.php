<?php
// require_once('/home/hagustin2/data/connect.php');
// $connection = db_connect();

require_once('../private/connect.php');
$connection = db_connect();

require('../private/prepared.php');
require('../private/functions.php');
// include('../private/variables.php');

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $title; ?> | The Travel Destinations Catalogue</title>
    
    <!-- BS Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- BS Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  </head>

  <body class="min-vh-100 d-flex flex-column justify-content-between">
    <header class="text-center">
            <nav class="py-2 bg-success border-bottom">
                <div class="container d-flex flex-wrap">
                    <ul class="nav me-auto">
                        <li class="nav-item"><a href="#" class="nav-link link-light link-body-emphasis px-2">Browse by: </a></li>
                        <!-- Depending upon the categories that you choose, the link text and referenced page will differ. -->
                        <li class="nav-item"><a href="browse-by-region.php" class="nav-link link-light link-body-emphasis px-2">Region&emsp;|</a></li>
                        <li class="nav-item"><a href="browse-by-category.php" class="nav-link link-light link-body-emphasis px-2">Category&emsp;|</a></li>
                        <li class="nav-item"><a href="browse-by-season-type.php" class="nav-link link-light link-body-emphasis px-2">Season Type</a></li>
                    </ul>

                    <div>
                        <a href="index.php" class="btn text-light">Home</a>
                        <?php if (isset($_SESSION['user_id'])) : ?>
                        <a href="add.php" class="btn btn-primary">Add</a>
                            <a href="edit.php" class="btn btn-warning">Edit</a>
                            <a href="delete.php" class="btn btn-danger">Delete</a>
                        <a href="logout.php" class="btn btn-dark">Log Out</a>
    
                        <?php
                        $current_page = basename($_SERVER['PHP_SELF']);
                        if ($current_page !== 'add.php' && $current_page !== 'edit.php' && $current_page !== 'delete.php') {
                        ?>
                
                        <?php
                        }
                        ?>
    
                        <?php else : ?>
                        <a href="login.php" class="btn btn-success">Log In</a>
                        <?php endif; ?>
                    </div>

                    <ul class="nav">
                        <li class="nav-item"><a href="advanced-search.php" class="nav-link link-light link-body-emphasis px-2">Advanced Search</a></li>
                    </ul>
                </div>

            </nav>
            <section class="py-3 mb-4 border-bottom">
                <div class="container d-flex flex-wrap justify-content-between align-items-center">
                    <a href="index.php"
                        class="d-flex align-items-center mb-3 mb-lg-0 me-lg-auto link-body-emphasis text-decoration-none">
                            <svg class="bi" width="40" height="32">
                                <use xlink:href="#bootstrap"></use>
                            </svg>
                            
                            <h1 class="fs-4 fw-bold text-success"><i class="bi bi-airplane-engines"></i>
                            <!-- <i class="bi bi-globe"></i> -->
                            The Travel Destinations Catalogue</h1>
                    </a>
                    

                    <!-- If you choose to do the 'quick search' as your challenge, include the widget here. -->
                    <form action="search-results.php" method="get" class="form-inline d-flex">
                        <!-- This is an input type of search, so the user has to hit 'enter' or 'return' to submit the form. A more user-friendly thing to do would be to also offer a submit button beside it. -->
                        <input type="text" name="quick-search" class="form-control" placeholder="Search for a destination" value="<?php echo isset($_GET['quick-search']) ? htmlspecialchars($_GET['quick-search']) : ''; ?>" required>
                        <button type="submit" class="btn btn-success ml-2">
                            <i class="bi bi-search "></i> 
                        </button>
                   </form>
                </div>
            </section>
      </header>

    <main class="container">
    <section class="row justify-content-between">

        <!-- Introduction -->
        <div>