<?php include_once 'app/views/share/header.php'; ?>
 

<?php
// Tính tổng tiền của các sản phẩm trong giỏ hàng
function calculateTotalPrice($cart) {
    $totalPrice = 0;
    foreach ($cart as $item) {
        if (is_array($item) && isset($item['price']) && isset($item['quantity'])) {
            // Tính tổng giá của từng sản phẩm và cộng vào tổng giá
            $totalPrice += $item['price'] * $item['quantity'];
        }
    }
    return $totalPrice;
}
?>

<div class="container">
    <h2>Giỏ hàng</h2>
    <?php if (!empty($_SESSION['cart'])) : ?>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID sản phẩm</th>
                    <th scope="col">Tên sản phẩm</th>
                    <th scope="col">Giá</th>
                    <th scope="col">Số lượng</th>
                    <th scope="col">Tổng giá</th>
                    <th scope="col">Xóa</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['cart'] as $key => $item) : ?>
                    <tr>
                        <?php if (is_array($item)) : ?>
                            <td><?= $item['id'] ?></td>
                            <td><?= $item['name'] ?></td>
                            <td><?= $item['price'] ?></td>
                            <?php
                            // Tính tổng giá của sản phẩm
                            $totalItemPrice = $item['price'] * $item['quantity'];
                            ?>
                            <td><?= $item['quantity'] ?></td>
                            <td><?= $totalItemPrice ?></td>
                            <td>
    <form action="/chieu5/cart/remove_item" method="post" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
        <input type="hidden" name="item_index" value="<?= $key ?>">
        <button type="submit" class="btn btn-danger">Xóa</button>
    </form>
</td>

                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p><strong>Tổng tiền:</strong> <?= calculateTotalPrice($_SESSION['cart']) ?></p>
        <form action="/chieu5/cart/checkout" method="post">
            <button type="submit" name="checkout" class="btn btn-primary">Thanh Toan</button>
        </form>
    <?php else : ?>
        <p>Giỏ hàng của bạn đang trống</p>
    <?php endif; ?>
</div>

<?php include_once 'app/views/share/footer.php'; ?>
