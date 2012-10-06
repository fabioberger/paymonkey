<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

//Load PHPThumb library for resizing images
include_once "phpthumb_lib.php";

class Imagelibrary {
	
	public function checkURLIsImage($url="") {
		
		if($url=="") return false;
		
		$ch = curl_init();
					
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_NOBODY, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_exec($ch);
					
		$file_type = curl_exec($ch);
		
		curl_close($ch);
		
		if(!$file_type) return false;
		
		if(preg_match("/image/",$file_type)) return true;
		
		return false;
		
	}
	
	public function storeRemoteImage($img_link="", $path="", $overwrite=false, $filename="") {
		
		if($img_link=="" || $path == "") return false;
		if($filename=="") {
			$filename = $this->uniquename("aimg", "");
		}
		
		$ch = curl_init();
	
		curl_setopt($ch, CURLOPT_URL, $img_link);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
		$img_data = curl_exec($ch);
		curl_close($ch);
		
		if(!$img_data) return false;
	
		$path = (substr($path, -1) == "/") ? $path : $path . "/";
		$fullpath = $path . $filename;
		
		if(file_exists($fullpath)){
			if($overwrite==true) {
		        unlink($fullpath);
			} else {
				return false;
			}
		}
		
		$fp = fopen($fullpath,'x');
		
		if(!$fp) return false;
		
		if(!fwrite($fp, $img_data)) { 
			fclose($fp);
			return false; 
		}
		
		fclose($fp);
		
		if(!strpos($filename, ".")) {
			$img_type = exif_imagetype($fullpath);
			$img_ext = image_type_to_extension($img_type);
			$newfullpath = $fullpath . $img_ext;
			rename($fullpath, $newfullpath);
		} else {
			$newfullpath = $fullpath;
		}
		
		return $newfullpath;
	}
	
	public function uniquename($prefix,$extension=""){
		
		$return='';
		
		for ($i=0;$i<7;$i++){
			$return.=chr(rand(97,122));
		}
		
		if($extension != "" && substr($path, 1) != ".") $extension = "." . $extension;
		
		$return="$prefix-$return-".time()."-X$extension";	
		
		return $return;	
	}
	
	public function createAvatar($image_src, $image_target, $format="jpg") {	
		
		$thumber = new Phpthumb_lib();
		
		$image = $thumber->create($image_src);
		
		if(!$image) return false;
		
		$image->adaptiveResize(160, 160);
		$success = $image->save($image_target, $format);
		
		if(!$success) return false;
		
		return true;
	}
	
	public function createThumb($image_src, $thumb_target, $format="jpg") {
		
		$thumber = new Phpthumb_lib();
		
		$image = $thumber->create($image_src);
		
		if(!$image) return false;
		
		$image->adaptiveResize(30, 30);
		$success = $image->save($thumb_target, $format);
		
		if(!$success) return false;
		
		return true;
		
	}
	
}

?>