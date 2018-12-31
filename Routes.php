<?php
	// These are the URI routes for your website
	// Every time a client requests a URI, this routes table is checked

	// Guideline:
		/*
			uri			->		The URI that will trigger this route. It can be a regular expression so long as isRegex is truthy
			view		->		The path from the DOCUMENT_ROOT to the file to use as a view
			layout		->		The path from the DOCUMENT_ROOT to the file to use as a layout for the view
			isRegex		->		A bool value to let the router know if the 'uri' parameter should be parsed as a regular expression.
								If it is, then any captured matches should be named captures, the names will become variables for the layour and view
								to use. For example "@\/forums\/thread\/(?<threadID>\d+)\/@" would capture /forums/thread/21/ and put the integer '21' in
								the global $_GET and can be accessed like $_GET['threadID'] in code.
			customData	->		Any extra data that you would like to have access to in the layout or view. The indices must be named and non-numerical.
								For instance, adding ["hello"]=>"hi" to this array would inject the variable $hello into the route's layout with the
								value of "hi"
		*/

	// Be sure to have a route for a /404 page!
	$routes = [
		[
			"uri"=>"/",
			"view"=>"/Views/HomePage.php",
			"layout"=>"/Layouts/Default.php",
			"isRegex"=>false,
			"customData"=>[],
		],
	];
