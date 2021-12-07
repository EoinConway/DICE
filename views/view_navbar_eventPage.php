<?php
/*
 * This view uses the following  PHP variables as content
 * 
 * First - get the content from the $data array which is provided by the controller:
 */
extract($data);
/*
 * Then use these values to fill in the 'blank' content of the view
 * 
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
            #detailsCard {
                background: rgb(255,255,255);
                background: linear-gradient(39deg, rgba(255,255,255,1) 25%, rgba(217,48,79,1) 75%);
            }

            #button, #feeRow {
                float: right;
            }

            #disqus_thread{
                padding-top: 5em;
            }

            .iframeContainer {
                display: flex;
                align-items: center;
                justify-content: center;
                padding-top: 4em;
            }
            
            li a {
                text-decoration: none;
                color: black;
            }
        </style>

    </head> 

    <body class="d-flex flex-column h-100">
        <script src="https://www.paypal.com/sdk/js?client-id=AWAkbtHxqxbXjwBZjxuZyLL1XODramhWz06sxdbnZMDQ9GTv26GZn1DuUZL4XlvNLp-vKjNqoim62NPG&currency=EUR"></script>
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
            <!--Main container for page content-->  
            <div class="container container-main">

                <div class="text-center" style="font-family: 'Permanent Marker', cursive;"><?php echo $panelHead_1; ?></div>

                <div class="row">

                    <!--                    left column-->
                    <div class="col-md-8">
                        <div class="iframeContainer">
                            <iframe
                                width="450"
                                height="250"
                                frameborder="0" style="border:0; margin-left: auto; margin-right:auto;"
                                src="https://www.google.com/maps/embed/v1/place?key=AIzaSyAhHiQ8y_oRGYGt0q6D11MRlxjgYA1r6MA&q=<?php echo $panelHead_3; ?>" allowfullscreen>
                            </iframe>
                        </div>
                    </div>


                    <!--                        right column-->
                    <div class="col-md-4">

                        <!--button-->
                        <div class="dropdown" id="button">

                            <form method="POST" action="<?php echo($_SERVER['PHP_SELF'] . '?pageID=event&eventID=' . $_GET['eventID']); ?>">
                                <?php echo $panelContent_1; ?>
                            </form>
                        </div>
                        <!--details-->
                        <div class="card border-dark mb-3 mt-5" id='detailsCard'>
                            <div class="card-header text-center" style="font-family: 'Permanent Marker', cursive; font-size: 1.5em;">Event Details</div>
                            <div class="card-body text-dark">
                                <?php echo $panelContent_2; ?><!--event details table-->
                            </div>
                        </div>
                        <?php echo $panelContent_3; ?>
                    </div>

                </div>

                <div id="disqus_thread"></div>
                <script>
<?php
// get the right protocol
$protocol = !empty($_SERVER['HTTPS']) ? 'https' : 'http';

// simply render canonical base on the current http host ( multiple host ) + requests
echo $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
?>

                    var disqus_config = function () {
                        this.page.url = <?php echo $protocol; ?>; // Replace PAGE_URL with your page's canonical URL variable
                        this.page.identifier = <?php echo $_GET['eventID']; ?>; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
                    };

                    (function () { // DON'T EDIT BELOW THIS LINE
                        var d = document, s = d.createElement('script');
                        s.src = 'https://dice-events.disqus.com/embed.js';
                        s.setAttribute('data-timestamp', +new Date());
                        (d.head || d.body).appendChild(s);
                    })();
                </script>
                <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>


                <!--DELETE MODAL-->
                <div id="myModal" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h4 class="modal-title">Delete Event</h4>
                                <button type="button" class="close" data-bs-dismiss="modal">×</button>
                            </div>

                            <div class="modal-body">
                                <p>Are you sure you want to delete this event ? </p>
                                <form method="POST" action="<?php echo($_SERVER['PHP_SELF'] . '?pageID=yourEvents'); ?>" id="form-delete-event">
<!--                                    ID <input readonly name="id">-->
                                    ID <input readonly name="id" value="<?php echo $_GET['eventID']; ?>">
                                </form>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                                <button type="submit" form="form-delete-event" class="btn btn-danger" name="btnDelete">Delete</button>
                            </div>

                        </div>
                    </div>
                </div>

                <!--QR CODE MODAL-->
                        <div id="QRModal" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h4 class="modal-title">QR CODE</h4>
                                        <button type="button" class="close" data-bs-dismiss="modal">×</button>
                                    </div>

                                    <div class="modal-body">
                                        <p>Show the QR Code below on arrival at the event</p>
                                        
                                        <?php 
                                        require_once 'phpqrcode/qrlib.php';
                                        
                                        $path = 'imgs/qrcodes/';
                                        $file = $path.uniqid().".png";
                                        $text = 'This is a valid ticket for event no. ' . $_GET['eventID'] . ' held by ' . $_SESSION['userFirstName'] . ' ' . $_SESSION['userLastName'];
                                        QRCode::png($text, $file);
                                        echo '<center><img src="'.$file.'"@ style="width: 40%;"></center>';
                                        ?>
                                        
                                        <div id="qrID"></div>
                                        
<!--                                        <form method="POST" action="<?php echo($_SERVER['PHP_SELF'] . '?pageID=yourEvents'); ?>" id="qrID">
                                            <input readonly name="id">
                                        </form>-->
                                    </div>

                                </div>
                            </div>
                        </div>
                
                
            </div>  <!--end of main container-->
        </main>
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
                    var amount = '<?php echo $panelHead_2; ?>';
                    var userID = '<?php echo $_SESSION['userID']; ?>';
                    var eventID = '<?php echo $_GET['eventID']; ?>';

                    paypal.Buttons({
                        createOrder: function (data, actions) {
                            return actions.order.create({
                                purchase_units: [{
                                        amount: {
                                            value: amount
                                        }
                                    }]
                            });
                        },
                        onApprove: function (data, actions) {
                            return actions.order.capture().then(function (details) {
                                alert('Transaction completed by ' + details.payer.name.given_name);
<?php
//add db connection and call method to add attendee
?>
                            });

                        }
                    }).render('#paypal-button-container'); // Display payment options on your web page
        </script>
    </body>
</html>

