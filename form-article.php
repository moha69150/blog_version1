<?php
$articleDB= require_once __DIR__  . '/database/Articledb.php';
const ERROR_REQUIRED = 'Veuillez renseigner ce champ';
const ERROR_TITLE_TOO_SHORT = 'Le titre est trop court';
const ERROR_CONTENT_TOO_SHORT = 'L\'article est trop court';
const ERROR_IMAGE_URL = 'L\'image doit être une URL valide';
$filename = __DIR__ . '/data/articles.json';

$errors = [
  'title' => '',
  'image' => '',
  'category' => '',
  'content' => '',
];

$category= '';



$_GET= filter_input_array(INPUT_GET,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$id = $_GET['id'] ?? '';
if($id){
  $article = $articleDB->fetchOne($id);
  $title = $article['title'];
  $image = $article['image'];
  $category = $article['category'];
  $content = $article['content'];
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $_POST = filter_input_array(INPUT_POST, [
    'title' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    'image' => FILTER_SANITIZE_URL,
    'category' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    'content' => [
      'filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
      'flags' => FILTER_FLAG_NO_ENCODE_QUOTES
    ]
  ]);

  $title = $_POST['title'];
  $image = $_POST['image'];
  $category = $_POST['category'];
  $content = $_POST['content'];

  if (!$title) {
    $errors['title'] = ERROR_REQUIRED;
  } elseif (mb_strlen($title) < 5) {
    $errors['title'] = ERROR_TITLE_TOO_SHORT;
  }

  if (!$image) {
    $errors['image'] = ERROR_REQUIRED;
  } elseif (!filter_var($image, FILTER_VALIDATE_URL)) {
    $errors['image'] = ERROR_IMAGE_URL;
  }

  if (!$category) {
    $errors['category'] = ERROR_REQUIRED;
  }

  if (!$content) {
    $errors['content'] = ERROR_REQUIRED;
  } elseif (mb_strlen($content) < 50) {
    $errors['content'] = ERROR_CONTENT_TOO_SHORT;
  }

  if (empty(array_filter($errors, fn ($e) => $e !== ''))) {
    if ($id) {
      $article['title'] = $title;
      $article['image'] = $image;
      $article['category'] = $category;
      $article['content'] = $content;
      $articleDB->UpdateOne($article);
    } else {
      $articleDB->createOne([
        'title'=> $title,
        'content'=> $content,
        'category'=> $category,
        'image'=> $image
      ]);
    }
    header('Location: /dyma/Php/blog_version1/');
  
  }
}

?>

<!DOCTYPE html>
<html lang="fr">
    <head>
    <link rel="stylesheet" href="public/form-article.css">
        <?php require_once 'includes/head.php' ?>
        

       
    </head>

    <body>
        <div class="container">
            <?php require_once 'includes/header.php' ?>
            <div class="content">
                <div class="block p-20 form-container">
                    <h1><?= $id ? 'Modifier' : 'Rédiger' ?> ma fiche d'acivité</h1>
                    <form action="form-article.php<?= $id ? "?id=$id" : '' ?>" , method="post">
                        <div class="form-control">
                            <label for="title">Titre</label>
                            <input type="text" name="title" id="title" value="<?= $title ?? '' ?>">
                            <?php if ($errors['title']) : ?>
                                <p class="text-danger"><?= $errors['title'] ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="form-control">
                            <label for="image">Image</label>
                            <input type="text" name="image" id="image" value="<?= $image ?? '' ?>">
                            <?php if ($errors['image']) : ?>
                                <p class="text-danger"><?= $errors['image'] ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="form-control">
                            <label for="category">Catégorie</label>
                            <select name="category" id="category">
                                <option <?= !$category || $category === 'technologie' ? 'selected' : '' ?> value="technologie">Technologie</option>
                                <option <?= !$category || $category === 'nature' ? 'selected' : '' ?> value="nature">Nature</option>
                                <option <?= !$category || $category === 'politique' ? 'selected' : '' ?> value="politique">Politique</option>
                            </select>
                            <?php if ($errors['category']) : ?>
                                <p class="text-danger"><?= $errors['category'] ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="form-control">
                            <label for="content">Contenu</label>
                            <textarea name="content" id="content" ><?= $content ?? '' ?></textarea>
                            <?php if ($errors['content']) : ?>
                                <p class="text-danger"><?= $errors['content'] ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="form-actions">
                            <a href="/dyma/Php/blog_version1/"><button class="btn btn-secondary" type="button">Annuler</button></a>
                            <button class="btn btn-primary" type="submit"><?= $id ?'Modifier' : 'Sauvegarder' ?></button>
                        </div>
                    </form>
                </div>
            </div>
            <?php require_once 'includes/footer.php' ?>
        </div>

    </body>
</html>