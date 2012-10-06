<div class="container">
<section id="typography">
<div class="page-header">
<h1>Your Dashboard</h1>
</div>
<div class="row">
<div class="span6">
<h3>Amount Collected</h3>
<div class="progress progress-striped active">
<div class="bar" style="width:40%;"></div>
</div>
</div>
<div class="span6">
<h3>Stats</h3>
Due: 02-12-2012<br/>
Paypal email (edit)</br/>
<div class="control-group">
<div class="controls">
<button type="submit" class="btn-large btn">Cashout</button>
</div>
</div>
</div>
</div>
<div class="row">
<?php
$friends = array(
	12312321=>"name last1",
	32423534=>"name last2",
	12312322=>"name last3",
	12312323=>"name last4",
	12312324=>"name last5"
);
foreach($friends as $friend_id => $friend_name) {
?>
<div class="span2">
<div class="member">
<div class="friend_img">
<img src="http://graph.facebook.com/<?=$friend_id; ?>/picture"/>
</div>
<div class="friend_name"><?=$friend_name; ?></div>
</div>
</div>
<?php
}
?>
</div>
</section>
</div>