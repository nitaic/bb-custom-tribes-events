<?php

class BBCustomFeaturedEventsModule extends FLBuilderModule
{
  public function __construct()
  {
    parent::__construct(array(
      'name'            => __('Feature Events', 'fl-builder'),
      'description'     => __('Lists events in card format', 'fl-builder'),
      'category'        => __('Custom Modules', 'fl-builder'),
      'dir'             => BB_CUSTOM_MODULES_DIR . 'bb-custom-featured-events-module/',
      'url'             => BB_CUSTOM_MODULES_URL . 'bb-custom-featured-events-module/',
      'icon'            => 'button.svg',
    ));
  }
}

/**
 * Build Category List
 */

function bb_custom_get_event_category_fields()
{

  $args = array(
    "hide_empty" => true,
    "taxonomy" => "tribe_events_cat"
  );
  $categories = get_terms($args);

  //$categories = 




  $fields[''] = '';

  if (!empty($categories) && !is_wp_error($categories)) {
    foreach ($categories as $category) {
      $fields[$category->term_id] = $category->name;
    }
  }

  return $fields;
}

/**
 * Build Location List
 */

function bb_custom_get_event_region_fields()
{

  $args = array(
    "hide_empty" => true,
    "taxonomy" => "region"
  );
  $regions = get_terms($args);

  $fields[''] = '';

  if (!empty($regions) && !is_wp_error($regions)) {
    foreach ($regions as $region) {
      $fields[$region->term_id] = $region->name;
    }
  }

  return $fields;
}

/**
 * Register the module and its form settings.
 */

FLBuilder::register_module('BBCustomFeaturedEventsModule', array(
  'general' => array(
    'title' => __('General', 'fl-builder'),
    'sections' => array(
      'general' => array(
        'title' => __('', 'fl-builder'),
        'fields' => array(
          'heading' => array(
            'type' => 'text',
            'label' => __('Heading', 'fl-builder'),
            //'default' => '',
            //'size' => '4'
          )
        )
      ),
      'content' => array(
        'title' => __('Choose Events To Show', 'fl-builder'),
        'fields' => array(
          'event_choice_setup' => array(
            'type' => 'select',
            'label' => __('Show All or Choose Category', 'fl-builder'),
            'default' => 'option-1',
            'options' => array(
              'option-1'      => __('Show All', 'fl-builder'),
              'option-2'      => __('Select Category', 'fl-builder'),
            ),
            'toggle' => array(
              'option-1' => array(
                'fields' => array(''),
              ),
              'option-2' => array(
                'fields' => array('event_category'),
              ),
            )
          ),
          'event_category' => array(
            'type' => 'select',
            'label' => __('Choose Category', 'fl-builder'),
            'default' => '',
            'options' => bb_custom_get_event_category_fields()
          ),
          'event_region' => array(
            'type' => 'select',
            'label' => __('Choose Region To Show Events From', 'fl-builder'),
            'default' => '',
            'options' => bb_custom_get_event_region_fields()
          ),
          'post_number' => array(
            'type' => 'select',
            'label' => __('Number of Posts To Show', 'fl-builder'),
            'default' => '3',
            'options' => array(
              '1'      => __('1', 'fl-builder'),
              '2'      => __('2', 'fl-builder'),
              '3'      => __('3', 'fl-builder'),
              '4'      => __('4', 'fl-builder'),
              '5'      => __('5', 'fl-builder'),
              '6'      => __('1', 'fl-builder'),
              '7'      => __('7', 'fl-builder'),
              '8'      => __('8', 'fl-builder'),
              '9'      => __('9', 'fl-builder'),
              '10'      => __('10', 'fl-builder')
            )
          ),
          'event_featured' => array(
            'type' => 'select',
            'label' => __('Only Show Featured Events', 'fl-builder'),
            'default' => 'no',
            'options' => array(
              'no'      => __('No', 'fl-builder'),
              'yes'      => __('Yes', 'fl-builder'),
            )
          ),
        )
      )
    )
  ),
));
