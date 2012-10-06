<div class="container">
<section id="typography">
<div class="page-header">
<h1>Add Friends to your group!</h1>
</div>
<div class="row">
<div class="span4">
	Put friend selector here!

	<ul class='cThumbList'>
	<?php 
	foreach($friends['data'] as $friend) {
		?>
		<li class='friend-box' id='friend$friendid' onClick='if(this.getAttribute(\"class\") == \"friend-box\") { deselect($friendid); } else { select($friendid); }'>
					<img alt='<?=$friend['name']; ?>' title='' src='http://graph.facebook.com/<?=$friend['id']; ?>/picture' class='avatar' width='45' height='45' />
					<span class='friend-name'><?=$friend['name']; ?></span>
					<input id='box$friendid' name='box' type='checkbox' value='$friendid' checked='false' class='checker' />
					</li>
		<?php
	}
	?>
	</ul>

	

	<?php print_r($friends); ?>



</div>
</div>
</section>
</div>