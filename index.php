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
    <link rel="stylesheet" href="assets/css/style.css">


    <title>Burger Code</title>
</head>
<body>

    <div class="container site">
        <h1 class="text-logo"><i class="fas fa-utensils"></i> Burger Code <i class="fas fa-utensils"></i></h1>

        <?php

            require 'admin/database.php';

            echo '<nav>
                    <ul class="nav nav-pills" id="pills-tab" role="tablist">';

            $db = Database::connect();
            $statement = $db->query('SELECT * FROM categories');
            $categories = $statement->fetchAll();

            foreach ($categories as $category)
            {
                if ($category['id'] == '1')

                    echo '<li class="nav-item">
                            <a class="nav-link active" id="pills-menus-tab" data-toggle="pill" href="#pills-' . $category['name'] . '" role="tab" aria-controls="pills-menus" aria-selected="true">' . $category['name'] . '</a>
                          </li>';
                else
                    echo '<li class="nav-item">
                            <a class="nav-link" id="pills-menus-tab" data-toggle="pill" href="#pills-' . $category['name'] . '" role="tab" aria-controls="pills-menus" aria-selected="false">' . $category['name'] . '</a>
                          </li>';
            }

            echo        '</ul>
                    </nav>';

            echo '<div class="tab-content">';


            foreach ($categories as $category)
            {
                if ($category['id'] == '1')

                    echo '<div class="tab-pane active" id="pills-' . $category['name'] . '">';
                else
                    echo '<div class="tab-pane" id="pills-' . $category['name'] . '">';

                echo '<div class="row">';

                $statement = $db->prepare('SELECT * FROM items WHERE items.category = ?');
                $statement->execute(array($category['id']));


                while ($item = $statement->fetch())
                {
                    echo '<div class="col-sm-6 col-md-4 ">
                    <div class="card">
                        <img src="assets/images/' . $item['image'] . '" alt="..." class="card-img-top">
                        <div class="price">' . number_format($item['price'],2, '.', '') . ' €</div>
                        <div class="figure-caption">
                            <h4>' . $item['name'] . '</h4>
                            <p>' . $item['description'] . '</p>
                            <a href="#" class="btn btn-order" role="button"><i class="fas fa-shopping-cart"></i> Commander </a>
                        </div>
                    </div>
                </div>';
                }

                echo    '</div>
                      </div>';
            }
            Database::disconnect();

            echo '</div>';

        ?>

    </div>





</body>
</html>