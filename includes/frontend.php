<?php

/**
 * Build Query
 */

global $post;

// Build taxonomy array with region set
$tax_query[] = array(
  'taxonomy' => 'region',
  'field' => 'term_id',
  'terms' => $settings->event_region,
);

// Add chosen category to taxonomy array
if ('option-2' === $settings->event_choice_setup) {
  $tax_query = $tax_query + array('relation' => 'AND');
  $tax_query[] = array(
    'taxonomy' => 'tribe_events_cat',
    'field' => 'term_id',
    'terms' => $settings->event_category,
  );
};

// Set posts per page and chosen taxonomies
$args = array(
  'posts_per_page' => $settings->post_number,
  'tax_query' => $tax_query,
);

// add featured true to args to only show featured events
if ('yes' == $settings->event_featured) {
  $args['featured'] =  'true';
}

// Get Tribe events
$featured_events = tribe_get_events($args);

/*
echo '<pre>';
print_r($featured_events);
echo '</pre>';
*/

/**
 * Output optional module heading
 */
?>
<?php if ($settings->heading) : ?>
  <h2 class="has-text-centered is-mb-2"><?= $settings->heading ?></h2>
<?php endif; ?>

<?php
/**
 * Output Query
 */
if (!empty($featured_events) && !is_wp_error($featured_events)) : ?>

  <div class="card-deck">
    <?php foreach ($featured_events as $post) : ?>

      <?php setup_postdata($post); ?>
      <?php

      $startdate = tribe_get_start_date($post->ID, false);
      $enddate = tribe_get_end_date($post->ID, false);
      $is_same_day = $startdate == $enddate;

      ?>

      <div class="card">
        <figure class="card-img-top">
          <?php the_post_thumbnail(); ?>
        </figure>

        <div class="card-body">
          <div class="category">
            <?= $startdate; ?>
            <?php if (!$is_same_day) {
              echo ' - ' . $enddate;
            } ?>
          </div>
          <h4 class="card-title"><?= $post->post_title; ?></h4>
          <p class="subtitle"><?= tribe_get_venue($post->ID) ?></p>
          <div class="card-text">
            <?php the_excerpt(); ?>
          </div>
          <a href="<?php the_permalink(); ?>" class="btn btn-primary">View Details</a>
        </div>
      </div>

    <?php endforeach; ?>
  </div>

<?php endif; ?>
<?php wp_reset_postdata(); ?>