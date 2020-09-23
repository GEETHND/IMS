<?php 
session_start();
include("db.inc.php");

extract($_POST);
$tcurrentdate= $_SESSION["currentdate"];
$tdatetime=strftime("%Y-%m-%d %H:%M:%S");
$addeduser="";
$ct=0;

require('db.inc.php'); 
extract($_POST);

//************************************************************************************************
if (isset($_POST['btnAdd']) || $_POST['btnAdd']=="Add")
{
	//$txtMCatCode=trim($txtSCatCode,'0');
//	$txtMCatCode=str_pad($txtSCatCode,6,0,STR_PAD_LEFT);
	$txtSCatName=addslashes(trim($txtSCatName));
	$sql= "SELECT count(*) as rowcount FROM `item_sub_category` WHERE `product_category_code`='$lstMCatCode' AND `product_sub_category_code`='$txtSCatCode'";
	//echo $sql;
	$result= mysql_query($sql) or die(mysql_error());
	$row=mysql_fetch_assoc($result);
	if ($row['rowcount']!=0)
	{
		echo "<script> checksubcat();
		function checksubcat()
		{
			alert('Record Exsist!');
			return false;
		}  </script>";
	}
	else
	{
		//$tSCatCode=($txtMainSubCode + $txtSCatCode);
		$sql1="INSERT INTO `item_sub_category`(`product_sub_category_code`,`product_category_code`,`product_sub_category_des`, `os_user`,`user_add_date`) VALUES ('$txtSCatCode','$lstMCatCode','$txtSCatName','$tusername','$tcurrentdate')";
		//echo $sql1;
		$result1= mysql_query($sql1) or die(mysql_error());
		echo "<script> alert ('Sub Category $txtSCatCode - $txtSCatName added successfully!!'); </script>";		
	}
	$lstMCatCode=0;
	$txtSCatCode="";
	$txtSCatName="";
	unset($_REQUEST);
}
	
//***********************************************************************************
if (isset($_POST['btnFind']) || $_POST['btnFind']=="Find")
{
	///////*******###########!!!!!!!!!!______________________________________________Get the os user from main category table and equal user for that table user
	
	$sqluser="SELECT `os_user` FROM `item_category` WHERE `product_category_code`='$lstMCatCode'";
	$resultuser=mysql_query($sqluser) or die(mysql_error());
	$rowuser=mysql_fetch_array($resultuser);
	
	$sql="SELECT count(*) as rowcount,`product_category_code`,`product_sub_category_code`,`product_sub_category_des` FROM `item_sub_category` WHERE `product_sub_category_code`='$txtSCatCode' AND `product_category_code`='$lstMCatCode'"; 
	$result=mysql_query($sql) or die(mysql_error());
	$row=mysql_fetch_array($result);
	//echo $row[rowcount];
	if ($row[rowcount]==0)
	
	{
		echo "<script> checksubcat();
		function checksubcat()
		{
			alert('No Record Found!');
			return false;
		}  </script>";
		$ct=1;
		$txtSCatName="";
	}
	else
	{
	$txtSCatName= $row['product_sub_category_des'];
	$ct=2;
	$addeduser = $rowuser ['os_user'];
	}
	//$tMCat=$row['product_category_code'];
}

//**********************************************************************************
if (isset($_POST['btnEdit']) || $_POST['btnEdit']=="Edit")
{
	if($tusername == 'admin' || $tusername == 'bursar' || $tusername == $addedUser)
	{	
	$txtSCatName=addslashes(trim($txtSCatName));
	//if ($_REQUEST['lstMCatCode'] != $hdMCat)
	//{
		//echo "<script> alert (' You Cannot Change Main Category Code!!!'); < /script>";
	//}
	//else
	//{
	$sql="UPDATE `item_sub_category` SET `product_category_code`='$lstMCatCode', `product_sub_category_des`='$txtSCatName',`os_user`='$tusername',`user_add_date`='$tcurrentdate' WHERE `product_sub_category_code`='$txtSCatCode' AND `product_category_code`='$lstMCatCode'";
	//echo $sql;
	mysql_query($sql) or die(mysql_error());
	echo "<script> alert('Record $txtSCatCode - $txtSCatName updated successfully!'); </script>" ;
	//$lstMCatCode=0;
	//}
	}
	else
	{
		echo "<script> alert('Sorry, You Do Not Have Permission!'); return false; </script>" ;
	}
	$txtSCatCode="";
	$txtSCatName="";
	unset($_REQUEST);
	
}

//************************************************************************************
if (isset($_POST['btnClear']) || $_POST['btnClear']=="Clear")
{
	$lstMCatCode=0;
	unset($_REQUEST);
	$txtSCatCode="";
	$txtSCatName="";
	$txtMainSubCode="";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Sub Category Registry</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>

<script>

function validateform()
{
	tMCatCode= document.getElementById('lstMCatCode');
	tSCatCode = document.getElementById('txtSCatCode');
	tSCatName=document.getElementById('txtSCatName');
	
	if (tMCatCode.value==0)
	{
		alert ('Please Select a Main Category Code!!!');
		return false;
	}
	if (tSCatCode.value=="")
	{
		alert ('Please enter the Sub Category Code!!!');
		return false;
	}
	if (tSCatName.value=="")
	{
		alert ('Please enter the Sub Category Name!!!')
		return false;
	}
	if (isNaN(tSCatCode.value))
	{
		alert('Sub Category Code should a number');
		return false;
	}
	return true;
}


function validatefind()
{
	tMCatCode= document.getElementById('lstMCatCode');
	tSCatCode = document.getElementById('txtSCatCode');
	
	if (tMCatCode.value==0)
	{
		alert ('Please Select a Main Category Code!!!');
		return false;
	}
	if (tSCatCode.value=="")
	{
		alert ('Please enter the Sub Category Code!!!');
		return false;
	}
	if (isNaN(tSCatCode.value))
	{
		alert('Sub Category Code should a number');
		return false;
	}
	return true;
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

<form id="form1" name="form1" method="post" action="">

<table width="100%" height="201" border="0" align="center" style="background-color:lightblue;">
  <!--<tr>
    <td colspan="3">
		<?php //include 'header.php' ?>	</td>
  </tr>
  <tr>
    <td colspan="2"><span class="style25"><strong>University Of Kelaniya</strong></span></td>
  </tr>
  <tr>
    <td colspan="2"><span class="style25"><strong>Kelaniya</strong></span></td>
  </tr>-->
  
  <tr>
  	<td width="15%" class="style3" valign="top">Sub Category List</td>
    <td width="199" class="style3">Main Category  Code </td>
    <td width="1102" class="style3"><label>
      <select name="lstMCatCode" id="lstMCatCode" onchange="submit()">
	  <option value="0">Select... </option>
	  <?php 
	  $sql = "SELECT `product_category_code`,`product_category_name` FROM `item_category` where `os_user`!='admin_med' "; //list of Category.....
	  $result= mysql_query($sql) or die(mysql_error());
	  while($row = mysql_fetch_array($result))
	  {
	  ?>
	  <option value="<?php echo $row['product_category_code']?>" 
			<?php 
			if (!isset($_REQUEST['lstMCatCode'])) 
			$_REQUEST['lstMCatCode'] = "undefine"; 
			if($row['product_category_code']===$_REQUEST['lstMCatCode'])
			echo " selected=\"selected\" " ;
		?>>
	  <?php	 
		echo $row['product_category_code'].' - '.$row['product_category_name'];
	  ?>
	  </option>
	  <?php
		}
		?> 	
      </select>
    </label></td>
  </tr>
  <tr>
  <td rowspan="2" class="style3" valign="top">
  <!-- Show the Sub Category List-->
	<table border="0" cellspacing="0" cellpadding="0" width="260px">
							  
<?php if ($_REQUEST['lstMCatCode']<>0) 
{  
		$sql="SELECT `product_sub_category_code`,`product_sub_category_des` FROM `item_sub_category` WHERE `product_category_code`='$lstMCatCode'";
		$result = mysql_query($sql) or die(mysql_error());
		$a=1;
		while($row=mysql_fetch_assoc($result))
			{
?>								
	<tr valign="top"align=""><td <?php if ($a%2==0) echo "bgcolor=\"#C4C4C4\""; else echo "bgcolor=\"#E3E3E3\"";  ?> >
	<?php echo "<font class=\"style3\" style=\"font-weight:normal\">".$row['product_sub_category_code']. " - ".$row['product_sub_category_des']."</font>"."<br>"; ?></td></tr>
 	 <?php $a++;}//end while 
		}//end if ?></table>
		<!-- End  -->
  </td>
  	<td class="style3">Sub Category Code </td>
    <td class="style3">
	<?php 
	if (
	(isset($_POST['btnAdd']) || $_POST['btnAdd']=="Add") || 
	(isset($_POST['btnClear']) || $_POST['btnClear']=="Clear")
	)
	{
	}
	else
	{
	//$tMCatCode = trim($lstMCatCode,0);
	//$MCatCode = str_pad("$tMCatCode",3,0,STR_PAD_LEFT);
	}
	?>
	<input name="txtSCatCode" type="text" id="txtSCatCode" size="10" maxlength="3" value="<?php echo $txtSCatCode; ?>" <?php if (isset($_POST['btnFind']) || $_POST['btnFind']=="Find"){ ?> readonly="" <?php }?> />
    Ex:0XX</td>
  </tr>
  <tr valign="top">
  <td class="style3">Sub Category Name </td>
    <td class="style3"><label>
    <input name="txtSCatName" type="text" id="txtSCatName" value="<?php echo $txtSCatName; ?>" size="50" />
    </label></td>
  </tr>
  
  <tr>
    <td colspan="3">
    <input name="btnAdd" type="submit" class="btn2" id="btnAdd" value="Add" onclick="return validateform()" <?php if(isset($_REQUEST['btnFind']) && $ct==2 ){ ?> disabled="disabled" <?php } ?>/>

    <input name="btnFind" type="submit" class="btn2" id="btnFind" value="Find" onclick="return validatefind()" />

    <input name="btnEdit" type="submit" class="btn2" id="btnEdit" value="Edit" onclick="return validateform()" <?php if(!isset($_REQUEST['btnFind']) || $ct==1){ ?> disabled="disabled" <?php } ?> />
	<label>
	<input name="btnClear" type="submit" class="btn2" id="btnClear" value="Clear" />
	<input name="btnExit" type="submit" class="btn2" id="btnExit" value="Exit" />
	<input name="addedUser" type="hidden" id="addedUser" value="<?php echo $addeduser; ?>" />
	<!--input name="hdMCat" class="style3" id="hdMCat" value="< ?php echo $tMCat; ?>" type="hidden" /-->
	</label></td>
	</tr>
 <!-- <tr>
    <td colspan="3"><?php //include 'footer.php'?></td>
  </tr>-->
</table>

</form>
</body>
</html>
