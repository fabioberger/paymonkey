<div class="container">
<section id="typography">
<div class="page-header">
<h1>Your Dashboard</h1>
</div>
<div class="row">
<div class="span9">
<?php
$friends = array(
	12312321=>"name last1",
	32423534543=>"name last2",
	34234325=>"name last3"
);
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