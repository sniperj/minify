<?php 
/*!
 * cssmin.php 2.4.8-2
 * Author: Tubal Martin - http://tubalmartin.me/
 * Repo: https://github.com/tubalmartin/YUI-CSS-compressor-PHP-port
 *
 * This is a PHP port of the CSS minification tool distributed with YUICompressor,
 * itself a port of the cssmin utility by Isaac Schlueter - http://foohack.com/
 * Permission is hereby granted to use the PHP version under the same
 * conditions as the YUICompressor.
 *----------------------------------------------------
 *   PHP 5 or higher is required.
 *
 * Permission is hereby granted to use this version of the software  with following license:
 *
 * --
 * Copyright (c) 2015 Sean Johnson  sojoliver@yahoo.com
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies
 * of the Software, and to permit persons to whom the Software is furnished to do
 * so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * The Software shall be used for Good, not Evil.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 * --

 * @Author: Sean Johnson <sojoliver@yahoo.com>
 * @package minCssAndJs
 * @copyright 2015 Sean Johnson <sojoliver@yahoo.com> 
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */

require_once('JSMin.php') ; 
require_once('CSSMin.php') ; 


class minify
{

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
				        		$this::minifyJsAndCss($folderName.'/'.$entry);
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
				        			$this::createFile($folderName, $filename, $minJs);	
			        			}

			        		}	
			        		elseif(strripos($entry, '.css')>0 )
			        		{
			        			if(is_null(strripos($entry, 'min.css')) || strripos($entry, 'min.css')=='')
			        			{
				        			$css 		= file_get_contents($folderName.'/'.$entry);
				        			$minCss 	= $cssMin->run($css );
				        			$filename 	= str_replace('.css', $fileSuffix.'.css', $entry) ; 
				        			$this::createFile($folderName, $filename, $minCss);			        				
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

}



  
