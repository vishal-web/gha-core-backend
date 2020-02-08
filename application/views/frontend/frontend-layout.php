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
    <style>
        .social.mini {
            margin-top: 0px;
            padding-top: 0px;
            border-top: none !important;
        }
    </style>
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
            echo "This page is under development";
            echo "</div>";
        }
    ?>

    <!-- Start Footer 
    ============================================= -->
    <?php $this->load->view('frontend/inc/footer'); ?>
    <!-- End Footer -->
    <script>
        var BASE_URL = '<?=base_url()?>';
        window.page_type = 'Frontedn';
    </script>
    <!-- jQuery Frameworks
    ============================================= -->
    <?php $this->load->view('frontend/inc/footer_links'); ?>
    <?php if ($this->uri->segment(1) == ''){ ?>
    <script> 
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
    <?php } ?>
</body>

</html>