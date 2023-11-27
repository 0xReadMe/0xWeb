<?php  
    function pack_php($file)  
    {  
        if (!file_exists($file) or !is_readable($file))  
        {  
            die('The file could not be found. Trying to hack yourself? 0_o');  
        }  
          
        $code = bzcompress('?>'. shell_exec('php -nw '. $file), 9);  
        $output_fname = dirname($file). '/'. basename($file, '.php'). '_bz.php';  
        $output = fopen($output_fname, 'w');  
          
        fputs($output, '<?php $f=fopen(__FILE__,\'r\');'.  
            'fseek($f,133);$c=\'\';'.  
            'while (!feof($f)){$c.=fread($f,1024);}'.  
            'eval(bzdecompress($c));'.  
            '__halt_compiler(); ?>'. "\n". chr(0));  
        fputs($output, $code);  
        fclose($output);  
        chmod($output_fname, 0777);  
          
        echo "done.\n";  
        $before = filesize($file);  
        $after = filesize($output_fname);  
        echo '> Before compress : '. ($before / 1024). " Kb\n";  
        echo '> After compress  : '. ($after / 1024). " Kb\n";  
        echo '> Compress ratio  : '. (($before - $after) * 100) / $before. "%\n";  
    }  
	
	pack_php('./crookedmirror.php');
?>