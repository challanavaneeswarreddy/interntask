<?php
    require 'model/taskModel.php';
    require 'model/tasks.php';
    require_once 'config.php';

    session_status() === PHP_SESSION_ACTIVE ? TRUE : session_start();

    class taskController
    {
        function __construct()
        {
            $this->objconfig = new config();
            $this->objsm = new tasksModel($this->objconfig);

        }
        
        public function mvcHandler() 
		{
			$act = isset($_GET['op']) ? $_GET['op'] : NULL;
			switch ($act) 
			{
                case 'add' :                    
					$this->insert();
					break;						
				case 'login':
					$this->login();
					break;				
				case 'signup' :					
					$this -> signup();
					break;
                case 'logout' :
                    $this -> logout();
                    break;
                case 'list' :
                    $this->list();
                    break;
                case 'addimage':
                    $this->image();
                    break;            								
				default:
                    $url="view/login.php";
                    $this->pageRedirect($url);
                    
			}
		}
        
        #page redirection
        public function pageRedirect($url)
		{
			header('Location:'.$url);
		}

        #sinup
        public function signup()
        {       
            $tasktb=new tasks();
            if(isset($_POST['signupbtn']))
                {
                    $username = $_POST['username'];
                    $password = $_POST['psw'];
                    $phone = $_POST['phone'];
                    $count=$this->objsm->check_user($username);
                    if($count>0){
                        $tasktb->sign_error_msg="This user is already exists";
                        $url="view/signup.php";
                        $this->pageRedirect($url);
                    }
                    else{
                        $pass=$this->encrypt($password,1);
                        //$pass=$password;
                        $sta = $this->objsm->createuser($username,$pass,$phone);
                        if ($sta>0){
                            $this->list();
                        }
                        else{
                            $tasktb->sign_error_msg="ERROR: Not Registered";
                            $url="view/signup.php";
                            $this->pageRedirect($url);
                        }

                    }

                }
                $_SESSION['tasktbl0']=serialize($tasktb);
            

            
        }

        #aes encryption
        public function encrypt($data,$val)
        {
            $cipher = "AES-256-CTR"; 

            //Generate a 256-bit encryption key 
            $encryption_key = "AWESOME"; 

            // Generate an initialization vector 
            $iv = 1234567891011121; 
            if($val==1)
            {
                //Data to encrypt  
                $encrypted_data = openssl_encrypt($data, $cipher, $encryption_key, 0, $iv); 

                return $encrypted_data;
            }
            
            else
            {
                $decrypted_data = openssl_decrypt($data, $cipher, $encryption_key, 0, $iv); 

                return $decrypted_data;
            }
             
        }

       


        #login
        public function login()
        {   $tasktb=new tasks();
            
            if(isset($_POST['loginbtn']))
            {
                $username = $_POST['uname'];
                $password = $_POST['psw'];
                $pass=$this->encrypt($password,1);
                $sta=$this->objsm->run($username,$pass);
                if($sta)
                {
                    $this->list();
                    
                }
                else
                {
                    $tasktb->log_error_msg="Login Invalid";
                    $url="view/login.php";
                    $this->pageRedirect($url);
                }
                

            }
            $_SESSION['tasktbl0']=serialize($tasktb);
        }    
        
        
        /* logging out the user */
        function logout()
        {
            session_destroy();
            header('location: index.php');
            exit;
        }

        public function checkValidation($tasktb)
        {    $noerror=true;
            // Validate category        
            if(empty($tasktb->description)){
                $tasktb->description_msg = "Field is empty.";$noerror=false;
            }
            else{$tasktb->description_msg ="";}            
            // Validate name            
            if(empty($tasktb->name)){
                $tasktb->taskname_msg = "Field is empty.";$noerror=false;     
            } 
            else{$tasktb->taskname_msg ="";}

            return $noerror;
        }

        //image upload
        public function image()
        {
            $taskstb=new tasks();
            $noerror = true;
            $output_dir = "images";
            try
            {
                if(isset($_POST['addimage']))
                {
                    if(isset($_SESSION['taskid'])){
                        $task_id=$_SESSION['taskid'];
                    }
        
                    if(isset($_FILES['image'])){
                        
                        $filename = $_FILES["image"]['name'];
                        $filesize = $_FILES["image"]['size'];
                        $filetype = $_FILES["image"]['type'];
                        $fileerror =  $_FILES["image"]['error'];
                        $filetmp =  $_FILES["image"]['tmp_name'];

                        $file_data = explode(".", $filename);
                        $extension = $file_data[count($file_data) - 1];

                        $allowed_extensions = ["jpg", "jpeg", "png"];

                        if(!in_array($extension, $allowed_extensions))
                        {   
                            $tasktb->pic_msg = "Only JPG, JPEG, PNG Imgae types are allowed .";$noerror=false; 
                        }

                        elseif($filesize >5000000){
                            $tasktb->pic_msg = "File Size cannot exceed 5MB.";$noerror=false;
                        }

                        elseif($fileerror > 0 ){
                            $tasktb->pic_msg = "This Image cannot be processed, select another Image!.";$noerror=false;
                        }
                        else
                        {   
                            $RandomNum = time();
                            $ImageName = preg_replace("/\.[^.\s]{3,4}$/", "", $filename);
                            $newFile = $ImageName.'-'.$RandomNum.'.'.$extension;
                            move_uploaded_file($_FILES["image"]["tmp_name"],$output_dir."/".$newFile);
                            $this->objsm->updateRecord($newFile,$task_id);   
                            $this->list();
                            
                        } 
                    }else
                    {
                        $tasktb->pic_msg = "Field is empty .";$noerror=false;    
                    }

                }
                    
            }catch (Exception $e) 
            {
                $this->close_db();	
                throw $e;
            }
            finally{
                if($noerror==false){
                    $url="view/upload.php";
                    $this->pageRedirect($url);
                }
                $_SESSION['tasktbl0']=serialize($tasktb);
            }
            
        }

        #inserting task    
        public function insert()
		{
            try{
                $tasktb=new tasks();
                if (isset($_POST['submit'])) 
                {   
                    // read form value
                    $tasktb->description = trim($_POST['description']);
                    $tasktb->name = trim($_POST['taskname']);
                    
                    
                    //call validation
                    $chk=$this->checkValidation($tasktb);
                                      
                    if($chk)
                    {   
                        //call insert record            
                        $pid = $this -> objsm ->insertRecord($tasktb);
                        
                        if($pid>0){	
                            	
                            $this->list();    
                        }else{
                            echo "Somthing is wrong..., try again.";
                        }
                    }else
                    {    
                        $_SESSION['tasktbl0']=serialize($tasktb);//add session obj           
                        $this->pageRedirect("view/create.php");                
                    }
                }
            }catch (Exception $e) 
            {
                $this->close_db();	
                throw $e;
            }
        }

        #list the tasks
        public function list(){
            $userid=isset($_SESSION['user_id'])?$_SESSION['user_id']:null;
            $result=$this->objsm->selectRecord($userid);
            include "view/taskview.php";                                        
        }



    }
?>