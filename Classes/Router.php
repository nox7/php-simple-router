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
			try{
				$statement = $this->dbConnection->prepare("
					SELECT * FROM uri_routes
				");
			}catch(mysqli_sql_exception $e){
				print("<h1>Missing URI Routes Database Table</h1>");
				print("<p>Your selected database does not have a table name `uri_routes`. Please create one that follows this table:</p>");
				print("<table><thead><tr><th>column name</th><th>type</th><th>coalition</th><th>index</th></tr></thead>");
				print("<tbody><tr><td>uri</td><td>varchar 255</td><td>ascii_general</td><td>PRIMARY</td></tr>");
				print("<tr><td>view</td><td>varchar 255</td><td>ascii_general</td><td></td></tr>");
				print("<tr><td>layout</td><td>varchar 255</td><td>ascii_general</td><td></td></tr>");
				print("<tr><td>isRegularExpression</td><td>int</td><td></td><td></td></tr>");
				print("<tr><td>customData</td><td>text</td><td></td><td></td></tr>");
				print("</tbody></table>");
				exit();
			}
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
