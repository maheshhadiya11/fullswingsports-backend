<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php
      if ( function_exists( 'wp_body_open' ) ) {
      wp_body_open();
    }
	?>
  <?php get_header(); ?>

  <div class="main container">
    <?php
    if (have_posts()) {
      while (have_posts()) {
        the_post();
        the_content();
      }
    }
    ?>
  </div>

  <?php get_footer(); ?>

<script>
  (function () {
    const s = document.createElement('script');
    const h = document.querySelector('head') || document.body;
    s.src = 'https://acsbapp.com/apps/app/dist/js/app.js';
    s.async = true;
    s.onload = function () {
      acsbJS.init({
        statementLink: '',
        footerHtml: '',
        hideMobile: false,
        hideTrigger: true,
        disableBgProcess: false,
        language: 'en',
        position: 'right',
        leadColor: '#146FF8',
        triggerColor: '#146FF8',
        triggerRadius: '50%',
        triggerPositionX: 'right',
        triggerPositionY: 'bottom',
        triggerIcon: 'people',
        triggerSize: 'bottom',
        triggerOffsetX: 20,
        triggerOffsetY: 20,
        mobile: {
          triggerSize: 'small',
          triggerPositionX: 'right',
          triggerPositionY: 'bottom',
          triggerOffsetX: 10,
          triggerOffsetY: 10,
          triggerRadius: '20',
        }
      });
    };
    h.appendChild(s);
  })();
  
</script>
<script id="ze-snippet" src=https://static.zdassets.com/ekr/snippet.js?key=d7793153-837d-402d-977b-0fbe15cf17cc> </script>
<script async type='module' src='https://interfaces.zapier.com/assets/web-components/zapier-interfaces/zapier-interfaces.esm.js'></script>
<zapier-interfaces-chatbot-embed is-popup='true' chatbot-id='cmea3csxw0008ujw9i3m7pgct'></zapier-interfaces-chatbot-embed>


  
  <?php wp_footer(); ?>
</body>

</html>
