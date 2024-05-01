<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div id="qrcode"></div>

    <script src="dist/js/qrcode.min.js"></script>
    <script src="dist/js/jquery-3.7.1.js"></script>

    <script>
        jQuery(document).ready(function() {
            const teacher_id = "<?= $_GET["teacher_id"] ?>";

            generateQRCode(teacher_id);

            function generateQRCode(teacher_id) {
                var input = teacher_id;

                var qr = qrcode(10, 'L');
                qr.addData(input);
                qr.make();
                
                document.getElementById("qrcode").innerHTML = qr.createImgTag(4, 0);
            }
        })
    </script>
</body>

</html>