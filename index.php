<?php
	require_once("Classes/Router.php");
	require_once("Classes/ViewEngine.php");
	$Router = new Router();
	$ViewEngine = new ViewEngine();

	$documentRoot = $_SERVER['DOCUMENT_ROOT'];

	$route = "/";

	if (isset($_GET['route'])){
		$route = $_GET['route'];
	}

	if (trim($route) == ""){
		$route = "/";
	}

	if (substr($route, 0, 1) != "/"){ // Prepend a missing slash to the route if it doesn't have one
		$route = "/" . $route;
	}


	// Template variables to be defined
	$view = null;
	$layout = null;

	// Get the route row for the attempted route URI from the DB
	$routeData = $Router->getRouteData($route);

	if ($routeData === false){
		// Route does not exist, get a 404 view
		$routeData = $Router->getRouteData("/404");

		if ($routeData === false){ // The 404 doesn't exist
			http_response_code(404);
			exit();
		}else{
			$viewFile = $documentRoot . $routeData['view'];
			$layoutFile = $documentRoot . $routeData['layout'];
		}
	}else{
		// Route exists
		if (count($routeData['parameters'])){
			// Merge parameters found (for regular expression routes) into the global $_GET array
			$_GET = array_merge($_GET, $routeData['parameters']);
		}

		$viewFile = $documentRoot . $routeData['view'];
		$layoutFile = $documentRoot . $routeData['layout'];
	}

	// Is there any custom data in the customData string?
	$customData = $routeData['customData'];
	extract($customData);

	$view = $ViewEngine->renderView($viewFile);
	$headContents = $view['head'];
	$bodyContents = $view['body'];

	include($layoutFile);
?>
