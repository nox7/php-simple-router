<?php
	require_once("Classes/Database.php");
	require_once("Classes/Router.php");
	require_once("Classes/ViewEngine.php");
	$connection = SQLDatabase::connect();
	$Router = new Router($connection);
	$ViewEngine = new ViewEngine();

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


	$view = null;
	$layout = null;
	if ($Router->doesRouteExist($route)){
		$viewFile = $Router->getViewPath($route);
		$layoutFile = $Router->getLayoutPath($route);
		if ($viewFile === false){ // The path to the view file does not exist
			$viewFile = $Router->getViewPath("/404"); // Get a 404 instead
			$layoutFile = $Router->getLayoutPath("/404");
		}
		$view = $ViewEngine->renderView($viewFile);
	}else{ // The route doesn't exist
		$viewFile = $Router->getViewPath("/404");
		$layoutFile = $Router->getLayoutPath("/404");
		$view = $ViewEngine->renderView($viewFile);
	}

	$headContents = $view['head'];
	$bodyContents = $view['body'];

	include($layoutFile);
?>
