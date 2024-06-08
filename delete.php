<?php

 class Delete1 {
    private $pdo;

    public function __construct($dsn, $username, $password) {
        try {
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function deleteNewsById($id) {
        $sql = "DELETE FROM `news` WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
    }

    public function redirect($url) {
        header("Location: $url");
        exit;
    }
}

// Iniciácia databázového pripojenia
$dsn = 'mysql:host=localhost;dbname=ancient';
$username = 'root';
$password = '';
$database = new Delete1($dsn, $username, $password);

// Spracovanie požiadavky na odstránenie záznamu
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $database->deleteNewsById($id);
}

// Presmerovanie na administrátorskú stránku
$database->redirect('admin.php');
?>
