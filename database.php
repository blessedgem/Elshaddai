<?php

require "vendor/autoload.php";

class Database 
{
    public static function query($request, $post)
    {
        $atiaa = \ntentan\atiaa\Driver::getConnection(
            array(
                'driver' => $post['databasetype'],
                'dbname' => $post['databasename'],
                'password'=> $post['password'],
                'user' => $post['username'],
                'host'=> $post['host']
            )
        );
        $query = self::$post['databasetype']($request, $post);
        
        $result = $atiaa->query($query['query']);
        $display = $atiaa->query($query['display_query']);

        return array(
            'result' => $result,
            'display' => $display
        );
    }
    
    public static function postgresql($request, $post)
    {
        $order = "";
        if (isset($request['order']))
        {
            $order = " ORDER BY ";
            for ( $i = 0; $i < count($post['columnNames']); $i++ ) 
            {
                if ($request['order'][$i]) 
                {
                    $order = $i == 0 ? $order : $order . ", ";
                    $order .= $post['columnNames'][$request['order'][$i]['column']]." ".addslashes($request['order'][$i]['dir']);
                }
            }
            $order = $order == " ORDER BY " ? "" : $order;
        }

        // Paging
        $limit = '';
        if (isset($request['start']) && $request['length'] != -1) 
        {
            $limit = " LIMIT ". $request['length']." OFFSET ".$request['start'];
        }

        // Global Filtering
        $globalSearch = "";
        if ($request['search']['value']) 
        {
            for ( $i = 0; $i < count($post['columnNames']); $i++ ) 
            {
                $globalSearch = $i == 0 ? $globalSearch : $globalSearch . " OR ";
                $globalSearch .= $post['columnNames'][$i] . "::text LIKE '%". $request['search']['value'] . "%'"; 
            }

            $globalSearch = $globalSearch ? "(" . $globalSearch . ")" : "";
            $globalSearch = $post['where'] && $globalSearch ? " AND " . $globalSearch : $globalSearch;
        }

        // Column Filtering
        $columnSearch = "";
        if (isset($request['columns']))
        {
            $count = 0;
            for ( $i = 0; $i < count($post['columnNames']); $i++ ) 
            {
                if ($request['columns'][$i]['search']['value']) 
                {
                    $columnSearch = $count ++ == 0 ? $columnSearch : $columnSearch . " AND ";
                    $columnSearch .= $post['columnNames'][$i] . "::text LIKE '%". $request['columns'][$i]['search']['value'] . "%'"; 
                }
            }

            $columnSearch = $columnSearch ? "(" . $columnSearch . ")" : "";
            $columnSearch = ($post['where'] || $globalSearch) && $columnSearch ? " AND " . $columnSearch : $columnSearch;
        }
        
        $columns = $post['cols'] ? $post['cols'] : "*";
        $conditions = $post['where'] || $globalSearch || $columnSearch ? " WHERE " . $post['where'] : "";

        $conditions .= $globalSearch . $columnSearch;
        
        return array(
            "query" => "SELECT $columns FROM {$post['tablename']} $conditions $order",
            "display_query" => "SELECT $columns FROM {$post['tablename']} $conditions $order $limit"
        );
    }
    
    public static function mysql($request, $post)
    {
        
    }
    
}
