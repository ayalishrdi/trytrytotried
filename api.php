<?php

require_once "koneksi.php";

if(function_exists($_GET['function'])){
    $_GET['function']();
}

// Get Data Users/utuk menampilkan data user
// URL DESIGN Get Data Users:
// localhost/api-native/api.php?function=getUsers
function getUsers(){

        // Permintaan ke server
        global $koneksi;
        $query = mysqli_query($koneksi, "SELECT * FROM users");
        while($data = mysqli_fetch_object($query)){
            $users[] = $data;
        }

        // Menghasilkan response server
        $respon = array(
            'status'    => 1,
            'message'   => 'Success get users',
            'users'     => $users
        );

        // Menampilkan data dalam bentuk JSON
        header('Content-Type: application/json');
        print json_encode($respon);

    }

// Insert Data User
// URL DESIGN Insert Data User:
// localhost/api-native/api.php?function=addUser
function addUser(){
    
        global $koneksi;

        $parameter = array(
            'nama' => '', 
            'alamat' => ''
        );

        $cekData = count(array_intersect_key($_POST, $parameter));

        if($cekData == count($parameter)){

            $nama   = $_POST['nama'];
            $alamat = $_POST['alamat'];
            
            $result = mysqli_query($koneksi, "INSERT INTO users VALUES('', '$nama', '$alamat')");

            if($result){
                return message(1, "Insert data $nama success");
            }else{
                return message(0, "Insert data failed");
            }

            }else{
            return message(0, "Parameter Salah");
        }

    }
         /*/ function addUser(){

         global $koneksi;
         $parameter = array(
             'nama'   => "",
             'alamat' => ""
         );
         $cekData = count(array_intersect_key($_POST, $parameter)); //cekdata dn function buat ngecek parameter nya masuk apa gk

         if($cekData == count ($parameter)){
             $nama    = $_POST['nama'];
            $alamat  = $_POST['alamat'];

             $result =mysqli_query($koneksi, "INSERT INTO users VALUES('','$nama','$alamat')");

                 if(result){
                     $respon = array(
                         'status'    => 1,
                         'message'   =>'insert data success'
                     );
                 }else{
                     $respon = array(
                         'status'    => 1,
                         'message'   =>'insert data failed'
                     );
                 }

         }else{
             $respon = array(
                 'status'    => 0,
                'messege'    => 'parameter salah !'
            );

        }
        //menampilkan data dalam bentuk JSON
       header('Content-Type: application/json');
        print json_encode($respon);
        
 }*/
function message($status, $msg){

    $respon = array(
            'status'    => $status,
            'message'   => $msg
    );

    // Menampilkan data dalam bentuk JSON
    header('Content-Type: application/json');
    print json_encode($respon);
    }

    //count untuk mengecek apakah nama dan alamat ada atau tidak

    function UpdateUser(){
        global $koneksi;

        if(!empty($_GET['id'])){
            $id = $_GET ['id'];     
        }
        $parameter = array (
            'nama'  => "",
            'alamat'=> ""
            
        );
        /*fungsi array_interesect_key() berfungsi untuk membandingkan kunci dari dua atau lebih array, dan mengembalikan kecocokan.*/
    
        $cekData =count(array_intersect_key($_POST, $parameter));

        if ($cekData == count($parameter)){
            
            $nama     = $_POST['nama'];
            $alamat   = $_POST['alamat'];

            $result   = mysqli_query($koneksi, "UPDATE users SET nama='$nama', alamat='$alamat' WHERE id='$id'");

            if($result){
                return message(1, "update data $nama success");
            }else{
                return message(0, "update data failed");
            }

        }else{
            return message(0, "parameter");
        }

            
            
        }
?>