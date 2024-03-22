<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Loader class */
require APPPATH."third_party/MX/Loader.php";

class MY_Loader extends MX_Loader {
    /** Load a module Assets **/
    public function assets($_sub_module="",$_filename="*",$extention=null){
        $filecache = array('css'=>'','js'=>'');
        // $path= FCPATH.'application/modules/'.$this->_module.'/views/'.$_sub_module.'/assets/';
		$path   = 'application/modules/'.$this->_module.'/views/'.$_sub_module.'/assets/';
        $pathcache='cacheassets';
        /*detect path assets in modules*/
        if (file_exists($path)) {
            $path .=$_filename;
            /*list file path assets*/
            $list = glob('./'.$path.'.'.$extention, GLOB_BRACE);
            foreach ($list as $key) {
                /*open file content and minify sourcecode*/
                if ($extention=='css') {
                    $bcss = $filecache['css'].file_get_contents($key);
                    // $bcss = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $bcss);
                    // $bcss = str_replace(["\r\n","\r","\n","\t",'  ','    ','     '], '', $bcss);
                    // $bcss = preg_replace(['(( )+{)','({( )+)'], '{', $bcss);
                    // $bcss = preg_replace(['(( )+})','(}( )+)','(;( )*})'], '}', $bcss);
                    // $bcss = preg_replace(['(;( )+)','(( )+;)'], ';', $bcss);
                    $filecache['css']= $bcss;
                }
                if ($extention=='js') {
                    $bjs = $filecache['js'].file_get_contents($key);
                    // $bjs = preg_replace("/((?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:\/\/.*))/", "", $bjs);
                    // $bjs = str_replace(["\r\n","\r","\t","\n",'  ','    ','     '], '', $bjs);
                    // $bjs = preg_replace(['(( )+\))','(\)( )+)'], ')', $bjs);
                    $filecache['js']=$bjs;
                }
            }
            if (array_key_exists($extention, $filecache)) {
                if ($filecache[$extention]!='') {
                    /*auto create path cache*/
                    if (!file_exists('./'.$pathcache)) {
                        mkdir('./'.$pathcache);
                    }
                    /*create file on path cache*/
                    $errormessage = "Unable to open file ".$extention." on ".$pathcache ."!";
                    $filename= $pathcache.'/'.md5($path).'.'.$extention;
                    $fw = fopen('./'.$filename, "w") or die($errormessage);
                    $txt = $filecache[$extention];
                    fwrite($fw, $txt);
                    fclose($fw);
                    /*write script on html*/
                    if ($extention=='css') {
                        echo '<link rel="stylesheet" type="text/css" href="'.base_url($filename).'">';
                    }
                    if ($extention=='js') {
                        echo '<script type="text/javascript" src="'.base_url($filename).'" ></script>';
                    }
                }
            }
        }
    }

    public function assetp($_sub_module="",$_filename="*",$extention=null){
        $filecache = array('css'=>'','js'=>'');
        // $path= FCPATH.'application/modules/'.$this->_module.'/views/'.$_sub_module.'/assets/';
		$path   = 'application/view/'.$_sub_module.'/assets/';
        $pathcache='cacheassets';
        /*detect path assets in modules*/
        if (file_exists($path)) {
            $path .=$_filename;
            /*list file path assets*/
            $list = glob('./'.$path.'.'.$extention, GLOB_BRACE);
            foreach ($list as $key) {
                /*open file content and minify sourcecode*/
                if ($extention=='css') {
                    $bcss = $filecache['css'].file_get_contents($key);
                    // $bcss = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $bcss);
                    // $bcss = str_replace(["\r\n","\r","\n","\t",'  ','    ','     '], '', $bcss);
                    // $bcss = preg_replace(['(( )+{)','({( )+)'], '{', $bcss);
                    // $bcss = preg_replace(['(( )+})','(}( )+)','(;( )*})'], '}', $bcss);
                    // $bcss = preg_replace(['(;( )+)','(( )+;)'], ';', $bcss);
                    $filecache['css']= $bcss;
                }
                if ($extention=='js') {
                    $bjs = $filecache['js'].file_get_contents($key);
                    // $bjs = preg_replace("/((?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:\/\/.*))/", "", $bjs);
                    // $bjs = str_replace(["\r\n","\r","\t","\n",'  ','    ','     '], '', $bjs);
                    // $bjs = preg_replace(['(( )+\))','(\)( )+)'], ')', $bjs);
                    $filecache['js']=$bjs;
                }
            }
            if (array_key_exists($extention, $filecache)) {
                if ($filecache[$extention]!='') {
                    /*auto create path cache*/
                    if (!file_exists('./'.$pathcache)) {
                        mkdir('./'.$pathcache);
                    }
                    /*create file on path cache*/
                    $errormessage = "Unable to open file ".$extention." on ".$pathcache ."!";
                    $filename= $pathcache.'/'.md5($path).'.'.$extention;
                    $fw = fopen('./'.$filename, "w") or die($errormessage);
                    $txt = $filecache[$extention];
                    fwrite($fw, $txt);
                    fclose($fw);
                    /*write script on html*/
                    if ($extention=='css') {
                        echo '<link rel="stylesheet" type="text/css" href="'.base_url($filename).'">';
                    }
                    if ($extention=='js') {
                        echo '<script type="text/javascript" src="'.base_url($filename).'" ></script>';
                    }
                }
            }
        }
    }
}
