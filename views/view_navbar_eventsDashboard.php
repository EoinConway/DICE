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

        <style>
            img {
                width: 100%;
                
            }

            #carouselIndicators {
                width: 100%;
            }
            
            #carouselIndicators a {
                text-decoration: none;
                color: white;
                opacity: 75%;
            }
            
            #carouselIndicators a:hover {
                opacity: 100%;
            }
            
            .carousel-caption {
                text-shadow: 0px 0px 20px rgba(0, 0, 0, 1);
            }
        </style>

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

                        <div class="row mt-5">
                            <div class="col-6">
                                <div id="carouselIndicators" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-indicators">
                                        <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                        <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                        <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                    </div>
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img src="imgs/yoga_carousel_img_pexels.jpg" class="d-block" alt="...">
                                            <div class="carousel-caption d-none d-md-block">
                                                <p class="fs-1">Mindfulness</p>
                                                <p class="fs-3"><a href="https://news.columbia.edu/news/can-meditation-and-yoga-help-reduce-anxiety-related-covid-19">Can Meditation and Yoga Help Reduce Anxiety Related to COVID-19?</a></p>
                                            </div>
                                        </div>
                                        <div class="carousel-item">
                                            <img src="imgs/volleyball_carousel_img_pexels.jpg" class="d-block" alt="...">
                                            <div class="carousel-caption d-none d-md-block">
                                                <p class="fs-1">Sports Decoder</p>
                                                <p class="fs-3"><a href="https://www.eurosport.co.uk/volleyball/sport-decoder-all-you-need-to-know-about-volleyball_vid1322704/video.shtml">All you need to know about volleyball.</a></p>
                                            </div>
                                        </div>
                                        <div class="carousel-item">
                                            <img src="imgs/soccer_carousel_img_pexels.jpg" class="d-block" alt="...">
                                            <div class="carousel-caption d-none d-md-block">
                                                <p class="fs-1">Soccer Today</p>
                                                <p class="fs-3"><a href="https://www.soccertoday.com/coronavirus-covid-19-impact-on-soccer/">COVID-19 impact on soccer.</a></p>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselIndicators" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carouselIndicators" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="card-body">
                                    <h1 class="card-title"><?php echo $panelHead_3; ?></h1>
                                    <p class="card-text"><?php echo $panelContent_3; ?></p>
                                </div>
                            </div>
                        </div>

                    </main>
                </div>


            </div>
            <!--end of main container-->

            <!--Archive MODAL-->
            <div id="myModal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h4 class="modal-title">Archive Event</h4>
                            <button type="button" class="close" data-bs-dismiss="modal">×</button>
                        </div>

                        <div class="modal-body">
                            <p>Are you sure you want to archive this event ? </p>
                            <form method="POST" action="<?php echo($_SERVER['PHP_SELF'] . '?pageID=events'); ?>" id="form-delete-user">
                                ID <input readonly name="id">
                            </form>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                            <button type="submit" form="form-delete-user" class="btn btn-danger" name="btnArchive">Archive</button>
                        </div>

                    </div>
                </div>
            </div>

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
        <script>
            function confirmArchive(self) {
                var id = self.getAttribute("data-id");

                document.getElementById("form-delete-user").id.value = id;
                $("#myModal").modal("show");
            }
        </script>
    </body>
</html>

