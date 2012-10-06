<div class="container">
<section id="typography">
<div class="page-header">
<h1>Your Dashboard</h1>
</div>
<div class="row">
<div class="span9">
<?php 
foreach($friends as $friend_id => $friend_name) {
?>
<div class="member">
<div class="friend_img">
<img src="http://graph.facebook.com/<?=$friend_id; ?>/picture"/>
</div>
<div class="friend_name"><?=$friend_name; ?></div>
</div>
<?php
}
?>
</div>
</div>
</section>
</div>