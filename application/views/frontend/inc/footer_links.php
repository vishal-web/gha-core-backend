<script src="<?=base_url()?>assets/frontend/js/jquery-1.12.4.min.js"></script>
<script src="<?=base_url()?>assets/frontend/js/bootstrap.min.js"></script>
<script src="<?=base_url()?>assets/frontend/js/equal-height.min.js"></script>
<script src="<?=base_url()?>assets/frontend/js/jquery.appear.js"></script>
<script src="<?=base_url()?>assets/frontend/js/jquery.easing.min.js"></script>
<script src="<?=base_url()?>assets/frontend/js/jquery.magnific-popup.min.js"></script>
<script src="<?=base_url()?>assets/frontend/js/modernizr.custom.13711.js"></script>
<script src="<?=base_url()?>assets/frontend/js/owl.carousel.min.js"></script>
<script src="<?=base_url()?>assets/frontend/js/wow.min.js"></script>
<script src="<?=base_url()?>assets/frontend/js/isotope.pkgd.min.js"></script>
<script src="<?=base_url()?>assets/frontend/js/imagesloaded.pkgd.min.js"></script>
<script src="<?=base_url()?>assets/frontend/js/count-to.js"></script>
<script src="<?=base_url()?>assets/frontend/js/bootsnav.js"></script>
<script src="<?=base_url()?>assets/frontend/js/main.js"></script>
<script src="<?=base_url()?>assets/frontend/js/custom.js"></script>

<?php
  if ($this->uri->segment('3') === 'start') {
?>
    <script src="<?=base_url()?>assets/frontend/js/fuelux.min.js"></script>
    <script src="<?=base_url()?>assets/frontend/js/exam.js"></script>
<?php
  }
?>