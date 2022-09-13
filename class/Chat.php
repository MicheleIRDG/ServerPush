<?php
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

require dirname(__DIR__) . "/class/ChatUser.php";
require dirname(__DIR__) . "/class/ChatRooms.php";

class Chat implements MessageComponentInterface {
    protected SplObjectStorage $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        echo 'Server Started' . PHP_EOL;
    }

    /**
     * @param ConnectionInterface $conn
     * @return void
     */
    public function onOpen(ConnectionInterface $conn):void {

        // Store the new connection to send messages to later
        echo 'Incoming Connection: ';
        $this->clients->attach($conn);

        echo "Client ($conn->resourceId) Connected!\n";
    }

    /**
     * @param ConnectionInterface $from
     * @param $msg
     * @return void
     * @throws JsonException
     */
    public function onMessage(ConnectionInterface $from, $msg):void
    {
        if(str_contains($msg, "auth")) {
            $data = json_decode($msg, true, 512, JSON_THROW_ON_ERROR);

            $user_object = new \ChatUser;
            $user_object->setUserToken($data['auth']);
            $user_object->setUserConnectionId($from->resourceId);
            $user_object->update_user_connection_id();
        } else {
            $numRecv = count($this->clients) - 1;
            echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n", $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

            $data = json_decode($msg, true, 512, JSON_THROW_ON_ERROR);

            //group chat
            $chat_object = new \ChatRooms;
            $chat_object->setUserId($data['userid']);
            $chat_object->setMessage($data['msg']);
            $chat_object->setCreatedOn(date("Y-m-d h:i:s"));
            $chat_object->save_chat();

            $user_object = new \ChatUser;
            $user_object->setUserId($data['userid']);
            $user_data = $user_object->get_user_data_by_id();
            $user_name = $user_data['user_name'];
            $data['dt'] = date("d-m-Y h:i:s");

            foreach ($this->clients as $client) {
                if ($from == $client) {
                    $data['from'] = 'Me';
                } else {
                    $data['from'] = $user_name;
                }
                $client->send(json_encode($data, JSON_THROW_ON_ERROR));
            } // fine foreach
        } // fine if
    } // fine onMessage

    /**
     * @param ConnectionInterface $conn
     * @return void
     */
    public function onClose(ConnectionInterface $conn):void {

        $querystring = $conn->httpRequest->getUri()->getQuery();

        parse_str($querystring, $queryarray);

        if(isset($queryarray['token']))
        {

            $user_object = new \ChatUser;

            $user_object->setUserToken($queryarray['token']);

            $user_data = $user_object->get_user_id_from_token();

            $user_id = $user_data['user_id'];

            $data['status_type'] = 'Offline';

            $data['user_id_status'] = $user_id;

            foreach($this->clients as $client)
            {
                $client->send(json_encode($data));
            }
        }
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    /**
     * @param ConnectionInterface $conn
     * @param Exception $e
     * @return void
     */
    public function onError(ConnectionInterface $conn, \Exception $e):void {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
} // fine class Chat
?>
