<?php
define("MB", 1048576);
$msgErr = [];

/**
 * Upload d'une image avec validation
 */
function imageUpload($imageRequest) {
    global $msgErr;

    $allowExt = ["jpg", "png", "gif", "mp3"];

    // Vérification de l'erreur d'upload
    if (!isset($_FILES[$imageRequest]) || $_FILES[$imageRequest]['error'] !== UPLOAD_ERR_OK) {
        $msgErr[] = "upload_error";
        return json_encode(["status" => "fail", "errors" => $msgErr]);
        return;
    }

    $imageNameOriginal = $_FILES[$imageRequest]['name'];
    $imageTmp = $_FILES[$imageRequest]['tmp_name'];
    $imageSize = $_FILES[$imageRequest]['size'];

    // Extension sécurisée
    $ext = strtolower(pathinfo($imageNameOriginal, PATHINFO_EXTENSION));

    // Vérification de l'extension
    if (!in_array($ext, $allowExt)) {
        $msgErr[] = "ext";
    }

    // Vérification de la taille
    if ($imageSize > 2 * MB) {
        $msgErr[] = "size";
    }

    // Si aucune erreur, on déplace le fichier
    if (empty($msgErr)) {
        $imageName = uniqid('', true) . "." . $ext;
        $uploadDir = __DIR__ . "/uploads";

        // Création du dossier si inexistant
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Déplacement du fichier
        if (move_uploaded_file($imageTmp, $uploadDir . "/" . $imageName)) {
            return json_encode(["status" => "success", "imagename" => $imageName]);
        } else {
            return json_encode(["status" => "fail", "errors" => ["upload"]]);
        }
    } else {
        return json_encode(["status" => "fail", "errors" => $msgErr]);
    }
}

/**
 * Suppression sécurisée d'un fichier
 */
function deletefile($dir, $imagename) {
    $filePath = realpath($dir . "/" . $imagename);
echo "<br>";
echo $filePath;
    // Vérifie que le fichier est bien dans le dossier
    if ($filePath && strpos($filePath, realpath($dir)) === 0 && file_exists($filePath)) {
        unlink($filePath);
    }
}
