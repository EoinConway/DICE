<?php
/*
 * 
 * This view uses the following  PHP variables as content
 * 
 * First - get the content from the $data array:
 */
extract($data);
/*
 * Then use these values to fill in the 'blank' content of the view
 * 
 */
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap" rel="stylesheet">
        <script src="https://kit.fontawesome.com/11ee0e738c.js" crossorigin="anonymous"></script>
        <!-- extra stylesheets below bootstrap css -->
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <title><?php echo $pageTitle; ?></title>



    </head> 

    <body class="d-flex flex-column h-100">
        <main class="flex-shrink-0"> 
            <!--Main Navigation-->
            <nav class="navbar navbar-expand-lg navbar-dark" style="background-image: url(imgs/hero_img_pexels.jpg);">
                <div class="container">
                    <a class="navbar-brand" href="<?php echo($_SERVER['PHP_SELF'] . '?pageID=home'); ?>">DICE</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <?php //foreach($menuNav as $menuItem){echo "<li>$menuItem</li>";} //populate the navbar menu items?>
                            <?php echo $menuNav; ?>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="container-fluid">
                <div class="row">
                    <!--Left Vertical Menu-->
                    <nav id="sidebarMenu" class ="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                        <div class="position-sticky pt-3"></div>
                        <ul class ="nav flex-column">
                            <?php echo $sideNav; ?>

                        </ul>
                    </nav>
                    <!--Main Page Content-->
                    <main class="col-md-9 col-lg-10 ms-sm-auto px-md-4">
                        <!--display nav horizontally at small breakpoint-->
                        <nav class ="d-sm-block d-md-none bg-light">
                            <div class="position-sticky pt-3"></div>
                            <ul class ="nav">
                                <?php echo $sideNav; ?>
                            </ul>
                        </nav>
                        <div class="card-body text-center">
                            <h1 class="card-title"><?php echo $panelHead_1; ?></h1>
                            <p class="card-text"><?php echo $panelContent_1; ?></p>
                        </div>


                        <div class="card-body text-center">
                            <h1 class="card-title"><?php echo $panelHead_2; ?></h1>
                            <p class="card-text text-danger"><?php echo $panelContent_2; ?></p>
                            <p class="card-text"><?php include ('forms/form_createEvent.php'); ?></p>
                        </div>
                </div>

        </main>
    </div>


</div>
<!--end of main container-->

</main>


<!--Footer-->
<footer class="footer mt-auto py-3">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3">
                <p>© 2021 Copyright: Eoin Conway</p>
            </div>
            <div class="col-md-6" id="footer-brand">
                <a href="<?php echo($_SERVER['PHP_SELF'] . '?pageID=home'); ?>">DICE</a> 
            </div>
            <div class="col-md-3 mt-2">
                <a href="#"><i class="fab fa-facebook fa-2x px-2"></i></a>
                <a href="#"><i class="fab fa-twitter fa-2x px-2"></i></a>
                <a href="#"><i class="fab fa-instagram fa-2x px-2"></i></a>
            </div>
        </div>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
<!-- extra scripts below -->
</body>
</html>

