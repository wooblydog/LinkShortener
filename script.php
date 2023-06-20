<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Ваш код для обработки полученной строки $url

    $long_url = $_POST['floatingInput'];
    $new_url = search_or_create($long_url);
    echo $new_url;

    // Отправка ответа обратно клиенту
}

function search_or_create($long_url)
{
    $fp = fopen('links.csv', 'r');
    while (($row = fgetcsv($fp, 0, ";")) !== false) {
        if ($row[0] == $long_url) {
            return $row[1];
        }
    }
    return generate_new_link($long_url);
}

function generate_new_link($long_url)
{
    $fp = fopen('links.csv', 'a+');
    $generated_key_for_url = generate_key();
    $new_url = "http://localhost/{$generated_key_for_url}";
    fputcsv($fp, array($long_url, $new_url), ";");

    return $new_url;
}


function generate_key()
{
    $strength = 6;
    $permitted_chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $input_length = strlen($permitted_chars);
    $random_string = '';
    for ($i = 0; $i < $strength; $i++) {
        $random_character = $permitted_chars[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }
    return $random_string;
}



?>