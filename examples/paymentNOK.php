<HTML>
<HEAD>
<TITLE>Račun o plačilu</TITLE>
</HEAD>
<BODY bgcolor="#CCAACC">
<center><h1>Račun o plačilu</h1>
	<FONT size="5" color="RED">
		Transakcija ni uspela. Prosim poizkusite ponovno.<BR>
    </FONT>
</center>	
	<BR><BR>
	<FONT size="3" color="BLACK">
	
	<pre>
	<?php
	$buf = extract($_GET);
	if(isset($buf) and $buf != ""){
		print_r($_GET);
	}
	?>
	</pre>
	<BR><BR>

	</FONT>
	<center>
<p>Copyright Bankart d.o.o.</p>
</center>
</BODY>
</HTML>