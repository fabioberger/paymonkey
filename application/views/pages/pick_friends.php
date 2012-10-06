<div class="container">
<section id="typography">
<div class="page-header">
<h1>Add Friends to your group!</h1>
</div>
<div class="row">
<div class="span9">

	<form name="friendpick" method="post" action="#">
	<ul class='cThumbList'>
	<?php 
	foreach($friends['data'] as $friend) {
		?>
		<li class='friend-box' id='friend<?=$friend['id']; ?>' onClick='if(this.getAttribute("class") == "friend-box") { select(<?=$friend['id']; ?>); } else { deselect(<?=$friend['id']; ?>); }'>
					<img alt='<?=$friend['name']; ?>' title='' src='http://graph.facebook.com/<?=$friend['id']; ?>/picture' class='avatar' width='45' height='45' />
					<span class='friend-name'><?=$friend['name']; ?></span>
					<input id='box<?=$friend['id']; ?>' name='box' type='checkbox' value='<?=$friend['id']; ?>,<?=$friend['name']; ?>' class='checker' />
					</li>
		<?php
	}
	?>
	</ul>
	</form>

	<form name="realform" method="post" action="/home/add_friends/">
		<input type="hidden" name="allfriends" value="" />
	</form>

</div>
<div class="span2">
	<div class="buttoner">
	<button class="btn btn-primary" onClick="submiter();">Continue</button>
	</div>
</div>
</div>
</section>
</div>