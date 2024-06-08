<?php

class FooterTemplate {
    private $footerText;

    public function __construct($footerText) {
        $this->footerText = $footerText;
    }

    public function renderFooter() {
        echo "<div id='templatemo_footer'>
                {$this->footerText}
                <div class='cleaner'></div>
              </div>";
    }
}

// Vytvorenie šablóny a zobrazenie pätičky
$footerTemplate = new FooterTemplate("Copyright © 2048 <a href='#'>Your Company Name</a> <!-- Credit: www.templatemo.com -->");
$footerTemplate->renderFooter();
?>
