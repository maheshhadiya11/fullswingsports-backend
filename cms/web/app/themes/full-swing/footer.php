	<?php
	$promoBlocks = get_field('promo_blocks', 'option');
	$templateUri = get_template_directory_uri();
	$quoteBlock = get_field('quote_block', 'option');
	$footerLogo = get_field('footer_logo', 'option');
	$menu = get_field('footer_menu', 'option');
	$socials = get_field('footer_socials', 'option');
	$logos = get_field('logos', 'option');
	$copyright = get_field('copyright', 'option');
	$legalLinks = get_field('legal_links', 'option');

	$divider = '<hr class="col-span-full md:col-span-6 md:col-start-2 xl:col-span-10 xl:col-start-2 xxl:col-span-full xxl:col-start-1" />';
	?>

	<footer class="main-footer">
		<div class="main-footer__inner container default-grid">
			<?php if ($promoBlocks) : ?>
				<div class="top-footer col-span-full md:col-span-6 md:col-start-2 xl:col-span-10 xl:col-start-2 xxl:col-span-full xxl:col-start-1">
					<?php foreach ($promoBlocks as $block) : ?>
						<a href="<?php echo $block["link"]["url"]; ?>" class="top-footer__item">
							<img src="<?= $templateUri . '/assets/icons/' . $block['icon'] . '.svg'; ?>" width="24" height="24" alt="<?= $block['icon']; ?>" />
							<div class="headline card-title">
								<?= $block['headline']; ?>
							</div>
							<div class="copy body-copy-2">
								<?= $block['copy']; ?>
							</div>
						</a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<?php if ($quoteBlock) : ?>
				<div class="quote col-span-full md:col-span-6 md:col-start-2 xl:col-span-10 xl:col-start-2 xxl:col-span-full xxl:col-start-1">
					
					<h2 class="headline-h3"><span class="quote__symbol headline-h3">“</span><?= $quoteBlock['quote'] ?>“</h2>
					<p class="card-title"><?= $quoteBlock['quote_author'] ?></p>
				</div>
				<?= $divider ?>
			<?php endif; ?>

			<?php if ($footerLogo) : ?>
				<img class="footer-logo hidden md:block md:col-span-1 md:col-start-2 xl:col-span-2 xl:col-start-2 xxl:col-start-1" src="<?= $footerLogo['url']; ?>" alt="<?= $footerLogo['alt']; ?>" width="<?= $footerLogo['width']; ?>" height="<?= $footerLogo['height']; ?>" />
			<?php endif; ?>

			<nav class="footer-nav col-span-full md:col-span-5 xl:col-span-8 xxl:col-span-8 xxl:col-start-5">
				<?php if ($menu) : ?>
					<?php foreach ($menu as $menuKey => $menuItem) :
						$hasSocials = $menuKey + 1 === count($menu) && $socials;
					?>
			
						<div class="footer-nav__item <?= $hasSocials ? 'has-socials' : '' ?>">
							<div>
								<?php if (isset($menuItem['section_title']) && !empty($menuItem['section_title'])) : ?>
									<span class="footer-nav__item--title card-title mb-8 xl:mb-20 xxl:mb-52">		<?= $menuItem['section_title']; ?></span>
								<?php endif; ?>
								<?php if (isset($menuItem['section_link']['url']) && !empty($menuItem['section_link']['url'])) : ?>
									<a class="footer-nav__item--title card-title" href="<?= $menuItem['section_link']['url']; ?>" target="<?= $menuItem['section_link']['target']; ?>">
										<?= $menuItem['section_link']['title']; ?>
									</a>
								<?php endif; ?>

								<?php foreach ($menuItem['sub_links'] as $link) : ?>
									<?php if (!isset($link['link']['url']) || empty($link['link']['url'])) continue; ?>
									<a class="footer-nav__item--sublink body-copy-2" href="<?= $link['link']['url']; ?>" target="<?= $link['link']['target']; ?>">
										<?= $link['link']['title']; ?>
									</a>
								<?php endforeach; ?>
							</div>


							<?php if ($hasSocials) : ?>
								<div class="socials">

									<?php if (isset($socials['section_title']) && !empty($socials['section_title'])) : ?>
									<span class="footer-nav__item--title card-title mb-8 xl:mb-20 xxl:mb-52">		<?= $socials['section_title']; ?></span>
								<?php endif; ?>
									<div>
										<?php foreach ($socials['links'] as $link) :
											if (!isset($link['image']) || empty($link['image']) || !isset($link['link']['url']) || empty($link['link']['url'])) continue;
											$url = $link['link']['url'];
											$svg = '';
    										if (strpos($url, 'instagram') !== false) {
    										    $svg = '<svg width="23" height="24" viewBox="0 0 23 24" fill="none" xmlns="http://www.w3.org/2000/svg">
														  <path d="M7.3944 2.00012H15.3569C18.3902 2.00012 20.8548 4.60012 20.8548 7.80012V16.2001C20.8548 17.7384 20.2756 19.2136 19.2445 20.3013C18.2135 21.3891 16.815 22.0001 15.3569 22.0001H7.3944C4.36107 22.0001 1.89648 19.4001 1.89648 16.2001V7.80012C1.89648 6.26187 2.47573 4.78661 3.50679 3.6989C4.53785 2.61119 5.93626 2.00012 7.3944 2.00012ZM7.20482 4.00012C6.29977 4.00012 5.43178 4.37941 4.79182 5.05454C4.15185 5.72967 3.79232 6.64534 3.79232 7.60012V16.4001C3.79232 18.3901 5.31846 20.0001 7.20482 20.0001H15.5465C16.4515 20.0001 17.3195 19.6208 17.9595 18.9457C18.5995 18.2706 18.959 17.3549 18.959 16.4001V7.60012C18.959 5.61012 17.4328 4.00012 15.5465 4.00012H7.20482ZM16.3522 5.50012C16.6665 5.50012 16.9679 5.63182 17.1901 5.86624C17.4123 6.10066 17.5371 6.4186 17.5371 6.75012C17.5371 7.08164 17.4123 7.39959 17.1901 7.63401C16.9679 7.86843 16.6665 8.00012 16.3522 8.00012C16.038 8.00012 15.7366 7.86843 15.5144 7.63401C15.2922 7.39959 15.1673 7.08164 15.1673 6.75012C15.1673 6.4186 15.2922 6.10066 15.5144 5.86624C15.7366 5.63182 16.038 5.50012 16.3522 5.50012ZM11.3757 7.00012C12.6327 7.00012 13.8382 7.52691 14.727 8.46459C15.6159 9.40227 16.1152 10.674 16.1152 12.0001C16.1152 13.3262 15.6159 14.598 14.727 15.5357C13.8382 16.4733 12.6327 17.0001 11.3757 17.0001C10.1186 17.0001 8.9131 16.4733 8.02426 15.5357C7.13542 14.598 6.63607 13.3262 6.63607 12.0001C6.63607 10.674 7.13542 9.40227 8.02426 8.46459C8.9131 7.52691 10.1186 7.00012 11.3757 7.00012ZM11.3757 9.00012C10.6214 9.00012 9.89812 9.31619 9.36482 9.8788C8.83151 10.4414 8.5319 11.2045 8.5319 12.0001C8.5319 12.7958 8.83151 13.5588 9.36482 14.1214C9.89812 14.6841 10.6214 15.0001 11.3757 15.0001C12.1299 15.0001 12.8532 14.6841 13.3865 14.1214C13.9198 13.5588 14.2194 12.7958 14.2194 12.0001C14.2194 11.2045 13.9198 10.4414 13.3865 9.8788C12.8532 9.31619 12.1299 9.00012 11.3757 9.00012Z" fill="#F6F6F6"/>
														</svg>'; 
    										} elseif (strpos($url, 'twitter') !== false) {
    										    $svg = '<svg width="23" height="24" viewBox="0 0 23 24" fill="none" xmlns="http://www.w3.org/2000/svg">
														  <path d="M17.4981 1.90417H20.6959L13.7097 10.3277L21.9284 21.7901H15.4932L10.4529 14.8382L4.68573 21.7901H1.48602L8.95845 12.7803L1.07422 1.90417H7.67277L12.2287 8.25851L17.4981 1.90417ZM16.3758 19.771H18.1477L6.70996 3.81731H4.8085L16.3758 19.771Z" fill="#F6F6F6"/>
														</svg>'; 
    										} elseif (strpos($url, 'facebook') !== false) {
    										    $svg = '<svg width="23" height="24" viewBox="0 0 23 24" fill="none" xmlns="http://www.w3.org/2000/svg">
														  <path d="M21.1048 12.0001C21.1048 6.48012 16.8582 2.00012 11.6257 2.00012C6.39315 2.00012 2.14648 6.48012 2.14648 12.0001C2.14648 16.8401 5.40732 20.8701 9.72982 21.8001V15.0001H7.83398V12.0001H9.72982V9.50012C9.72982 7.57012 11.218 6.00012 13.0475 6.00012H15.4173V9.00012H13.5215C13.0001 9.00012 12.5736 9.45012 12.5736 10.0001V12.0001H15.4173V15.0001H12.5736V21.9501C17.3605 21.4501 21.1048 17.1901 21.1048 12.0001Z" fill="#F6F6F6"/>
														</svg>'; 
    										} else {
    										    if (!isset($link['image']) || empty($link['image'])) continue;
    										    $svg = wp_get_attachment_image($link['image']);
    										}
										?>
											<a href="<?= $link['link']['url']; ?>" target="<?= $link['link']['target']; ?>" title="<?= $link['link']['title']; ?>">
												 <?= $svg; ?>
											</a>
										<?php endforeach; ?>
									</div>
								</div>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
			</nav>

			<?= $divider ?>
			<?php if ($logos) : ?>
				<div class="footer-logos col-span-full md:col-span-6 md:col-start-2 xl:col-span-10 xl:col-start-2 xxl:col-span-full xxl:col-start-1">
					<?php foreach ($logos as $logo) :
						$link = isset($logo['link']['url']) ? $logo['link'] : [
							'url' => '',
							'title' => '',
							'target' => ''
						];
					?>
						<a class="flex items-center" href="<?= $link['url']; ?>" title="<?= $link['title']; ?>" target="<?= $link['target']; ?>">
							<img src="<?= $logo['image']['url']; ?>" alt="<?= $logo['image']['alt']; ?>" width="<?= $logo['image']['width']; ?>" height="<?= $logo['image']['height']; ?>" />
							<span class="logoCopy"><?= $logo['copy']; ?></span>
						</a>
					<?php endforeach; ?>
					<div class="acessibee_wrapper">
						<button class="accessibility_button">
							Accessibility Adjustments
							<div class="accessibility_icon">
								<svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
									<g clip-path="url(#clip0_6856_6080)">
										<path d="M7.16062 4.47577C6.65407 4.47577 6.24342 4.06513 6.24342 3.55857C6.24342 3.05202 6.65407 2.64138 7.16062 2.64138M7.16062 4.47577C7.66717 4.47577 8.07782 4.06513 8.07782 3.55857C8.07782 3.05202 7.66717 2.64138 7.16062 2.64138M7.16062 4.47577V7.77768M7.16062 2.64138V1.17386M4.40903 7.04386C3.90247 7.04386 3.49183 6.63321 3.49183 6.12666C3.49183 5.62011 3.90247 5.20946 4.40903 5.20946M4.40903 7.04386C4.91558 7.04386 5.32622 6.63321 5.32622 6.12666C5.32622 5.62011 4.91558 5.20946 4.40903 5.20946M4.40903 7.04386V7.77755M4.40903 5.20946V1.1739M1.65743 3.74201C1.15088 3.74201 0.740234 3.33137 0.740234 2.82481C0.740234 2.31826 1.15088 1.90762 1.65743 1.90762M1.65743 3.74201C2.16399 3.74201 2.57463 3.33137 2.57463 2.82481C2.57463 2.31826 2.16399 1.90762 1.65743 1.90762M1.65743 3.74201V7.77768M1.65743 1.90762V1.17386" stroke="#F6F6F6" stroke-width="1.10064" stroke-linecap="round" stroke-linejoin="round"/>
									</g>
									<defs>
										<clipPath id="clip0_6856_6080">
										<rect width="8.8051" height="8.8051" fill="white" transform="translate(0.00634766 0.0732117)"/>
										</clipPath>
									</defs>
								</svg> 
							</div>
						</button>
				</div>
				</div>
				<?= $divider ?>
			<?php endif; ?>

			<div class="footer-bottom col-span-full md:col-span-6 md:col-start-2 xl:col-span-10 xl:col-start-2 xxl:col-span-full xxl:col-start-1 body-legal">
				<?php if ($copyright) : ?>
					<div>
						<?= $copyright ?>
					</div>
				<?php endif; ?>

				<?php if ($legalLinks) : ?>
					<div class="legal-links">
						<?php foreach ($legalLinks as $link) : ?>
							<a href="<?= $link['link']['url']; ?>" target="<?= $link['link']['target']; ?>">
								<?= $link['link']['title']; ?>
							</a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</footer>