<?php

/**
 * Implements hook_views_data().
 */
function asocol_views_data_alter(&$data) {
  $data['views']['events_filter_year'] = [
    'title' => t('Events filter year'),
    'help' => t('Provide markup of events filter by current year and next year for the area.'),
    'area' => [
      'id' => 'events_filter_year',
    ],
  ];
  $data['views']['asocol_tools'] = [
    'title' => t('Asocol Tools'),
    'help' => t('Asocol Tools.'),
    'area' => [
      'id' => 'asocol_tools',
    ],
  ];
  $data['views']['asocol_tools_user'] = [
    'title' => t('Asocol Tools User'),
    'help' => t('Asocol Tools User.'),
    'area' => [
      'id' => 'asocol_tools_user',
    ],
  ];
  $data['commerce_product']['membership_status'] = [
    'title' => t('Membership status'),
    'help' => t('Membership status.'),
    'field' => [
      'id' => 'asocol_membership_status',
    ],
  ];
}
