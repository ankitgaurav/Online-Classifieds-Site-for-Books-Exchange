<?php
require_once __DIR__ . '/facebook/autoload.php';
include ('files/config.php');
$fb = new Facebook\Facebook([
  'app_id' => '1075301472498825',
  'app_secret' => '512acc15a69c09a625014719ca4eb4e9',
  'default_graph_version' => 'v2.2',
  ]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl('https://handybooks.in/fb/fb-callback.php', $permissions);

echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
?>