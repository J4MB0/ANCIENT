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

    public function insertNews($title, $content) {
        $sql = "INSERT INTO news (title, content) VALUES (:title, :content)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['title' => $title, 'content' => $content]);
    }

    public function redirect($url) {
        header("Location: $url");
        exit;
    }
}

class NewsController {
    private $database;

    public function __construct($database) {
        $this->database = $database;
    }

    public function handleRequest() {
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $this->handlePost();
        } 
    }

    private function handlePost() {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $this->database->insertNews($title, $content);
        $this->database->redirect('admin.php');
    }

    
}

// Iniciácia databázového pripojenia
$dsn = 'mysql:host=localhost;dbname=ancient';
$username = 'root';
$password = '';
$database = new Database($dsn, $username, $password);

// Spracovanie požiadavky
$controller = new NewsController($database);
$controller->handleRequest();
?>

<!-- partials/create_form.php -->
<head>
    <title>CRUD</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="admin.php">PHP CRUD OPERATION</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="admin.php"><span style="font-size:larger;">Home</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="vytvor.php"><span style="font-size:larger;">Add New</span></a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="col-lg-6 m-auto">
    <form method="post">
        <br><br>
        <div class="card">
            <div class="card-header bg-primary">
                <h1 class="text-white text-center"> Create </h1>
            </div>
            <br>
            <label> TITLE: </label>
            <input type="text" name="title" class="form-control"> <br>
            <label> CONTENT: </label>
            <input type="text" name="content" class="form-control"> <br>
            <button class="btn btn-success" type="submit" name="submit"> Submit </button><br>
            <a class="btn btn-info" type="submit" name="cancel" href="admin.php"> Cancel </a><br>
        </div>
    </form>
</div>
</body>
