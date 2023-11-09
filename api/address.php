<?php
require 'db.php';
$data = json_decode(file_get_contents('php://input'), true);
$uid = $data['uid'];
$hno = $data['hno'];
$society = mysqli_real_escape_string($con, $data['society']);
$pincode = $data['pincode'];
$area = $data['area'];
$landmark = mysqli_real_escape_string($con, $data['landmark']);
$aid = $data['aid'];
$type = $data['type'];
$name = $data['name'];
$latitud = $data['latitud'];
$longitud = $data['longitud'];
$municipio = $data['municipio']; // Add "municipio" field
$calle = $data['calle']; // Add "calle" field

if ($area == '' or $hno == '' or $society == '' or $pincode == '' or $aid == '' or $type == '' or $name == '') {
    $returnArr = array("ResponseCode" => "401", "Result" => "false", "ResponseMsg" => "Something Went wrong  try again !");
} else {
    $count = $con->query("select * from user where id=" . $uid . " and status = 1")->num_rows;
    if ($count != 0) {
        if ($aid == 0) {
            $con->query("insert into address(`uid`,`hno`,`society`,`pincode`,`area`,`landmark`,`type`,`name`,`latitud`,`longitud`, `municipio`, `calle`) values(" . $uid . ",'" . $hno . "','" . $society . "'," . $pincode . ",'" . $area . "','" . $landmark . "','" . $type . "','" . $name . "', " . $latitud . ", " . $longitud . ", '" . $municipio . "', '" . $calle . "')");
            $returnArr = array("ResponseCode" => "200", "Result" => "true", "ResponseMsg" => "Dirección agregada correctamente.");
        } else {
            $con->query("update address set hno='" . $hno . "',society='" . $society . "',pincode=" . $pincode . ",area='" . $area . "',landmark='" . $landmark . "',type='" . $type . "',name='" . $name . "', `municipio`='" . $municipio . "', `calle`='" . $calle . "' where id=" . $aid . "");
            $adata = $con->query("select * from address where id=" . $aid . "")->fetch_assoc();
            $p = array();
            $p['id'] = $adata['id'];
            $p['uid'] = $adata['uid'];
            $p['hno'] = $adata['hno'];
            $p['society'] = $adata['society'];
            $p['area'] = $adata['area'];
    // Agregar obtención de municipio y calle
    $p['municipio'] = $adata['municipio']; // Asegúrate de que esta columna exista en tu tabla
    $p['calle'] = $adata['calle']; // Asegúrate de que esta columna exista en tu tabla

            $charge = $con->query("select * from area_db where name='" . $adata['area'] . "'")->fetch_assoc();
            $charges = $con->query("select * from area_db where name='" . $adata['area'] . "'");
            if ($charges->num_rows != 0) {
                $p['IS_UPDATE_NEED'] = FALSE;
            } else {
                $p['IS_UPDATE_NEED'] = TRUE;
            }
            $p['delivery_charge'] = $charge['dcharge'];
            $p['pincode'] = $adata['pincode'];
            $p['landmark'] = $adata['landmark'];
            $p['type'] = $adata['type'];
            $p['status'] = $adata['status'];
            $p['name'] = $adata['name'];

            $returnArr = array("Address" => $p, "ResponseCode" => "200", "Result" => "true", "ResponseMsg" => "Address Updated Successfully!!!");
        }
    } else {
        $returnArr = array("ResponseCode" => "401", "Result" => "false", "ResponseMsg" => "User Either Not Exit OR Deactivated From Admin!");
    }
}
echo json_encode($returnArr);
mysqli_close($con);
?>
