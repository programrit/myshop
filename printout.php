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
    $sql=mysqli_query($conn,"SELECT * FROM user WHERE username='$user1'");
    $row=mysqli_fetch_array($sql);
    $status="pending";
    $product_id=$conn->real_escape_string($_GET['id']);
    $size=$conn->real_escape_string($_GET['size']);
    $product_id=htmlspecialchars($product_id);
    $size=htmlspecialchars($size);
    $query="SELECT name,address,user_id,time,price FROM checkout WHERE  user_id='$row[id]'AND product_id='$product_id' AND size='$size' AND status='$status'";
    $result=$conn->query($query);
    if($result->num_rows>0){
        $rows=$result->fetch_assoc();
          $obj=new IndianCurrency($rows['price']);
          $total=$rows['price']+40;
          $obj1=new IndianCurrency($total);
          if($rows['price']>=500){
            $info=[
              "customer"=>ucfirst("$rows[name]"),
              "address"=>"$rows[address]",
              "user_no"=>"$rows[user_id]",
              "invoice_date"=>"$rows[time]",
              "delivery_fees"=>0,
              "total_amt"=>$rows['price'],
              "words"=> $obj->get_words(),
            ];
          }else{
            $info=[
              "customer"=>ucfirst("$rows[name]"),
              "address"=>"$rows[address]",
              "user_no"=>"$rows[user_id]",
              "invoice_date"=>"$rows[time]",
              "delivery_fees"=>40,
              "total_amt"=>$rows['price']+40,
              "words"=> $obj1->get_words(),
              
            ];
          }
    }
    //customer and invoice details  
  //invoice Products
  $products_info=[];
  $query="SELECT * FROM checkout WHERE user_id='$row[id]' AND product_id='$_GET[id]'AND size='$_GET[size]'";
    $result=$conn->query($query);
    if($result->num_rows>0){
        while($rows=$result->fetch_assoc()){
            $products_info[]=[
                "name"=>$rows['product_name'],
                "price"=>$rows['price']/$rows['quantity'],
                "qty"=>$rows['quantity'],
                "total"=>$rows['price'],
            ];
        }
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
      $this->Cell(50,7,"User No : ".$info["user_no"]);
      
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
      $this->Cell(80,9,"Amount in Words ",0,1);
      $this->SetFont('Arial','',12);
      $this->Cell(0,10,$info["words"],0,0);
      
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
  $pdf->Output();
}else{
    header("Location: login");
}?>