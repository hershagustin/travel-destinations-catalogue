<?php

require_once '../private/authentication.php';
require_login();
$title = "Admin";
include 'includes/header.php';
?>
        
    <section class="row justify-content-center text-center">
        <div class="col col-md-10 col-xl-8">
            <h1 class="fw-light">Private Page (Admin)</h1>
            <p class="lead text-muter mb-5">Welcome to the admin area! This page is only for logged-in users. If you're here, you've successfully logged in. If you log out, you'll be sent back to the home page.</p>
        </div>  
    </section>

<?php      
include 'includes/footer.php';
?>

