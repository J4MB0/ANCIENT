<?php
    include "partials/connection.php";
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $sql = "DELETE from `news` where id=$id";
        $conn->query($sql);
    }
    header('location:admin.php');
    exit;
?>