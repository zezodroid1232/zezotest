//هذا الكود يستخدم لإنشاء ملف مضغوط بإسم ///example.zip// بمحتويات مشابهة لمحتوى الصفحة الموجودة في الرابط http://www.example.com/. يقوم الكود بتحميل كل السكربتات والأنماط الم//وجودة في الصفحة المحددة// واضافتها إلى الملف المضغوط، ويتم تحميل الصفحة نفسها أيضاً واضافتها إلى الملف المضغوط// بإسم index.html. يقوم الكود بإخراج رابط التحميل للملف المضغوط في نهاية العملية.

<?php
$url = $_GET["url_zezo"];
$zip_name = $_GET["filename"];

// Download the page
$html = file_get_contents($url);

// Create a new dom object
$dom = new DOMDocument();

// Load the html into the object
@$dom->loadHTML($html);

// Create a new zip object
$zip = new ZipArchive();

// Open the zip file for writing
if ($zip->open($zip_name, ZIPARCHIVE::CREATE )!==TRUE) {
    exit("cannot open <$zip_name>\n");
}

// Iterate through all the scripts
$scripts = $dom->getElementsByTagName('script');
foreach($scripts as $script) {
    // Get the script source
    $script_src = $script->getAttribute('src');
    
    // Download the script
    $script_content = file_get_contents($url.$script_src);
    
    // Add the script to the zip
    $zip->addFromString($script_src, $script_content);
}

// Iterate through all the stylesheets
$stylesheets = $dom->getElementsByTagName('link');
foreach($stylesheets as $stylesheet) {
    // Get the stylesheet source
    $stylesheet_src = $stylesheet->getAttribute('href');
    
    // Download the stylesheet
    $stylesheet_content = file_get_contents($url.$stylesheet_src);
    
    // Add the stylesheet to the zip
    $zip->addFromString($stylesheet_src, $stylesheet_content);
}

// Add the html to the zip
$zip->addFromString("index.html", $html);

// Close the zip
$zip->close();

// Output the download link
echo "<a href='$zip_name'>Download</a>";
?>