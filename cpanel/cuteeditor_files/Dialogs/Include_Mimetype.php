<?php	
error_reporting(E_ALL ^ E_NOTICE);

   function FindType($ext) {    
      $mimetypes = BuildMimeArray(); 
      $ext=strtolower($ext);
      // return mime type for extension 
      if (isset($mimetypes[$ext])) { 
         return $mimetypes[$ext];          
      } else { 
         return 'ee'; 
      }           
   }  
   
   function FindType2($ext) {    
      $mimetypes = BuildMimeArray2(); 
      // return mime type for extension 
      if (isset($mimetypes[$ext])) { 
         return $mimetypes[$ext];          
      } else { 
         return 'ee'; 
      }           
   } 
  function GetExtension($str_FileName)
  {
	  return ".".substr(strrchr($str_FileName, '.'), 1);
  } 
  
  function GetMaxSize($max_size)
  {	  
    if (!is_numeric($max_size)) {
        if (strpos($max_size, 'M') !== false)
            $max_size = intval($max_size)*1024*1024;
        elseif (strpos($max_size, 'K') !== false)
            $max_size = intval($max_size)*1024;
        elseif (strpos($max_size, 'G') !== false)
            $max_size = intval($max_size)*1024*1024*1024;
    }
    return $max_size;
  }


   function BuildMimeArray() { 
      return array( 
         ".ez" => "application/andrew-inset", 
         ".hqx" => "application/mac-binhex40", 
         ".cpt" => "application/mac-compactpro", 
         ".doc" => "application/msword", 
         ".bin" => "application/octet-stream", 
         ".dms" => "application/octet-stream", 
         ".lha" => "application/octet-stream", 
         ".lzh" => "application/octet-stream", 
         ".exe" => "application/octet-stream", 
         ".class" => "application/octet-stream", 
         ".so" => "application/octet-stream", 
         ".dll" => "application/octet-stream", 
         ".oda" => "application/oda", 
         ".pdf" => "application/pdf", 
         ".ai" => "application/postscript", 
         ".eps" => "application/postscript", 
         ".ps" => "application/postscript", 
         ".smi" => "application/smil", 
         ".smil" => "application/smil", 
         ".wbxml" => "application/vnd.wap.wbxml", 
         ".wmlc" => "application/vnd.wap.wmlc", 
         ".wmlsc" => "application/vnd.wap.wmlscriptc", 
         ".bcpio" => "application/x-bcpio", 
         ".vcd" => "application/x-cdlink", 
         ".pgn" => "application/x-chess-pgn", 
         ".cpio" => "application/x-cpio", 
         ".csh" => "application/x-csh", 
         ".dcr" => "application/x-director", 
         ".dir" => "application/x-director", 
         ".dxr" => "application/x-director", 
         ".dvi" => "application/x-dvi", 
         ".spl" => "application/x-futuresplash", 
         ".gtar" => "application/x-gtar", 
         ".hdf" => "application/x-hdf", 
         ".js" => "application/x-javascript", 
         ".skp" => "application/x-koan", 
         ".skd" => "application/x-koan", 
         ".skt" => "application/x-koan", 
         ".skm" => "application/x-koan", 
         ".latex" => "application/x-latex", 
         ".nc" => "application/x-netcdf", 
         ".cdf" => "application/x-netcdf", 
         ".sh" => "application/x-sh", 
         ".shar" => "application/x-shar", 
         ".swf" => "application/x-shockwave-flash", 
         ".sit" => "application/x-stuffit", 
         ".sv4cpio" => "application/x-sv4cpio", 
         ".sv4crc" => "application/x-sv4crc", 
         ".tar" => "application/x-tar", 
         ".tcl" => "application/x-tcl", 
         ".tex" => "application/x-tex", 
         ".texinfo" => "application/x-texinfo", 
         ".texi" => "application/x-texinfo", 
         ".t" => "application/x-troff", 
         ".tr" => "application/x-troff", 
         ".roff" => "application/x-troff", 
         ".man" => "application/x-troff-man", 
         ".me" => "application/x-troff-me", 
         ".ms" => "application/x-troff-ms", 
         ".ustar" => "application/x-ustar", 
         ".src" => "application/x-wais-source", 
         ".xhtml" => "application/xhtml+xml", 
         ".xht" => "application/xhtml+xml", 
         ".zip" => "application/zip", 
         ".au" => "audio/basic", 
         ".snd" => "audio/basic", 
         ".mid" => "audio/midi", 
         ".midi" => "audio/midi", 
         ".kar" => "audio/midi", 
         ".mpga" => "audio/mpeg", 
         ".mp2" => "audio/mpeg", 
         ".mp3" => "audio/mpeg", 
         ".aif" => "audio/x-aiff", 
         ".aiff" => "audio/x-aiff", 
         ".aifc" => "audio/x-aiff", 
         ".m3u" => "audio/x-mpegurl", 
         ".ram" => "audio/x-pn-realaudio", 
         ".rm" => "audio/x-pn-realaudio", 
         ".rpm" => "audio/x-pn-realaudio-plugin", 
         ".ra" => "audio/x-realaudio", 
         ".wav" => "audio/x-wav", 
         ".pdb" => "chemical/x-pdb", 
         ".xyz" => "chemical/x-xyz", 
         ".bmp" => "image/bmp", 
         ".gif" => "image/gif", 
         ".ief" => "image/ief", 
         ".jpeg" => "image/jpeg", 
         ".jpg" => "image/jpeg", 
         ".jpe" => "image/jpeg", 
         ".png" => "image/x-png", 
         ".tiff" => "image/tiff", 
         ".tif" => "image/tiff", 
         ".djvu" => "image/vnd.djvu", 
         ".djv" => "image/vnd.djvu", 
         ".wbmp" => "image/vnd.wap.wbmp", 
         ".ras" => "image/x-cmu-raster", 
         ".pnm" => "image/x-portable-anymap", 
         ".pbm" => "image/x-portable-bitmap", 
         ".pgm" => "image/x-portable-graymap", 
         ".ppm" => "image/x-portable-pixmap", 
         ".rgb" => "image/x-rgb", 
         ".xbm" => "image/x-xbitmap", 
         ".xpm" => "image/x-xpixmap", 
         ".xwd" => "image/x-windowdump", 
         ".igs" => "model/iges", 
         ".iges" => "model/iges", 
         ".msh" => "model/mesh", 
         ".mesh" => "model/mesh", 
         ".silo" => "model/mesh", 
         ".wrl" => "model/vrml", 
         ".vrml" => "model/vrml", 
         ".css" => "text/css", 
         ".html" => "text/html", 
         ".htm" => "text/html", 
         ".asc" => "text/plain", 
         ".txt" => "text/plain", 
         ".rtx" => "text/richtext", 
         ".rtf" => "text/rtf", 
         ".sgml" => "text/sgml", 
         ".sgm" => "text/sgml", 
         ".tsv" => "text/tab-seperated-values", 
         ".wml" => "text/vnd.wap.wml", 
         ".wmls" => "text/vnd.wap.wmlscript", 
         ".etx" => "text/x-setext", 
         ".xml" => "text/xml", 
         ".xsl" => "text/xml", 
         ".mpeg" => "video/mpeg", 
         ".mpg" => "video/mpeg", 
         ".mpe" => "video/mpeg", 
         ".qt" => "video/quicktime", 
         ".mov" => "video/quicktime", 
         ".wmv" => "video/x-ms-wmv", 
         ".mxu" => "video/vnd.mpegurl", 
         ".avi" => "video/x-msvideo", 
         ".movie" => "video/x-sgi-movie", 
         ".flv" => "application/octet-stream", 
         ".ice" => "x-conference-xcooltalk" 
      ); 
   } 
   
   function BuildMimeArray2() { 
      return array( 
         ".zip" => "application/octet-stream"
      ); 
   } 

	function upload_translate_datatype($str_datatype)
	{
		$old_type=$str_datatype;
		preg_match('#image\/[x\-]*([a-z]+)#', $str_datatype, $str_datatype);
		$str_datatype = $str_datatype[1];

		$str_type = "";
		switch($str_datatype)
		{
			case 'jpeg':
			case 'pjpeg':
			case 'jpg':
				$str_type = "image/jpeg";
				break;
			case 'tif':
			case 'tiff':
				$str_type = "image/tiff";
			case 'gif':
				$str_type = "image/gif";
				break;
			case 'png':
				$str_type = "image/x-png";
				break;
			default:
				$str_type = $old_type;
				break;
		}

		return $str_type;
	}
?>