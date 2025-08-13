<?php
include "connect.php";
$data = json_decode(file_get_contents("php://input"), true);
if(!isset($data['id'])) { echo json_encode(['success'=>false]); exit; }
$id = intval($data['id']);
$stmt = $con->prepare("UPDATE orders SET status='en cours de traitment' WHERE id=?");
echo $stmt->execute([$id]) ? json_encode(['success'=>true]) : json_encode(['success'=>false]);


