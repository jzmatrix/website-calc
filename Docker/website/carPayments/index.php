<?
	$printMode = $_POST{'print'};
	$listMode = $_POST{'list'};
?>
<html>
    <head>
        <title>Monthly Payment Calculator</title>
    </head>
    <body>
		<?
			if (!isset($printMode))
			{
		?>
        <center><h1>Monthly Payment Calculator</h1></center>
        <center><small><a href='/'>BACK</a></small></center>
        <form method='POST' action='.'>
            <table align='center' border='0'>
                <tr><td>Purchase Price:</td><td><input type='text' name='cost' size='5' value='<? echo $_POST{'cost'};?>'></td></tr>
                <tr><td>Min APR:</td><td><select name='minAPR'>
                    <?
						if (isset($_POST{'minAPR'}))
						{
							$minAPR = $_POST{'minAPR'};
						}
						else
						{
							$minAPR = .05;
						}
                        for ($x = 0.00;$x<=0.15;$x = $x + .005)
                        {
                            print "<option value='$x'";
                            if ($minAPR == "$x"){print " selected ";}
                            print ">" . $x * 100 ."%</option>\n";
                        }
                    ?>
                </select></td></tr>
                <tr><td>Max APR:</td><td><select name='maxAPR'>
                    <?
						if (isset($_POST{'maxAPR'}))
						{
							$maxAPR = $_POST{'maxAPR'};
						}
						else
						{
							$maxAPR = .05;
						}
                        for ($x = 0.00;$x<=0.15;$x = $x + .005)
                        {
                            print "<option value='$x'";
                            if ($maxAPR == "$x"){print " selected ";}
                            print ">" . $x * 100 ."%</option>\n";
                        }
                    ?>
                </select></td></tr>
                <tr><td>Months:</td><td>
                    <input type='checkbox' name='3month' value='1' <? if ($_POST{'3month'}){ print " checked ";} ?>> - 3&nbsp;
                    <input type='checkbox' name='4month' value='1' <? if ($_POST{'4month'}){ print " checked ";} ?>> - 4&nbsp;
                    <input type='checkbox' name='5month' value='1' <? if ($_POST{'5month'}){ print " checked ";} ?>> - 5&nbsp;
                    <input type='checkbox' name='6month' value='1' <? if ($_POST{'6month'}){ print " checked ";} ?>> - 6&nbsp;
                    <input type='checkbox' name='7month' value='1' <? if ($_POST{'7month'}){ print " checked ";} ?>> - 7&nbsp;
                </td></tr>
				<tr><td>Sweet Spot:</td><td>$<input type='text' name='sweet' size='5' value='<? echo $_POST{'sweet'};?>'></td></tr>
				<tr><td colspan='2'><center>Print Mode: <input type='checkbox' value='1' name='print' <? if ($printMode){print " checked ";} ?>> | List Mode: <input type='checkbox' value='1' name='list' <? if ($listMode){print " checked ";} ?>></center></td></tr>
                <tr><td colspan='2'><center><input type='submit' value='Build Payment Table'></center></td></tr>
            </table>
        </form>
        <?
			}
            if (isset($_POST{'cost'}))
            {
				if ($_POST{'3month'} == 1) { $monthList[] = 3 * 12; }
				if ($_POST{'4month'} == 1) { $monthList[] = 4 * 12; }
				if ($_POST{'5month'} == 1) { $monthList[] = 5 * 12; }
				if ($_POST{'6month'} == 1) { $monthList[] = 6 * 12; }
				if ($_POST{'7month'} == 1) { $monthList[] = 7 * 12; }
				#######
				$cost = $_POST{'cost'};
				$minAPR = $_POST{'minAPR'};
				$maxAPR = $_POST{'maxAPR'};
				$sweetSpot = $_POST{'sweet'};
				#######
				$tc = 0;
				$maxCol = 3;
				#######
				print "<table align='center' border='1'>\n";
				print "<tr><td colspan='$maxCol'><center>Cost: <b>\$$cost</b></center></td></tr>\n";
				print "<tr>\n";
				for ($interestRate = $minAPR;$interestRate <= $maxAPR; $interestRate = $interestRate + .005)
				{
					$tc ++;
					print "<td>";
					buildTable($interestRate);
					print "</td>";
                	# print "<td>DO IT :: $interestRate :: $tc</td>\n";
					if ((($tc % 3) == 0) || (isset($listMode))){ print "</tr><tr>";}
				}
				print "</tr></table>\n";
            }
        ?>
    </body>
</html>
<?
################################################################################
function buildTable($interestRate)
{     
	global $monthList, $cost, $sweetSpot;
	# print "<p>BUILD :: $interestRate\n";
    ?>
    <table align='center' border='0'>
        <tr>
            <td width='60'><center><strong>Rate</strong></center></td>
            <td width='50'><center><strong>Term</strong></center></td>
            <td width='100'><center><strong>Monthly</strong></center></td>
			<td width='100'><center><strong>Total</strong></center></td>
			<td width='100'><center><strong>Excess</strong></center></td>
		</tr>
		<tr height='2'><td colspan='5' height='2' bgcolor='#000000'></td></tr>
		<?
		$rc = 0;
		foreach ($monthList as $month)
		{
			$interestPrint = sprintf("%.1f",$interestRate * 100);
			######
			$rc ++;
			$bg = "#FFFFFF";
			if (($rc % 2) == 0) { $bg = "00FFFF";}
			#######
			$monthlyPayment = calcPayment($interestRate, $month, $cost);
			$paymentPrint = sprintf('$%7.2f', $monthlyPayment);
			#######
			$totalPaid = $monthlyPayment * $month;
			$totalPaid_DIS = sprintf('$%7.2f',$totalPaid);
			$excessAmount = sprintf('$%7.2f',$totalPaid - $cost);
			#######
			if (isset($sweetSpot))
			{
				if ($monthlyPayment <= $sweetSpot) { $bg = "#00FF00"; }
			}
			#######
			print "<tr><td bgcolor='$bg'>$interestPrint%</td><td align='right' bgcolor='$bg'>$month</td><td  bgcolor='$bg' align='right'>$paymentPrint</td><td  bgcolor='$bg' align='right'>$totalPaid_DIS</td><td  bgcolor='$bg' align='right'>$excessAmount</td></tr>\n";
		}
		?>
		<tr height='2'><td colspan='5' height='2' bgcolor='#000000'></td></tr>
	</table>
		<?
}
################################################################################
function calcPayment ($interestRate,$month, $purchasePrice)
{
	if ($interestRate)
	{
		$annualAPR = 1+($interestRate / 12);
		$topFormula = (($annualAPR-1)*($annualAPR)**$month);
		$bottomFormula = ((($annualAPR)**$month)-1);
		##########
		#print "<p>annualAPR :: $annualAPR\n";
		#print "<p>TOP :: $topFormula\n";
		#print "<P>BOT :: $bottomFormula\n";
		##########
		$monthlyPayment = sprintf("%.2f",$purchasePrice * ($topFormula / $bottomFormula));
	}
	else
	{
		$monthlyPayment = $purchasePrice / $month;
	}
	##########
	return $monthlyPayment;
}
################################################################################
?>