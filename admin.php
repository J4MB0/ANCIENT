<?php

class Template {
    private $title;
    private $metaCharset;
    private $metaViewport;
    private $bootstrapCss;

    public function __construct($title, $metaCharset = 'utf-8', $metaViewport = 'width=device-width, initial-scale=1', $bootstrapCss = 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css') {
        $this->title = $title;
        $this->metaCharset = $metaCharset;
        $this->metaViewport = $metaViewport;
        $this->bootstrapCss = $bootstrapCss;
    }

    public function renderHeader() {
        echo "<!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='{$this->metaCharset}'>
            <meta name='viewport' content='{$this->metaViewport}'>
            <link href='{$this->bootstrapCss}' rel='stylesheet' integrity='sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC' crossorigin='anonymous'>
            <title>{$this->title}</title>
        </head>
        <body>";
    }

    public function renderFooter() {
        echo "<!-- Option 1: Bootstrap Bundle with Popper -->
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js' integrity='sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM' crossorigin='anonymous'></script>
        </body>
        </html>";
    }
}

class Navbar {
    private $brand;
    private $links;

    public function __construct($brand, $links) {
        $this->brand = $brand;
        $this->links = $links;
    }

    public function render() {
        echo "<nav class='navbar navbar-expand-lg navbar-dark bg-dark'>
            <div class='container-fluid'>
                <a class='navbar-brand' href='{$this->brand['href']}'>{$this->brand['title']}</a>
                <div class='collapse navbar-collapse' id='navbarNav'>
                    <ul class='navbar-nav'>";
        foreach ($this->links as $link) {
            echo "<li class='nav-item'>
                    <a class='nav-link active' aria-current='page' href='{$link['href']}'>{$link['title']}</a>
                  </li>";
        }
        echo "        </ul>
                </div>
            </div>
        </nav>";
    }
}

class Table {
    private $columns;
    private $data;

    public function __construct($columns, $data) {
        $this->columns = $columns;
        $this->data = $data;
    }

    public function render() {
        echo "<div class='container my-4'>
            <table class='table'>
            <thead>
              <tr>";
        foreach ($this->columns as $column) {
            echo "<th>{$column}</th>";
        }
        echo "  </tr>
            </thead>
            <tbody>";
        foreach ($this->data as $row) {
            echo "<tr>";
            foreach ($row as $cell) {
                echo "<td>{$cell}</td>";
            }
            echo "<td>
                      <a class='btn btn-success' href='uprav.php?id={$row['id']}'>Edit</a>
                      <a class='btn btn-danger' href='delete.php?id={$row['id']}'>Delete</a>
                  </td>
                </tr>";
        }
        echo "  </tbody>
            </table>
          </div>";
    }
}

// Vytvorenie šablóny
$template = new Template("Databaza");
$template->renderHeader();

// Navbar
$navbar = new Navbar(
    ['href' => 'admin.php', 'title' => 'PHP CRUD OPERATION'],
    [
        ['href' => 'admin.php', 'title' => 'Events'],
        ['href' => 'admin2.php', 'title' => 'Contact'],
        ['href' => 'vytvor.php', 'title' => 'Add New']
    ]
);
$navbar->render();

// Pripojenie a načítanie dát
include "partials/connection.php";
$sql = "SELECT * FROM news";
$result = $conn->query($sql);
if (!$result) {
    die("Invalid query!");
}
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = [
        'id' => $row['id'],
        'title' => $row['title'],
        'content' => $row['content']
    ];
}

// Vytvorenie a zobrazenie tabuľky
$table = new Table(['ID', 'TITLE', 'CONTENT', 'ACTIONS'], $data);
$table->render();

$template->renderFooter();

?>
