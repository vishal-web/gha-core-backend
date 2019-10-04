<div class="container">
	<div class="col-md-12" style="min-height: 70vh">
		<div class="page text-center" style="font-size: 40px; margin: 10% 0px;">
			<p style=" line-height: initial;">We are redirecting you to payment page ...</p>
			<form action="<?=$form_action?>" method="post">
				<?php
					foreach ($form_fields as $key => $value) {
						echo form_hidden($key, $value);
					}
				?>
			</form>
		</div>
	</div>
</div>

<script>
	document.forms[0].submit();
</script>