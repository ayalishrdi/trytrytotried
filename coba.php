<?php

require_once "koneksi.php";

if(function_exists($_GET['function'])){
    $_GET['function']();
}

function getUsers(){

    global $koneksi;
    $query = mysqli_query($koneksi, "SELECT * FROM users");
    while($data = mysqli_fetch_object($query)){
        $users[] = $data;
    }

    $respon = array(
        'status'   =>1,
        'message'  => 'success get users',
        'users'    => $users
    );

    header('Content-Type: application/json');
    print json_encode($respon);

}

function addUser(){

    global $koneksi;

    $parameter = array(
        'nama'  => '',
        'alamat' => ''
    );
    $cekData = count(array_intersect_key($_POST, $parameter));

    if($cekData == count($parameter)){
        $nama   = $_POST['nama'];
        $alamat = $_POST['alamat'];
        
        $result = mysqli_query($koneksi, "INSERT INTO users VALUES('', '$nama', '$alamat')");

        if($result){
            $respon = array(
                'status'   =>1,
                'message'  =>'Insert Data Succes'
            );
        }else{
            $respon = array(
                'status'   =>0,
                'message'  =>'Insert Data Failed'
            );
        }
    }else{
        $respon = array(
            'status'   =>0,
            'message'  =>'Parameter Salah'
        );
    }
    header('Content-Type: application/json');
    print json_encode($respon);

}

// update data user
// URL DESIGN update data user
// localhost/api-native/api.php?function=updateUser
function updateUser(){

    global $koneksi;

    if(!empty($_GET['id'])){
        $id =$_GET['id'];
    }

    $parameter = array(
        'nama' =>"",
        'alamat' =>""
    );

    // fungsi array_inetrsect_key()berfungsi untuk membandingkan kunci dari dua(atau lebih) array, dan mengembalikan kecocokan
    $cekData = count(array_intersect_key($_POST, $parameter));

    if($cekData == count($parameter)){
        $nama =$_POST['nama'];
        $alamat =$_POST['alamat'];

        $result =mysqli_query($koneksi, "UPDATE users SET nama='$nama', alamat='$alamat' WHERE id='$id'");

        if($result){
            return message(1, "Update data $nama success");
        }else{
            return message(0, "Update data failed");
        }

    }else{
        return message(0, "parameter salah");
    }
}


// delete data user
// URL DESIGN delete data user:
// localhost/api-native/api.php?function=deleteUser&id={id}
function deleteUser(){

    global $koneksi;

    if(!empty($_GET['id'])){
        $id = $_GET['id'];
    }

    $result =mysqli_query($koneksi, "DELETE FROM users WHERE id='$id'");

    if($result){
        return message(1, "delete data succsess");
    }else{
        return message(0, "delete data failed");
    }

}

// Detail Data User per id
// URL DESIGN Data user per id
// localhost/api-native/api.php?function=detailUserId&id=(id)
function detailUserId(){

    global $koneksi;

    if(!empty($_GET['id'])){
        $id = $_GET['id'];
    }

    $result = $koneksi->query("SELECT * FROM users WHERE id='$id'");

    while($data = mysqli_fetch_object($result)){
        $detailUser[] = $data;
        $nama = $data->nama;
    }
    
    if($detailUser){
        $respon = array(
            'status'  =>1,
            'message' => "Berhasil mendapatkan data $nama",
            'user'    => $detailUser
        );
    }else{
        return message(0, "Data tidak ditemukan");
    }


    // Menampilkan data dalam bentuk JSON
    header('Content-Type: application/json');
    print json_encode($respon);

}


?>