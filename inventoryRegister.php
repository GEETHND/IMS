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
	$pCatagoty=$_POST['lstCatagoty'];
	$Code=$_POST['txtCode'];
	$Des=addslashes(trim($_POST['txtDes']));
	$Local=$_POST['lstLocal'];
	$Type=$_POST['lstType'];
	$Location=$_POST['lstLocation'];
	$Umo=$_POST['lstUMO'];
	$Costing=$_POST['lstCosting'];
	$OrderL=trim($_POST['txtOrderL']);
	$OrderQ=trim($_POST['txtOrderQ']);
	
	if($tusername == 'admin_med' || $_POST['chkmed'])
	{
		$sqlItemAdd="insert into item_masterfile (product_category_code,product_sub_category_code,item_code,item_description,import_local,item_type_code,item_uom,
	item_costing_method,item_mas_rol_med,item_rol_qty_med,item_cost,item_price,item_currency_code,item_exchrate,item_cost_fc,item_price_fc,item_selling_rate,item_loc_code_med,user_add,user_add_date)
values	('$pId','$pCatagoty','$Code','$Des','$Local','$Type','$Umo','$Costing',$OrderL,$OrderQ,1.00,1.00,'Rs',1.00,1.00,1.00,1.00,'$Location','$tusername','$tdatetime')";
	}
	else
	{
		$sqlItemAdd="insert into item_masterfile (product_category_code,product_sub_category_code,item_code,item_description,import_local,item_type_code,item_uom,
	item_costing_method,ite_mas_rol,item_rol_qty,item_cost,item_price,item_currency_code,item_exchrate,item_cost_fc,item_price_fc,item_selling_rate,item_loc_code,user_add,user_add_date)
values	('$pId','$pCatagoty','$Code','$Des','$Local','$Type','$Umo','$Costing',$OrderL,$OrderQ,1.00,1.00,'Rs',1.00,1.00,1.00,1.00,'$Location','$tusername','$tdatetime')";
	}
//echo $sqlItemAdd;
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
	if (document.getElementById('lstCatagoty').value=="0")
	{
		alert('Please select the Sub Category !');
		return false;
		form1.lstCatagoty.focus();
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
	document.getElementById('lstCatagoty').value=0;
}
</script>
</head>
<body>
<div id="header">
		<div class="wrapper clearfix">
			<div id="logo">
				<img src="images/ucsclogo.png" alt="LOGO" width=150px; height=130px;>
			 </div>
			<ul id="navigation">
				<li class="selected">
					<a href="inventory.html">Inventory</a>
				</li>
				<li>
					<a href="purchase.html">Purchase</a>
				</li>
				<li>
					<a href="index.html">Administration</a>
				</li>
				<li>
					<a href="index.html">Gallery</a>
				</li>
				<li>
					<a href="index.html">Contact Us</a>
				</li>
			</ul>
		</div>
	</div>
<!--************************************************************************************************************-->


<form id="form1" name="form1" method="post" action="" >

<table width="100%" border="1" id="cmd" bgcolor="#fff">
	<!--<tr>
		<td colspan="3">
		<?php /*include 'header.php'*/ ?>		</td>
	</tr>-->
	<tr>
		<!--<td width="3%" height="185" valign ="top">
		<?php 
		//$menu_type= 'inventory';
		//include 'menu.php'; 
		?>		</td>-->
		<td width="97%">
			<!--<form id="form1" name="form1" method="post" action="">-->
			<table width="100%" border="0" align="center">
				<!--<tr>
					<td colspan="2"><div align="left" class="style25">
					University Of Kelaniya </div>					</td>
				</tr>
				<tr>
					<td colspan="2"><div align="left" class="style25">
					Kelaniya</div>					</td>
				</tr>-->
				
				<tr>
					<td height="36" bgcolor="#999999"><div align="right"><span class="style9">INVENTORY REGISTRY</span></div></td>
			    </tr>
				<tr>
					<td height="72" valign="top">
						<table width="100%" height="171" border="1">
							<tr>
							  <td width="24%"><strong>Item Information </strong></td>
								<td colspan="4"><span class="style26"><strong>Item Detail </strong></span></td>											
						    </tr>
							<tr>
							  <td width="24%" rowspan="9" align="left" valign="top">
							  
							  <div style="overflow:scroll; width:300px; height:300px">
							  
							  <table border="0" cellspacing="0" cellpadding="0" width="100%">
							  
<?php if ($_REQUEST['lstCatagoty']<>0) { //echo $_REQUEST['lstCatagoty']; ?>
<?php  
$code="$_REQUEST[lstProduct]$_REQUEST[lstCatagoty]";
$sql="SELECT item_code,item_description  FROM `item_masterfile` WHERE item_code LIKE '$code%'";
$result = mysql_query($sql) or die(mysql_error());
$a=1;
while($row=mysql_fetch_assoc($result))
	{
?>								
<tr><td <?php if ($a%2==0) echo "bgcolor=\"#C4C4C4\""; else echo "bgcolor=\"#E3E3E3\"";  ?>>
<?php echo "<font size=\"2\"\>".$row['item_code']. " - ".$row['item_description']."</font>"."<br>"; ?></td></tr>
  <?php $a++;}//end while 
		}//end if ?></table>
		
		</div>
		
		</td>
							  <td width="15%"><span class="style31">Main Category </span>								</td>
								<td width="26%" class="style31"><select name="lstProduct" id="lstProduct" onChange="ClearSubCategory();submit()">
                                  <option value="0">Select... </option>
                                  <?php
											$_REQUEST['txtCode']='';
											//$_REQUEST['lstCatagoty']=0;
											$sql="select product_category_code, product_category_name from item_category where os_user!='admin_med'";
											$result = mysql_query($sql) or die("Mysql error product loading");
											while($row=mysql_fetch_assoc($result)) {
										?>
                                  <option value="<?php echo $row['product_category_code'];?>" 
										<?php 
											if (!isset($_REQUEST['lstProduct'])) 
											$_REQUEST['lstProduct'] = "undefine"; 
											//if (isset($row['supplier_code']) && $_REQUEST['lstSupplier']!=0)
											if($row['product_category_code']===$_REQUEST['lstProduct'])
											echo " selected=\"selected\" " ;?>>
                                  <?php	 echo $row['product_category_code'].' - '.$row['product_category_name'];?>
                                  </option>
                                  <?php }?>
							  </select></td>
							    <td width="12%" class="style31"><span class="style28">Imported / Local </span></td>
							    <td width="23%" class="style31"><span class="style1 style24">
							      <select name="lstLocal" id="lstLocal">
                                    <option selected value="L">Local</option>
                                    <option value="F">Foreign</option>
                                  </select>
						      </span></td>
							</tr>
							<tr>
							  <td><span class="style31">Sub Category </span>	</td>
								<td class="style31"><span class="style29 style24 style1">
									<select name='lstCatagoty' id="lstCatagoty" onChange="submit()">
                        <option value="0">Select... </option>
                        <?php
								if ($_REQUEST['lstProduct']<>0)
								{ 
									$sql = "select product_sub_category_code,product_sub_category_des from item_sub_category where product_category_code='003' and os_user!='admin_med'  order by 1";
									$result = mysql_query($sql) or die("Mysql error Sub Catagory");
									while($row=mysql_fetch_assoc($result))
									{?>
							<option value="<?php echo $row['product_sub_category_code'];?>"
							<?php 
								if(($row['product_sub_category_code'])===$_REQUEST['lstCatagoty'])
								echo "selected=\"selected\"" ;?>>
                        <?php echo $row['product_sub_category_code'].' - '.$row['product_sub_category_des'];?></option>
                        <?php
								}
								}?>
                      </select></span> <?php //echo  "Code :".$txtCode. "-"."Category :".$lstCatagoty ;?></td>
							    <td class="style31">location</td>
						      <td class="style31"><select name="lstLocation" id="lstLocation">
                                  <option value="0">Select... </option>
                                  <?php 
								 if(isset($_REQUEST['lstCatagoty']) && $_REQUEST['lstCatagoty'] != 0)
								{
								  if($tusername == 'admin_med')
								  {
								  	$sql="select location_code,location_name from location WHERE `os_user`='admin_med' order by location_name asc";
								  }
								  elseif($tusername == 'admin_sup')
								  {
								  	$sql="select location_code,location_name from location WHERE `os_user`<>'admin_med' order by location_name asc";
								  }
								  else
								  {
								  	$sql = "select location_code,location_name from location order by location_name asc";
								  }
											$result= mysql_query($sql) or die("Mysql error3");
											while($row=mysql_fetch_assoc($result))
											{
										?>
                                  <option value="<?php echo $row['location_code']?>" 
										<?php 
											if (!isset($_REQUEST['lstLocation'])) 
											$_REQUEST['lstLocation'] = "undefine"; 
											if($row['location_code']===$_REQUEST['lstLocation'])
											echo " selected=\"selected\" " ;
										?>>
                                  <?php 
											echo $row['location_name'] ;
										?>
                                  </option>
                                  <?php
											}
											}
										?>
                                </select>
								<?php if($tusername == 'admin' || $tusername == 'bursar') { ?>
							    **Medical Faculty 
							    <input type="checkbox" name="chkmed" value="chkmed" />
								<?php } ?> </td>
							</tr>
							<tr>
							  <td><span class="style31">Code</span>								</td>
								<td>            	
								  <input name="txtCode" type="text" id="txtCode" readonly="" value="<?php				
								if (($_REQUEST['lstCatagoty']!=0) && ($_REQUEST['lstProduct']!=0) )
								{	
										$code="$_REQUEST[lstProduct]$_REQUEST[lstCatagoty]";
										$sql="SELECT max(item_code)+1 as maxCode FROM `item_masterfile` WHERE item_code LIKE '$code%'";
										$result = mysql_query($sql) or die("max code error ");
										//$codeNo="001";
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
												//$codeNo=substr($codeNo,4,3); 
											    //$codeNo= str_pad($codeNo,3,0,STR_PAD_LEFT);
												$codeNo= str_pad($codeNo,9,0,STR_PAD_LEFT);
												echo "$codeNo";
												}
											}
											
											//$code="$code$codeNo";
											//echo $code;			
							}?> "/> <?php /*if (($_REQUEST['lstCatagoty']<>0) && ($_REQUEST['lstProduct']<>0))
							{
							echo "OK";
							
							}*/ ?></td>
							    <td colspan="2">&nbsp;</td>
						    </tr>
							<tr>
							  <td height="26"><span class="style31"><span class="style28">Item Type </span></span></td>
							  <td colspan="3"><span class="style31">
							    <select name="lstType" id="lstType" >
                                  <option value="0">Select... </option>
                                  <?php	
								  		if(isset($_REQUEST['lstCatagoty']) && $_REQUEST['lstCatagoty'] != 0)
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
                                </select>
							  </span></td>
						  </tr>
							<tr>
							  <td height="26"><span class="style31">Description</span></td>
							  <td colspan="3"><input name="txtDes" type="text" id="txtDes" size="75" /></td>
						  </tr>
							<tr>
							  <td height="26" colspan="4"><span class="style26"><strong>Unit Information </strong></span></td>
							</tr>
							<tr>
							  <td height="26"><span class="style31">U.O.M</span></td>
							  <td><span class="style31">
							    <select name="lstUMO" id="lstUMO">
                                  <option selected value="0">Select...</option>
                                  <option value="l">Litre</option>
                                  <option value="Kg">Kilogram</option>
                                  <option value="Pkt">Packets</option>
                                  <option value="Other">Other</option>
                                </select>
							  </span></td>
						      <td><span class="style31"><span class="style28">Re-Order Level </span></span></td>
						      <td><span class="style31">
						        <input name="txtOrderL" type="text" id="txtOrderL"  />
						      </span></td>
						  </tr>
							<tr>
							  <td height="26"><span class="style31">Costing</span></td>
							  <td><span class="style31">
							    <select name="lstCosting" id="lstCosting">
                                  <option selected value="F">FIFO</option>
                                  <option value="L">LIFO</option>
                                </select>
							  </span></td>
						      <td><span class="style31"><span class="style28">Re-Order Qty. </span></span></td>
						      <td><span class="style31">
						        <input name="txtOrderQ" type="text" id="txtOrderQ"  />
						      </span></td>
						  </tr>
							<tr>
							  <td height="26" colspan="4"><input name="btnSave" type="submit" class="style3" id="btnSave" value="Save" onclick="return validateForm()" />
						      <input name="btnClear" type="submit" id="btnClear" value="Clear" class="style3"/>
						      <input name="btnExit" type="submit" class="style3" id="btnExit" value=" Exit " /></td>
						  </tr>
				  </table>					</td>
				</tr>
		  </table>

			 <!--    </form>    -->		</td>
	</tr>
	<!--<tr>
		<td colspan="3">
			<?php //include 'footer.php'?>		</td>
	</tr>-->
</table>

</form>
</body>
</html>
