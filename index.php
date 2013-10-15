<?php
    
    include("theme/header.php");           // Include the header theme

    include("lib/Parsedown.php");          // Parse the markdown to html

    include("lib/pages.php");              // What is my current page?
    $pages = new pages();

    //include("lib/articles.php");           // Display articles
    //$articles = new articles();
    //$articles->displayAll();

    include("theme/footer.php");           // Include the footer theme

?>

    
