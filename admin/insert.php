<?php

    require 'database.php';

    $nameError = $descriptionError = $priceError = $categoryError = $imageError = $name = $description = $price = $category = $image = "";

    if (!empty($_POST))
    {
        $name            = checkInput($_POST['name']);
        $description     = checkInput($_POST['description']);
        $price           = checkInput($_POST['price']);
        $category        = checkInput($_POST['category']);
        $image           = checkInput($_FILES['image']['name']);
        $imagePath       = '../assets/images/' . basename($image); // basename() = Nom de base de l'image
        $imageExtension  = pathinfo($imagePath, PATHINFO_EXTENSION);
        $isSuccess       = true;
        $isUploadSuccess = false;


        if (empty($name))
        {
            $nameError = "Ce champ ne peut pas être vide.";
            $isSuccess = false;
        }

        if (empty($description))
        {
            $descriptionError = "Ce champ ne peut pas être vide.";
            $isSuccess = false;
        }

        if (empty($price))
        {
            $priceError = "Ce champ ne peut pas être vide.";
            $isSuccess = false;
        }

        if (empty($category))
        {
            $categoryError = "Ce champ ne peut pas être vide.";
            $isSuccess = false;
        }

        if (empty($image))
        {
            $imageError = "Ce champ ne peut pas être vide.";
            $isSuccess = false;
        }
        else
        {
            $isUploadSuccess = true;
            if ($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif") // Vérification des extensions de fichiers
            {
                $imageError = "Les fichiers autorisés sont: .jpg, .jpeg, .png, .gif";
                $isUploadSuccess = false;
            }
            if (file_exists($imagePath)) // Vérification si le fichier existe déjà
            {
                $imageError = "Le fichier existe déjà";
                $isUploadSuccess = false;
            }
            if ($_FILES['image']['size'] > 500000) // Vérification du poid de l'image
            {
                $imageError = "Le fichier ne doit pas dépasser les 500KB";
                $isUploadSuccess = false;
            }
            if ($isUploadSuccess)
            {
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $imagePath))
                {
                    $imageError = "Il y a eu une erreur lors de l'upload";
                    $isUploadSuccess = false;
                }
            }
        }

        if ($isSuccess && $isUploadSuccess)
        {
            $db = Database::connect();
            $statement = $db->prepare("INSERT INTO items (name, description, price, category, image) VALUES (?,?,?,?,?)");
            $statement->execute(array($name,$description,$price,$category,$image));

            Database::disconnect();
            header("Location: index.php");
        }

    }

    function checkInput($data)
    {
        $data = trim($data);
        $data = stripcslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

?>

<!doctype html>
<html lang="FR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Holtwood+One+SC" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">


    <title>Burger Code</title>
</head>
<body>

<h1 class="text-logo"><i class="fas fa-utensils"></i> Burger Code <i class="fas fa-utensils"></i></h1>
<div class="container admin">
            <h1><strong>Voir un item </strong></h1>
            <br>
                <!--   QUAND JE VEUX UPLOAD UNE IMAGE J'utilise : enctype="multipart/form-data  -->
            <form class="form" role="form" action="insert.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Nom:</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Nom" value="<?php echo $name; ?>">
                    <span class="help-inline"><?php echo $nameError; ?></span>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <input type="text" class="form-control" id="description" name="description" placeholder="Description" value="<?php echo $description; ?>">
                    <span class="help-inline"><?php echo $descriptionError; ?></span>
                </div>
                <div class="form-group">
                    <label for="price">Prix:</label>
                    <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="Prix" value="<?php echo $price; ?>">
                    <span class="help-inline"><?php echo $priceError; ?></span>
                </div>
                <div class="form-group">
                    <label for="category">Catégorie:</label>
                    <select class="form-control" id="category" name="category">
                        <?php
                            $db = Database::connect();
                            foreach ($db->query('SELECT * FROM categories') as $row)
                            {
                                echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                            }
                            echo '<span class="help-inline">$categoryError</span>';

                            Database::disconnect();

                        ?>
                    </select>
                    <span class="help-inline"><?php echo $descriptionError; ?></span>
                </div>
                <div class="form-group">
                    <label for="image">Sélectionner une image:</label>
                    <input type="file" id="description" name="image">
                    <span class="help-inline"><?php echo $imageError; ?></span>
                </div>
                <br>

            <div class="form-actions">
                <button type="submit" class="btn btn-success"><i class="fas fa-plus"></i> Ajouter</button>
                <a class="btn btn-primary" href="index.php"><i class="fas fa-long-arrow-alt-left"></i> Retour</a>
            </div>
            </form>
</div>





</body>
</html>
