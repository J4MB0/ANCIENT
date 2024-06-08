<?php
include 'delete.php';
class Delete2 extends Delete1 {
    /*private $pdo;

    public function __construct($dsn, $username, $password) {
        try {
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }
    public function redirect($url) {
        header("Location: $url");
        exit;
    }    
    */

    public function deleteContactById($id) {
        $sql = "DELETE FROM `kontakt` WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
    }

    
}

// Iniciácia databázového pripojenia
$dsn = 'mysql:host=localhost;dbname=ancient';
$username = 'root';
$password = '';
$database = new Delete2($dsn, $username, $password);

// Spracovanie požiadavky na odstránenie záznamu
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $database->deleteContactById($id);
}

// Presmerovanie na administrátorskú stránku
$database->redirect('admin2.php');
?>
