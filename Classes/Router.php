<?php

	require_once(__DIR__ . "/../Routes.php");
	// $routes is now in the variable scope from Routes.php

	class Router{

		private $dbConnection;

		public function __construct(){}

		public function getRouteData($desiredRoute){
			global $routes;

			// Loop through and try to match routes
			foreach($routes as $routeData){
				$uri = $routeData['uri'];
				$isRegularExpression = (int) $routeData['isRegex'];
				if ($isRegularExpression == 1){
					$matchSuccess = preg_match($uri, $desiredRoute, $matches);
					if ($matchSuccess == 1){ // Returns 1 if matched, 0 if not
						return array_merge([
							"parameters"=>$matches
						], $routeData);
					}
				}else{
					if (trim($uri) === trim($desiredRoute)){
						return array_merge(["parameters"=>[]], $routeData);
					}
				}
			}

			return false; // Route doesn't exist
		}

	}
?>
