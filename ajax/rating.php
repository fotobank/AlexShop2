<?php

include(__DIR__ . '/../system/configs/define/config.php');
/** @noinspection PhpIncludeInspection */
include SYS_DIR . 'core' . DS . 'boot.php';

define('IS_CLIENT', true);
$okay = new Okay();
if (isset($_POST['id']) && is_numeric($_POST['rating'])){
    $product_id = (int)str_replace('product_', '', $_POST['id']);
    $rating = (float)$_POST['rating'];

    if (!isset($_SESSION['rating_ids'])) {$_SESSION['rating_ids'] = [];}

    if (!in_array($product_id, $_SESSION['rating_ids'])){
        $query = $okay->db->placehold('SELECT rating, votes FROM __products WHERE id = ? LIMIT 1', $product_id);
        $okay->db->query($query);
        $product = $okay->db->result();

        if (!empty($product)){
            $rate = ($product->rating * $product->votes + $rating) / ($product->votes + 1);
            $query = $okay->db->placehold("UPDATE __products SET rating = ?, votes = votes + 1 WHERE id = ?", $rate, $product_id);
            $okay->db->query($query);
            $_SESSION['rating_ids'][] = $product_id; // ������ � ������ ������� ��� �������������
            echo $rate;
        } else echo -1; //����� �� ������
    } else echo 0; //��� ����������
} else echo -1; //�������� ���������