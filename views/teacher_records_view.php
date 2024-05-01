<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="dist/css/dataTables.bootstrap5.css">
</head>

<body style="background-color: transparent;">
    <div class="container pb-3">
        <table class="table table-bordered data-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time In</th>
                    <th>Time Out</th>
                </tr>
            </thead>
            <tbody>
                <?php $teacher_attendance_data = $model->MOD_GET_ATTENDANCE($_GET["teacher_id"]) ?>
                <?php if ($teacher_attendance_data) : ?>
                    <?php foreach ($teacher_attendance_data as $row) : ?>
                        <tr>
                            <td><?= $row["date_created"] ?></td>
                            <td><?= $row["time_in"] ?></td>
                            <td><?= $row["time_out"] ?></td>
                        </tr>
                    <?php endforeach ?>
                <?php endif ?>
            </tbody>
        </table>
    </div>

    <script src="dist/js/bootstrap.bundle.min.js"></script>
    <script src="dist/js/jquery-3.7.1.js"></script>
    <script src="dist/js/dataTables.js"></script>
    <script src="dist/js/dataTables.bootstrap5.js"></script>

    <script>
        $('.data-table').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": false,
            "info": false,
            "autoWidth": true,
            "responsive": true,
        })
    </script>
</body>

</html>