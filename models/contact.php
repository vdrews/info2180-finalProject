<?php
namespace app\models;
include_once('../config/database.php');

class Contact{
    private static $conn;
    private $id;
    private $title;
    private $firstname;
    private $lastname;
    private $email;
    private $telephone;
    private $company;
    private $type;
    private $assigned_to;
    private $created_by;
    private $created_at;
    private $updated_at;
    private static $contacts = [];

    public function __construct($id, $title, $firstname, $lastname, $email, $telephone,  $company, $type, $assigned_to, $created_by, $created_at, $updated_at) {
        $this->id = $id;
        $this->title = $title;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->telephone = $telephone;
        $this->company = $company;
        $this->type = $type;
        $this->assigned_to = $assigned_to;
        $this->created_by = $created_by;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;

        if (!self::contactExists($id)) {
            self::$contacts[$id] = $this;
        }
    }

    public static function contactExists($id) {
        return isset(self::$contacts[$id]);
    }

    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getFirstName() {
        return $this->firstname;
    }

    public function setFirstName($firstname) {
        $this->firstname = $firstname;
    }

    public function getLastName() {
        return $this->lastname;
    }

    public function setLastName($lastname) {
        $this->lastname = $lastname;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->email = $email;
        }
        else {
            $this->email = null;
            echo "Email is not valid";
        }
    }

    public function getTelephone() {
        return $this->telephone;
    }

    public function setTelephone($telephone) {
        $this->telephone = $telephone;
    }

    public function getCompany() {
        return $this->company;
    }

    public function setCompany($company) {
        $this->company = $company;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function getAssignedTo() {
        return $this->assigned_to;
    }

    public function setAssignedTo($assigned_to) {
        $this->assigned_to = $assigned_to;
    }

    public function getCreatedBy() {
        return $this->created_by;
    }

    public function setCreatedBy($created_by) {
        $this->created_by = $created_by;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    public function setCreatedAt($created_at) {
        $this->created_at = $created_at;
    }

    public function getUpdatedAt() {
        return $this->updated_at;
    }

    public function setUpdatedAt($updated_at) {
        $this->updated_at = $updated_at;
    }

    public static function setConnection($conn){
        self::$conn = $conn;
    }

    private static function clearContacts() {
        self::$contacts = [];
    }

    public static function getContacts() {
        return self::$contacts;
    }

    public static function getContactById($id) {
        if (isset(self::$contacts[$id])) {
            return self::$contacts[$id];
        }

        return null;
    }

    public static function loadContacts(){
        $query = "SELECT * FROM Contacts";
        $result = mysqli_query(self::$conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $fetchedContacts = mysqli_fetch_all($result, MYSQLI_ASSOC);

            foreach ($fetchedContacts as $contact) {
                self::clearContacts();

                new Contact(
                    $contact['id'],
                    $contact['title'],
                    $contact['firstname'],
                    $contact['lastname'],
                    $contact['email'],
                    $contact['telephone'],
                    $contact['company'],
                    $contact['type'],
                    $contact['assigned_to'],
                    $contact['created_by'],
                    $contact['created_at'],
                    $contact['updated_at']
                );
            }
        }
    }

    public static function addContact($title, $firstname, $lastname, $email, $telephone,  $company, $type, $assigned_to, $created_by) {
        $query = "INSERT INTO Contacts (title, firstname, lastname, email, telephone, company, type, assigned_to, created_by)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare(self::$conn, $query);
        mysqli_stmt_bind_param($stmt, 'sssssssii', $title, $firstname, $lastname, $email, $telephone,  $company, $type, $assigned_to, $created_by);

        if (mysqli_stmt_execute($stmt)) {
            new Contact(
                mysqli_insert_id(self::$conn),
                $title,
                $firstname,
                $lastname,
                $email,
                $telephone,
                $company,
                $type,
                $assigned_to,
                $created_by,
                date('Y-m-d H:i:s'),
                date('Y-m-d H:i:s')
            );

            echo "New Contact added";
            return true;
        }

        return false;
    }

    public static function updateContact($id, $type, $assigned_to, $updated_at) {
        foreach (self::$contacts as $contact) {
            if ($contact->getId() === $id) {
                $contact->setType($type);
                $contact->setAssignedTo($assigned_to);
                $contact->setUpdatedAt($updated_at);

                $query = "UPDATE Contacts SET type = ?, assigned_to = ?, updated_at = ? WHERE id = ?";
                $stmt = mysqli_prepare(self::$conn, $query);
                mysqli_stmt_bind_param($stmt, 'sssi', $type, $assigned_to, $updated_at, $id);

                if (mysqli_stmt_execute($stmt)) {
                    return true;
                }
                else {
                    return false;
                }
            }
        }

        return false;
    }
}
?>

<?php

?>
