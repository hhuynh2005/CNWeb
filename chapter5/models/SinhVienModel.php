<?php

function getAllSinhVien($pdo)
{
    $sql = "SELECT * FROM sinhvien";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addSinhVien($pdo, $ten, $email)
{
    $sql = "INSERT INTO sinhvien (ten_sinh_vien, email) VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$ten, $email]);
}

?>