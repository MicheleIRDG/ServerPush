<?php
namespace Ratchet;
require_once "vendor/Ratchet/ComponentInterface.php";
require_once "vendor/Ratchet/MessageInterface.php";

interface MessageComponentInterface extends \Ratchet\ComponentInterface, \Ratchet\MessageInterface {
}
