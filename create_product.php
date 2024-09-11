<?php require_once 'templates/header.php'; ?>

    <form action="controller/productController.php" method="POST" enctype="multipart/form-data">

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name"
                   value="<?php echo Validation::getValue('name') ?>">
        </div>

        <div class="form-floating">
            <textarea class="form-control" id="description"
                      style="height: 100px"><?php echo Validation::getValue('description') ?></textarea>
            <label for="description">Description</label>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="text" class="form-control" id="price" name="price"
                   value="<?php echo Validation::getValue('price') ?>">
        </div>

        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" class="form-control" id="stock" name="stock"
                   value="<?php echo Validation::getValue('stock') ?>">
        </div>

        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" class="form-control" id="stock" name="stock"
                   value="<?php echo Validation::getValue('stock') ?>">
        </div>

        <div class="form-check">
            <input type="file" id="image" name="image" accept="image/png, image/jpeg">
            <label class="form-check-label" for="image">Image</label>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="active" id="active"
                <?php echo Validation::getValue('active') ? 'checked' : ''; ?>>
            <label class="form-check-label" for="active">
                Active
            </label>
        </div>


        <button type="submit" class="btn btn-primary" name="create">Create</button>
    </form>

<?php require_once 'templates/footer.php'; ?>