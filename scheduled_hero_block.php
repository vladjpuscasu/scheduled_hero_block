<?php
/**
 * Hero Scheduled block
 *
 * @package      your-theme
**/

/* Logic for hero section:
	1. Create an array of all hero regions
  2. Get the current time 
	3. Decide which hero to use based on user's region
  4. Check for scheduled time, and if it equals or is past the current time, based on region, show the hero section
*/

// Get regions from the Lenbrook Regions plugin
$default_region = Regions()->default_region;
$current_region = Regions()->current_region;

date_default_timezone_set('America/Toronto');
// Array that will contain all hero content
$heroes = array();
// Array that will be shown
$hero = array();
// Array for scheduled hero
$heroes2 = array();

//date_default_timezone_set('America/New_York');

$date = date("Y-m-d H:i:s" );
$now_date = strtotime($date . "+5hours");

// Load default hero; use default_region() 2-char code as key
$heroes[$default_region] = get_field('default_hero');
// Load any regional heroes
if (have_rows('regional_hero')):
	//$regional_heroes = get_field('regional_heroes');
	foreach (get_field('regional_hero') as $x):
		foreach ($x['regions'] as $region):
			$heroes[$region] = $x;
		endforeach;
	endforeach;
endif;
// Load any Schedule heroes
if (have_rows('schedule_hero')):
	//$regional_heroes = get_field('regional_heroes');
	foreach (get_field('schedule_hero') as $y):
		foreach ($y['regions2'] as $region):
			$heroes2[$region] = $y;
		endforeach;
	endforeach;
endif;


//get time for specific region
if( isset($heroes2[$current_region])){
	$hero = $heroes2[$current_region];
	$scheduleField = $hero['schedule'];
	$post_date = date(strtotime($scheduleField));
}


if (isset($post_date) && $now_date>$post_date && isset($heroes2[$current_region])): 
// Check if there is a hero for the current region, that is past the current time
	$hero = $heroes2[$current_region];
elseif (isset($heroes[$current_region])):
	// Check if there is a hero for the current region
	$hero = $heroes[$current_region];
else: // else use the default international hero
	$hero = $heroes[$default_region];
endif;

/*
 * Prepare variables for content
 */
// Create button class attribute based on chosen style
$buttonClassName = '';
if( (isset($hero['style']) && $hero['style'] == 'dark') || $hero['style2'] == 'dark'  )
	$buttonClassName = 'is-style-light';
else
	$buttonClassName = 'is-style-dark';

$anchor = '';
if( isset( $block['anchor'] ) )
	$anchor = 'id="' . $block['anchor'] . '"';
// else
// 	$anchor = 'id="' . sanitize_title( $hero['title'] ) . '"';


?>


<?php if (isset($post_date) && $now_date>$post_date ): ?>


<?php if ($hero['video2']): ?>
	<section class="hero hero-video alignfull <?php echo 'hero-' . $hero['style2']; ?>" <?php echo $anchor; ?>>
		<video autoplay muted playsinline poster="<?php echo $hero['bg_image2'];?>" style="width: 100%;">
			<source src="<?php echo $hero['video2']; ?>" type="video/mp4">
		</video>
<?php else: ?>
	<section class="hero alignfull <?php echo 'hero-' . $hero['style2']; ?>" <?php echo $anchor ?> style="background-image:url('<?php echo $hero['bg_image2']; ?>')">
<?php endif; ?>
	  <div class="hero-inner">
	    <?php if ($hero['title2']): ?>
	      <h2><?php echo $hero['title2']; ?></h2>
	    <?php endif; ?>
	    <?php if ($hero['description2']): ?>
	      <div class="hero-description">
	        <?php echo $hero['description2']; ?>
	      </div>
	    <?php endif; ?>
	      <div class="hero-cta">
	        <?php if ($hero['button_link2'] && $hero['button_text2']): ?>
	          <div class="wp-block-button">
	            <a class="wp-block-button__link <?php echo $buttonClassName; ?>" href="<?php echo $hero['button_link2']; ?>"><?php echo $hero['button_text2']; ?></a>
	          </div>
	        <?php endif; ?>
	        <?php if ($hero['anchor_link2'] && $hero['anchor_link_text2']): ?>
	          <span class="secondary-cta">or <a href="#<?php echo sanitize_title($hero['anchor_link2']); ?>"><?php echo $hero['anchor_link_text2']; ?></a></span>
	        <?php endif; ?>
	      </div>
	  </div>
	</section>
<?php else: ?>

<?php if ($hero['video']): ?>
	<section class="hero hero-video alignfull <?php echo 'hero-' . $hero['style']; ?>" <?php echo $anchor; ?>>
		<video autoplay muted playsinline poster="<?php echo $hero['bg_image'];?>" style="width: 100%;">
			<source src="<?php echo $hero['video']; ?>" type="video/mp4">
		</video>
<?php else: ?>
	<section class="hero alignfull <?php echo 'hero-' . $hero['style']; ?>" <?php echo $anchor ?> style="background-image:url('<?php echo $hero['bg_image']; ?>')">
<?php endif; ?>
	  <div class="hero-inner">
	    <?php if ($hero['title']): ?>
	      <h2><?php echo $hero['title']; ?></h2>
	    <?php endif; ?>
	    <?php if ($hero['description']): ?>
	      <div class="hero-description">
	        <?php echo $hero['description']; ?>
	      </div>
	    <?php endif; ?>
	      <div class="hero-cta">
	        <?php if ($hero['button_link'] && $hero['button_text']): ?>
	          <div class="wp-block-button">
	            <a class="wp-block-button__link <?php echo $buttonClassName; ?>" href="<?php echo $hero['button_link']; ?>"><?php echo $hero['button_text']; ?></a>
	          </div>
	        <?php endif; ?>
	        <?php if ($hero['anchor_link'] && $hero['anchor_link_text']): ?>
	          <span class="secondary-cta">or <a href="#<?php echo sanitize_title($hero['anchor_link']); ?>"><?php echo $hero['anchor_link_text']; ?></a></span>
	        <?php endif; ?>
	      </div>
	  </div>
	</section>
 <?php endif; ?>
