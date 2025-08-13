<?php
include "connect.php";

$data = json_decode(file_get_contents("php://input"), true);
if(!isset($data['id']) || !isset($data['status'])) {
    echo json_encode(['success'=>false]);
    exit;
}

$id = intval($data['id']);
$status = $data['status'];

$stmt = $con->prepare("UPDATE orders SET status=? WHERE id=?");
echo $stmt->execute([$status, $id]) ? json_encode(['success'=>true]) : json_encode(['success'=>false]);
