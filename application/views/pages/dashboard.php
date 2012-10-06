<div class="container">
<section id="typography">
<div class="page-header">
<h1>Your Dashboard</h1>
</div>
<div class="row">
<div class="span9">

<?php print_r($friends); ?>

<?php 
	foreach($friends as $friend_id => $friend_name) {
	?><div class="member"><img src="http://graph.facebook.com/<?=$friend_id; ?>/picture" /></div><?php
	}
?>

</div>
</div>
</section>
</div>