<?php
$showNotification = get_field('show_notification', 'option');
$notification = get_field('notification_link', 'option');
$logo = get_field('logo', 'option');
$hasTopbar = $showNotification && !empty($notification);
?>
<?php if ($hasTopbar) : ?>
	<div class="topbar">
		<a href="<?= $notification['url']; ?>" target="<?= $notification['target']; ?>">
			<?= $notification['title']; ?>
		</a>
	</div>
<?php endif; ?>


<?php if (isset($logo) && !empty($logo)) : ?>
	<header class="container main-header <?= $hasTopbar ? 'has-topbar' : '' ?>">
		<div class="main-header__inner">
			<a href="/">
				<img src="<?= $logo['url']; ?>" alt="<?= $logo['alt']; ?>" width="<?= $logo['width']; ?>" height="<?= $logo['height']; ?>" />
			</a>
		</div>
	</header>
<?php endif; ?>