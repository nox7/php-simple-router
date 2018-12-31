<?php
	// Starting utility class to get the mysqli object from a database connection
	// Example of use:
	/*
		$mysqli = SQLDatabase::connect();
		$mysqli->prepare("SELECT * FROM example");
		$mysqli->execute();
		$result = $mysqli->get_result();
		$firstRow = $result->fetch_assoc();
	*/

	class SQLDatabase{

		public static function connect(){
			mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Set MySQLi to throw exceptions
			try{
				$connection = new mysqli("localhost", "root", "", "DatabaseNameHere");

				// Failure of connection detection
				$connection->set_charset("utf-8");
				return $connection;
			}catch(mysqli_sql_exception $e){
				print("
					<h1>Database Failure!</h1>
					<p>
						The connection to the database was unsuccessful. Be sure that the username and password is correct. Also be sure the database that is being connected to exists.
					</p>
					<p>
						<strong>Exception message:</strong> <span style=\"color:red;\">" . $e->getMessage() . "</span>
					</p>
				");
				exit();
			}
		}
	}
?>
