<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Final Project</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"/>
</head>

<body class="container">
    <div class="container">
        <h1>Login</h1>
        <p>&nbsp;</p>

        <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
            <p style="color:red">Login credentials are not correct</p>
        <?php endif; ?>

        <form method="post" action="controllers/loginProc.php">
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="email">Email</label>
                        <input type="text"
                               class="form-control"
                               id="email"
                               name="email"
                               value="mmacdona@admin.com">
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="password">Password</label>
                        <input type="password"
                               class="form-control"
                               id="password"
                               name="password"
                               value="password">
                    </div>
                </div>
            </div>

            <input type="submit" class="btn btn-primary" value="Login">
        </form>
    </div>
</body>
</html>
