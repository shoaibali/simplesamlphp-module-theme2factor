<?php
$this->data['header'] = $this->t('{login:user_pass_header}');

if (strlen($this->data['username']) > 0) {
	$this->data['autofocus'] = 'password';
} else {
	$this->data['autofocus'] = 'username';
}
$this->includeAtTemplateBase('includes/header.php');

?>
	<h1>Single Sign On (SSO) Login</h1>

	</div><!-- #login-header -->


<!-- Error -->
<?php if ($this->data['errorcode'] !== NULL) :?>
  <div class="alert">
    <p><strong><?php echo $this->t('{login:error_header}'); ?> - <?php echo $this->t('{auth2factor:errors:title_' . $this->data['errorcode'] . '}'); ?></strong></p>
    <p><?php echo $this->t('{auth2factor:errors:descr_' . $this->data['errorcode'] . '}'); ?></p>
  </div>

<?php endif; ?>


<form action="?" method="post" name="f">
<div class="form-controls">
<p><!-- USERNAME -->
<label for="username" style="display: none;"><?php echo $this->t('{login:username}'); ?></label>
<?php
  if ($this->data['forceUsername']) {
    echo '<strong style="font-size: medium">' . htmlspecialchars($this->data['username']) . '</strong>';
  }
  else {
    echo '<input autocomplete="off" autocorrect="off" autocapitalize="off" class="form-control" type="text" id="username" tabindex="1" placeholder="Username" name="username" value="' . htmlspecialchars($this->data['username']) . '" />';
  }
?>


<!-- PASSWORD -->
<label for="password" style="display: none;"><?php echo $this->t('{login:password}'); ?></label>
<input autocomplete="off" autocorrect="off" autocapitalize="off" class="form-control" id="password" type="password" tabindex="2" name="password" placeholder="Password" />
</p>
</div><!-- .form-controls -->

<!-- SUBMIT -->
<p><input type="submit" class="btn btn-block" id="regularsubmit" value="<?php echo $this->t('{login:login_button}'); ?>" /></p>

<?php
  foreach ($this->data['stateparams'] as $name => $value) {
    echo('<input type="hidden" name="' . htmlspecialchars($name) . '" value="' . htmlspecialchars($value) . '" />');
  }
?>

	</form>

<?php

if(!empty($this->data['links'])) {
	echo '<ul class="links" style="margin-top: 2em">';
	foreach($this->data['links'] AS $l) {
		echo '<li><a href="' . htmlspecialchars($l['href']) . '">' . htmlspecialchars($this->t($l['text'])) . '</a></li>';
	}
	echo '</ul>';
}
?>

<div id="login-footer">
  <p><a href="#" id="link-forgot">Forgot Password</a> &middot; <a href="#" id="link-help">Help</a></p>
</div>
</div><!-- #login-box -->
</div><!-- #wrap -->

</body>
</html>
