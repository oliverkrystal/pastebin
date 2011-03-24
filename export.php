<?php
//Check to make sure that the post directory is available
	$post_storage = getcwd()."/../posts/";
	//make sure system is configured correctly:
	if (!is_dir($post_storage) ) {
		die ("You fail!  Make a storage directory stupid");
	}
//Read parameters.
	//THESE WILL ALWAYS RETURN A NULL STRING THAT IS NOT NULL AND ISSET WILL DETECT IT AS SET AND IS_NULL WILL DETECT IT AS SET!!!!
	$post_number = filter_var($_REQUEST["post"], FILTER_SANITIZE_NUMBER_INT);
	//UNFILTERED CONTENT!
	$DIRTY_post = $_REQUEST["post"];

//Check to see if $post is null and swap if needed
	if (is_null($DIRTY_post))
		die ("You need to specify a post!");
	if (file_exists($post_storage.$post_number)) {
		$content =  file_get_contents($post_storage.$post_number);
		$content= str_ireplace("&#13;", "<br>", $content);
		echo $content;
	} else
		die ("Couldn't find that post in the system");

?>
