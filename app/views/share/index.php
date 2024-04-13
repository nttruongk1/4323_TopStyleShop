    <?php
    include_once 'app/views/share/header.php';
    ?>

    <div class="row">

        <a href="/topstyle/product/add" class="btn btn-primary btn-icon-split">
            <span class="icon text-white-50">
            <i class="fa-solid fa-plus"></i>
            </span>
            <span class="text">Add Product</span>
        </a>

        <div class="col-sm-12" style="padding-top: 10px;">
            <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $products->fetch(PDO::FETCH_ASSOC)) : ?>
                        <tr>
                            <th>
                                <?= $row['id'] ?>
                                <!-- <a class="btn btn-danger" href="/topstyle/cart/add/<?= $row['id'] ?>">ADD TO CART</a> -->
                            </th>
                            <th><?= $row['name'] ?></th>
                            <th><?= $row['description'] ?></th>
                            <th style=" width: 20px;
                                        height: 15px;
                                        object-fit: cover;">

                                <?php
                                if (empty($row['image']) || !file_exists($row['image'])) {
                                    echo "No Image!";
                                } else {
                                    echo "<img src='/topstyle/" . $row['image'] . "' alt='' 
                                    style=' width: 160px;
                                            height: 90px;
                                            object-fit: cover;'/>";
                                }
                                ?>

                            </th>
                            <th><?= $row['price'] ?></th>
                            <th >
                                <a href="/topstyle/product/edit/<?=$row['id']?>" style='display: inline-block;'>
                                Sửa
                                </a>
                                <span>|</span>
                                <a href="/topstyle/product/deleted/<?= $row['id'] ?>" style="display: inline-block;">Xóa</a>
                            </th>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php
    include_once 'app/views/share/footer.php';
    ?>