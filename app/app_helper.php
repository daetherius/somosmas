<?php
class AppHelper extends Helper {
	function url($url = null, $full = false){
		if(is_array($url)){
			$carried = array(
				'categories'=>array('category','program','type'),
				'albums'=>array('category','type')
			);
			
			if(isset($url['controller']) && $url['controller']){
				$ctllr = $url['controller'];
			}else{
				$ctllr = $this->params['controller'];
			}
			
			if(isset($carried[$ctllr]) && $carried[$ctllr]){
				foreach($carried[$ctllr] as $added){
					if((!isset($url[$added])) && isset($this->params[$added])){
						$url[$added] = $this->params[$added];
					}
				}
			}
		}
		return parent::url($url, $full);
	}
	
}
?>