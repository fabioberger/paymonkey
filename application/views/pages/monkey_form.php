<div class="container">
<section id="typography">
<div id="monkeyform_modal" class="modal">
<div class="modal-header">
<h3>Monkey Form</h3>
</div>
<div class="modal-body">
<div id="monkeyform_content">
<form method="post" action="/home/group_details/" id="monkeyform" class="form-horizontal">
<div class="control-group">
<label class="control-label" for="inputEmail">Paypal Email</label>
<div class="controls">
<input name="paypal_email" type="text" id="inputEmail" placeholder="Paypal Email">
</div>
</div>
<div class="control-group">
<label class="control-label" for="inputPassword">Amount Per Person</label>
<div class="controls">
<div class="input-prepend">
<span class="add-on">$</span><input name="amount" class="span2" id="prependedInput" size="16" type="text" placeholder="19.00">
</div>
</div>
</div>
<div class="control-group">
<label class="control-label" for="dp1">Payment Due Date</label>
<div class="controls">
<div class="input-append date" id="dp1" data-date="2012-02-12" data-date-format="yyyy-mm-dd">
<input name="date" id="duedate" class="span2" size="16" type="text" value="2012-02-12" readonly="">
<span class="add-on"><i class="icon-calendar"></i></span>
</div>
<input type="hidden" name="group_id" value="<?=$group_id; ?>" >
</div>
</div>
<div class="control-group">
<div class="controls">
<button type="submit" class="btn-large btn-primary">Create Monkey</button>
</div>
</div>
</form>
</div>
</div>
</div>
</section>
</div>