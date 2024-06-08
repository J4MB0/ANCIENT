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

class Gallery {
    private $images;

    public function __construct($images) {
        $this->images = $images;
    }

    public function render() {
        echo '<div class="cbox_last">
                <h3>Our Photo Gallery</h3>
                <ul class="photo_gallery">';
        foreach ($this->images as $image) {
            echo "<li><a href='#'><img src='{$image['src']}' alt='{$image['alt']}' class='image_frame' /></a></li>";
        }
        echo '</ul>
            </div>';
    }
}

class Content {
    private $sections;

    public function __construct($sections) {
        $this->sections = $sections;
    }

    public function render() {
        foreach ($this->sections as $section) {
            echo "<div class='cbox_w280 {$section['float']}'>
                    <a href='#'><img src='{$section['image']}' alt='image' class='image_frame' /></a>
                    <p>{$section['text']}</p>
                    <a href='#' class='more float_r'><span>&gt;&gt;</span> Details</a>
                    <div class='cleaner'></div>
                </div>";
        }
        echo '<div class="cleaner"></div>';
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
$template = new Template("Ancient Gallery - Free CSS Template", "utf-8", "", "", "templatemo_style.css", $script);
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
        <?php $template->includeFile("partials/sidebar.php"); ?>

        <div id="content">
            <?php
            $gallery = new Gallery([
                ['src' => 'images/templatemo_image_01.jpg', 'alt' => 'Image 1'],
                ['src' => 'images/templatemo_image_02.jpg', 'alt' => 'Image 2'],
                ['src' => 'images/templatemo_image_03.jpg', 'alt' => 'Image 3'],
                ['src' => 'images/templatemo_image_03.jpg', 'alt' => 'Image 10'],
                ['src' => 'images/templatemo_image_01.jpg', 'alt' => 'Image 20'],
                ['src' => 'images/templatemo_image_02.jpg', 'alt' => 'Image 30']
            ]);
            $gallery->render();

            $content = new Content([
                ['float' => 'float_l', 'image' => 'images/templatemo_image_06.jpg', 'text' => 'Validate <a href="http://validator.w3.org/check?uri=referer" rel="nofollow">XHTML</a> &amp; <a href="http://jigsaw.w3.org/css-validator/check/referer" rel="nofollow">CSS</a>. Excepteur sint occaecat cupidatat non proi ent.'],
                ['float' => 'float_r', 'image' => 'images/templatemo_image_04.jpg', 'text' => 'Duis ac tellus et risus vulputate vehicnec lobortis risus a elit. Etiam tempor. Utllan corper ligula.'],
                ['float' => 'float_l', 'image' => 'images/templatemo_image_05.jpg', 'text' => 'Marst str sint occaecat cupidatat non prod ent, sunt in culpa qui officia deserunt mol satst gislets ste otedform.'],
                ['float' => 'float_r', 'image' => 'images/templatemo_image_07.jpg', 'text' => 'Fedarls moste risus vulputate vehiculnec lobortis risus a elit. Etiam tempor. sullan cooffieca deserunt moti.']
            ]);
            $content->render();
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
