<?php
error_reporting(E_ALL ^ E_NOTICE);
	include_once("Include_GetString.php") ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>
      <?php echo GetString("NetSpell") ; ?> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
      &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
      &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
      &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
      &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
      &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
    </title>

    <meta name="content-type" content="text/html ;charset=Unicode" />
    <meta http-equiv="Page-Enter" content="blendTrans(Duration=0.1)" />
    <meta http-equiv="Page-Exit" content="blendTrans(Duration=0.1)" />
		<link href="../Themes/<?php echo $Theme; ?>/dialog.css" type="text/css" rel="stylesheet" />
    <!--[if IE]>
			<link href="../Style/IE.css" type="text/css" rel="stylesheet" />
		<![endif]-->
    <script type="text/javascript" src="../Scripts/Dialog/DialogHead.js"></script>
    <script type="text/javascript" src="spellerpages/spellChecker.js"></script>
    <script type="text/javascript">

      var editor=Window_GetDialogArguments(window);

      window.onload = function()
      {
      document.getElementById('txtHtml').value = editor.getHTML();

      var speller = new spellChecker( document.getElementById('txtHtml') ) ;
      speller.spellCheckScript = 'server-scripts/spellchecker.php' ;
      speller.OnFinished = speller_OnFinished ;
      speller.openChecker() ;
      }

      function speller_OnFinished( numberOCorrections )
      {
      if ( numberOCorrections > 0 )
      editor.setHTML( document.getElementById('txtHtml').value ) ;
      do_Close();
      }
      function do_Close()
      {
      Window_CloseDialog(window);
      }
    </script>
  </head>
  <body>
    <input type="hidden" id="txtHtml" value="">
      <iframe id="spellchecker" src="spellerpages/blank.html" name="spellchecker" width="100%" height="100%" frameborder="0"></iframe>
    </body>
  <script type="text/javascript" src="../Scripts/Dialog/DialogFoot.js"></script>
</html>
