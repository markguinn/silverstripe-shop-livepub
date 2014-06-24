<?php if (!empty($_SESSION['LoggedInMember'])): ?>
	Logged in as: <strong><?= htmlentities($_SESSION['LoggedInMember']['FirstName'] . ' ' . $_SESSION['LoggedInMember']['Surname']) ?></strong>
<?php endif; ?>
