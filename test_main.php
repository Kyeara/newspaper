<?php
require_once 'writer/classloader.php';

echo "<h2>Main Page Image Test</h2>";

$articles = $articleObj->getActiveArticles();
echo "<h3>Articles from database:</h3>";

foreach ($articles as $article) {
    echo "<div style='border: 1px solid #ccc; padding: 10px; margin: 10px 0;'>";
    echo "<h4>" . $article['title'] . "</h4>";
    echo "<p><strong>Author:</strong> " . $article['username'] . "</p>";
    echo "<p><strong>Image path in DB:</strong> " . ($article['image_path'] ?: 'NO IMAGE') . "</p>";
    
    if (!empty($article['image_path'])) {
        echo "<p><strong>Full URL:</strong> <a href='" . $article['image_path'] . "' target='_blank'>" . $article['image_path'] . "</a></p>";
        echo "<p><strong>File exists:</strong> " . (file_exists($article['image_path']) ? 'YES' : 'NO') . "</p>";
        echo "<p><strong>Image display test:</strong></p>";
        echo "<img src='" . $article['image_path'] . "' style='max-width: 200px; border: 1px solid red;' onerror='this.style.border=\'3px solid red\'; this.alt=\'IMAGE FAILED TO LOAD\';'>";
    }
    echo "</div>";
}
?>
