<?php

class Database {
    private $pdo;

    public function __construct($dsn, $username, $password) {
        try {
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function getContactById($id) {
        $sql = "SELECT * FROM kontakt WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateContact($id, $name, $email, $phone, $message) {
        $sql = "UPDATE kontakt SET name = :name, email = :email, phone = :phone, message = :message WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id, 'name' => $name, 'email' => $email, 'phone' => $phone, 'message' => $message]);
    }

    public function redirect($url) {
        header("Location: $url");
        exit;
    }
}

class ContactController {
    private $database;
    private $name;
    private $email;
    private $phone;
    private $message;

    public function __construct($database) {
        $this->database = $database;
    }

    public function handleRequest() {
        if ($_SERVER["REQUEST_METHOD"] == 'GET') {
            $this->handleGet();
        } else {
            $this->handlePost();
        }
    }

    private function handleGet() {
        if (!isset($_GET['id'])) {
            $this->database->redirect('admin2.php');
        }
        $id = $_GET['id'];
        $contact = $this->database->getContactById($id);
        if (!$contact) {
            $this->database->redirect('admin2.php');
        }
        $this->renderForm($contact);
    }

    private function handlePost() {
        $this->id = $_POST["id"];
        $this->name = $_POST["name"];
        $this->email = $_POST["email"];
        $this->phone = $_POST["phone"];
        $this->message = $_POST["message"];
        $this->database->updateContact($this->id, $this->name, $this->email, $this->phone, $this->message);
        $this->database->redirect('admin2.php');
    }

    private function renderForm($contact) {
        $this->id = $contact['id'];
        $this->name = $contact['name'];
        $this->email = $contact['email'];
        $this->phone = $contact['phone'];
        $this->message = $contact['message'];
        
    }

    public function getID(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }

    public function getEmail(){
        return $this->email;
    } 
    public function getPhone(){
        return $this->phone;
    }

    public function getMessage(){
        return $this->message;
    } 
}

// Iniciácia databázového pripojenia
$dsn = 'mysql:host=localhost;dbname=ancient';
$username = 'root';
$password = '';
$database = new Database($dsn, $username, $password);

// Spracovanie požiadavky
$controller = new ContactController($database);
$controller->handleRequest();
?>

<!-- partials/contact_form.php -->
<head>
    <title>CRUD</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark" class="fw-bold">
    <div class="container-fluid">
        <a class="navbar-brand" href="admin.php">PHP CRUD OPERATION</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="admin.php">Events</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="admin2.php">Kontakt</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="col-lg-6 m-auto">
    <form method="post">
        <br><br>
        <div class="card">
            <div class="card-header bg-warning">
                <h1 class="text-white text-center"> Update </h1>
            </div>
            <br>
            <input type="hidden" name="id" value="<?php echo $controller->getID(); ?>" class="form-control"> <br>
            <label> NAME: </label>
            <input type="text" name="name" value="<?php echo $controller->getName(); ?>" class="form-control"> <br>
            <label> EMAIL: </label>
            <input type="text" name="email" value="<?php echo $controller->getEmail(); ?>" class="form-control"> <br>
            <label> PHONE: </label>
            <input type="text" name="phone" value="<?php echo $controller->getPhone(); ?>" class="form-control"> <br>
            <label> MESSAGE: </label>
            <input type="text" name="message" value="<?php echo  $controller->getMessage(); ?>" class="form-control"> <br>
            <button class="btn btn-success" type="submit" name="submit"> Submit </button><br>
            <a class="btn btn-info" type="submit" name="cancel" href="admin2.php"> Cancel </a><br>
        </div>
    </form>
</div>
</body>
