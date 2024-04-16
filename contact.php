<style>
<?php include("css/templatemo_style.css")?>
</style>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ancient - Contact Us</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="templatemo_style.css" rel="stylesheet" type="text/css" />

<script language="javascript" type="text/javascript">
function clearText(field)
{
    if (field.defaultValue == field.value) field.value = '';
    else if (field.value == '') field.value = field.defaultValue;
}
</script>

</head>
<body>

<div id="templatemo_wrapper">

	<span class="bg_top"></span>
    <span class="bg_bottom"></span>

	<?php include("partials/menu.php")?>
    
     <?php include("partials/header.php")?>
    
    <div id="templatemo_main">
    	<div class="cbox_fw">
        <h2>Contact Us</h2>

		<p>Validate <a href="http://validator.w3.org/check?uri=referer" rel="nofollow">XHTML</a> &amp; <a href="http://jigsaw.w3.org/css-validator/check/referer" rel="nofollow">CSS</a>. In fermentum, eros ac tincidunt aliquam, elit velit semper nunc, a tincidunt orci lectus a arcu. Nullam commodo, arcu non facilisis imperdiet, felis lectus tempus felis, vitae volutpat augue ante quis leo. Aliquam tristique dolor ac odio. Sed consectetur, lacus et dictum tristique, odio neque elementum ante, nec eleifend leo dolor vel tortor.</p>
        
        </div>
        
        <div id="sidebar">
        

                <h3>Address One</h3>
                
                180-250 Quisque odio quam, <br />
                Pulvinar sit amet convallis eget, 10320<br />
                Venenatis ut turpis<br />
                <br />
                Tel: 020-080-0740<br />
                Fax: 020-080-0920
                
                <div class="cleaner h40"></div>
                
                <h3>Address Two</h3>
                    110-310 Duis lacinia dictum, <br />
                    PVestibulum auctor, 10510<br />
                    Nam rhoncus, diam a mollis tempor<br />
                    <br />
                    Tel: 010-050-0480<br />
                    Fax: 010-050-0470
                  
                <div class="cleaner"></div>
        
        </div>
        
        <div id="content">
        <?php
                $dsn = 'mysql:host=localhost;dbname=ancient';
                $username = 'root';
                $password = '';

                try {
                    $pdo = new PDO($dsn, $username, $password);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Pozre či je form zaslaný
                    if (isset($_POST['submit'])) {
                        // Zísak info  z formu
                        $name = $_POST['name'];
                        $email = $_POST['email'];
                        $phone = $_POST['phone'];
                        $message = $_POST['message'];
                        if(empty($_POST["name"]) || empty($_POST["email"]) ||  empty($_POST["phone"]) || empty($_POST["message"])){
                          echo('Všetky polia musia byť vyplnené');
                        }else{

                        // Vloží info do databázy
                        $insertStmt = $pdo->prepare("INSERT INTO kontakt (name, email, phone, message) VALUES (:name, :email, :phone, :message)");

                        $insertStmt->execute(['name' => $name, 'email' => $email, 'phone' => $phone, 'message' => $message]);

                        // Výpíše śpešnú správu
                        echo "Úspešne odoslané!";
                        }
                    }
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                ?>
		<div id="contact_form">
                    
                
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
            </div>
            
        </div>
        
        <div class="cleaner"></div>
    </div> <!-- end of main -->
    <div id="templatemo_main_bottom"></div>
    
    <?php include("partials/footer.php")?>
</div> <!-- end of wrapper -->
<!-- templatemo 287 ancient -->
<!-- 
Ancient Template 
http://www.templatemo.com/preview/templatemo_287_ancient 
-->
</body>
