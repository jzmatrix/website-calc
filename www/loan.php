<form method='post' action='loan.php'>
	<table>
		<tr><td>Purchase Price:</td><td><input type='text' name='principal' size='20'></td></tr>
		<tr><td>Down Payment:</td><td><input type='text' name='dpwm' size='20'></td></tr>
		<tr><td colspan='2'><center><input type='submit' value='Build Payment Table'></center></td></tr>
	</table>
</form>
<?
	$principal = $_POST{'principal'};;
	print "Loan Calculator :: $principal\n";
	$downPayment = 0;
	$loanTerms = 72;
?>
<table>
	<tr>
		<td><center><strong>Credit<br>Rating</strong></center></td>
		<td><center><strong>Interest<br>Rate</strong></center></td>
		<td><center><strong></strong></center></td>
	</tr>
	<?
	for ($x = .03;$x<=.10;$x = $x + .005)
	{
		$payment = ($principal * ( $x / 12)) / ( 1- ( 1 + $x/ 12 )**$loanTerms);
		# $payment = $principal * 
	?>
	<tr>
	<td></td>
	<td><? print $x*100 + '%';?></td>
	<td><? print $payment;?></td>
	</tr>
	<?
	}
	?>
</table>



<!-- 
A = P ∗ ( r ( 1 + r ) n ) / ( ( 1 + r ) n − 1 )

A = Monthly Payment
P = 70000
r = Interest Rate / 12
n = Term of loan
-->