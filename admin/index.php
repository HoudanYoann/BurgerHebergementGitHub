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
            <h1><strong>Liste des items </strong></h1><a href="insert.php" class="btn btn-success btn-lg"><i class="fas fa-plus"></i> Ajouter</a>

            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Prix</th>
                        <th>Catégorie</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require 'database.php';

                    $db = Database::connect();
                    $statement = $db->query("SELECT items.id, items.name, items.description, items.price, categories.name AS category
                                                       FROM items LEFT JOIN categories ON items.category = categories.id
                                                       ORDER BY items.id DESC");

                    while ($item = $statement->fetch())
                    {
                        echo '<tr>';
                        echo '<td>' . $item["name"] . '</td>';
                        echo '<td>' . $item["description"] . '</td>';
                        echo '<td>' . number_format((float)$item["price"],2,'.','') . '</td>'; // Pour montrer les floats avec par exemple 4.90 au lieu de 4.9
                        echo '<td>' . $item["category"] . '</td>';
                        echo '<td width="340px">';
                            echo '<a class="btn btn-light" href="view.php?id=' . $item['id'] . '"><i class="fas fa-eye"></i> Voir</a>';
                            echo ' ';
                            echo '<a class="btn btn-primary" href="update.php?id=' . $item['id'] . '"><i class="fas fa-pen"></i> Modifier</a>';
                            echo ' ';
                            echo '<a class="btn btn-danger" href="delete.php?id=' . $item['id'] . '"><i class="fas fa-times"></i> Supprimer</a>';
                        echo '</td>';
                    echo '</tr>';
                    }

                    Database::disconnect();

                    ?>

                </tbody>


            </table>


        </div>

    </div>





</body>
</html>