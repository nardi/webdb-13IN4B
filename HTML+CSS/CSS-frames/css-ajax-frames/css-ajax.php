<?php 
//include common constants and functions
include_once 'common.inc.php';

//define default pages for all target divs
$content1 = (isset($_GET['content1']))? ($_GET['content1']) :('pagina1.tpl') ;
$content2 = (isset($_GET['content2']))? ($_GET['content2']) :('pagina2.tpl')  ;
?>
<?php echo '<?xml version="1.0"?>' ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
   <title>CSS-ajax-frames</title>
   <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	 <script type="text/javascript" src="js/taconite-client.js"></script>
	 <script type="text/javascript" src="js/taconite-parser.js"></script>
	 <script type="text/javascript">
	 
	  //tell javascript ids of fillable elements
		var elementid = new Array();
		elementid[1] = 'content1';
		elementid[2] = 'content2';
		
		//javascript vars to store the state of the page
		//which file is loaded into which element?
		var filename = new Array();
		filename[1] = '<?php echo $content1; ?>'; 
		filename[2] = '<?php echo $content2; ?>';
		
		//fill an element with a file by taconite
		//eindex: indexposition of element in array
		//file:   name of the file to load by taconite 
	 	function fill(eindex, file) {
			var arq = new AjaxRequest(
				"taconiteserver.php?elementid="+elementid[eindex]+"&filename="+file
				);
			arq.sendRequest();
			filename[eindex] = file;
			return false; //cancel the link-click
		}
		
		//show a real url for bookmarking in location bar
		function realurl() {
			var baseurl = '<?php $_SERVER['PHP_SELF']; ?>';
			window.location.replace(baseurl+'?content1='+filename[1]+'&content2='+filename[2]);
		}
		
		//show links to real url only if javascript is on
		//(called by body: onload)
		function showlinkstorealurl() {
			document.getElementById('hidden1').style.visibility='visible';
			document.getElementById('hidden2').style.visibility='visible';
		}
	 </script>
	 <style type="text/css">
	  #leftcolumn {position:absolute; width:50%; left: 0%;}
	  #rightcolumn {position:absolute; width:50%; left: 50%;}
		.tabcontrol {position:relative; width: 96%; left: 2%; height: 15em; 
			border-style: groove; overflow: auto;
		} 
		.tabs {background-color: Silver}
		.content {padding: 1em;}
		.hidden {visibility: hidden} 
	 </style>

</head>

<body onload="showlinkstorealurl();">

<div id="leftcolumn">

<h1>CSS-ajax-frames</h1>

<div id="tabcontrol1" class="tabcontrol">
	<div id="tabs1" class="tabs">
		<a href="index.php?content1=pagina1.tpl&content2=<?php echo $content2; ?>" 
            onclick="return fill(1, 'pagina1.tpl');">
            pagina 1</a>&nbsp;
		<a href="index.php?content1=pagina3.tpl&content2=<?php echo $content2; ?>" 
            onclick="return fill(1, 'pagina3.tpl');">
            pagina 3</a>&nbsp;
		&nbsp;&nbsp;
		<a href="javascript:realurl()" id="hidden1" class="hidden"
			 title="show real url in location bar for bookmarking">show real url</a>
	</div>
	<div id="content1" class="content">
        <?php include common_checkFilename($content1); ?>
	</div>
</div>

<div id="vast1" class="vast">
test... test... test... test... test... test... test... test... test... test... 
test... test... test... test... test... test... test... test... test... test... 
test... test... test... test... test... test... test... test... test... test... 
test... test... test... test... test... test... test... test... test... test... 
test... test... test... test... test... test... test... test... test... test... 
test... test... test... test... test... test... test... test... test... test... 
test... test... test... test... test... test... test... test... test... test... 
test... test... test... test... test... test... test... test... test... test... 
test... test... test... test... test... test... test... test... test... test... 
test... test... test... test... test... test... test... test... test... test... 
test... test... test... test... test... test... test... test... test... test... 
test... test... test... test... test... test... test... test... test... test... 
test... test... test... test... test... test... test... test... test... test... 
test... test... test... test... test... test... test... test... test... test... 
test... test... test... test... test... test... test... test... test... test... 
test... test... test... test... test... test... test... test... test... test... 
test... test... test... test... test... test... test... test... test... test... 
test... test... test... test... test... test... test... test... test... test... 
test... test... test... test... test... test... test... test... test... test... 
test... test... test... test... test... test... test... test... test... test... 
</div>

<!-- end leftcolumn -->
</div>

<div id="rightcolumn">

<div id="vast2" class="vast">
brom... brom... brom... brom... brom... brom... brom... brom... brom... brom... 
brom... brom... brom... brom... brom... brom... brom... brom... brom... brom... 
brom... brom... brom... brom... brom... brom... brom... brom... brom... brom... 
brom... brom... brom... brom... brom... brom... brom... brom... brom... brom... 
brom... brom... brom... brom... brom... brom... brom... brom... brom... brom... 
brom... brom... brom... brom... brom... brom... brom... brom... brom... brom... 
brom... brom... brom... brom... brom... brom... brom... brom... brom... brom... 
brom... brom... brom... brom... brom... brom... brom... brom... brom... brom... 
brom... brom... brom... brom... brom... brom... brom... brom... brom... brom... 
brom... brom... brom... brom... brom... brom... brom... brom... brom... brom... 
brom... brom... brom... brom... brom... brom... brom... brom... brom... brom... 
brom... brom... brom... brom... brom... brom... brom... brom... brom... brom... 
brom... brom... brom... brom... brom... brom... brom... brom... brom... brom... 
brom... brom... brom... brom... brom... brom... brom... brom... brom... brom... 
brom... brom... brom... brom... brom... brom... brom... brom... brom... brom... 
brom... brom... brom... brom... brom... brom... brom... brom... brom... brom... 
brom... brom... brom... brom... brom... brom... brom... brom... brom... brom... 
brom... brom... brom... brom... brom... brom... brom... brom... brom... brom... 
brom... brom... brom... brom... brom... brom... brom... brom... brom... brom... 
brom... brom... brom... brom... brom... brom... brom... brom... brom... brom... 
brom... brom... brom... brom... brom... brom... brom... brom... brom... brom... 
brom... brom... brom... brom... brom... brom... brom... brom... brom... brom... 
brom... brom... brom... brom... brom... brom... brom... brom... brom... brom... 
</div>

<div id="tabcontrol2" class="tabcontrol">
	<div id="tabs2" class="tabs">
		<a href="index.php?content2=pagina2.tpl&content1=<?php echo $content1; ?>" 
            onclick="return fill(2, 'pagina2.tpl');">
            pagina 2</a>&nbsp;
		<a href="index.php?content2=pagina4.tpl&content1=<?php echo $content1; ?>" 
            onclick="return fill(2, 'pagina4.tpl');">
            pagina 4</a>&nbsp;
		&nbsp;&nbsp;
		<a href="javascript:realurl()" id="hidden2" class="hidden"
			 title="show real url in location bar for bookmarking">show real url</a>
	</div>
	<div id="content2" class="content">
        <?php include common_checkFilename($content2); ?>
	</div>
</div>

<!-- end rightcolumn -->
</div>

</body>

</html>