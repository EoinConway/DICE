<?php
/*
 * @author gerry.guinane
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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <!-- extra stylesheets below bootstrap css -->
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
       
        <title><?php echo $pageTitle; ?></title>

        <style>
            main i {
                color: red;
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


                        <div class="card-body text-center">
                            <h3 class="card-title pb-5"><?php echo $panelHead_2; ?></h3>
                            <p class="card-text"><?php echo $panelContent_2; ?></p>
                        </div>



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
                                        <form method="POST" action="<?php echo($_SERVER['PHP_SELF'] . '?pageID=yourEvents'); ?>" id="form-delete-user">
                                            ID <input readonly name="id">
                                        </form>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" form="form-delete-user" class="btn btn-danger" name="btnDelete">Delete</button>
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
                                        $text = 'This is a valid ticket for event no.';
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

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.24/sorting/datetime-moment.js"></script>

        <!-- extra scripts below -->
      
<script>

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    function confirmDelete(self) {
        var id = self.getAttribute("data-id");

        document.getElementById("form-delete-user").id.value = id;
        $("#myModal").modal("show");
    }
    
    function generateQR(self) {
        var id = self.getAttribute("data-id");

        document.getElementById("qrID").id.value = id;
        document.getElementById("qrID").innerHTML = id;
        $("#QRModal").modal("show");
    }
    
    
                        $(document).ready(function() {
                $.fn.dataTable.moment( 'MMM D, YY' );

                $('#eventsTable').DataTable();
            } );

</script>
</body>
</html>

