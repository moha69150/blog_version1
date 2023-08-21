<?php
$articleDB= require_once __DIR__ . '/database/Articledb.php';
$statement=$pdo->prepare('SELECT * FROM article WHERE id=:id');
$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$id = $_GET['id'] ?? '';

    if(!$id) {
        header('Location:/dyma/Php/blog_version1/');
    } else {
        
        $article = $articleDB->fetchOne($id);
    }

    
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
    <link rel="stylesheet" href="public/show-article.css">
        <?php require_once 'includes/head.php' ?>
        

       
    </head>

    <body>
        <div class="container">
            <?php require_once 'includes/header.php' ?>
            <div class="content">
                <a class="article-back" href="/dyma/Php/blog_version1/">Retour à la liste des articles</a>
                <div class="article-container">
                <div class="article-cover-img" style="background-image:url(<?= $article['image'] ?>)"></div>
                <h1 class="article-title" ><?= $article['title'] ?></h1>
                <div class="separator">
                    <p class="article-content"><?= $article['content'] ?></p>
                    <div class="action">
                        <a class="btn btn-secondary" href="/dyma/Php/blog_version1/delete-article.php?id=<?= $article['id'] ?>">Supprimer</a>
                        <a class="btn btn-primary" href="/dyma/Php/blog_version1/form-article.php?id=<?= $article['id'] ?>" >Editer l'article</a>
                    </div>
                </div>
            </div>
                </div>
                
            <?php require_once 'includes/footer.php' ?>
        </div>

    </body>
</html>