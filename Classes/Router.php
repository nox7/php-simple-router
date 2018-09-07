<?php

	class Router{

		private $dbConnection;

		public function __construct($databaseConnection){
			// Dependency injection
			$this->dbConnection = $databaseConnection;
		}

		public function getAllRoutes(){
			// This became necessary to handle regularly-expressed uris in PHP
			// Get all of the uri routes
			$statement = $this->dbConnection->prepare("
				SELECT * FROM uri_routes
			");
			$statement->execute();
			$result = $statement->get_result();
			return $result->fetch_all(MYSQLI_ASSOC);
		}

		public function getRouteData($desiredRoute){
			$routes = $this->getAllRoutes();

			// Loop through and try to match routes
			foreach($routes as $routeData){
				$uri = $routeData['uri'];
				$isRegularExpression = (int) $routeData['isRegularExpression'];
				if ($isRegularExpression == 1){
					$matchSuccess = preg_match("@" . $uri . "@", $desiredRoute, $matches);
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
