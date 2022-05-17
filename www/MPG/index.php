<?
	###############
	require_once("db.php");
	###############
	session_start();
	$sessID = session_id();
	$carKey = $_SESSION{'carKey'};
	$carName = $_SESSION{'carName'};
	# print "<P>SESS :: $sessID :: $carKey :: $carName\n";
?>
<html>
    <head>
        <title>MPG Calculator</title>
    </head>
    <body>
        <center><h1 style="font-size:10vw">MPG Calculator</h1></center>
        <center><small><a href='/'>BACK</a></small></center>
		<center><small><a href='createCar.php'>Create Car</a></small> | <a href='selectCar.php'>Select Car</a></center>
		<?
		if ($carKey)
		{
			print "<center><small><b>Current Car: </b>$carName</small></center>\n";
			print "<center><small><a href='fillup.php'>Add Fill Up</a></small></center>\n";
		}
		?>
		<table align='center' border='1'>
			<tr>
				<td><center><strong>Fill Date</td>
				<td><center><strong>Odometer</td>
				<td><center><strong>Gallons</td>
				<td><center><strong>Price/Gallon</td>
				<td><center><strong>Traveled</td>
				<td><center><strong>MPG</td>
			</tr>
			<?
				$sql = "SELECT fillDate, fillMiles, fillGallons, fillPrice FROM calcData.mpgData WHERE carKey = '$carKey' ORDER BY fillDate";
				do_sql($sql);
				get_rows();
				$cc = 0;
				for ($x = 0;$x<=$rc;$x++)
				{
					$x2 = $x - 1;
					if ($x > 0) { $prevMiles = $dbd[$x2]['fillMiles']; } else {$prevMiles = 0;}
					$fillDate = $dbd[$x]['fillDate'];
					$fillMiles = $dbd[$x]['fillMiles'];
					$fillGallons = $dbd[$x]['fillGallons'];
					$fillPrice = sprintf('$%7.2f',$dbd[$x]['fillPrice']);
					#######
					if ($prevMiles)
					{
						$tankDistance = $fillMiles - $prevMiles;
						$mpgValue = $tankDistance / $fillGallons;
					}

					# $paymentPrint = sprintf('$%7.2f', $monthlyPayment);
					if ($fillDate)
					{
						$cc = $cc + 1;
						$bg = "#FFFFFF";
						if (($cc % 2) == 0){$bg = "#00FFFF";}
						?>
						<tr>
							<td bgcolor='<? echo $bg;?>'><? echo $fillDate;?></td>
							<td bgcolor='<? echo $bg;?>' align='right'><? echo $fillMiles;?></td>
							<td bgcolor='<? echo $bg;?>' align='right'><? echo $fillGallons;?></td>
							<td bgcolor='<? echo $bg;?>' align='right'><? echo $fillPrice;?></td>
							<td bgcolor='<? echo $bg;?>' align='right'><? echo $tankDistance;?></td>
							<td bgcolor='<? echo $bg;?>'><? if ($mpgValue) { echo sprintf('%4.2f',$mpgValue); }?></td>

						</tr>
						<?
					}
				}
			?>
		</table>
	</body>
</html>