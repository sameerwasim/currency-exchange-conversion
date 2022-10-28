<?php

require_once('./env.php');
require_once('./dbFunctions.php');

$token = $_GET['token'];
$hits = $database->select([ 'table' => 'hitRecord', 'where' => "token = '$token'" ]);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>

    <div class="mt-5">
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>IP</th>
                                <th>Timestamp</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($hits as $key => $hit): ?>
                            <tr>
                                <td><?= $hit['id'] ?></td>
                                <td><?= $hit['ip'] ?></td>
                                <td><?= $hit['timestamp'] ?></td>
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