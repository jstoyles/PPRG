<?php
class App{
	public function init(){
		session_start();

		global $config, $routes, $view, $controller, $model, $db, $page;

		if($config['URL'] != '' && $config['URL'] != '/'){
			$url_paths = explode('/', $config['URL']);

			$file_found = false;
			foreach($routes as $route){
				$route_paths = explode('/', $route['url']);

				if(in_array($config['URL'], $route)){
					$view = $route['view'];
					$page = $url_paths[count($url_paths)-2];
					$controller = isset($route['controller'])?$route['controller']:'';
					$model = isset($route['model'])?$route['model']:'';
					$file_found = true;
					break;
				}
				else if(count($url_paths)==count($route_paths)){
					for($p = 0; $p<count($route_paths); $p++){
						if($route_paths[$p]==$url_paths[$p]){ continue; }
						else if(substr($route_paths[$p], 0, 2)=='{$'){
							$view = $route['view'];
							$page = $url_paths[count($url_paths)-2];
							$controller = isset($route['controller'])?$route['controller']:'';
							$model = isset($route['model'])?$route['model']:'';
							$file_found = true;
							break;
						}
						else{
							$file_found = false;
							break;
						}
					}
				}
				else{
					if(!$file_found){
						$view = 'error_404.phtml';
					}
				}
			}
		}

		if($model != ''){
			include($config['MODELS_DIR'] . $model);
			require_once('db.php');
			$db = new DB();
		}

		if($controller != ''){
			include($config['CONTROLLERS_DIR'] . $controller);
			$className = ucfirst(str_replace('-','', str_replace('.php', '', $controller)));
			$class = new $className;
			if(method_exists($class, 'init')){ $class->init(); }
		}

		//Generate favicon
		if(!file_exists($config["CODE_BASE"] . "/public/favicon.png") || !$config["CACHE_FAVICON"]){
			$faviconWidth = 64;
			$faviconHeight = 64;
			$faviconFontSize = !empty(abs($config["FAVICON_TEXT_SIZE"]))?abs($config["FAVICON_TEXT_SIZE"]):$faviconHeight-10;
			$faviconText = !empty($config["FAVICON_TEXT"])&&!empty(abs($config["FAVICON_TEXT_SIZE"]))?strtoupper($config["FAVICON_TEXT"]):'-';
			$favicon = imagecreatetruecolor($faviconWidth, $faviconHeight);

			if(is_array($config["FAVICON_TEXT_COLOR"]) && count($config["FAVICON_TEXT_COLOR"])==3){
				$faviconTextColor = imagecolorallocate($favicon, $config["FAVICON_TEXT_COLOR"][0], $config["FAVICON_TEXT_COLOR"][1], $config["FAVICON_TEXT_COLOR"][2]);
			}
			else{
				$faviconTextColor = imagecolorallocate($favicon, 0, 0, 0);
			}

			if(is_array($config["FAVICON_BG_COLOR"]) && count($config["FAVICON_BG_COLOR"])==3){
				$faviconBackground = imagecolorallocate($favicon, $config["FAVICON_BG_COLOR"][0], $config["FAVICON_BG_COLOR"][1], $config["FAVICON_BG_COLOR"][2]);
			}
			else{ //make background transparent
				$faviconBackground = imagecolortransparent($favicon, imagecolorallocate($favicon, 255, 255, 255));
			}

			if(!empty($config["FAVICON_SHAPE"]) && $config["FAVICON_SHAPE"]=="circle"){
				imagefilledrectangle($favicon, 0, 0, $faviconWidth, $faviconHeight, imagecolortransparent($favicon, imagecolorallocate($favicon, 255, 255, 255)));
				imagefilledellipse($favicon, $faviconWidth/2, $faviconHeight/2, $faviconWidth, $faviconHeight, $faviconBackground);
			}
			else{
				imagefilledrectangle($favicon, 0, 0, $faviconWidth, $faviconHeight, $faviconBackground);
			}

			if(!empty($config["FAVICON_FONT"])){
				$faviconFont = $config["CODE_BASE"] . $config["FAVICON_FONT"];
			}
			else{
				$faviconFont = $config["CODE_BASE"] . '/public/assets/fonts/Open_Sans/OpenSans-Bold.ttf';
			}
			$faviconBoundaryBox = imagettfbbox($faviconFontSize, 0, $faviconFont, $faviconText);

			$faviconTextX = (imagesx($favicon) / 2) - (($faviconBoundaryBox[4]+$faviconBoundaryBox[0]) / 2);
			$faviconTextY = (imagesy($favicon) / 2) - (($faviconBoundaryBox[5]+$faviconBoundaryBox[1]) / 2);

			$text_width = $bounding_box_size[2] - $bounding_box_size[0];

			imagettftext($favicon, $faviconFontSize, 0, $faviconTextX, $faviconTextY, $faviconTextColor, $faviconFont, $faviconText);
			imagepng($favicon, $config["CODE_BASE"] . "/public/favicon.png");
			imagedestroy($favicon);
		}


		//Generate Logo
		if(!file_exists($config["CODE_BASE"] . "/public/assets/images/logo.png") || !$config["CACHE_LOGO"]){
			$logoWidth = 320;
			$logoHeight = 80;
			$logoText = !empty($config["LOGO_TEXT"])&&!empty(abs($config["LOGO_TEXT_SIZE"]))?strtoupper($config["LOGO_TEXT"]):'-';
			$logoFontSize = !empty(abs($config["LOGO_TEXT_SIZE"]))?abs($config["LOGO_TEXT_SIZE"]):$logoHeight-20;

			if(!empty($config["LOGO_FONT"])){
				$logoFont = $config["CODE_BASE"] . $config["LOGO_FONT"];
			}
			else{
				$logoFont = $config["CODE_BASE"] . '/public/assets/fonts/Open_Sans/OpenSans-Bold.ttf';
			}

			$logoBoundaryBox = imagettfbbox($logoFontSize, 0, $logoFont, $logoText);
			if(($logoBoundaryBox[2]+20+$logoBoundaryBox[0])<$logoWidth){ $logoWidth = $logoBoundaryBox[2]+20+$logoBoundaryBox[0]; }

			$logo = imagecreatetruecolor($logoWidth, $logoHeight);

			if(is_array($config["LOGO_TEXT_COLOR"]) && count($config["LOGO_TEXT_COLOR"])==3){
				$logoTextColor = imagecolorallocate($logo, $config["LOGO_TEXT_COLOR"][0], $config["LOGO_TEXT_COLOR"][1], $config["LOGO_TEXT_COLOR"][2]);
			}
			else{
				$logoTextColor = imagecolorallocate($logo, 0, 0, 0);
			}

			if(is_array($config["LOGO_BG_COLOR"]) && count($config["LOGO_BG_COLOR"])==3){
				$logoBackground = imagecolorallocate($logo, $config["LOGO_BG_COLOR"][0], $config["LOGO_BG_COLOR"][1], $config["LOGO_BG_COLOR"][2]);
			}
			else{ //make background transparent
				$logoBackground = imagecolortransparent($logo, imagecolorallocate($logo, 255, 255, 255));
			}

			imagefilledrectangle($logo, 0, 0, $logoWidth, $logoHeight, $logoBackground);

			$logoTextX = 10;
			$logoTextY = (imagesy($logo) / 2) - (($logoBoundaryBox[5]+$logoBoundaryBox[1]) / 2);

			$text_width = $bounding_box_size[2] - $bounding_box_size[0];

			imagettftext($logo, $logoFontSize, 0, $logoTextX, $logoTextY, $logoTextColor, $logoFont, $logoText);
			imagepng($logo, $config["CODE_BASE"] . "/public/assets/images/logo.png");
			imagedestroy($logo);
		}


		if(file_exists($config["VIEWS_DIR"] . 'header.phtml')){
			$view_file = file_get_contents($config["VIEWS_DIR"] . 'header.phtml');
			$this->load_view($view_file);
		}

		$file_info = new SplFileInfo($view);
		
		if($file_info->getExtension()=='phtml' || $file_info->getExtension()=='php'){ //only allow php execution for phtml and php files
			$view_file = file_get_contents($config["VIEWS_DIR"] . $file_info->getFilename());
			$this->load_view($view_file);
		}
		else{
			require_once($config["VIEWS_DIR"] . $file_info->getFilename());
		}

		if(file_exists($config["VIEWS_DIR"] . 'footer.phtml')){
			$view_file = file_get_contents($config["VIEWS_DIR"].'/footer.phtml');
			$this->load_view($view_file);
		}
	}

	public static function assign($variable , $value){
		global $data;
		$data[$variable] = $value;
	}

	private function load_view($view_markup){
		global $config, $page, $data;
		if(is_array($data)){ extract($data); }

		$view_markup = str_replace('}}', '?>', $view_markup);
		$view_markup = str_replace('{{ $', '<?=$', $view_markup);
		$view_markup = str_replace('{{$', '<?=$', $view_markup);
		$view_markup = str_replace('{{=', '<?=', $view_markup);
		$view_markup = str_replace('{{', '<?php', $view_markup);

		try{ eval('?>'.$view_markup); }
		catch(Exception $e){ echo '<strong>!! EXCEPTION ERROR !!</strong>'; }
	}
}
?>