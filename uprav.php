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

    public function getNewsById($id) {
        $sql = "SELECT * FROM news WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateNews($id, $title, $content) {
        $sql = "UPDATE news SET title = :title, content = :content WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id, 'title' => $title, 'content' => $content]);
    }

    public function redirect($url) {
        header("Location: $url");
        exit;
    }
}

class NewsController {
    private $database;
    private $title;
    private $content;

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
            $this->database->redirect('admin.php');
        }
        $id = $_GET['id'];
        $news = $this->database->getNewsById($id);
        if (!$news) {
            $this->database->redirect('admin.php');
        }
        $this->renderForm($news);
    }

    private function handlePost() {
        $this->id = $_POST["id"];
        $this->title = $_POST["title"];
        $this->content = $_POST["content"];
        $this->database->updateNews($this->id, $this->title, $this->content);
        $this->database->redirect('admin.php');
    }

    private function renderForm($news) {
        $this->id = $news['id'];
        $this->title = $news['title'];
        $this->content = $news['content'];
    }

    public function getID(){
        return $this->id;
    }

    public function getTitle(){
        return $this->title;
    }

    public function getContent(){
        return $this->content;
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

<!-- partials/form.php -->
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
                <li class="nav-item">
                    <a type="button" class="btn btn-primary nav-link active" href="vytvor.php">Add New</a>
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
            <label> TITLE: </label>
            <input type="text" name="title" value="<?php echo $controller->getTitle(); ?>" class="form-control"> <br>
            <label> CONTENT: </label>
            <input type="text" name="content" value="<?php echo $controller->getContent(); ?>" class="form-control"> <br>
            <button class="btn btn-success" type="submit" name="submit"> Submit </button><br>
            <a class="btn btn-info" type="submit" name="cancel" href="admin.php"> Cancel </a><br>
        </div>
    </form>
</div>
</body>
