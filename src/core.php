<?php

function hash_password($password){
    return password_hash($password, PASSWORD_DEFAULT);
}

function validate_login($nama, $password){
    if (empty($nama) || empty($password)) {
        return 'Nama dan password tidak boleh kosong.';
    }
    return null;
}

function validate_barang($nama_barang, $stok){
    if (empty($nama_barang)) {
        return 'Nama barang tidak boleh kosong.';
    }
    if (!is_numeric($stok) || $stok < 0) {
        return 'Stok harus berupa angka dan tidak boleh negatif.';
    }
    return null;
}

function format_tanggal($tanggal){
    return date('d-m-Y', strtotime($tanggal));
}

?>