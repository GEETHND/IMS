<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>IMS UCSC</title>
	<link rel="stylesheet" href="css/style.css" type="text/css">
</head>
<body bgcolor='#fff'>
	<div id="header">
		<div class="wrapper clearfix">
			<div id="logo">
				<a href="inventory.php"><img src="images/ucsclogo.png" alt="LOGO"></a>
			  
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
	<div id="contents" align="center">
		<table width="100%" height="171" border="1" bgcolor="#fff">
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
											$sql="select product_category_code, product_category_name from product_category_mf where os_user!='admin_med' order by 1";
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
									$sql = "select product_sub_category_code,product_sub_category_des from product_sub_category_mf where product_category_code=$_REQUEST[lstProduct] and os_user!='admin_med'  order by 1";
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
				  </table>
	</div>
	<!--div id="footer">
		<ul id="featured" class="wrapper clearfix">
			<li>
				<img src="images/astronaut.jpg" alt="Img" height="204" width="220">
				<h3><a href="blog.html">Category 1</a></h3>
				<p>
					Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque nec mi tortor. Phasellus commodo semper vehicula.
				</p>
			</li>
			<li>
				<img src="images/earth.jpg" alt="Img" height="204" width="220">
				<h3><a href="blog.html">Category 2</a></h3>
				<p>
					Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque nec mi tortor. Phasellus commodo semper vehicula.
				</p>
			</li>
			<li>
				<img src="images/spacecraft-small.jpg" alt="Img" height="204" width="220">
				<h3><a href="blog.html">Category 3</a></h3>
				<p>
					Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque nec mi tortor. Phasellus commodo semper vehicula.
				</p>
			</li>
			<li>
				<img src="images/space-shuttle.jpg" alt="Img" height="204" width="220">
				<h3><a href="blog.html">Category 4</a></h3>
				<p>
					Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque nec mi tortor. Phasellus commodo semper vehicula.
				</p>
			</li>
		</ul>
		<div class="body">
			<div class="wrapper clearfix">
				<div id="links">
					<div>
						<h4>Social</h4>
						<ul>
							<li>
								<a href="http://freewebsitetemplates.com/go/googleplus/" target="_blank">Google +</a>
							</li>
							<li>
								<a href="http://freewebsitetemplates.com/go/facebook/" target="_blank">Facebook</a>
							</li>
							<li>
								<a href="http://freewebsitetemplates.com/go/youtube/" target="_blank">Youtube</a>
							</li>
						</ul>
					</div>
					<div>
						<h4>Heading placeholder</h4>
						<ul>
							<li>
								<a href="index.html">Link Title 1</a>
							</li>
							<li>
								<a href="index.html">Link Title 2</a>
							</li>
							<li>
								<a href="index.html">Link Title 3</a>
							</li>
						</ul>
					</div>
				</div>
				<div id="newsletter">
					<h4>Newsletter</h4>
					<p>
						Sign up for Our Newsletter
					</p>
					<form action="index.html" method="post">
						<input type="text" value="">
						<input type="submit" value="Sign Up!">
					</form>
				</div>
				<p class="footnote">
					© Copyright © 2023.Company name all rights reserved
				</p>
			</div>
		</div>
	</div-->
</body>
</html>