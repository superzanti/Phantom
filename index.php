<?php
    
    include("lib/Parsedown.php");          // Parse the markdown to html

    ob_start();// start output buffer
    include("lib/pages.php");              // What is my current page?
    $pages = new pages();
    $content = ob_get_clean();// flush output buffer and save to variable

    include("theme/index.php");

?>

    
