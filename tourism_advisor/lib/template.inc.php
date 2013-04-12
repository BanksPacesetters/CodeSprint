<?php
//this function loads a template file and fills it with the specified data and returns source	
	function template($template, $tags = array()) {
		$output = "";
		//first read in the template file
		if(file_exists($template)) {
			
			//unify array of read-in template
			$output = implode("", file($template));
			
			//try to replace the data supplied with the corresponding tags in the template
			if(sizeof($tags) > 0) {
			foreach($tags as $tag => $data) {
				 $output = preg_replace("{\{".$tag."\}}", $data, $output);
				}
			}
			
		}else {
			$output = "Template file $template not found.";
		}
		
		return $output;
	}
	

//grabs a static document and returns the content (used with embedded php)
	function parse($file) {
		ob_start();
		include($file);
		$buffer = ob_get_contents();
		ob_end_clean();
		return $buffer;
	}
?>