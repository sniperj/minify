<?php error_reporting(E_ERROR);

require_once('JSMin.php') ; 
require_once('CSSMin.php') ; 


echo minifyJsAndCss() ;

	function minifyJsAndCss($folderName='.')
	{	
		$fileSuffix = '.min';
		$jsMin 		= new JSMin ; 
		$cssMin 	= new CSSmin ; 
		/*
			retrieve a list of files.
		*/
		if ($handle = opendir($folderName)) 
		{	
		    while (false !== ($entry = readdir($handle))) 
		    {
				
		        if ($entry != "." && $entry != ".." )
		        {
			        if(is_dir( realpath($folderName.'/'.$entry)))
			       	{
			        		minifyJsAndCss($folderName.'/'.$entry);
			       	}
			       	else 
			       	{
						if(strripos($entry, '.js')>0)
						{
		        			if(is_null(strripos($entry, 'min.js')) || strripos($entry, 'min.js')=='')
		        			{					
			        			$js 		= file_get_contents($folderName.'/'.$entry);
			        			$minJs 		= $jsMin->minify($js);
			        			$filename 	= str_replace('.js', $fileSuffix.'.js', $entry) ; 
			        			createFile($folderName, $filename, $minJs);	
		        			}

		        		}	
		        		elseif(strripos($entry, '.css')>0 )
		        		{
		        			if(is_null(strripos($entry, 'min.css')) || strripos($entry, 'min.css')=='')
		        			{
			        			$css 		= file_get_contents($folderName.'/'.$entry);
			        			$minCss 	= $cssMin->run($css );
			        			$filename 	= str_replace('.css', $fileSuffix.'.css', $entry) ; 
			        			createFile($folderName, $filename, $minCss);			        				
		        			}	

		        		}			       		
			       	}	

		        }

		   }

		    closedir($handle);
		}	
	}

    function createFile($path, $filename, $content)
    {
            $myFile = fopen($path.'/'.$filename,'w');//Open the file for writing

            fputs($myFile, $content);// Write the data ($string) to the text file
            fclose($myFile);// Closing the file after writing data to it
    }

  
?>