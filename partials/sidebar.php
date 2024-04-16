<style>
<?php include("css/templatemo_style.css")?>
</style>
 <!--
<div id="sidebar">
        
   	  <div id="nne">
            
	        	<h3>News &amp; Events</h3>
                <ul class="nne_box">
                	<li><span>16 March 2048</span><a href="#">Ut enim ad minim veniamquis nostru itation ullamco laboris nisi.</a></li>
                    <li><span>14 March 2048</span><a href="#">Dunt in culpa qui officia deserunt mol satst gislets  ste otedform.</a></li>
                    <li><span>22 February 2048</span><a href="#">Mourt sculpa qui officia deserunt fure satst gisletsser tellerast.</a></li>
                    <li><span>18 February 2048</span><a href="#">Admirest ad minim veniamquis nostru itation ullamco laboris nisi.</a></li>	
                </ul>
                
			</div>
            
            
        
        </div>
-->

        <div id="sidebar">
    <div id="nne">
        <h3>News &amp; Events</h3>
        <ul class="nne_box">
            <?php
            // Pripojenie k databáze (upravte údaje podľa vašich potrieb)
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "ancient";
            
            $conn = new mysqli($servername, $username, $password, $dbname);
            
            // Overenie spojenia
            if ($conn->connect_error) {
                die("Spojenie s databázou zlyhalo: " . $conn->connect_error);
            }
            
            // Získanie údajov z databázy
            $sql = "SELECT * FROM news LIMIT 4";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $title = $row['title'];
                    $content = $row['content'];
                    echo '<li><span>' . $title . '</span><a href="#">' . $content . '</a></li>';
                }
            } else {
                echo '<li>No news available</li>';
            }
            
            $conn->close();
            ?>
        </ul>
    </div>
</div>
