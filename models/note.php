<?php
namespace app\models;
include_once('../config/database.php');

class Note{
    private static $conn;
    private $id;
    private $contact_id;
    private $comment;
    private $created_by;
    private $created_at;
    private static $notes = [];

    public function __construct($id, $contact_id, $comment, $created_by, $created_at){
        $this->id = $id;
        $this->contact_id = $contact_id;
        $this->comment = $comment;
        $this->created_by = $created_by;
        $this->created_at = $created_at;

        if (!self::noteExists($id)) {
            self::$notes[$id] = $this;
        }
    }

    public static function noteExists($id) {
        return isset(self::$notes[$id]);
    }

    public function getId() {
        return $this->id;
    }

    public function getContactId() {
        return $this->contact_id;
    }

    public function getComment() {
        return $this->comment;
    }

    public function getCreatedBy() {
        return $this->created_by;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    public static function setConnection($conn){
        self::$conn = $conn;
    }

    private static function clearNotes() {
        self::$notes = [];
    }

    public static function getNotes() {
        return self::$notes;
    }

    public static function getNoteById($id) {
        if (isset(self::$notes[$id])) {
            return self::$notes[$id];
        }

        return null;
    }

    public static function loadNotes() {
        $query = "SELECT * FROM users";
        $result = mysqli_query(self::$conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $fetchedUsers = mysqli_fetch_all($result, MYSQLI_ASSOC);
            self::clearNotes();

            foreach ($fetchedUsers as $user) {
                new Note ($user['id'],
                    $user['contact_id'],
                    $user['comment'],
                    $user['created_by'],
                    $user['created_at']
                );
            }
        }
    }

    public static function addContact($contact_id, $comment, $created_by) {
        $query = "INSERT INTO Notes (contact_id, comment, created_by) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare(self::$conn, $query);
        mysqli_stmt_bind_param($stmt, 'isi', $contact_id, $comment, $created_by);

        if (mysqli_stmt_execute($stmt)) {
            new Note(
                mysqli_insert_id(self::$conn),
                $contact_id,
                $comment,
                $created_by,
                date('Y-m-d H:i:s')
            );

            return true;
        }

        return false;
    }

}
