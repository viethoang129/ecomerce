<?php 
   include '../lib/session.php';
   Session::checkLogin();
   include '../lib/database.php';
   include '../helper/format.php';
?>


<?php
   class adminLogin{
   private $db;
   private $fm;
   public function __construct()
   {
      $this->db = new Database();
      $this->fm = new Format();
   }
   public function login_admin($adminUser,$adminPass){
      $adminUser = $this->fm->validation($adminUser);
      $adminPass = $this->fm->validation($adminPass);

      $adminUser = mysqli_real_escape_string($this->db->link, $adminUser);
      $adminPass = mysqli_real_escape_string($this->db->link, $adminPass);

      if(empty($adminUser) || empty($adminPass)){
         $alert = "Tai khoan va mat khau khong duoc de trong";
         return $alert;
      }else{
         $query = "SELECT * FROM  tbl_admin where adminUser = '$adminUser' AND adminPass = '$adminPass' LIMIT 1";
         $result = $this->db->select($query);
         if($result != false){
            $value = $result->fetch_assoc();
            Session::set('adminlogin', true);

            Session::set('adminId',$value['adminId']);
            Session::set('adminUser',$value['adminUser']);
            Session::set('adminName',$value['adminName']);

            header('Location:index.php');
         }else{
            $alert = "Tai khoan va mat khau khong chinh xac";
            return $alert;
         }
      }
   }

   }
    
?>