<?php
    function show($query)
    {
        global $connect;

        $get_data = mysqli_query($connect, $query);
        $rows = [];
        while ($row = mysqli_fetch_assoc($get_data)) {
            $rows [] = $row;
        }

        return $rows;
    }
