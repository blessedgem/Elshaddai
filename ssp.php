<?php

require 'database.php';

$reponse = Database::query($_REQUEST, $_POST);

if($_POST['graph'])
{
    echo json_encode($reponse['result']);
}

else
{
    foreach ($reponse['display'] as $key => $value)
    {
       foreach ($value as $index => $datum)
        {
           $new[] = "$datum";
        }
        $data[] = $new;
        unset($new);
    }

    $output = array(
    //    "sEcho" => intval($_GET['sEcho']),
        "recordsFiltered" => count($reponse['result']),
        "recordsTotal" => count($reponse['result']),
        "data" => $data ? $data : []
    );
    echo json_encode($output);
}