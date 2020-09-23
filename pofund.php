
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style23 {color: #990000}
-->
</style>
</head>

<body>
<strong><span class="style23">Funds</span></strong><strong>
<select name="lstfund" id="lstfund"  onchange="submit()" >
  <option selected="selected"><?php echo $fund;?></option>
  <?php
	   
	   $sql1="select * from fund where year='$cyear' and grant_code='$titypecode' order by fund_code";
		  $result1=mysql_query($sql1) or die("Error in SQL");
		  while($row=mysql_fetch_array($result1))
		 {
 $fndcode=$row['fund_code'];
             echo '<option>'.$fndcode.'</option>' ;   
}
?>
</select>
<select name="lstfdept" id="lstfdept" onchange="submit()">
  <option selected="selected"><?php echo $funddept; ?></option>
  <?php
				
		////
		
		
 		
	$sql="select * from fund_detail where grant_code='$titypecode' and fund_code='$fund' and year='$cyear' and fac_code='$tfaccode' ";

$result=mysql_query($sql) or die("Mysql error2");
while ($row=mysql_fetch_array($result))
	   
	   {
			  
	  $tffaccode=$row['fac_code'];
	  $tfdeptcode=$row['dept_code'];
	  $tfprogcode=$row['prog_code'];
	  $tfamt=$row['amount'] ;
	
	  $tffac='';
	  $tfdept='';
	  $tfprog='';
	$sql1="select * from payroll_department_mfile where dep_code='$tffaccode'";
	$result1=mysql_query($sql1) or die("Mysql errorq");

	while ($row=mysql_fetch_array($result1))

	$tffac=$row['dep_name'] ;
	 
	///
	$sql1="select * from dept_masterfile where sec_code='$tfdeptcode'";
	$result1=mysql_query($sql1) or die("Mysql errorq");

	while ($row=mysql_fetch_array($result1))

	$tfdept=$row['sec_name'] ;

	///
	
	$sql1="select * from programme_masterfile where prog_code='$tfprogcode'";
	$result1=mysql_query($sql1) or die("Mysql errorq");

	while ($row=mysql_fetch_array($result1))

	$tfprog=$row['prog_name'] ;
		
///////////////////////////////////////////

$more=0;
$less=0;
////////////////////////////////////////////

$sql1="select sum(grnm_value_more) as tm, sum(grnm_value_less) as tl from grn_master where grnm_fund_code='$fund' and grnm_grant_code='$titypecode' and grnm_fund_yr='$cyear' and grnm_fund_fac='$tffaccode' and grnm_fund_dept='$tfdeptcode' and grnm_fund_prog='$tfprogcode' and (purchase_type_flag='PendingGRN' or purchase_type_flag='NormalGRN' or purchase_type_flag='ApprovedGRN' )";		
$result1=mysql_query($sql1) or die("Mysql error1q");
  
while ($row=mysql_fetch_array($result1))
	  {
	   $more=$row['tm'];
       $less=$row['tl'];
}

 //////
 
 
$sql1="select sum(fund_amount) as t from purch_ord_mas where fund_code='$fund' and item_type_code='$titypecode' and pom_acct_yr='$cyear' and fund_fac='$tffaccode' and fund_dept='$tfdeptcode' and fund_prog='$tfprogcode' and pom_cancel<>'Y' and (fund_avail='Y' or po_approved='Y')   and !(pom_po_no='$tn' and pom_acct_yr='$tyear')";		
$result1=mysql_query($sql1) or die("Mysql error1q");
  
while ($row=mysql_fetch_array($result1))
	   $ttotfnd=$row['t'];


     $tavailable = $tfamt + $less  - ($ttotfnd + $more) ;

	/////
	
	{

	if ($tffac<>'' and $tfprog<>'' and $tfdept<>'')
	if ($tavailable>0)
	echo '<option>'.$tffac.' | '.$tfdept.' | '.$tfprog.' | ('.number_format($tavailable,2).')'.'</option>' ;  
	else
	echo '<option>'.$tffac.' | '.$tfdept.' | '.$tfprog.'|      ***** ('.number_format($tavailable,2).')'.'</option>' ;  
	
	if ($tfprog=='' and $tfdept<>'' and $tffac<>'')
	if ($tavailable>0)
	echo '<option>'.$tffac.' | '.$tfdept.' | ('.number_format($tavailable,2).')'.'</option>' ;  
	else
	echo '<option>'.$tffac.' | '.$tfdept.' | '.'      *****  ('.number_format($tavailable,2).')'.'</option>' ;  
	  	
	if ($tfprog=='' and $tfdept=='' and $tffac<>'')
	if ($tavailable>0)
	echo '<option>'.$tffac.' | ('.number_format($tavailable,2).')'.'</option>' ;  
else
echo '<option>'.$tffac.' |    ***** ('.number_format($tavailable,2).')'.'</option>' ;  
	}

	}
	
	?>
</select>
<span style="color:#990000"><?php echo  ('Rs.  '. number_format((($totval+$freight + $insurance + $fother) * $terate),2)) ; ?></span></strong>
</body>
</html>
