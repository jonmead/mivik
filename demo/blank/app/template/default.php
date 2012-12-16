<!DOCTYPE html>
<html>
	<head>
		<!-- This is the easiest way to reference resources in public/js, public/css, and public/img -->
		<!--<?php $r->url->outputCssTag("styles.css");?>-->
		<!--<?php $r->url->outputImgTag("image.png", "alt text");?>-->
		<!-- <?php $r->url->outputJsTag("script.js");?> -->
	</head>
	<body>
		<?php echo $r->actionOutput;?>
	</body>
</html>