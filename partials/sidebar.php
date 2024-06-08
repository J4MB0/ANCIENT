<?php

class DbConnection {
    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $conn;

    public function __construct($servername, $username, $password, $dbname) {
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
    }

    public function connect() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getNews($limit = 4) {
        $sql = "SELECT * FROM news LIMIT ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $news = [];
        while ($row = $result->fetch_assoc()) {
            $news[] = $row;
        }
        $stmt->close();
        return $news;
    }

    public function close() {
        $this->conn->close();
    }
}

class SidebarTemplate {
    private $cssFile;
    private $news;

    public function __construct($cssFile, $news) {
        $this->cssFile = $cssFile;
        $this->news = $news;
    }

    public function includeCss() {
        echo "<style>";
        include($this->cssFile);
        echo "</style>";
    }

    public function renderSidebar() {
        echo '<div id="sidebar">
                <div id="nne">
                    <h3>News &amp; Events</h3>
                    <ul class="nne_box">';
        if (count($this->news) > 0) {
            foreach ($this->news as $newsItem) {
                $title = $newsItem['title'];
                $content = $newsItem['content'];
                echo "<li><span>{$title}</span><a href='#'>{$content}</a></li>";
            }
        } else {
            echo '<li>No news available</li>';
        }
        echo '      </ul>
                </div>
              </div>';
    }
}

// Pripojenie k databáze a získanie noviniek
$database = new DbConnection("localhost", "root", "", "ancient");
$database->connect();
$news = $database->getNews();
$database->close();

// Vytvorenie šablóny a zahrnutie CSS súboru
$sidebarTemplate = new SidebarTemplate("css/templatemo_style.css", $news);
$sidebarTemplate->includeCss();
$sidebarTemplate->renderSidebar();
?>
