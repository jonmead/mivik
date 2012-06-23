<?php
header('HTTP/1.x 404 Not Found'); 
?>
<h3>404: The page you have requested does not exist.</h3>
<p><a href="<?php echo $r->url->baseUrl;?>">Click here to return to the homepage.</a></p>
<?php
exit;