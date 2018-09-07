<?php

	class ViewEngine{

		public function __construct(){

		}

		private function getHead($content){
			preg_match("/<view_head>(.*?)<\/view_head>/ism", $content, $matches);

			if (!isset($matches[1])){
				return false;
			}else{
				return $matches[1];
			}
		}

		private function getBody($content){
			preg_match("/<view_body>(.*?)<\/view_body>/ism", $content, $matches);

			if (!isset($matches[1])){
				return false;
			}else{
				return $matches[1];
			}
		}

		public function renderView($path){
			if (file_exists($path)){
				
				ob_start();
				include($path);
				$content = ob_get_contents();
				ob_end_clean();

				$headContents = $this->getHead($content);
				$bodyContents = $this->getBody($content);

				return [
					"head"=>$headContents,
					"body"=>$bodyContents
				];
			}else{
				return false;
			}
		}
	}
?>
