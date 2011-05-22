<?php
/*
 *      This program is free software; you can redistribute it and/or modify
 *      it under the terms of the GNU General Public License as published by
 *      the Free Software Foundation; either version 2 of the License, or
 *      (at your option) any later version.
 *
 *      This program is distributed in the hope that it will be useful,
 *      but WITHOUT ANY WARRANTY; without even the implied warranty of
 *      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *      GNU General Public License for more details.
 *
 *      You should have received a copy of the GNU General Public License
 *      along with this program; if not, write to the Free Software
 *      Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 *      MA 02110-1301, USA.
 */
include 'functions.php';
//Check to make sure that the post directory is available
	$post_storage = getcwd()."/../posts/";
//make sure system is configured correctly:
	if (!is_dir($post_storage) ) {
		die ("You fail!  Make a storage directory stupid");
	}
//Create a random post number and check to insure that it is not currently in use
	$post_number = getPasteString();
	//$post_number = checkIfChild($post_number);
	if (file_exists($post_storage.$post_number)) {
		if (!checkIfChild($post_number))
			$post_number++;
	}

//Read parameters.
	//THESE WILL ALWAYS RETURN A NULL STRING THAT IS NOT NULL AND ISSET WILL DETECT IT AS SET AND IS_NULL WILL DETECT IT AS SET!!!!
	$post = filter_var($_REQUEST["post"], FILTER_SANITIZE_STRING);
	$post_data = filter_var($_REQUEST["data"], FILTER_SANITIZE_SPECIAL_CHARS);
	$post_wrap = filter_var($_GET["wrap"], FILTER_SANITIZE_NUMBER_INT);
	//UNFILTERED CONTENT!
	$DIRTY_post = $_REQUEST["post"];
	$DIRTY_post_data = $_REQUEST["data"];

//Check to see if $post is null and swap if needed
	if (is_null($DIRTY_post)){
		$post_number = $post;
	} else {
		$post_number = $post;
		//header('Location: index.php?post='.$post_number);
	}

//If no parameters, present a blank page
	if (is_null($DIRTY_post) && is_null($DIRTY_post_data)) {
		$post_number = $ran_number;
		$title = "Post #" . $post_number;
		$body ="";
	}
//If one parameter, try to retrieve post
	elseif (isset($DIRTY_post) && is_null($DIRTY_post_data)) {
		if (file_exists($post_storage.$post_number)) {
			$title = "Post #" . $post_number;
			$body = file_get_contents($post_storage.$post_number);
			$echo = true;
		}
		else {
			$title = "Failure.";
			$body = "Couldn't find that post in the system.  Let go and let be.";
		}
	}
//If data is not set, something's screwed up
	elseif (is_null($DIRTY_post) && isset($DIRTY_post_data)){
		die ("don't do that, it isn't nice!");
	}
//If two parameters, make a post
	elseif (isset($DIRTY_post) && isset($DIRTY_post_data)){
		$post_data = str_replace("&#13;&#10;", "&#13;", $post_data );
		file_put_contents($post_storage.$post_number, $post_data);
		$title = "Post #" . $post_number;
		$body = $post_data;
		$echo = true;
	}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type = "text/css" href="/stylesheet.css"/>
		<style type="text/css">
			<?php
				if ($post_wrap == '1'){ echo "
			pre {
				test
				/*border-style: dashed;*/
				border-width: .5px;
				padding: 5px 10px 5px 10px;
				/*width: 90%;*/
				margin-left: auto;
				margin-right: auto;
				display: block;
				margin: 6px;
				/*white-space:pre-wrap;*/
			}";
				} else { echo "
			pre {
				border-style: dashed;
				border-width: .5px;
				padding: 5px 10px 5px 10px;
				width: 90%;
				margin-left: auto;
				margin-right: auto;
				display: block;
				margin: 6px;
				white-space:pre-wrap;
			}";
					} ?>
/* we love php funkiness*/
			#paste {
				width: 90%;
				margin-left: auto;
				margin-right: auto;
				text-align: left;
				display: block;
			}
			ul {

				width: 90%;
			}
		</style>
		<!--[if IE]>
			<script src="/resource/js/html5.js"></script>
		<![endif]-->
		<title><?php echo $title; ?></title>
	</head>


	<body>
		<h1>Soliloquy For The Fallen Pastebin</h1>
		<nav>
			<a href="http://soliloquyforthefallen.net">Soliloquy Homepage</a>
			<a href="/">New Paste</a>
		</nav>

		<div id="leftSide">
			<p><a href="index.php?post=<?php echo $post_number ?>">Find this post again.</a></p>
			<p><a href="export.php?post=<?php echo $post_number ?>">Download a raw copy of this paste.</a></p>
		</div>

		<div id="paste">
				<?php if ($echo == true) {
					echo "<pre>";
					echo "<ol>";
						$output = explode("&#13;", $body);
						$count = 0;
						foreach ($output as $item) {
							if ($count % 2 == 0)
								echo "<li>".$item."</li>";
							else
								echo "<li style = 'background-color: #E8E8E8;'>".$item."</li>";
							$count++;
						}
					echo "</ol>";
					echo "</pre>";
					}
				?>
		</div>
		<div id="newPaste">
			<h2><?php if (is_null($DIRTY_post)){ echo "Make new paste:"; } else { echo "Edit this Paste"; } ?></h2>
			<form action="index.php" method="post">
				Post Number (Randomly Generated): <input disabled="disabled" type="readonly" name="post" value="<?php echo $post_number; ?>" />
				<br/>
				<!-- Post Content:-->
				<textarea rows="20" cols="100" name="data" ><?php if (file_exists ($post_storage.$post_number)){ echo $body;} ?></textarea>
				<input type="submit"  value="Submit Post"/>
			</form>
		</div>

	</body>
</html>
