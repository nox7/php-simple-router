<?php

	class Router{

		private $dbConnection;

		public function __construct($databaseConnection){
			// Dependency injection
			$this->dbConnection = $databaseConnection;
		}

		public function doesRouteExist($route){
			$statement = $this->dbConnection->prepare("
				SELECT uri FROM uri_routes WHERE uri = ?
			");
			$statement->bind_param("s", $route);
			$statement->execute();
			$result = $statement->get_result();

			return $result->num_rows > 0;
		}

		public function getViewPath($route){
			$statement = $this->dbConnection->prepare("
				SELECT view FROM uri_routes WHERE uri = ?
			");
			$statement->bind_param("s", $route);
			$statement->execute();
			$result = $statement->get_result();
			$row = $result->fetch_assoc();

			// Returns the file name. Give it a path
			return __DIR__ . "/../Views/" . $row['view'];
		}

		public function getLayoutPath($route){
			$statement = $this->dbConnection->prepare("
				SELECT layout FROM uri_routes WHERE uri = ?
			");
			$statement->bind_param("s", $route);
			$statement->execute();
			$result = $statement->get_result();
			$row = $result->fetch_assoc();

			return __DIR__ . "/../Layouts/" . $row['layout'];
		}
	}
?>
