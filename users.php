<?php require_once 'templates/header.php'; ?>
<?php require_once 'models/AdminModel.php'; ?>


<?php
//MIDDLEWARE. RETURN THE NOT ADMIN TO INDEX PHP
if (!Middleware::is_admin()) {
    header('location: index.php');
    exit();
}
?>


<?php
$adminModel = new AdminModel();
$users = $adminModel->index();
?>


<table class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">First</th>
        <th scope="col">Last</th>
        <th scope="col">Email</th>
        <th scope="col">Role</th>
        <th scope="col">Active</th>
        <th scope="col">Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($users as $user): ?>
        <tr>
            <th scope="row"><?php echo htmlspecialchars($user['id']) ?></th>
            <td><?php echo htmlspecialchars($user['fname']) ?></td>
            <td><?php echo htmlspecialchars($user['lname']) ?></td>
            <td><?php echo htmlspecialchars($user['email']) ?></td>

            <?php if ($user['is_admin'] == 1): ?>
                <td class="text-warning">Admin</td>
            <?php else: ?>
                <td class="text-primary">User</td>
            <?php endif; ?>


            <?php if ($user['is_active'] == 1): ?>
                <td class="text-success">Active</td>
            <?php else: ?>
                <td class="text-danger">not Active</td>
            <?php endif; ?>


            <td>
                <a href="edit_user.php?id=<?php echo htmlspecialchars($user['id']) ?>" class="btn btn-primary">Edit</a>

                <form action="controller/adminController.php" method="POST">
                    <input type="hidden" value="<?php echo htmlspecialchars($user['id']) ?>" name="id">
                    <button class="btn btn-danger" name="delete_user">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>


<?php require_once 'templates/footer.php'; ?>
