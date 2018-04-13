<?php

    require_once "sqlfunctions.php";
    $number = $_GET["gtin"];
    $field = $_GET["field"];
    $number = preg_replace("/[^A-Za-z0-9 -_]/", "", $number);
    $number = preg_replace("!\s+!", "%", $number);
    $conn = connect_gtin();
    $sql = "select GTIN_CD, BRAND_NM, GTIN_NM from gtin natural join brand natural join brand_type where " . $field . " like '%" . $number . "%'";

    $result = query_gtin($sql, $conn);

    function add_row($my_assoc, $my_key, $my_text) {
        if(!is_null($my_assoc[$my_key])) {
            return $my_text . ": " . $my_assoc[$my_key] . "<br>\n";
        }
        return "";
    }

    function add_button($my_assoc, $my_key, $my_text) {
        $gtin_no = $my_assoc[$my_key];
        if(!is_null($gtin_no)) {
            $my_retval = "<span id='" .$gtin_no. "' title='more info' style='cursor: pointer; background-color: rgba(0,0,0,0.5); padding: 1em 1em 1em 1em; color: white; margin: 1em 0em 1em 0em;' onclick='search_specific_gtin(\"" . "#" .$gtin_no. "\")'> \n";
            $my_retval .= $gtin_no . " \n";
            $my_retval .= "</span> <br><br> \n";
            return $my_retval;
        }
        return "";
    }

    if ($result->num_rows > 0) {
        $retval .= "" . $result->num_rows . " items found.<br><br>\n\n";
        while ($row = $result->fetch_assoc()) {
            $retval .= "<span style='border-bottom: 1px solid black; display: block; width: 100%;'/><br>";

            $retval .= add_button($row, "GTIN_CD", "GTIN Number");
            $retval .= add_row($row, "BRAND_NM", "Brand Name");
            $retval .= add_row($row, "GTIN_NM", "Product Name");
            $retval .= "<div class=\"" . $row["GTIN_CD"] . "\"></div>";
            $retval .= "\n<br>\n";
        }
    }
    disconnect_gtin($conn);
    echo "Results: <br>" . $retval;
?>