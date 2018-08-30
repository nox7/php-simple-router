<?php

	/*
		Relies on a database called uri_routes

		CREATE TABLE `uri_routes` (
		  `uri` varchar(255) CHARACTER SET ascii NOT NULL,
		  `view` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
		  `layout` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
		  `customData` text COLLATE utf8mb4_unicode_ci NOT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

		ALTER TABLE `uri_routes`
		  ADD PRIMARY KEY (`uri`),
		  ADD UNIQUE KEY `uri` (`uri`);
	*/

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
