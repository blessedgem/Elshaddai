<?php

require "vendor/autoload.php";

// Ordering 
$order = "";
if (isset($_REQUEST['order']))
{
    $order = " ORDER BY ";
    for ( $i = 0; $i < count($_POST['columnNames']); $i++ ) 
    {
        if ($_REQUEST['order'][$i]) 
        {
            $order = $i == 0 ? $order : $order . ", ";
            $order .= $_POST['columnNames'][$_REQUEST['order'][$i]['column']]." ".addslashes($_REQUEST['order'][$i]['dir']);
        }
    }
    $order = $order == " ORDER BY " ? "" : $order;
}

// Paging
$limit = '';
if (isset($_REQUEST['start']) && $_REQUEST['length'] != -1) 
{
    $limit = " LIMIT ". $_REQUEST['length']." OFFSET ".$_REQUEST['start'];
}

// Global Filtering
$globalSearch = "";
if ($_REQUEST['search']['value']) 
{
    for ( $i = 0; $i < count($_POST['columnNames']); $i++ ) 
    {
        $globalSearch = $i == 0 ? $globalSearch : $globalSearch . " OR ";
        $globalSearch .= $_POST['columnNames'][$i] . "::text LIKE '%". $_REQUEST['search']['value'] . "%'"; 
    }
    
    $globalSearch = $globalSearch ? "(" . $globalSearch . ")" : "";
    $globalSearch = $_POST['where'] && $globalSearch ? " AND " . $globalSearch : $globalSearch;
}

// Column Filtering
$columnSearch = "";
if (isset($_REQUEST['columns']))
{
    for ( $i = 0; $i < count($_POST['columnNames']); $i++ ) 
    {
        if ($_REQUEST['columns'][$i]['search']['value']) 
        {
            $columnSearch = $i == 0 ? $columnSearch : $columnSearch . " AND ";
            $columnSearch .= $_POST['columnNames'][$i] . "::text LIKE '%". $_REQUEST['columns'][$i]['search']['value'] . "%'"; 
        }
    }
    
    $columnSearch = $columnSearch ? "(" . $columnSearch . ")" : "";
    $columnSearch = ($_POST['where'] || $globalSearch) && $columnSearch ? " AND " . $columnSearch : $columnSearch;
}

$atiaa = \ntentan\atiaa\Driver::getConnection(
    array(
        'driver' => $_POST['databasetype'],
        'dbname' => $_POST['databasename'],
        'password'=> $_POST['password'],
        'user' => $_POST['username'],
        'host'=> $_POST['host'],
    )
);

$columns = $_POST['cols'] ? $_POST['cols'] : "*";
$conditions = $_POST['where'] || $globalSearch || $columnSearch ? " WHERE " . $_POST['where'] : "";

$conditions .= $globalSearch . $columnSearch;
$result = $atiaa->query("SELECT $columns FROM {$_POST['tablename']} $conditions $order");
$displayed = $atiaa->query("SELECT $columns FROM {$_POST['tablename']} $conditions $order $limit");

foreach ($displayed as $key => $value)
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
    "recordsTotal" => count($result),
    "recordsFiltered" => count($result),
    "data" => $data ? $data : []
);
echo json_encode($output);
