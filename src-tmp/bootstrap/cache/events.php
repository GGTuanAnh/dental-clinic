<?php return array (
  'App\\Providers\\EventServiceProvider' => 
  array (
    'App\\Events\\BookingCreated' => 
    array (
      0 => 'App\\Listeners\\QueueBookingWebhook',
    ),
  ),
  'Illuminate\\Foundation\\Support\\Providers\\EventServiceProvider' => 
  array (
    'App\\Events\\BookingCreated' => 
    array (
      0 => 'App\\Listeners\\QueueBookingWebhook@handle',
    ),
  ),
);