<div class="container">
<section id="typography">
<div class="page-header">
<h1>Locations</h1>
</div>
<div class="row">
	<div class="span12">
		<?php 
		foreach($friend_infos as $friend) {
			echo $friend['name'].": ".$friend['location']['name']."<br />";
		}
		?>
	</div>
</div>
</section>
</div>