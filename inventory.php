<?php 
session_start();
include("db.inc.php");

extract($_POST);
$tcurrentdate= $_SESSION["currentdate"];
$tdatetime=strftime("%Y-%m-%d %H:%M:%S");
$code='';

if (isset($_POST['btnSave']) || $_POST['btnSave']=="Save")
{
	$pId=$_POST['lstProduct'];
	$pCatagoty=$_POST['lstCategory'];
	$Code=$_POST['txtCode'];
	$Des=addslashes(trim($_POST['txtDes']));
	$Local=$_POST['lstLocal'];
	$Type=$_POST['lstType'];
	$Location=$_POST['lstLocation'];
	$Umo=$_POST['lstUMO'];
	$Costing=$_POST['lstCosting'];
	$OrderL=trim($_POST['txtOrderL']);
	$OrderQ=trim($_POST['txtOrderQ']);
	
	
	$sqlItemAdd="insert into item_masterfile (product_category_code,product_sub_category_code,item_code,item_description,import_local,item_type_code,item_uom,item_costing_method,ite_mas_rol,item_rol_qty,user_add,user_add_date)
values	('$pId','$pCatagoty','$Code','$Des','$Local','$Type','$Umo','$Costing',$OrderL,$OrderQ,'$tusername','$tdatetime')";
	

 $result= mysql_query($sqlItemAdd) or die(mysql_error());
echo "<script> alert ('Item Code $txtCode - $txtDes  added successfully!!'); </script>";
	unset($_REQUEST);
}
if (isset($_POST['btnClear']) || $_POST['btnClear']=="Clear")
{
	unset($_REQUEST);
}
if (isset($_POST['btnExit']) || $_POST['btnExit']=="Exit")
{
	header("location:homeindex.php");
}
?>
<!--*********************************************************************************************************-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Inventory Register</title>
<link rel="stylesheet" href="css/style.css" type="text/css">
<script>
function validateForm()
{		
	if (document.getElementById('lstProduct').value=="0")
	{
		alert('Please select the Main Category !');
		return false;
	}	
	if (document.getElementById('lstCategory').value=="0")
	{
		alert('Please select the Sub Category !');
		return false;
		form1.lstCategory.focus();
	}
	if (document.getElementById('lstType').value=="0")
	{
		alert('Please select the Item Type ! ');
		return false;
	}
	if (document.getElementById('lstLocation').value=="0")
	{
		alert('Please select Item Location ! ');
		return false;
	}
	if (document.getElementById('txtDes').value=="")
	{
		alert('Please Enter Item Description ');
		return false;
	}
	if (document.getElementById('lstUMO').value=="0")
	{
		alert('Please Select Unit of Measurement (U.O.M) ! ');
		return false;
	}
	var OrderL=document.getElementById('txtOrderL').value;
	if (OrderL=="")
	{
		alert('Please Enter Re-Order Level ! ');
		return false;
	}
	if (isNaN(OrderL))
	{
		alert('Re-Ordr Level must have numbers only !');
		return false;
		OrderQ.focus();
	}
	var OrderQ=document.getElementById('txtOrderQ').value;
	if (OrderQ=="")
	{
		alert('Please Enter Re-Order Quantity ');
		return false;
	}
	if (isNaN(OrderQ))
	{
		alert('Re-Ordr Quantity omust have numbers only !');
		return false;
		form1.OrderQ.focus();
	}
	return true;
}
function ClearSubCategory()
{
	document.getElementById('lstCategory').value=0;
}
</script>
</head>
<body>
<div id="header">
		<div class="wrapper clearfix">
			<div id="logo">
				<a href="index.php"><img src="images/ucsclogo.png" alt="LOGO"></a>
			</div>
			<!--ul id="navigation">
				<li class="selected">
					<a href="inventory.php">Inventory</a>
				</li>
				<li>
					<a href="purchase.php">Purchase</a>
				</li>
				<li>
					<a href="index.php">Administration</a>
				</li>
				<li>
					<a href="supplier.php">Supplier</a>
				</li>
				<li>
					<a href="index.php">Reports</a>
				</li>
			</ul-->
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


<form id="form1" name="form1" method="post" action="" >

<table width="100%" border="0" id="cmd" style="background-color:lightblue;">
	<tr>
		<td colspan="4" align="center"><span class="title"><strong>Item Detail </strong></span></td>											
	</tr>
	<tr>
		<td width="15%" align="right"><span class="style31">Main Category &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>								</td>
		<td width="26%" class="">
		<select name="lstProduct" id="lstProduct" onChange="ClearSubCategory();submit()" class="styleselect1">
            <option value="0">Select... </option>
                <?php
					$_REQUEST['txtCode']='';
					$sql="select product_category_code, product_category_name from item_category";
					$result = mysql_query($sql) or die("Mysql error product loading");
					while($row=mysql_fetch_assoc($result)) {
				?>
            <option value="<?php echo $row['product_category_code'];?>" 
				<?php 
					if (!isset($_REQUEST['lstProduct'])) 
					$_REQUEST['lstProduct'] = "undefine"; 
					if($row['product_category_code']===$_REQUEST['lstProduct'])
					echo " selected=\"selected\" " ;?> class="styleselect1">
                    <?php	 echo $row['product_category_code'].' - '.$row['product_category_name'];?>
            </option>
                    <?php }?>
		</select></td>
		<td width="12%" class="style31" align="right"><span class="style28">Imported / Local &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></td>
		<td width="23%" class="style31"><span class="style1 style24">
		<select name="lstLocal" id="lstLocal" class="styleselect1">
            <option selected value="L">Local</option>
            <option value="F">Foreign</option>
            </select>
			</span></td>
	</tr>
	<tr>
		<td align="right"><span class="style31">Sub Category&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span>	</td>
		<td class="style31"><span class="style29 style24 style1">
		<select name='lstCategory' id="lstCategory" onChange="submit()" class="styleselect1">
            <option value="0">Select... </option>
                <?php
				if ($_REQUEST['lstProduct']<>0){ 
				$cat = $_REQUEST['lstProduct'];
				$sql = "select product_sub_category_code,product_sub_category_des from item_sub_category where product_category_code=".$cat." order by 1";
				$result = mysql_query($sql) or die("Mysql error Sub Catagory");
				while($row=mysql_fetch_assoc($result))
				{?>
			<option value="<?php echo $row['product_sub_category_code'];?>"
				<?php 
				if(($row['product_sub_category_code'])===$_REQUEST['lstCategory'])
				echo "selected=\"selected\"" ;?>>
                <?php echo $row['product_sub_category_code'].' - '.$row['product_sub_category_des'];?></option>
                <?php }}?>
        </select></span> 
		</td>
	</tr>
    <tr>
        <td colspan="4" align="center"><span class="title"><strong>Existing Items</strong></span></td></tr>
    <tr>
        <td colspan="4" valign="top">
			<div style="overflow:scroll">
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
					<?php if ($_REQUEST['lstCategory']<>0) {  
					$code="$_REQUEST[lstProduct]$_REQUEST[lstCategory]";
					$sql="SELECT item_code,item_description  FROM `item_masterfile` WHERE item_code LIKE '$code%'";
					$result = mysql_query($sql) or die(mysql_error());
					$a=1;
					while($row=mysql_fetch_assoc($result))
						{
					?>								
	<tr><td <?php if ($a%2==0) echo "bgcolor=\"#66ccff\""; else echo "bgcolor=\"#ccffff\"";  ?>> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<?php echo "<font size=\"3\"\>".$row['item_description']."</font>"."<br>"; ?></td></tr>
			<?php $a++;}//end while 
			}//end if ?></table>
		</div>
		</td></tr>
	<!--tr>
		<td><span class="style31">Code</span></td>
		<td><input name="txtCode" type="text" id="txtCode" readonly="" value="<?php				
								if (($_REQUEST['lstCategory']!=0) && ($_REQUEST['lstProduct']!=0) )
								{	
										$code="$_REQUEST[lstProduct]$_REQUEST[lstCategory]";
										$sql="SELECT max(item_code)+1 as maxCode FROM `item_masterfile` WHERE item_code LIKE '$code%'";
										$result = mysql_query($sql) or die("max code error ");
										if($row=mysql_fetch_assoc($result))
										    {
												$codeNo=$row['maxCode'];
												//echo "code No - $codeNo-";
												if ($codeNo==NULL) 
												{ 
													$codeNo="001";
													echo "$code$codeNo"; 
												
												}
												else
												{ 											 
												$codeNo= str_pad($codeNo,9,0,STR_PAD_LEFT);
												echo "$codeNo";
												}
											}
								}?> "/></td>
		<td colspan="2">&nbsp;</td>
	</tr-->
	<tr>
		<td height="26" align="right">Item Type &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td colspan="3"><span class="style31">
			<select name="lstType" id="lstType" class="styleselect1" >
                <option value="0">Select... </option>
                                  <?php	
								  		if(isset($_REQUEST['lstCategory']) && $_REQUEST['lstCategory'] != 0)
										{
											$sql="select item_type_code, item_type_name from item_type_mf order by 1";
											$result = mysql_query($sql) or die("Mysql error Item Type");
											while($row=mysql_fetch_assoc($result))
											{?>
                <option value="<?php echo $row['item_type_code'];?>" 
										<?php 
										if(isset($_REQUEST['lstType'])){
											if($row['item_type_code']===$_REQUEST['lstType'])
												echo " selected=\"selected\" " ;}	?>>
                                  <?php	 echo $row['item_type_code'].' - '.$row['item_type_name'];	?>
                </option>
                                  <?php } }?>
            </select></span></td>
	</tr>
	<tr><td height="26" align="right">Description &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td colspan="3"><input name="txtDes" type="text" id="txtDes" size="75" class="styleselect1" /></td>
	</tr>
	<tr>
		<td height="26" colspan="4"><span class="title"><strong>Unit Information </strong></span></td>
	</tr>
	<tr><td height="26" align="right">U.O.M &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td><span class="style31">
			<select name="lstUMO" id="lstUMO" class="styleselect1">
                <option selected value="0">Select...</option>
                <option value="l">Litre</option>
                <option value="Kg">Kilogram</option>
                <option value="Pkt">Packets</option>
                <option value="Other">Other</option>
            </select></span></td>
		<td align="right">Re-Order Level  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td><span class="style31"><input name="txtOrderL" type="text" id="txtOrderL" class="styleselect1" /></span></td>
	</tr>
	<tr><td height="26" align="right">Costing &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td><span class="style31">
			<select name="lstCosting" id="lstCosting" class="styleselect1">
                <option selected value="F">FIFO</option>
                <option value="L">LIFO</option>
            </select></span></td>
		<td align="right">Re-Order Qty.  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td><span class="style31"><input name="txtOrderQ" type="text" id="txtOrderQ"  class="styleselect1" /></span></td>
	</tr>
	<tr><td height="26" colspan="4"><input name="btnSave" type="submit" class="btn2" id="btnSave" value="Save" onclick="return validateForm()" />
			<input name="btnClear" type="submit" id="btnClear" value="Clear" class="btn2"/>
			<input name="btnExit" type="submit" class="btn2" id="btnExit" value=" Exit " /></td>
	</tr>
</table>
</form>
</body>
</html>
