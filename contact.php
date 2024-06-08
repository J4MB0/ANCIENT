<?php

class Template {
    private $title;
    private $metaCharset;
    private $metaKeywords;
    private $metaDescription;
    private $cssFile;
    private $script;

    public function __construct($title, $metaCharset = 'utf-8', $metaKeywords = '', $metaDescription = '', $cssFile = 'templatemo_style.css', $script = '') {
        $this->title = $title;
        $this->metaCharset = $metaCharset;
        $this->metaKeywords = $metaKeywords;
        $this->metaDescription = $metaDescription;
        $this->cssFile = $cssFile;
        $this->script = $script;
    }

    public function renderHeader() {
        echo "<!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta http-equiv='Content-Type' content='text/html; charset={$this->metaCharset}' />
            <title>{$this->title}</title>
            <meta name='keywords' content='{$this->metaKeywords}' />
            <meta name='description' content='{$this->metaDescription}' />
            <link href='{$this->cssFile}' rel='stylesheet' type='text/css' />
            {$this->script}
        </head>
        <body>";
    }

    public function renderFooter() {
        echo "</body>
        </html>";
    }

    public function includeFile($filePath) {
        include($filePath);
    }
}

class ContactForm {
    private $pdo;

    public function __construct($dsn, $username, $password) {
        try {
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function handleFormSubmission() {
        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $message = $_POST['message'];

            if(empty($name) || empty($email) || empty($phone) || empty($message)){
                echo 'Všetky polia musia byť vyplnené';
                return;
            }

            $insertStmt = $this->pdo->prepare("INSERT INTO kontakt (name, email, phone, message) VALUES (:name, :email, :phone, :message)");
            $insertStmt->execute(['name' => $name, 'email' => $email, 'phone' => $phone, 'message' => $message]);
            echo "Úspešne odoslané!";
        }
    }

    public function renderForm() {
        echo '<div id="contact_form">
            <form method="post" name="contact" id="ok" action="#">
                <label for="name">Name:</label> <input type="text" id="name" name="name" class="required input_field" />
                <div class="cleaner_h10"></div>
                <label for="email">Email:</label> <input type="text" id="email" name="email" class="validate-email required input_field" />
                <div class="cleaner_h10"></div>
                <label for="phone">Phone:</label> <input type="text" name="phone" id="phone" class="input_field" />
                <div class="cleaner_h10"></div>
                <label for="message">Message:</label> <textarea id="text" name="message" rows="0" cols="0" class="required"></textarea>
                <div class="cleaner_h10"></div>
                <input type="submit" class="submit_btn" name="submit" id="submit" value="Send" />
                <input type="reset" class="submit_btn" name="reset" id="reset" value="Reset" />
            </form>
        </div>';
    }
}

// Script na vyčistenie textového poľa
$script = "<script language='javascript' type='text/javascript'>
    function clearText(field) {
        if (field.defaultValue == field.value) field.value = '';
        else if (field.value == '') field.value = field.defaultValue;
    }
</script>";

// Vytvorenie šablóny
$template = new Template("Ancient - Contact Us", "utf-8", "", "", "templatemo_style.css", $script);
$template->renderHeader();
?>

<div id="templatemo_wrapper">
    <span class="bg_top"></span>
    <span class="bg_bottom"></span>

    <?php
    $template->includeFile("partials/menu.php");
    $template->includeFile("partials/header.php");
    ?>

    <div id="templatemo_main">
        <div class="cbox_fw">
            <h2>Contact Us</h2>
            <p>Validate <a href="http://validator.w3.org/check?uri=referer" rel="nofollow">XHTML</a> &amp; <a href="http://jigsaw.w3.org/css-validator/check/referer" rel="nofollow">CSS</a>. In fermentum, eros ac tincidunt aliquam, elit velit semper nunc, a tincidunt orci lectus a arcu. Nullam commodo, arcu non facilisis imperdiet, felis lectus tempus felis, vitae volutpat augue ante quis leo. Aliquam tristique dolor ac odio. Sed consectetur, lacus et dictum tristique, odio neque elementum ante, nec eleifend leo dolor vel tortor.</p>
        </div>

        <div id="sidebar">
            <h3>Address One</h3>
            180-250 Quisque odio quam, <br />
            Pulvinar sit amet convallis eget, 10320<br />
            Venenatis ut turpis<br /><br />
            Tel: 020-080-0740<br />
            Fax: 020-080-0920
            <div class="cleaner h40"></div>
            <h3>Address Two</h3>
            110-310 Duis lacinia dictum, <br />
            PVestibulum auctor, 10510<br />
            Nam rhoncus, diam a mollis tempor<br /><br />
            Tel: 010-050-0480<br />
            Fax: 010-050-0470
            <div class="cleaner"></div>
        </div>

        <div id="content">
            <?php
            $form = new ContactForm('mysql:host=localhost;dbname=ancient', 'root', '');
            $form->handleFormSubmission();
            $form->renderForm();
            ?>
        </div>

        <div class="cleaner"></div>
    </div> <!-- end of main -->
    <div id="templatemo_main_bottom"></div>

    <?php $template->includeFile("partials/footer.php"); ?>
</div> <!-- end of wrapper -->

<?php
$template->renderFooter();
?>
