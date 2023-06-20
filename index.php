<?php
$key = $_SERVER['REQUEST_URI'];

if (!empty($key)) {
    $original_url = get_original_url($key);

    if ($original_url !== null) {
        header("Location: $original_url");
        exit;
    }
}

function get_original_url($key)
{
    $fp = fopen('links.csv', 'r');
    while (($row = fgetcsv($fp, 0, ";")) !== false) {
        if ($row[1] == "http://localhost$key") {
            return $row[0];
        }
    }
    return null;
}

?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>Link Cutter</title>
</head>
<body class="mx-auto p-5 m-5">
<form id="urlForm" method="post" action="" name="urlForm">
    <div class="form-floating m-5  align-middle d-flex justify-content-center ">
        <input type="url" class="form-control" id="floatingInput" name="floatingInput" placeholder="-" required
               value="<?= $_POST['floatingInput'] ?>">
        <label for="floatingInput">Type url to shortening</label>
        <button type="submit" class="ms-5 btn btn-primary pe-5 ps-5" id="submitBtn">Cut</button>
    </div>
    <div class="d-flex justify-content-center">
        <p id="resultContainer" class="mt-4"></p>
        <button class="ms-5 btn btn-primary pe-5 ps-5" onclick="copytext('#resultContainer')" id="kildsan">Копировать
        </button>
    </div>
</form>
</body>

<script src="https://code.jquery.com/jquery-latest.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>

<script>
    $(document).ready(function () {
        $('#urlForm').submit(function (event) {
            event.preventDefault();

            var url = $('#floatingInput').val();

            $.ajax({
                type: 'POST',
                url: 'script.php',
                data: {floatingInput: url},
                success: function (response) {
                    $('#resultContainer').html(response);
                }
            });
        });
    });
</script>

<script>
    function copytext(el) {
        var $tmp = $("<input>");
        $("body").append($tmp);
        $tmp.val($(el).text()).select();
        document.execCommand("copy");
        $tmp.remove();
    }
</script>
</html>
