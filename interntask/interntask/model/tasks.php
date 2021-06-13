<?php 
    class tasks
    {
         // table fields
        public $id;
        public $description;
        public $taskname;
        public $pic;
        // message string
        public $id_msg;
        public $description_msg;
        public $taskname_msg;
        public $pic_msg;
        public $log_error_msg;
        public $sign_error_msg;
        // constructor set default value
        function __construct()
        {
            $id=0;$category=$name=$pic="";
            $id_msg=$description_msg=$taskname_msg=$pic_msg=$log_error_msg=$sign_error_msg="";
        }
    }

?>