<?php
    class dboperation
    {
        public $con,$res;
        function __construct()
        {
            $this->con=mysqli_connect("207.211.188.157","pkd","Pranavkd44#","teachers",5632);
            if(!$this->con)
            {
                die("connection failed".mysqli_connect_error());
            }
        }
        public function executequery($sql)
        {
            $this->res=mysqli_query($this->con,$sql);
            return $this->res;
        }
    }
?>
