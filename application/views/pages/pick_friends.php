<div class="container">
<section id="typography">
<div class="page-header">
<h1>Add Friends to your group!</h1>
</div>
<div class="row">
<div class="span4">
	Put friend selector here!

	<ul>
	<?php 
	foreach($friends['data'] as $friend) {
		?><li><?=$friend['name']; ?></li><?php
	}
	?>
	</ul>

	<?php print_r($friends); ?>



</div>
</div>
</section>
</div>