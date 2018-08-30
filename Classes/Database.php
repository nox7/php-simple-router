<?php
	class SQLDatabase{

		public static function connect(){
			mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Set MySQLi to throw exceptions
			try{
				$connection = new mysqli("localhost", "root", "", "_stockphotos");

				// Failure of connection detection
				$connection->set_charset("utf-8");
				return $connection;
			}catch(Exception $e){
				print("
					<h1>Database Failure!</h1>
					<p>
						The connection to the database was unsuccessful. Be sure that the username and password is correct. Also be sure the database that is being connected to exists.
					</p>
				");
				exit();
			}
		}
	}
?>
