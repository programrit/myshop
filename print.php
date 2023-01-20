<?php 
require ("fpdf185/fpdf.php");
require("number-convert-words.php");
include('include/session.class.php');
include('include/user.class.php');
include('include/databse.class.php');
include('include/collection.class.php');
$conn=DB::db();
session::start();
if (session_status()===PHP_SESSION_NONE) {
    echo"<script>alert('Session not start')</script>";
}
if (session::get('is_login')) {
    $user1=session::get('username');
    $users=mysqli_query($conn, "SELECT * FROM user WHERE username='$user1'");
    $fetch=mysqli_fetch_array($users);
    $user_id=$fetch["id"];
    $product_id=$conn->real_escape_string($_GET["product_id"]);
    $size=$conn->real_escape_string($_GET["size"]);
    $color=$conn->real_escape_string($_GET["color"]);
    $product_id=htmlspecialchars($product_id);
    $size=htmlspecialchars($size);
    $color=htmlspecialchars($color);
    $product_id=base64_decode($product_id);
    $size=base64_decode($size);
    $color=base64_decode($color);
    $sizes=explode(",", $size);
    $sizes=implode("','", $sizes);
    $product_ids=explode(",", $product_id);
    $product_ids=implode("','", $product_ids);
    $colors=explode(",", $color);
    $colors=implode("','", $colors);
    if($sizes=="" || $sizes==null || empty($sizes)){
      echo "<script>alert('Size is not match!')</script>";
      header("refresh:1 url=order");
    }else if($product_ids=="" || $product_ids ==null || empty($product_ids)){
      echo "<script>alert('Product id is not match!')</script>";
      header("refresh:1 url=order");
    }else if($colors=="" || $colors ==null || empty($colors)){
      echo "<script>alert('Color is not match!')</script>";
      header("refresh:1 url=order");
    }else{
      $status="pending";
    $query="SELECT name,address,product_id,user_id,time,SUM(price),order_id FROM checkout WHERE user_id='$user_id' AND status='$status'  AND (size IN ('".$sizes."')) AND (product_id IN ('".$product_ids."')) AND (color IN ('".$colors."'))";
      $result=$conn->query($query);
      if($result->num_rows>0){
        while($rows=$result->fetch_assoc()){
          $obj=new IndianCurrency($rows['SUM(price)']);
          $total=$rows['SUM(price)']+40;
          $obj1=new IndianCurrency($total);
          if($rows['SUM(price)']>=500){
            $info=[
              "customer"=>ucfirst("$rows[name]"),
              "address"=>"$rows[address]",
              "order_no"=>"$rows[order_id]",
              "invoice_date"=>"$rows[time]",
              "delivery_fees"=>0,
              "total_amt"=>$rows['SUM(price)'],
              "words"=> $obj->get_words(),
            ];
          }else{
            $info=[
              "customer"=>ucfirst("$rows[name]"),
              "address"=>"$rows[address]",
              "order_no"=>"$rows[order_id]",
              "invoice_date"=>"$rows[time]",
              "delivery_fees"=>40,
              "total_amt"=>$rows['SUM(price)']+40,
              "words"=> $obj1->get_words(),
            ];
          }
        }
    }else{
      echo "<script>alert('Something went wrong. this product is not will be there')</script>";
    }
    //customer and invoice details  
  //invoice Products
    $status="pending";
    $query1="SELECT * FROM checkout WHERE user_id='$user_id' AND status='$status' AND (size IN ('".$sizes."')) AND (product_id IN ('".$product_ids."')) AND (color IN ('".$colors."'))";
    $result1=$conn->query($query1);
      if($result1->num_rows>0){
          while($row=$result1->fetch_assoc()){
              $products_info[]=[
                  "name"=>$row['product_name'],
                  "price"=>$row['price']/$row['quantity'],
                  "qty"=>$row['quantity'],
                  "total"=>$row['price'],
              ];
          }
      }else{
        header("refresh:1; url=order");
      }
  
  class PDF extends FPDF
  {
    function Header(){
      
      //Display Company Info
      $this->SetFont('Arial','B',14);
      $this->Cell(50,10,"My-shop",0,1);
      $this->SetFont('Arial','',14);
      $this->Cell(50,7,"North Street,",0,1);
      $this->Cell(50,7,"Srivilliputhur 636002.",0,1);
      $this->Cell(50,7,"PH : 9876543210",0,1);
      
      //Display INVOICE text
      $this->SetY(15);
      $this->SetX(-40);
      $this->SetFont('Arial','B',18);
      $this->Cell(50,10,"INVOICE",0,1);
      
      //Display Horizontal line
      $this->Line(0,48,210,48);
    }
    
    function body($info,$products_info){
      
      //Billing Details
      $this->SetY(55);
      $this->SetX(10);
      $this->SetFont('Arial','B',12);
      $this->Cell(50,10,"Bill To: ",0,1);
      $this->SetFont('Arial','',12);
      $this->Cell(50,7,$info["customer"],0,1);
      $this->Cell(50,7,$info["address"],0,1);
      
      //Display Invoice no
      $this->SetY(55);
      $this->SetX(-60);
      $this->Cell(50,7,"Order No : ".$info["order_no"]);
      
      //Display Invoice date
      $this->SetY(63);
      $this->SetX(-60);
      $this->Cell(50,7,"Invoice Date : ".$info["invoice_date"]);
      
      //Display Table headings
      $this->SetY(95);
      $this->SetX(10);
      $this->SetFont('Arial','B',12);
      $this->Cell(80,9,"DESCRIPTION",1,0);
      $this->Cell(40,9,"PRICE",1,0,"C");
      $this->Cell(30,9,"QTY",1,0,"C");
      $this->Cell(40,9,"TOTAL",1,1,"C");
      $this->SetFont('Arial','',12);
      
      //Display table product rows
      foreach($products_info as $row){
        $this->Cell(80,9,$row["name"],"LR",0);
        $this->Cell(40,9,$row["price"],"R",0,"R");
        $this->Cell(30,9,$row["qty"],"R",0,"C");
        $this->Cell(40,9,$row["total"],"R",1,"R");
      }
      //Display table empty rows
      for($i=0;$i<12-count($products_info);$i++)
      {
        $this->Cell(80,9,"","LR",0);
        $this->Cell(40,9,"","R",0,"R");
        $this->Cell(30,9,"","R",0,"C");
        $this->Cell(40,9,"","R",1,"R");
      }
      //Display table total row
      $this->SetFont('Arial','B',12);
      $this->Cell(150,9,"DELIVERY FEES",1,0,"R");
      $this->Cell(40,9,$info["delivery_fees"],1,1,"R");
      $this->Cell(150,9,"TOTAL",1,0,"R");
      $this->Cell(40,9,$info["total_amt"],1,1,"R");
      
      //Display amount in words
      $this->SetY(225);
      $this->SetX(10);
      $this->SetFont('Arial','B',12);
      $this->Cell(0,9,"Amount in Words ",0,1);
      $this->SetFont('Arial','',12);
      $this->Cell(0,9,$info["words"],0,1);
      
    }
    function Footer(){
      
      //set footer position
      $this->SetY(-50);
      $this->SetFont('Arial','B',12);
      $this->Cell(0,10,"for My-shop",0,1,"R");
      $this->Ln(15);
      $this->SetFont('Arial','',12);
      $this->Cell(0,10,"Authorized Signature",0,1,"R");
      $this->SetFont('Arial','',10);
      
      //Display Footer Text
      $this->Cell(0,10,"This is a computer generated invoice",0,1,"C");
      
    }
    
  }
  //Create A4 Page with Portrait 
  $pdf=new PDF("P","mm","A4");
  $pdf->AddPage();
  $pdf->body($info,$products_info);
  ob_end_clean();
  $pdf->Output();
    }
    
}else{
    header("Location: login");
}?>

<?php
// WHERE user_id='$rows[user_id]' AND status='$status' AND size LIKE ('%$sizes%' AND product_id LIKE '%$product_ids%' AND color LIKE '%$color%')