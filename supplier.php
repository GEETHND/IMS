<?php 
session_start();
include("db.inc.php");

extract($_POST);
$tcurrentdate= $_SESSION["currentdate"];
$tdatetime=strftime("%Y-%m-%d %H:%M:%S");


$i=0;

$maxno=0;
$tdate=strftime("%d/%m/%Y");
$tdateArr =explode('/',$tdate);
$tdatetime=strftime("%Y-%m-%d %H:%M:%S");
$supcode1=$_REQUEST['txtSupCode'];
$chk1 = $_POST["chk1"];
$how_many = count($chk1); 



if (isset($_POST['btnSave']) || $_POST['btnSave']=="Save")
{
	if ($txtZip=='' || $txtZip=='null')
	{
		$txtZip='null';
	}
	else
	{
		$txtZip="'$txtZip'";
	}
	if ($txtRef=='' || $txtRef=='null') 
	{
		$txtRef='null';
	}
	else
	{
		$txtRef="'$txtRef'";
	}
	if ($txtVatNo=='' || $txtVatNo=='null') 
	{
		$txtVatNo='null';
	}
	else
	{
		$txtVatNo="'$txtVatNo'";
	}
	//########
	$taSupName=addslashes(trim($txtaSupName));
	
	$supsql = "SELECT count(*) as supcount FROM `supplier` WHERE `supplier_name`='$taSupName' and `sup_year` = '$lstYear'";
	//echo $supsql;
	$res = mysql_query($supsql) or die(mysql_error());
	$rowsup1 = mysql_fetch_assoc($res);
	//echo $rowsup1['supcount'];
	if($rowsup1['supcount'] == "0" )
	//#######
	{
	for ($i=0; $i<$how_many; $i++)
	{
	if ($chk1[$i])
	{
		//$taSupName=addslashes(trim($txtaSupName));
		$txtStreet=addslashes(trim($txtStreet));
		$txtCity=addslashes(trim($txtCity));
		if (isset ($_REQUEST['optReg']) || $_REQUEST['optReg']== "RES")
		{
		$sql="INSERT INTO `supplier`(`supplier_code`, `supplier_name`, `sup_year`, `supplier_contact`, `supplier_address1`, `supplier_address2`, `supplier_address3`, `supplier_phone`, `supplier_fax`, `supplier_vat_no`, `supplier_email`, `sup_foreign_local`, `sup_address4`, `supplier_phone2`, `supplier_phone3`, `supplier_phone4`, `branch_code`, `registered_status`, `effective_date_from`, `effective_date_to`, `sup_cat_code`,`sup_refno`,`sup_user_add`,`sup_add_date`) VALUES ('$supcode1','$taSupName','$lstYear',null,'$txtStreet','$txtCity','$txtCountry','$txtTel1','$txtFax',$txtVatNo,'$txtEMail','$optLOF',$txtZip,'$txtTel2',null,null,null,'$optReg','$txtFrom','$txtTo','$chk1[$i]',$txtRef,'$tusername','$tdatetime' ); ";
		//echo $sql;
		}
		else
		{
		$sql="INSERT INTO `supplier`(`supplier_code`, `supplier_name`, `sup_year`, `supplier_contact`, `supplier_address1`, `supplier_address2`, `supplier_address3`, `supplier_phone`, `supplier_fax`, `supplier_vat_no`, `supplier_email`, `sup_foreign_local`, `sup_address4`, `supplier_phone2`, `supplier_phone3`, `supplier_phone4`, `branch_code`, `registered_status`, `sup_cat_code`,`sup_refno`,`sup_user_add`,`sup_add_date`) VALUES ('$supcode1','$taSupName','$lstYear',null,'$txtStreet','$txtCity','$txtCountry','$txtTel1','$txtFax',$txtVatNo,'$txtEMail','$optLOF',$txtZip,'$txtTel2',null,null,null,'NRS','$chk1[$i]',$txtRef,'$tusername','$tdatetime'); ";
		}
		//echo $sql;
	mysql_query($sql) or die(mysql_error());
	}
	}
	}
	else
	{
		echo "<script> alert ('Same Supplier Name Entered Before!!'); </script>";
		$i = 0;
	}
	if  ($i>0) 
	{
		$save = true;
	}
	else
	{
		$save = false;
	}
}
	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>


<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Supplier Information</title>

<link href="css/style.css" rel="stylesheet" type="text/css" />

</head>
<body>

<script>

function setDisabled(obj)
{
	if (obj=="RES")
	{
		document.getElementById("txtFrom").disabled = false;
		document.getElementById("txtTo").disabled = false;	
	}	
		
	if (obj=="NRS" || obj=="")
	{
		document.getElementById("txtFrom").disabled = "disabled";
		document.getElementById("txtTo").disabled = "disabled";	
	}		
}	


function setLOF(obj)
{
	if (obj=="L")
	{
		document.getElementById("txtZip").readOnly =true ;
		document.getElementById("txtCountry").value = "Sri Lanka";
		document.getElementById("txtZip").value = "";
		document.getElementById("txtCountry").readOnly =true ;
	}	
	if (obj=="F")
	{
		//document.getElementById("txtZip").disabled = null;
		document.getElementById("txtCountry").removeAttribute("readOnly",0); 
		//document.getElementById("txtCountry").disabled = null;
		document.getElementById("txtZip").removeAttribute("readOnly",0); 
		document.getElementById("txtCountry").value = "";
	}		
}


function validateForm()
{	
	tYear=document.getElementById('lstYear');
	taSupName=document.getElementById('txtaSupName');
	tStreet= document.getElementById('txtStreet');
	tCity= document.getElementById('txtCity');
	tCountry= document.getElementById('txtCountry');
	tTel1= document.getElementById('txtTel1');
	tTel2= document.getElementById('txtTel2');
	tFax= document.getElementById('txtFax');
	thmany= getRadioArray('chk1[]');
	selected = false;
	
	if (tYear.value=="0")
	{
		alert('Please Select Supplier Year');
		return false;
	}	
	if (taSupName.value=="")
	{
		alert('Please Enter Supplier Name');
		return false;
	}		
	if (tStreet.value=="")
	{
		alert('Please Enter Supplier Street');
		return false;
	}
	if (tCity.value=="")
	{
		alert('Please Enter Supplier City');
		return false;
	}
	if (tCountry.value=="")
	{
		alert('Please Enter Supplier Country');
		return false;
	}
	if (tTel1.value=="" && tTel2.value=="")
	{
		alert('Please Enter Contact Details');
		return false;
	}
	if (isNaN(tTel1.value) || tTel1.value.length != 10)
	{
		alert('Telephone Number Should be 10 Digit Number');
		return false;
	}
	for (i=0;i<thmany.length;i++)
	{
		selected = selected || thmany[i].checked;
	}
	if (!selected)
	{
		alert ('Please Select Atleast One Category');
		return false;
	}
	/*var tel= /^[0-9]\/+$/;
	if (tTel2.value.match(tel))
	{
		return true;
	}
	else
	{	
		alert('Telephone number should be numeric');
		return false;
	}*/
	return true;
}

function getRadioArray(groupName) 
{
var radioArray = new Array();
var nodeList = document.getElementsByTagName("input");
	for(var i = 0; i < nodeList.length; i++) 
	{
		if(nodeList.item(i).name == groupName) 
		{
			radioArray[radioArray.length] = nodeList.item(i);
		}
	}
return radioArray;
}	


</script>
<div id="header">
		<div class="wrapper clearfix">
			<div id="logo">
				<a href="index.php"><img src="images/ucsclogo.png" alt="LOGO"></a>
			</div>
			<div class="dropdown">
              <button class="dropbtn">Inventory</button>
              <div class="dropdown-content">
                <a href="inventory.php" style="float:left; border-right:thin; border-right-color:#00F">Items</a>
                <a href="maincategory.php">Category</a>
                <a href="subcatregistry.php" style="float:left">Sub category</a>
              </div>
            </div>
			<div class="dropdown">
              <button class="dropbtn">Supplier</button>
              <div class="dropdown-content">
                <a href="supplier.php" style="float:left">Supplier registry</a>
                <a href="supcategory.php" style="float:left">Category</a>
              </div>
            </div>
			<div class="dropdown">
              <button class="dropbtn">Purchase</button>
              <div class="dropdown-content">
                <a href="purchase.php" style="float:left">PO</a>
                <a href="#" style="float:left">Funds</a>
              </div>
            </div>
			<div class="dropdown">
              <button class="dropbtn">Administration</button>
              <div class="dropdown-content">
                <a href="#" style="float:left">Users</a>
                <a href="logout.php" style="float:left">Logout</a>
              </div>
            </div>
			<div class="dropdown">
              <button class="dropbtn">Reports</button>
              
            </div>
		</div>
	</div>
<!--************************************************************************************************************-->
<!-- ************************************************************Form**********************************************-->

<form id="form1" name="form1" method="post" action="" >

<table width="100%" border="0" id="cmd" style="background-color:lightblue;">
  <!--<tr>
    <td colspan="8">
		<?php //include 'header.php' ?>	</td>
  </tr>-->
  <tr>
    <td rowspan="17" valign="top" class="style24">  <?php //echo  $lstYr;?>
		<div style="overflow:scroll; width:250px; height:470px"><table width="580px">
          <tr>
            <td><strong>Supplier Category</strong> </td>
          </tr>
		  	<?php
				$sql="SELECT `sup_cat_code`,`sup_cat_name` FROM `supplier_category` WHERE `user_add_date` > '2007-10-01 00:00:00' order by 1";
				$result = mysql_query($sql) or die(mysql_error());
				$c=0;
				while($row=mysql_fetch_assoc($result))
				{
					$supcatcode= substr($row[sup_cat_code],-4);
			?>
          <tr>
            <td <?php if ($c%2==0) echo "bgcolor=\"#C4C4C4\""; else echo "bgcolor=\"#E3E3E3\"";  ?> ><label>
              <input name="chk1[]" type="checkbox" id="chk1[]" value="<?php echo "$supcatcode"; ?>" />
			  <?php echo "$supcatcode - $row[sup_cat_name]"; ?>
            </label></td>
          </tr>
          <?php
		  	$c++;
		  	}
		  ?>

		  <input name="hdcount" type="hidden" id="hdcount" value="<?php  echo $c; ?>">
		  <tr>          </tr>
        </table>
		</div></td>
   <!-- <td colspan="7"><span class="style25"><strong>University Of Kelaniya</strong></span></td>-->
  </tr>
  <!--<tr>
    <td colspan="7"><span class="style25"><strong>Kelaniya</strong></span></td>
  </tr>-->
  <tr>
    <td colspan="4" class="style31"><div align="right" class="style24">
      <div align="left">Year :
        <select name="lstYear" id="lstYear" onchange="submit()" >
          <option value="0" selected="selected"> Select...</option>
          <<option value="<?php echo $tdateArr[2]-1; ?>"  <?php if ($lstYear==$tdateArr[2]-1) {echo "selected=\"selected\"";}?>> <?php echo $tdateArr[2]-1; ?> </option>>
          <option  value="<?php echo $tdateArr[2]; ?>" <?php if ($_POST['lstYear']==$tdateArr[2]) {echo "selected=\"selected\"";}?>> <?php echo $tdateArr[2]; ?> </option>
          <option value="<?php echo $tdateArr[2]+1; ?>" <?php if ($_POST['lstYear']==$tdateArr[2]+1) {echo "selected=\"selected\"";}?>
> <?php echo $tdateArr[2]+1; ?> </option>
        </select>
</div>
      <label></label>
      <label></label>
</div></td>
    <td colspan="2" class="style31" align="right"><span class="style24">Supplier Code:</span></td>
    <td class="style31"><span class="style24"><?php
		if (isset($_REQUEST['lstYear']) || $_REQUEST['lstYear'] != 0) 
		{
		$sql= "SELECT `supplier_code` FROM `supplier` WHERE `sup_year`=$_REQUEST[lstYear] order by `supplier_code` Desc limit 1; ";
		$result = mysql_query($sql) or die(mysql_error());
		$row = mysql_fetch_assoc($result);
		$maxno=$row['supplier_code']  ;
		$nextno=(int)$maxno+1;
		$supcode= str_pad($nextno,4,0,STR_PAD_LEFT);
	?>
    <input name="txtSupCode" type="text" id="txtSupCode" size="4%" value="<?php if ($_REQUEST['lstYear'] == 0) { echo ""; } else { echo $supcode; }?>" readonly="" />
    </span>
	<?php 
	}
	?>	</td>
  </tr>
  <tr>
    <td colspan="7" bgcolor="lightblue"></td>
  </tr>
 
  <tr>
    <td colspan="7" class="style31"><span class="style11">&nbsp;</span></td>
  </tr>
  <tr>
    <td  class="style31" width="100"><span class="style11">Foreign/Local :</span></td>
    <td colspan="2" class="style31">
      <input name="optLOF" type="radio" value="L" onclick="setLOF(this.value)" checked="checked" <?php if (!isset($_REQUEST['lstYear'])) { ?> disabled="disabled" <?php } ?> />
      Local
      <input name="optLOF" type="radio" value="F" onclick="setLOF(this.value)"  <?php if (!isset($_REQUEST['lstYear'])) { ?> disabled="disabled" <?php } ?>/>
    Foreign</td>
    <td class="style31"><span class="style11">Ref. No : </span></td>
    <td colspan="3" class="style31"><input name="txtRef" type="text" id="txtRef" size="15%" <?php if (!isset($_REQUEST['lstYear'])) { ?>
			readonly="readonly" <?php } ?> /></td>
  </tr>
  <tr>
    <td class="style31"><span class="style11">Name :</span></td>
    <td colspan="2" class="style31">
		<textarea name="txtaSupName" cols="35%" rows="1" id="txtaSupName" <?php if (!isset($_REQUEST['lstYear'])) { ?>readonly="readonly" <?php } ?>></textarea>	</td>
    <td class="style31">VAT Reg. No: </td>
    <td colspan="3" class="style31"><label>
      <input name="txtVatNo" type="text" id="txtVatNo" size="15%" maxlength="20" <?php if (!isset($_REQUEST['lstYear'])) { ?>
			readonly="readonly" <?php } ?> />
    </label></td>
    </tr>
  <tr>
    <td class="style31"><span class="style11">No/Street :</span></td>
    <td colspan="2" class="style31"><input name="txtStreet" type="text" id="txtStreet" size="20%" <?php if (!isset($_REQUEST['txtStreet'])) { ?>
			readonly="readonly" <?php } ?> />
    eg: NO.5,Main Street, </td>
    <td colspan="4" class="style31">&nbsp;</td>
  </tr>
  <tr>
    <td class="style31"><span class="style11">City :</span></td>
    <td colspan="2" class="style31"><input name="txtCity" type="text" id="txtCity" size="20%" <?php if (!isset($_REQUEST['txtCity'])) { ?>
			readonly="readonly" <?php } ?>/>
    eg: Gampaha. </td>
    <td colspan="4" class="style31">&nbsp;</td>
  </tr>
  <tr>
    <td class="style31"><span class="style11">Post Code : </span></td>
    <td colspan="2" class="style31"><input name="txtZip" type="text" id="txtZip" size="5%" <?php if (!isset($_REQUEST['optLOF']) || ($_REQUEST['optLOF']=="L")) { ?> readonly="readonly" value="" <?php } ?>/></td>
    <td colspan="4" class="style31">&nbsp;</td>
  </tr>
  <tr>
    <td class="style31"><span class="style11">Country :</span></td>
    <td colspan="2" class="style31">
	<input name="txtCountry" type="text" id="txtCountry" size="11%" <?php if (!isset($_REQUEST['optLOF']) || ($_REQUEST['optLOF']=="L")) { ?> readonly="readonly" value="Sri Lanka" <?php } ?> /></td>
    <td colspan="4" class="style31">&nbsp;</td>
  </tr>
  <tr>
    <td class="style31"><span class="style11">Telephone I :</span></td>
    <td colspan="2" class="style31"><input name="txtTel1" type="text" id="txtTel1" size="10%" maxlength="10" <?php if (!isset($_REQUEST['txtTel1'])) { ?>
			readonly="readonly" <?php } ?> /></td>
    <td class="style31" width="90"><span class="style11">Telephone II : (Foreign/Range) </span></td>
    <td class="style31" width="90"><input name="txtTel2" type="text" id="txtTel2" size="15%" <?php if (!isset($_REQUEST['txtTel2'])) { ?>
			readonly="readonly" <?php } ?>/></td>
    <td class="style31" width="35" align="left">Fax :</td>
    <td class="style31" ><input name="txtFax" type="text" id="txtFax" size="15%" <?php if (!isset($_REQUEST['txtFax'])) { ?>
			readonly="readonly" <?php } ?> /></td>
  </tr>
  <tr>
    <td class="style31">E-mail : </td>
    <td colspan="6" class="style31"><input name="txtEMail" type="text" id="txtEMail" size="15%" <?php if (!isset($_REQUEST['txtEMail'])) { ?>
			readonly="readonly" <?php } ?>/></td>
  </tr>
  <tr>
    <td class="style31"><span class="style33">Reg. Status : </span></td>
    <td colspan="2" class="style31"><!--label-->
      <input name="optReg" type="radio" value="RES" onclick="setDisabled(this.value)" checked="checked"  <?php if (!isset($_REQUEST['lstYear']) || $tusername == 'admin_med') { ?> disabled="disabled" <?php } ?> />
      Registered 
      <input name="optReg" type="radio" value="NRS" onclick="setDisabled(this.value)" <?php if($tusername == 'admin_med') { ?> checked="checked" <?php } if (!isset($_REQUEST['lstYear']) || $tusername == 'admin_med') { ?> disabled="disabled" <?php } ?> />Non_Registered    
	  <!--/label-->	</td>
    <td class="style31"><div align="left"><span class="style33">From :</span></div></td>
    
	<td class="style31">
	<input name="txtFrom" readonly="readonly" type="text" id="txtFrom" size="15%" value="<?php if (isset($_REQUEST['lstYear']) )
	echo "$_REQUEST[lstYear]-01-01"; ?> " <?php if($tusername == 'admin_med') { ?> disabled="disabled" <?php } ?> />    </td>
	  
    <td class="style31"><div align="left"><span class="style33">To :</span></div></td>
    <td class="style31">
	<input name="txtTo" readonly="readonly" type="text" id="txtTo" size="12%" value="<?php if (isset($_REQUEST['lstYear']) ) echo "$_REQUEST[lstYear]-12-31"; ?> " <?php if($tusername == 'admin_med') { ?> disabled="disabled" <?php } ?> />	 </td> 
  </tr>
  <tr>
    <td colspan="7"><label></label></td>
    </tr>
  <tr>
    <td colspan="7"><!--label-->
      <input name="btnSave" type="submit" class="btn2" id="btnSave" value="Save" onclick="return validateForm()" />
      <!--/label-->
      <label>
      <input name="btnExit" type="submit" class="btn2" id="btnExit" value="Exit" />
      </label>
	  <label class="style3" ><font color="#003333"><?php 
	  if ($save)
	  {
	  echo "Supplier '$supcode1 - $taSupName' added successfully."; 
	  }
	  ?></font></label>	  </td>
    </tr>
 <!-- <tr>
    <td colspan="8"><?php //include 'footer.php'?></td>
  </tr>-->
</table>

</form>
</body>
</html>
