<?php

    require 'database.php';

    if (!empty($_GET['id']))
    {
        $id = checkInput($_GET['id']);
    }

    $db = Database::connect();
    $statement = $db->prepare("SELECT items.id, items.name, items.description, items.price, items.image, categories.name AS category
                                                       FROM items LEFT JOIN categories ON items.category = categories.id 
                                                       WHERE items.id = ?");
    // On va mettre en id celui de notre checkInput
    $statement->execute(array($id));
    $item = $statement->fetch();

    Database::disconnect();

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
    <div class="row">
        <div class="col-sm-6">
            <h1><strong>Voir un item </strong></h1>
            <br>
            <form>
                <div class="form-group">
                    <label>Nom:</label><?php echo ' ' . $item['name']; ?>
                </div>
                <div class="form-group">
                    <label>Description:</label><?php echo ' ' . $item['description']; ?>
                </div>
                <div class="form-group">
                    <label>Prix:</label><?php echo ' ' . number_format((float)$item['price'],2,'.','') . ' €'; ?>
                </div>
                <div class="form-group">
                    <label>Catégorie:</label><?php echo ' ' . $item['category']; ?>
                </div>
                <div class="form-group">
                    <label>Image:</label><?php echo ' ' . $item['image']; ?>
                </div>
            </form>
            <br>

            <div class="form-action">
                <a class="btn btn-primary" href="index.php"><i class="fas fa-long-arrow-alt-left"></i> Retour</a>
            </div>
        </div>

        <!--   IMAGE    -->

        <div class="col-sm-6 col-md-4 site">
            <div class="card">
                <img src="<?php echo '../assets/images/' . $item['image'];?>" alt="..." class="card-img-top">
                <div class="price"><?php echo number_format((float)$item['price'],2,'.',''); ?> €</div>
                <div class="figure-caption">
                    <h4><?php echo $item['name']; ?></h4>
                    <p><?php echo $item['description']; ?></p>
                    <a href="#" class="btn btn-order" role="button"><i class="fas fa-shopping-cart"></i> Commander </a>
                </div>
            </div>
        </div>




    </div>

</div>





</body>
</html>
