<div class="container">
<section id="typography">
<div class="page-header">
<h1>Add Friends to your group!</h1>
</div>
<div class="row">
<div class="span9">

	<ul class='cThumbList'>
	<?php 
	foreach($friends['data'] as $friend) {
		?>
		<li class='friend-box' id='friend<?=$friend['id']; ?>' onClick='if(this.getAttribute("class") == "friend-box") { deselect(<?=$friend['id']; ?>); } else { select(<?=$friend['id']; ?>); }'>
					<img alt='<?=$friend['name']; ?>' title='' src='http://graph.facebook.com/<?=$friend['id']; ?>/picture' class='avatar' width='45' height='45' />
					<span class='friend-name'><?=$friend['name']; ?></span>
					<input id='box<?=$friend['id']; ?>' name='box' type='checkbox' value='<?=$friend['id']; ?>' class='checker' />
					</li>
		<?php
	}
	?>
	</ul>

</div>
<div class="span2">
	<div class="buttoner">
	<button class="btn btn-primary">Continue</button>
	</div>
</div>
</div>
</section>
</div>