<?php require_once 'templates/header.php'; ?>


    <form action="controller/authController.php" method="POST">
        <div class="mb-3">
            <label for="fname" class="form-label">First name</label>
            <input type="text" class="form-control" id="fname" name="fname">
        </div>

        <div class="mb-3">
            <label for="lname" class="form-label">Last name</label>
            <input type="text" class="form-control" id="lname" name="lname">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>

        <button type="submit" class="btn btn-primary" name="register">Register</button>
    </form>

<?php require_once 'templates/footer.php'; ?>