<?php 
session_start();
include("db.inc.php");

$tcurrentdate= $_SESSION["currentdate"];
$addeduser="";
$ct=0;
extract($_POST);

if (isset($_POST['btnAdd']) || $_POST['btnAdd']=="Add")
{
	
	$txtMCatCode=trim($txtMCatCode);
	$txtAMCatName=trim($txtAMCatName);
	$txtAMCatName=addslashes($txtAMCatName);
	$sql= "SELECT count(*) as rowcount FROM `product_category_mf` WHERE `product_category_code`='$txtMCatCode' or `product_category_name`='$txtAMCatName'";
	$result= mysql_query($sql) or die("");
	$row=mysql_fetch_assoc($result);
	if ($row['rowcount']!=0)
	{
		echo "<script> checkmaincat();
		function checkmaincat()
		{
			alert('Record Exsist!');
			return false;
		}  </script>";
	}
	else
	{
		$txtMCatCode=str_pad($txtMCatCode,3,0,STR_PAD_LEFT);
		//echo $tcurrentdate;
		$sql1="INSERT INTO `product_category_mf`(`product_category_code`, `product_category_name`,`os_user`,`user_add_date`) VALUES ('$txtMCatCode','$txtAMCatName','$tusername','$tcurrentdate')";
		$result1= mysql_query($sql1) or die(mysql_error());
		echo "<script> alert('Record $txtMCatCode-$txtAMCatName added successfully!'); </script>" ;
		$txtMCatCode="";
		$txtAMCatName="";		
	}
}
	

//***********************************************************************************

if (isset($_POST['btnFind']) || $_POST['btnFind']=="Find")
{
	$MCatCode=trim($txtMCatCode);
	$sql="SELECT count(*) as rowcount,`product_category_code`,`product_category_name`,`os_user` FROM `product_category_mf` WHERE `product_category_code`='$MCatCode'"; 
	$result=mysql_query($sql) or die(mysql_error());
	$row=mysql_fetch_array($result);
	if ($row[rowcount]==0)
	{
		echo "<script> checkmaincat();
		function checkmaincat()
		{
			alert('No Record Found!');
			return false;
		}  </script>";
		$txtAMCatName="";
		$ct=1;
	}
	else
	{
	$txtMCatCode=$row['product_category_code'];
	$txtAMCatName= $row['product_category_name'];
	$addeduser = $row['os_user'];
	$ct=2;
	}
}

//**********************************************************************************
if (isset($_POST['btnEdit']) || $_POST['btnEdit']=="Edit")
{
	if($tusername == 'admin' || $tusername == 'bursar' || $tusername == $addedUser)
	{	
	$sql="UPDATE `product_category_mf` SET `product_category_code`='$txtMCatCode',`product_category_name`='$txtAMCatName' WHERE `product_category_code`= '$txtMCatCode';";
	//echo $sql;
	mysql_query($sql) or die(mysql_error());
	echo "<script> alert('Record $txtMCatCode - $txtAMCatName updated successfully!'); </script>" ;
	}
	else
	{
		echo "<script> alert('Sorry, You Do Not Have Permission!'); return false; </script>" ;
	}
	$txtMCatCode="";
	$txtAMCatName="";
}
//************************************************************************************
if (isset($_POST['btnClear']) || $_POST['btnClear']=="Clear")
{
	$txtMCatCode="";
	$txtAMCatName="";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Main Category Information</title>

<link href="css/style.css" rel="stylesheet" type="text/css" />
<script>
function validateform()
{
	tmaincatcode = document.getElementById('txtMCatCode');
	tmaincatname=document.getElementById('txtAMCatName');
	
	if (tmaincatcode.value=="")
	{
		alert ('Please enter the Main Category Code!!!');
		return false;
	}
	if (isNaN(tmaincatcode.value))
	{
		alert('Main Category Code should a number');
		return false;
	}
	if (tmaincatname.value=="")
	{
		alert ('Please enter the Main Catergory Name!!!');
		return false;
	}
	return true;
}

function validatefind()
{
	tmaincatcode = document.getElementById('txtMCatCode');
	
	if (tmaincatcode.value=="")
	{
		alert ('Please enter the Main Category Code!!!');
		return false;
	}
	if (isNaN(tmaincatcode.value))
	{
		alert('Main Category Code should a number');
		return false;
	}
	return true;
}
</script>
</head>
<body>
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

<table width="100%" border="0" id="cmd" bgcolor="lightblue">
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
    <td colspan="2" bgcolor="lightblue"></td>
  </tr>
  <tr>
    <td width="228" height="35" class="style3">Main Category Code </td>
    <td width="1073" class="style3"><label>
      <input name="txtMCatCode" type="text" id="txtMCatCode" value="<?php echo $txtMCatCode; ?>" maxlength="3" <?php if(isset($_REQUEST['btnFind'])){ ?> readonly="readonly" <?php } ?> />
    Ex : 0XX </label></td>
  </tr>
  <tr>
    <td height="32" class="style3">Main Category Name </td>
    <td class="style3"><label>
    <input name="txtAMCatName" type="text" id="txtAMCatName" size="50" value="<?php echo stripslashes($txtAMCatName); ?>"  />
    </label></td>
  </tr>
  
   <tr>
    <td height="27" colspan="2">
    <input name="btnAdd" type="submit" class="btn2" id="btnAdd" value="Add" onclick="return validateform() " <?php if(isset($_REQUEST['btnFind']) && $ct==2){ ?> disabled="disabled" <?php } ?>/>
    <input name="btnFind" type="submit" class="btn2" id="btnFind" value="Find" onclick="return validatefind()" />
    <input name="btnEdit" type="submit" class="btn2" id="btnEdit" value="Edit" onclick="return validatefind()" <?php if(!isset($_REQUEST['btnFind']) || $ct==1){ ?> disabled="disabled" <?php } ?> />
    <label class="style3" ><font color="#003333"></font> 
   
	<input name="btnClear" type="submit" class="btn2" id="btnClear" value="Clear" />
	</label>
    <input name="btnExit" type="submit" class="btn2" id="btnExit" value="Exit"/>
	<input name="addedUser" type="hidden" id="addedUser" value="<?php echo $addeduser; ?>" />
	<?php 
	  if ($result1)
	  {
	  //echo "$txtMCatCode -". stripslashes($txtAMCatName)." added successfully.";
//	  $txtMCatCode=" ";
//	  $txtAMCatName=" "; 
	  }
	  ?>
    </label></td>
    </tr>
 
 <!-- <tr>
    <td colspan="3"><?php //include 'footer.php'?></td>
  </tr>-->
</table>

</form>
</body>
</html>
