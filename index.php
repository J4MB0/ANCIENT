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

class MainContent {
    private $sections;

    public function __construct($sections) {
        $this->sections = $sections;
    }

    public function render() {
        foreach ($this->sections as $section) {
            echo "<div class='cbox_fws'>
                    <h3>{$section['title']}</h3>
                    <div class='cbox_w280 {$section['float']}'>
                        <a href='#'><img src='{$section['image']}' alt='image' class='image_frame' /></a>
                        <p>{$section['text']}</p>
                        <a href='#' class='more float_r'><span>&gt;&gt;</span> Read more</a>
                        <div class='cleaner'></div>
                    </div>
                </div>";
        }
        echo '<div class="cleaner"></div>';
    }
}

class Gallery {
    private $images;

    public function __construct($images) {
        $this->images = $images;
    }

    public function render() {
        echo '<div class="cbox_last">
                <h3>Photo Gallery</h3>
                <ul class="photo_gallery">';
        foreach ($this->images as $image) {
            echo "<li><a href='#'><img src='{$image['src']}' alt='{$image['alt']}' class='image_frame' /></a></li>";
        }
        echo '</ul>
            <div class="cleaner"></div>
            <p><a href="#" class="more float_r"><span>&gt;&gt;</span> View All</a></p>
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
$template = new Template("Ancient - Free CSS Template", "utf-8", "", "", "templatemo_style.css", $script);
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
            <h2>Lorem ipsum dolor amet consectetur</h2>
            <a href="#"><img src="images/templatemo_image_08.jpg" alt="image" class="image_frame image_fl" /></a>
            <p>Ancient Template is brought to you by <a href="#">templatemo</a> website. Feel free to download, edit and apply this template for your personal or commercial websites. Validate <a href="http://validator.w3.org/check?uri=referer" rel="nofollow">XHTML</a> &amp; <a href="http://jigsaw.w3.org/css-validator/check/referer" rel="nofollow">CSS</a>. Credits go to <a href="http://www.photovaco.com/" target="_blank">Free Photos</a> for Photos. Ut enim ad minim veniamquis nostrud exercitation ullamco lab.</p>
            <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum doloreeu fugiat null
            epteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit ani
            rum Curabitur pretium.</p>
            <a href="#" class="more float_r"><span>&gt;&gt;</span> View All</a>
            <div class="cleaner"></div>
        </div>

        <?php $template->includeFile("partials/sidebar.php"); ?>

        <div id="content">
            <?php
            $mainContent = new MainContent([
                [
                    'title' => 'Excepteur occaecat cupid duis consequat',
                    'float' => 'float_l',
                    'image' => 'images/templatemo_image_04.jpg',
                    'text' => 'Excepteur sint occaecat cupidatat non proi ent, sunt in culpa qui officia deserunt molt anim id est laborum.'
                ],
                [
                    'title' => 'Excepteur occaecat cupid duis consequat',
                    'float' => 'float_r',
                    'image' => 'images/templatemo_image_05.jpg',
                    'text' => 'Duis ac tellus et risus vulputate vehicnec lobortis risus a elit. Etiam tempor. Utllan corper ligula.'
                ],
                [
                    'title' => 'Excepteur occaecat cupid duis consequat',
                    'float' => 'float_l',
                    'image' => 'images/templatemo_image_06.jpg',
                    'text' => 'Marst str sint occaecat cupidatat non prod ent, sunt in culpa qui officia deserunt mol satst gislets ste otedform.'
                ],
                [
                    'title' => 'Excepteur occaecat cupid duis consequat',
                    'float' => 'float_r',
                    'image' => 'images/templatemo_image_07.jpg',
                    'text' => 'Fedarls moste risus vulputate vehiculnec lobortis risus a elit. Etiam tempor. sullan cooffieca deserunt moti.'
                ]
            ]);
            $mainContent->render();

            $gallery = new Gallery([
                ['src' => 'images/templatemo_image_01.jpg', 'alt' => 'Image 1'],
                ['src' => 'images/templatemo_image_02.jpg', 'alt' => 'Image 2'],
                ['src' => 'images/templatemo_image_03.jpg', 'alt' => 'Image 3']
            ]);
            $gallery->render();
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
