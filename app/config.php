<?php

date_default_timezone_set('America/New_York');

define("DB_TYPE", "mysql"); //Currently supports mysql and sqlite (For use with sqlite db - make sure folder containing the db file is writable!)
define("DB_HOST", "<DB HOST>");
define("DB_USER", "<DB USER>");
define("DB_PASSWORD", "<DB PASSWORD>");
define("DB_DB", "<DB NAME>");

$config["CODE_BASE"] = dirname(__DIR__);
$config["INCLUDES_DIR"] = $config["CODE_BASE"] . '/public/inc/';
$config["VIEWS_DIR"] = $config["CODE_BASE"] . '/public/views/';
$config["CONTROLLERS_DIR"] = $config["CODE_BASE"] . '/controllers/';
$config["MODELS_DIR"] = $config["CODE_BASE"] . '/models/';
$config["DOMAIN"] = $_SERVER['SERVER_NAME'];
$config["URI"] = $_SERVER['REQUEST_URI'];
$config["PROTOCOL"] = "https://";
$config["REMOTE_IP_ADDRESS"] = $_SERVER['REMOTE_ADDR'];
$config["HTTP_USER_AGENT"] = $_SERVER['HTTP_USER_AGENT'];
$config["HTTP_REFERER"] = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'';
$config["SITE_NAME"] = "Popular PHP Repositories on GitHub";

// Favicon options
/*
To use your own custom favicon...
1) IMPORTANT: Set $config["CACHE_FAVICON"] = true;
2) Create a png file named favicon.png and add it to the public directory.
*/
$config["FAVICON_TEXT"] = "PPRG";
$config["FAVICON_TEXT_SIZE"] = "24";
$config["FAVICON_BG_COLOR"] = [250,250,250]; //either [r,g,b] (e.g. [255, 255, 255]) or "transparent". Default: "transparent"
$config["FAVICON_TEXT_COLOR"] = [0, 0, 0]; //[r,g,b] (e.g. [0, 0, 0])
$config["FAVICON_SHAPE"] = "circle"; //either circle or square. Default: square
$config["FAVICON_FONT"] = '/public/assets/fonts/Open_Sans_Condensed/OpenSansCondensed-Bold.ttf'; //Default: /public/assets/fonts/Open_Sans/OpenSans-Bold.ttf
$config["CACHE_FAVICON"] = true;

// Logo options
/*
To use your own custom favicon...
1) IMPORTANT: Set $config["CACHE_FAVICON"] = true;
2) Create a png file named favicon.png and add it to the public directory.
3) Remember to adjust the logo width in your css
*/
$config["LOGO_TEXT"] = "PPRG";
$config["LOGO_TEXT_SIZE"] = "35";
$config["LOGO_BG_COLOR"] = "transparent"; //either [r,g,b] (e.g. [255, 255, 255]) or "transparent". Default: "transparent"
$config["LOGO_TEXT_COLOR"] = [0, 0, 0]; //[r,g,b] (e.g. [0, 0, 0])
$config["LOGO_FONT"] = '/public/assets/fonts/Prompt/Prompt-Regular.ttf'; //Default: /public/assets/fonts/Open_Sans/OpenSans-Bold.ttf
//$config["LOGO_FONT"] = '/public/assets/fonts/Oswald/Oswald[wght].ttf'; //Default: /public/assets/fonts/Open_Sans/OpenSans-Bold.ttf
$config["CACHE_LOGO"] = true;


$config["URL_PARTS"] = explode('?',$config["URI"]);
$config["URL"] = $config["URL_PARTS"][0];

return $config;

?>