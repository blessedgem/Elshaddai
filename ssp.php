<?php

require 'database.php';

$reponse = Database::query($_REQUEST, $_POST);

if($_POST['graph'])
{
    echo $reponse['result'];
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
        "recordsTotal" => count($reponse['result']),
        "recordsFiltered" => count($reponse['display']),
        "data" => $data ? $data : []
    );
    echo json_encode($output);
}