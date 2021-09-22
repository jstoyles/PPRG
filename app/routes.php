<?php
/*
url (required), 
view (required), 
controller (optional), 
model (optional)

example ['url'=>'/myurl/', 'view'=>'myview.ptml', 'controller'=>'mycontroller.php', 'model'=>'mymodel.php']
*/
$routes = [
	['url'=>'/reset-repos/', 'view'=>'reset-repos.php', 'controller'=>'reset-repos.php', 'model'=>'repos.php'],
	['url'=>'/repo-details/{$id}/', 'view'=>'repo-details.php', 'controller'=>'repo-details.php', 'model'=>'repos.php']
];

?>