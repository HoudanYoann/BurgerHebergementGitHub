<?php

require 'database.php';

if (!empty($_GET['id']))
{
    $id = checkInput($_GET['id']);
}

if (!empty($_POST))
{
    $id = checkInput($_POST['id']);
    $db = Database::connect();
    $statement = $db->prepare("DELETE FROM items WHERE id= ?");
    $statement->execute(array($id));

    Database::disconnect();

    header("Location: index.php");
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
    <h1><strong>Supprimer un item </strong></h1>
    <br>
    <!--   QUAND JE VEUX UPLOAD UNE IMAGE J'utilise : enctype="multipart/form-data  -->
    <form class="form" role="form" action="delete.php" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <p class="alert alert-warning">Êtes-vous sûr de vouloir supprimer ?</p>
        <div class="form-actions">
            <button type="submit" class="btn btn-danger">Oui</button>
            <a class="btn btn-info" href="index.php">Non</a>
        </div>
    </form>
</div>





</body>
</html>
