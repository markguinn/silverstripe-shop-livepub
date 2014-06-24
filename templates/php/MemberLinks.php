<?php if (empty($_SESSION['LoggedInMember'])): ?>
	<li><a class="login-register" href="/Security/login">Sign In</a></li>
<?php else: ?>
	<li><a href="/account">My Account</a></li>
	<li><a class="logout" href="/Security/logout">Sign Out</a></li>
<?php endif; ?>
