<?php
class ChatRooms
{
	private int $chat_id;
	private int $user_id;
	private string $message;
	private string $created_on;
	protected PDO $connect;

	public function __construct()
	{
		require_once("Database.php");

		$database_object = new Database();

		$this->connect = $database_object->connect();
	}

	// Autogenerated Methods

	/**
	 * @param $chat_id
	 * @return void
	 */
	public function setChatId($chat_id): void
	{
		$this->chat_id = $chat_id;
	}

	/**
	 * @return int
	 */
	public function getChatId(): int
	{
		return $this->chat_id;
	}

	/**
	 * @param $user_id
	 * @return void
	 */
	public function setUserId($user_id): void
	{
		$this->user_id = $user_id;
	}

	/**
	 * @return int
	 */
	public function getUserId(): int
	{
		return $this->user_id;
	}

	/**
	 * @param $message
	 * @return void
	 */
	public function setMessage($message): void
	{
		$this->message = $message;
	}

	/**
	 * @return string
	 */
	public function getMessage(): string
	{
		return $this->message;
	}

	/**
	 * @param $created_on
	 * @return void
	 */
	public function setCreatedOn($created_on): void
	{
		$this->created_on = $created_on;
	}

	/**
	 * @return string
	 */
	public function getCreatedOn(): string
	{
		return $this->created_on;
	}

	// Custom Methods

	/**
	 * @return void
	 */
	public function save_chat(): void
	{
		$query = "
		INSERT INTO chatrooms 
			(userid, msg, created_on) 
			VALUES (:userid, :msg, :created_on)
		";

		$statement = $this->connect->prepare($query);

		$statement->bindParam(':userid', $this->user_id);

		$statement->bindParam(':msg', $this->message);

		$statement->bindParam(':created_on', $this->created_on);

		$statement->execute();
	}

	/**
	 * @return bool|array
	 */
	public function get_all_chat_data(): bool|array
	{
		$query = "
		SELECT * FROM chatrooms 
			INNER JOIN chat_user_table 
			ON chat_user_table.user_id = chatrooms.userid 
			ORDER BY chatrooms.id ASC
		";

		$statement = $this->connect->prepare($query);

		$statement->execute();

		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}
} // end of class
?>