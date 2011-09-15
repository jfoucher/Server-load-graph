<?php

define('SERVER','localhost');
define('USER','user');
define('PASSWORD','pass');
define('DATABASE','db');
define('TABLE','table');


$c=mysql_connect(SERVER,USER,PASSWORD);
mysql_select_db(DATABASE);

if($_GET['savetodb'] || $argv[1]=='savetodb'){

	$loads = sys_getloadavg();

	print_r($loads);

	$q= "INSERT INTO `".DATABASE."`.`".TABLE."` (`timestamp`, `load1`, `load5`, `load15`) 
		VALUES ( CURRENT_TIMESTAMP, '".$loads[0]."', '".$loads[1]."', '".$loads[2]."');";

	mysql_query($q); 
}else{

	$q= "SELECT * FROM `".DATABASE."`.`".TABLE."`;";

	$r=mysql_query($q); 
	$data='';
	while ($row = mysql_fetch_object($r)){

		list($date,$time)=explode(' ',$row->timestamp);
		list($y,$m,$d)=explode('-',$date);
		list($h,$i,$s)=explode(':',$time);
		$load1=$row->load1;
		$load5=$row->load5;
		$load15=$row->load15;
		$data.="{c:[{v: new Date($y, $m, $d,$h,$i,$s)}, {v: $load1}, {v: $load5}, {v: $load15}]},";
	}
	//generate and show graph

	?>
	<html>
	<head>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	    <script type="text/javascript">
	    
	      // Load the Visualization API and the piechart package.
	      google.load('visualization', '1.0', {'packages':['corechart','annotatedtimeline','table']});
	      
	      // Set a callback to run when the Google Visualization API is loaded.
	      google.setOnLoadCallback(drawChart);



	function drawChart() {

	   var data = new google.visualization.DataTable(
	   {
	     cols: [{id: 'date', label: 'Date', type: 'date'},
		    {id: 'load1', label: 'Load 1 min', type: 'number'},
			{id: 'load5min', label: 'Load 5 min', type: 'number'},
			{id: 'load15min', label: 'Load 15 min', type: 'number'}],
	     rows: [
		    <?php echo $data ?>
		   ]
	   }
	) 

	var options = {'title':'15 minutes load xiilo.com',
		             'width':400,'displayAnnotations': true,
		             'height':300};

	 
	  var annotatedtimeline = new google.visualization.AnnotatedTimeLine(
	      document.getElementById('visualization'));
	  annotatedtimeline.draw(data, options);
	}
	</script>
	</head>
	<body>
	<div id="visualization" style="width:600px;height:400px;margin:0 auto"></div>
	</body>
	</html>
<?php
}
