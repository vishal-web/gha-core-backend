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

<?php if (isset($block_ctr) && $block_ctr) { ?>
<script>
  function disableF5(e) {
    if (((e.which || e.keyCode) == 116) || (e.keyCode == 82 && e.ctrlKey)) {
      e.preventDefault();
    }
  }

  $(document).bind("keydown", disableF5);

  function Disable(event) {
    if (event.button == 2) {
      window.oncontextmenu = function () {
        return false;
      }
    }
  }

  document.onmousedown = Disable;
  $("#iframe").on("click", function (e) { event.stopPropagation(); return false; });


  /* document.oncontextmenu = function() { 
    return false; 
  };

  console.log(window.frames['iframe']['document']);
  window.frames["iframe"].document.oncontextmenu = function(){ return false; }; */
</script>
<?php } ?>