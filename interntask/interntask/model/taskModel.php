<?php
    class tasksModel
    {
        // set database config for mysql
        function __construct($consetup)
		{
			$this->host = $consetup->host;
			$this->user = $consetup->user;
			$this->pass =  $consetup->pass;
			$this->db = $consetup->db;            					
		}

        // open mysql data base
		public function open_db()
		{
			$this->condb=new mysqli($this->host,$this->user,$this->pass,$this->db);
			if ($this->condb->connect_error) 
			{
    			die("Erron in connection: " . $this->condb->connect_error);
			}
		}
		// close database
		public function close_db()
		{
			$this->condb->close();
		}	


        // insert record
		public function insertRecord($obj)
		{
			try
			{	
				$user_id=isset($_SESSION['user_id'])?$_SESSION['user_id']:null;
				$this->open_db();
				$query=$this->condb->prepare("INSERT INTO Task(user_id,description,title) VALUES (?,?, ?)");
				
				$query->bind_param("iss",$user_id,$obj->description,$obj->name);
				
				$query->execute();
				$res= $query->get_result();
				
				$last_id=$this->condb->insert_id;
				$query->close();
				$this->close_db();
				return $last_id;
			}
			catch (Exception $e) 
			{
				$this->close_db();	
            	throw $e;
        	}
		}

		//to upadte imagename with task_id

		public function updateRecord($image,$pid)
		{
			
			try
			{
				$this->open_db();
				$status=1;
				$query=$this->condb->prepare("UPDATE Task SET pic=?, status=? WHERE task_id=?");
				$query->bind_param("sii", $image,$status,$pid);
				$query->execute();
				$res=$query->get_result();						
				$query->close();
				$this->close_db();
				return true;
			}
			catch (Exception $e) 
			{
            	$this->close_db();
            	throw $e;
        	}

		}




        // select record     
		public function selectRecord($id)
		{
			try
			{
                $this->open_db();
                if($id>0)
				{	
					$query=$this->condb->prepare("SELECT * FROM Task WHERE user_id=?");
					$query->bind_param("i",$id);
				}
                else
                {$query=$this->condb->prepare("SELECT * FROM Task");	}		
				
				$query->execute();
				$res=$query->get_result();	
				$query->close();				
				$this->close_db();                
                return $res;
			}
			catch(Exception $e)
			{
				$this->close_db();
				throw $e; 	
			}
			
		}



		public function createuser($username,$pass,$phone)
		{
			try
			{
				$this->open_db();
				if(!$query=$this->condb->prepare("INSERT INTO user(username,phone,password) VALUES (?, ?, ?)"))
				{
					echo "error";
				}
				else{
				$query->bind_param("sss",$username,$phone,$pass);
				
				$query->execute();
				$res= $query->get_result();
				
				$last_id=$this->condb->insert_id;
				$query->close();
				$this->close_db();
				return $last_id;}
			}
			catch (Exception $e) 
			{
				$this->close_db();	
            	throw $e;
        	}
		}


		public function check_user($username)
		{
			$this->open_db();
			$query= $this->condb->prepare("SELECT * FROM user WHERE username=?");
			$query->bind_param("s",$username);
				
			$result=$query->execute();
			$count = count(array($result));
			return $count;
		}

		#user validation
		public function run($username,$pass)
		{	
			$this->open_db();
			$query=$this->condb->prepare(" SELECT * FROM user WHERE username=? ");
			$query->bind_param("s",$username);
			$query->execute();
			$res= $query->get_result();
			if($res->num_rows >0)
			{
				while($row = mysqli_fetch_array($res))
				{
					//$password = $this->decrypt($row['password']);
					$password=$row['password'];
					$username=$row['username'];
					$user_id=$row['user_id'];
					$status = $row['status'];

					if($pass==$password and $status)
					{
						$_SESSION['loggedIn'] = true;
						$_SESSION['username'] = $username;
						$_SESSION['user_id']=$user_id;
						return true;
					}
					else{
						
						$_SESSION['loggedIn'] = false;
						return false;
					}
				}
				
				
				
			}
			else{
				
				return false;
			} 
			   
		}


	}

?>
