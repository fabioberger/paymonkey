<div class="container">
<section id="typography">
<div class="page-header">
<h1>Your Dashboard</h1>
</div>
<div class="row">
<div class="span6">
<h3>Amount Collected</h3>
<div class="progress active">
<div class="bar" style="width:40%"></div>
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
foreach($members as $friend_data) {
$friend_id = $friend_data['fbid'];
$friend_name = $friend_data['name'];
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
<div class="row">
<span class="span12">
<br/><br/>
<h2>Paid Example</h2>
<a href="http://paymonkey.herokuapp.com/pay/?payerid=871&groupid=481" target="_blank">http://paymonkey.herokuapp.com/pay/?payerid=871&groupid=481</a>
<br/>
<h2>Unpaid Example</h2>
<a href="http://paymonkey.herokuapp.com/pay/?payerid=841&groupid=481" target="_blank">http://paymonkey.herokuapp.com/pay/?payerid=841&groupid=481</a>
</span>
</div>
</section>
</div>