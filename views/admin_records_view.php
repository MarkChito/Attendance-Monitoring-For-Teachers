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
                    <th>Name</th>
                    <th>Date</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $teacher_attendance_data = $model->MOD_GET_ALL_ATTENDANCE() ?>
                <?php if ($teacher_attendance_data) : ?>
                    <?php foreach ($teacher_attendance_data as $row) : ?>
                        <?php
                        $teacher_data = $model->MOD_GET_TEACHER_DETAILS_BY_TEACHER_ID($row["teacher_id"]);

                        foreach ($teacher_data as $teacher_data_row) {
                            $teacher_name = $teacher_data_row["name"];
                        }
                        ?>

                        <tr>
                            <td><?= $teacher_name ?></td>
                            <td><?= $row["date_created"] ?></td>
                            <td class="text-center">
                                <a href="javascript:void(0)" class="view_attendance" teacher_name="<?= $teacher_name ?>" date_created="<?= $row["date_created"] ?>" time_in="<?= $row["time_in"] ?>" time_out="<?= $row["time_out"] ?>" status="<?= $row["status"] ?>">View</a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php endif ?>
            </tbody>
        </table>
    </div>

    <!-- Teacher Attendance Modal -->
    <div class="modal fade" id="teacher_attendance_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Attendance Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <img src="dist/img/default_user_image.png" alt="" style="width: 100px; height: 100px; border-radius: 50%; border: 1px solid gray;">
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <strong>Name:</strong>
                        </div>
                        <div class="col-8">
                            <span id="attendance_details_teacher_name">Juan Dela Cruz</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <strong>Date:</strong>
                        </div>
                        <div class="col-8">
                            <span id="attendance_details_date_created">01/01/2001</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <strong>Time In:</strong>
                        </div>
                        <div class="col-8">
                            <span id="attendance_details_time_in">12:00 am</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <strong>Time Out:</strong>
                        </div>
                        <div class="col-8">
                            <span id="attendance_details_time_out">12:00 pm</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <strong>Status:</strong>
                        </div>
                        <div class="col-8">
                            <span id="attendance_details_status">Out</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
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

        $(".view_attendance").click(function() {
            $("#attendance_details_teacher_name").text($(this).attr("teacher_name"));
            $("#attendance_details_date_created").text($(this).attr("date_created"));
            $("#attendance_details_time_in").text($(this).attr("time_in"));
            $("#attendance_details_time_out").text($(this).attr("time_out") ? $(this).attr("time_out") : "Not Yet Available");
            $("#attendance_details_status").text($(this).attr("status"));

            $("#teacher_attendance_modal").modal("show");
        })
    </script>
</body>

</html>