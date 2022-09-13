<?php
class Database
{
	/**
	 * @return PDO
	 */
	public function connect(): PDO
	{
		return new PDO("mysql:host=localhost; dbname=chat", "root", "");
	}
} // end of class Database
?>
