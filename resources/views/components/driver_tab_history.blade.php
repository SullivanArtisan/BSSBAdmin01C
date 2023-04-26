	<div class="row">
		<div class="col">
			<?php
				if(isset($dbTable)) {
					echo "<textarea readonly class=\"form-control mt-1\" rows=\"500\" id=\"dvr_history\" name=\"dvr_history\" placeholder=\"".$dbTable->dvr_history."\"></textarea>";
				} else {
					echo "<textarea readonly class=\"form-control mt-1\" rows=\"500\" id=\"dvr_history\" name=\"dvr_history\"></textarea>";
				}
			?>
		</div>
	</div>
