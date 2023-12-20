<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Panier d'achat</title>
    <link rel="stylesheet" type="text/css" href="css/robeafricaine.css">

</head>

<body>

    <form method="post">
        <?php
        include './includes/fonction.php';
        if (isset($_POST['del'])) {
            delPanier();
            $_POST['del'] = NULL;
        }

        include './public/header.php';
        include './includes/data.inc.php';

        $imageContainer = '';
        if (count($_SESSION['panier']) <= 1) {
            echo '<p>le panier est vide </p>';
        } else {
            $_SESSION['total'] = 0;
            $num = 1;

            for ($i = 0; $i < count($_SESSION['panier']); $i++) {
                $total = array_count_values($_SESSION['panier']);
                foreach ($image as $img) {

                    if ($img['id'] == $_SESSION['panier'][$i]) {
                        if (str_contains($imageContainer, 'id=' . $img['id'] . '" cl')) {
                            $_SESSION['total'] += (int)$img['prix'];
                        } else {
                            $_SESSION['total'] += (int)$img['prix'];
                            $total = $total[$img['id']];
                            $imageContainer .= '
                            <div class="cardpanier">
                            <div class="num">' . $num . '</div>
                            <img class="cardpanierimg" src="' . $img['image'] . '" alt="Card image cap">
                            <h5 class="card-title">' . $img['titre'] . '</h5>
                            <p class="card-text">' . $img['description'] . '</p>
                            <button type="button" name="ajouter" id="ajouter' . $img['id'] . '" class="btn btn-warning" value="' . $img['id'] . '">' . $img['prix'] . '</button>             
                            <a href="detailimage.php?id=' . $img['id'] . '" class="btn btn-info" id="Details">Details</a>
                            <button type="submit" class="btn btn-danger del" name="del" id="del" value="' . $img['id']  . '">X</button><div class="total">X ' . $total . '</div>
                        </div>
                    </div>';
                            $num++;
                        }
                    }
                }
            }
            echo '<div class="totalprice">
                        <h1>Total Price</h1>
                        <div class="totalpriceGrid">
                            <p>Price : </p>
                            <p>' . $_SESSION['total'] . '$</p>
                            <p>_____________</p>
                            <p>_____________</p>
                            <p>TPS :</p>
                            <p>+ 5%</p>
                            <p>TVQ :</p>
                            <p>+ 9.975%</p>
                            <p>_____________</p>
                            <p>_____________</p>
                            <p>Total :</p>
                            <p>' . round($_SESSION['total'] * 1.14975, 2) . '$</p>
                        </div>
                        <div class="monbutton">
                        <div id="paypal-payment-button"></div>
                        
                        <script src="https://www.paypal.com/sdk/js?client-id=AXjaUSY_rhWv6N5Z8qivSB7NlL88-zKNLwZ-QZohgc59hkkAxW77z5iVsskXWS_hKR08VEW9Qcqw5vWO"></script>
                        <script src="./public/paypal.js"></script>
                        </div>
                        
                    </div>
                    
                    <div class="image-container-panier">' . $imageContainer . '</div>';
        }


        ?>
    </form>

</body>

</html>