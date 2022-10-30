<?php

    class giohang extends DController{
        
      

        public function __construct(){
            parent::__construct();
            $item = array();
        }

        public function index(){
            $this->giohang();
        }

        public function giohang(){
            Session::checkSession();
            $this->load->view('giohang');
            $this->load->view('footer');
    
         
        }

        public function themgiohang(){
           Session::init();
           $id_product = $_POST['id_product'];
           $table_product = 'tbl_product';
            $cond = "id_product='$id_product'";
            $productmodel = $this->load->model('productmodel');
            $data['productbyid'] = $productmodel->productbyid($table_product,$cond);
            foreach( $data['productbyid'] as $key => $pro){
                $image_product = $pro['image_product'];
            }
    
           if(!empty($_SESSION['cart'])){
            $cart = $_SESSION['cart'];
            // Kiểm tra lần thứ 2 mua hàng đã có id phần tử mảng hay chưa dùng hàm array_key_exists
                if(array_key_exists($id_product,$cart)){
                    $cart[$id_product] = array(
                        "number_product" => (int)$cart[$id_product]["number_product"]+1,
                        "price_product" => $_POST['price_product'],
                        "name" =>$_POST['title_product'],
                        "image_product" =>$image_product,
                        "id_product" =>$id_product,
                        "discount_product"=>$_POST['discount_product']
    
                        
                    );
                }else{
                    $cart[$id_product] = array(
                        "number_product" =>1,
                        "price_product" => $_POST['price_product'],
                        "image_product" =>$image_product,
                        "name" =>$_POST['title_product'],
                        "id_product" =>$id_product,
                        "discount_product"=>$_POST['discount_product']
    
                        
                    );
                }
        }else{
            // Lần đầu tiên mua hàng
            $cart[$id_product] = array(
                "number_product" =>1,
                "price_product" => $_POST['price_product'],
                "image_product" =>$image_product,
                "name" =>$_POST['title_product'],
                "id_product" =>$id_product,
                "discount_product"=>$_POST['discount_product']
                
            );
        }
        $_SESSION['cart'] = $cart;
        print_r($_SESSION['cart']);
       header("Location:".BASE_URL.'/giohang');

    }

    public function capnhatgiohang(){
        Session::init();
        extract($_REQUEST);
        foreach($number_product as $key => $value){
           $_SESSION['cart'][$key]['number_product'] = $value;
        }
        // foreach($number_product as $key=>$value){
        //     $_SESSION['cart'][$key]['number_format'] = $value;
        // }

         header("Location: ".BASE_URL.'/giohang');
    }

    public function xoagiohang($id){
        Session::init();
        unset($_SESSION['cart'][$id]);
        header("Location: ".BASE_URL.'/giohang');
        
    }

    public function thanhtoangiohang(){
            
            $this->load->view('header');

            // tien hanh lay lai thong tin khach hang
            $customermodel = $this->load->model('customermodel');

            // Tao biến table_category_customer để hứng tên bảng dữ liệu sau đó truyển vào hàm category
            $table_customer = 'tbl_customer';
            $id = $_SESSION['userid'];
            $cond = "id_customer='$id'";
            $data['customer'] = $customermodel->customerbyid($table_customer,$cond);
            $this->load->view('thanhtoangiohang',$data);
            $this->load->view('footer');
    }

    public function dathang(){
            Session::init();

        // Lấy thông tin cho bảng hóa đơn
            $note_order = $_POST['note_order'];
            $date_order = date("d-m-Y");
            $id_customer = $_POST['id_customer'];

            // insert vào bảng hóa đơn
            $table_order = 'tbl_order';
            $ordermodel = $this->load->model('ordermodel');
            $data = array(
                'date_order' => $date_order,
                'note_order' => $note_order,
                'id_customer' => $id_customer
             );

            $result = $ordermodel->insert_order($table_order,$data);
            
            // Lấy id vừa insert và insert vào bảng hóa đơn
            $id_order = $ordermodel->lastidinsert();

            $table_orderdetail = 'tbl_order_detail';
            $orderdetailmodel = $this->load->model('orderdetailmodel');
            $items = $_SESSION['cart'];
                    foreach($items as $item){
                        extract($item);
                        $price_product_discount = ($price_product - ($price_product*($discount_product/100)));
                        $data = array(
                            'id_order' => $id_order,
                            'number_product' => $number_product,
                            'price_order_detail' =>  $price_product_discount,
                            'id_product'=> $id_product
                        );
                      $orderdetailmodel->insert_orderdetail($table_orderdetail,$data);
                    }
            
            // Lấy tổng tiền khách hàng đã mua
            $cond = "id_order='$id_order'";
            $total = 0;
            $data['orderdetail'] = $orderdetailmodel->orderdetailbyid($table_orderdetail,$cond);
            foreach($data['orderdetail'] as $key => $orderdet){
                $total+=($orderdet['number_product']* $orderdet['price_order_detail']);
            }
            $total = number_format($total);

            // send mail cho khách hàng
            $gettoemail = $_POST['email'];
            $getfromemail = 'Sondtgcd191140@fpt.edu.vn';
            $content_subject = 'Cám ơn bạn đã mua hàng tại NO5 Mobile <3';
            $content_message = 'Tổng tiền hóa đơn của quý khách là:'.$total.
            ' VNĐ . Đơn hàng sẽ sớm vân chuyển đến cho quý khách và chúc quý khách 1 ngày tốt lành :))';
            $mail = $this->load->model('mailmodel');
            $from = $getfromemai;
            $headers = "From:" . $from;
            $to = $gettoemail;
            $subject =  $content_subject;
            $message = $content_message;
            $result = $mail->sendMail($to,$subject,$message,$headers);

            header("Location: ".BASE_URL.'/index');
     

    }

}

?>

<!-- 
<div class="col-sm-6">
    <h2> Add cart </h2>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>stt</th>
                <th>name product</th>
                <th>thao tac</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($products as $key => $item) :?>
                <tr>
                    <td> <?= $key + 1 ?></td>
                    <td> <?= $item['name'] ?></td>
                    <td>
                        <a href="/cart/cart.php?id=<?= $item['id'] ?>" class="btn btn-xs btn-info"><i class="
                        glyphicon glyphicon-plus"></i> add to cart</a>
                    </td>
              </tr>    
            <?php endforeach ;?>
            
            </tbody>
        </table>
    </div> -->