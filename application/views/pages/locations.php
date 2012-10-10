<div class="container">
<section id="typography">
<div class="page-header">
<h1>Locations</h1>
</div>
<div class="row">
	<div class="span12">
		<?php 
		/*
		foreach($friend_infos as $friend) {
			if(array_key_exists('location', $friend)) {
			echo $friend['name'].": ".$friend['location']['name']."<br />";
			}
		}
		*/
		?>
	</div>

	<?php echo $headerjs; ?>
	<?php echo $headermap; ?>

	<?php echo $onload; ?>
	<?php echo $map; ?>
	<?php echo $sidebar; ?>
</div>
</section>
</div>