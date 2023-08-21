<?php
$articles = json_decode(file_get_contents(__DIR__ . '/articles.json'), true);
var_dump($articles);
define('DB_SERVER', '127.0.0.1');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'Dwwm_2023');
define('DB_NAME', 'blog');

try {
    $pdo = new PDO("mysql:host=". DB_SERVER . ":3308;dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD); 

    // // check connection status
    // echo $pdo->getAttribute(PDO::ATTR_CONNECTION_STATUS);
} catch(Exception $e) {
    echo $e->getMessage();
    die("ERREUR : Impossible de se connecter. ");
}



$statement = $pdo->prepare('
  INSERT INTO article (
    title,
    category,
    content,
    image
  ) VALUES (
    :title,
    :category,
    :content,
    :image
)');

foreach ($articles as $article) {
  $statement->bindValue(':title', $article['title']);
  $statement->bindValue(':category', $article['category']);
  $statement->bindValue(':content', $article['content']);
  $statement->bindValue(':image', $article['image']);
  $statement->execute();
}