<div class="container">
<section id="typography">
<div class="page-header">
<h1>Your Dashboard</h1>
</div>
<div class="row">
<div class="span9">

<script type="text/css">
	
	.member {
		width:200px;
		height:100px;
		float:left;
		padding:5px;
	}

	.friend_img {
		width:180px;
		height:85px;
	}

	.friend_name {
		width:200px;
		height:15px;
		font-weight:bold;
	}

</script>


<?php 
	foreach($friends as $friend_id => $friend_name) {
	?>
	<div class="member">
		<div class="friend_img">
			<img src="http://graph.facebook.com/<?=$friend_id; ?>/picture" />
		</div>
		<div class="friend_name"><?=$friend_name; ?></div>
	</div><?php
	}
?>

</div>
</div>
</section>
</div>