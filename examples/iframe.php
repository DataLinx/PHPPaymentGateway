<HTML>
<HEAD>
	<meta http-equiv="content-type" content="text/html; charset=windows-1250; width=device-width; initial-scale=1.0"> 
	<TITLE>Test iframe - PHP:</TITLE>
</HEAD>
<BODY bgcolor="#aabbcc" width="100%">
<CENTER>
<P><h1>Test iframe - PHP:</h1></P>
<P>
	<iframe width="800px" height="800px" height="100%" src="<?php echo($_POST['TranType']. '.php'); ?>" frameborder="yes" scrolling="yes" name="myIframe" id="myIframe" style="background: red"> </iframe>

<script language="JavaScript">

function calcHeight()
{
  //find the height of the internal page
  var the_height=
    document.getElementById('myIframe').contentWindow.
      document.body.scrollHeight;

  //change the height of the iframe
  document.getElementById('myIframe').height=the_height;
}
calcHeight();

</script>

</CENTER>
</BODY>
</HTML>