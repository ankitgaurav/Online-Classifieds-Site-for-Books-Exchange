<?php
session_start();
unset($_SEESSION);
session_destroy();
header('Location:home?msg=logout');
?>