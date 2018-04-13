<?php

    require_once "sqlfunctions.php";
    $number = $_GET["gtin_cd"];
    $number = intval($number);
    $number = preg_replace("/[^A-Za-z0-9 -_]/", "", $number);
    $number = preg_replace("!\s+!", "%", $number);

    $conn = connect_gtin();
    $sql = "select * from gtin natural join brand natual join brand_type where GTIN_CD = " . $number;

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
            $my_retval = "<span id='" .$gtin_no. "' title='more info' style='cursor: pointer; background-color: rgba(0,0,0,0.5); padding: 1em 1em 1em 1em; color: white; margin: 1em 0em 1em 0em;' onclick='search_specific_gtin(" . $gtin_no. ")'> \n";
            $my_retval .= $gtin_no . " \n";
            $my_retval .= "</span> <br><br> \n";
            return $my_retval;
        }
        return "";
    }

    if ($result->num_rows > 0) {
        $retval = "<br>\n<br>\n";
        $row = $result->fetch_assoc();
        $retval .= add_row($row, "BRAND_NM", "Brand Name");
        if(!is_null($row["BSIN"])) {
            $retval .= "<img src='http://tcarisland.com/img/brand/" . $row["BSIN"] . ".jpg'></img><br>\n";
        }
        $retval .= add_row($row, "SOURCE", "Country Code");
        $retval .= add_row($row, "BRAND_TYPE_NM", "Brand Type");
        $retval .= add_row($row, "PKG_TYPE_NM", "Package Type");
        $retval .= add_row($row, "M_OZ", "Ounces");
        $retval .= add_row($row, "GTIN_NM", "Product Name");
        $retval .= add_row($row, "PRODUCT_LINE", "Product Line");

        if(!is_null($row["BRAND_LINK"]) && strlen($row["BRAND_LINK"]) != 0) {
            $retval .= "Link: <a href='" . $row["BRAND_LINK"] . "'>" . $row["BRAND_LINK"] . "</a>" . "<br>\n";
        }
        //http://tcarisland/img/gtin/gtin-007/0078000002690.jpg
        $gtinNo = "" . $row["GTIN_CD"];
        $firstThree = substr($gtinNo, 0, 3);
        $img_link = "http://tcarisland.com/img/gtin/gtin-" . $firstThree . "/" . $gtinNo . ".jpg";
        if(!is_null($row["IMG"]) && $row["IMG"] == 1) {
            $retval .= "<img src='".$img_link."' width='150px'/>" . "<br>\n";
        }
    }
    disconnect_gtin($conn);
    echo $retval;
?>