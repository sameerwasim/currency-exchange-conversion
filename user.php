<?php

require_once('./env.php');
require_once('./dbFunctions.php');

$users = $database->select([ 'table' => 'user' ]);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>

    <div class="mt-5">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <form action="<?= baseUrl('actions/user.php') ?>" method="post">
                                <input type="hidden" name="action" value="add">
                                <div class="form-group mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Name" />
                                </div>
                                <div class="form-group mb-3">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" name="email" placeholder="Email" />
                                </div>
                                <div class="form-group mb-3">
                                    <label for="hits">Hits</label>
                                    <input type="text" class="form-control" name="hits" placeholder="Hits" />
                                </div>
                                <div class="form-group mb-3">
                                    <label for="submit">Submit</label>
                                    <input type="submit" class="btn btn-success w-100" name="submit"
                                        placeholder="Submit" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Hits</th>
                                <th>Token</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($users as $key => $user): ?>
                            <tr>
                                <td><?= $user['id'] ?></td>
                                <td><?= $user['name'] ?></td>
                                <td><?= $user['email'] ?></td>
                                <td><?= $user['hits'] ?></td>
                                <td><?= $user['token'] ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>

</html>