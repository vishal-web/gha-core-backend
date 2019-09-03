<!DOCTYPE html>
<html lang="en">


<head>
    <!-- ========== Meta Tags ========== -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?=$this->head_title?>">

    <!-- ========== Page Title ========== -->
    <title><?=$this->head_title?></title>
    <?php $this->load->view('frontend/inc/header_links'); ?>
</head>

<body>

    <!-- Header -->
    <?php  $this->load->view('frontend/inc/header'); ?>
    <!-- Header -->
    
    <?php 
        if (isset($view_file) && $view_file !== '') {
            $this->load->view($view_file);
        } else {
            echo "<div class='container' style='padding:50px'>";
            echo "Please send me the view files";
            echo "</div>";
        }
    ?>

    <!-- Start Footer 
    ============================================= -->
    <?php $this->load->view('frontend/inc/footer'); ?>
    <!-- End Footer -->

    <!-- jQuery Frameworks
    ============================================= -->
    <?php $this->load->view('frontend/inc/footer_links'); ?>
    
    <script>

        var BASE_URL = '<?=base_url()?>';

        $("#slider").carousel({
            autoPlay:5,
            //autoPlay: true, <-- if you want to set default slide time (5000)

            slideSpeed: 300,
            paginationSpeed: 500,
            singleItem: true,
            navigation: true,
            scrollPerPage: true
        });
    </script>
</body>

</html>