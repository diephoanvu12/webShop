<?php

// CartController
class CartController {
    public function remove_item() {
        session_start();
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['item_index'])) {
            $itemIndex = $_POST['item_index'];
            // Xóa sản phẩm khỏi giỏ hàng
            if (isset($_SESSION['cart'][$itemIndex])) {
                unset($_SESSION['cart'][$itemIndex]);
            }
        }
    
        // Chuyển hướng người dùng đến trang giỏ hàng sau khi xóa
        header('Location: /chieu5/cart/view_cart');
        exit;
    }
    public function add_to_cart() {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Kiểm tra xem các trường dữ liệu tồn tại trong yêu cầu POST
            if(isset($_POST['product_id']) && isset($_POST['product_name']) && isset($_POST['product_price'])) {
                // Lấy thông tin sản phẩm từ yêu cầu POST
                $productId = $_POST['product_id'];
                $productName = $_POST['product_name'];
                $productPrice = $_POST['product_price'];

                // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
                $productExists = false;
                foreach ($_SESSION['cart'] as $key => $item) {
                    if (is_array($item) && isset($item['id']) && $item['id'] == $productId) {
                        // Nếu sản phẩm đã có trong giỏ hàng, tăng số lượng
                        $_SESSION['cart'][$key]['quantity'] += 1;
                        $productExists = true;
                        break;
                    }
                }

                // Nếu sản phẩm chưa có trong giỏ hàng, thêm mới
                if (!$productExists) {
                    $_SESSION['cart'][] = [
                        'id' => $productId,
                        'name' => $productName,
                        'price' => $productPrice,
                        'quantity' => 1  // Set default quantity to 1
                    ];
                }

                // Chuyển hướng người dùng đến trang hiển thị giỏ hàng
                header('Location: /chieu5/cart/view_cart');
                exit;
            } else {
                // Nếu thiếu các trường dữ liệu, chuyển hướng về trang chính
                header('Location: /chieu5');
                exit;
            }
        }
    }

    public function calculateTotalQuantityAndPrice($cart, $productId) {
        $totalQuantity = 0;
        $totalPrice = 0;
        foreach ($cart as $item) {
            if (is_array($item) && isset($item['id']) && $item['id'] == $productId) {
                // Tăng số lượng sản phẩm và tính giá tiền
                $totalQuantity += $item['quantity'];
                $totalPrice += $item['price'] * $item['quantity'];
            }
        }
        return ['quantity' => $totalQuantity, 'price' => $totalPrice];
    }

    // Phương thức này sẽ hiển thị trang giỏ hàng
    public function view_cart() {
        session_start();
        // Kiểm tra xem giỏ hàng tồn tại trong session hay không
        if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            // Include view để hiển thị thông tin sản phẩm trong giỏ hàng
            include_once 'app/views/cart/view_cart.php';
        } else {
            // Nếu giỏ hàng trống, chuyển hướng về trang chính
            header('Location: /chieu5');
            exit;
        }
    }
}

?>