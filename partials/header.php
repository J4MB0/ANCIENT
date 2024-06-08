<?php

class HeaderTemplate {
    private $cssFile;
    private $siteTitle;
    private $socialLinks;

    public function __construct($cssFile, $siteTitle, $socialLinks) {
        $this->cssFile = $cssFile;
        $this->siteTitle = $siteTitle;
        $this->socialLinks = $socialLinks;
    }

    public function includeCss() {
        echo "<style>";
        include($this->cssFile);
        echo "</style>";
    }

    public function renderHeader() {
        echo "<div id='templatemo_header'>
                <div id='site_title'><h1><a href='#'>{$this->siteTitle}</a></h1></div>
                <div id='social'>";
        foreach ($this->socialLinks as $link) {
            echo "<a href='{$link['url']}'><img src='{$link['icon']}' alt='{$link['alt']}' /></a>";
        }
        echo "</div>
              </div>";
    }
}

// Definícia sociálnych odkazov
$socialLinks = [
    ['url' => '#', 'icon' => 'images/templatemo_icon_01.png', 'alt' => 'twitter'],
    ['url' => '#', 'icon' => 'images/templatemo_icon_02.png', 'alt' => 'RSS'],
    ['url' => '#', 'icon' => 'images/templatemo_icon_03.png', 'alt' => 'contact']
];

// Vytvorenie šablóny a zahrnutie CSS súboru
$headerTemplate = new HeaderTemplate("css/templatemo_style.css", "Free CSS Templates", $socialLinks);
$headerTemplate->includeCss();
$headerTemplate->renderHeader();
?>
