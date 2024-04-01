<?php
include_once 'app/views/share/header.php'
?>

<div class="row row-cols-1 row-cols-md-3 g-4">

<?php while ($row = $products->fetch(PDO::FETCH_ASSOC)) : ?>
    <div class="col">
        <div class="card">
            <a href="/chieu5/product/detail/<?=$row['id']?>">
                <img src="<?=$row['thumnail'];?>" class="card-img-top" alt="...">
            </a>
            <div class="card-body">
                    <h5 class="card-title"><?= $row['name'] ?></h5>
                    <p class="card-text"><?= $row['description'] ?></p>
                    <p class="card-text">Giá: <?= $row['price'] ?></p>
                    <!-- Tạo form post để gửi thông tin sản phẩm đi -->
                    <form action="/chieu5/cart/add_to_cart" method="post">
                        <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
                        <input type="hidden" name="product_name" value="<?= $row['name'] ?>">
                        <input type="hidden" name="product_price" value="<?= $row['price'] ?>">
                        <button type="submit" class="btn btn-primary">Mua Ngay</button>
                    </form>
                </div>
        </div>
    </div>
<?php endwhile; ?>
</div>

<?php
include_once 'app/views/share/footer.php'
?>