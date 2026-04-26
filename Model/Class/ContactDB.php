<?php

namespace Model\Entity;

use Model\ConnexionDB;

class ContactDB
{
    private $db;

    public function __construct()
    {
        $this->db = ConnexionDB::getPDO();
    }

    public function saveMessage($userId, $replyEmail, $subject, $message)
    {
        $sql = "INSERT INTO contact_messages (user_id, reply_email, subject, message) VALUES (?, ?, ?, ?);";
        $this->db->prepare($sql)->execute([$userId, $replyEmail, $subject, $message]);
    }
}