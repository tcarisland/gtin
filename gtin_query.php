<?php

    require_once "sqlfunctions.php";
    $number = $_GET["gtin"];
    $field = $_GET["field"];
    $number = preg_replace("/[^A-Za-z0-9 -_]/", "", $number);
    $number = preg_replace("!\s+!", "%", $number);
    $conn = connect_gtin();
    $sql = "select * from gtin natural join brand natual join brand_type where " . $field . " like '%" . $number . "%' limit 1000";
    $result = query_gtin($sql, $conn);
    $retval = "<br>";

    function add_row($my_assoc, $my_key, $my_text) {
        if(!is_null($my_assoc[$my_key])) {
            return $my_text . ": " . $my_assoc[$my_key] . "<br>\n";
        }
        return "";
    }

    if ($result->num_rows > 0) {
        $retval .= "" . $result->num_rows . " items found.<br><br>\n\n";
        while ($row = $result->fetch_assoc()) {
            $retval .= "<span style='border-bottom: 1px solid black; display: block; width: 100%;'/><br>";
            $retval .= add_row($row, "GTIN_CD", "GTIN Number");
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
                $retval .= "\n<br><br>\n";
            }
        }
    disconnect_gtin($conn);
    echo "Results: <br>" . $retval;
?>