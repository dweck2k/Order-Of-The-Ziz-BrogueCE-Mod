<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<nav id="site-nav" role="navigation" aria-label="ניווט ראשי">
  <a href="<?php echo esc_url( home_url('/') ); ?>" class="nav-logo" aria-label="עמוד הבית">
    הקודקס של השוליים
  </a>

  <?php
  wp_nav_menu([
    'theme_location' => 'primary',
    'container'      => false,
    'menu_class'     => 'nav-menu',
    'fallback_cb'    => 'codex_fallback_nav',
  ]);
  ?>
</nav>
