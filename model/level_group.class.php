<?php

    // level group 
    class LevelGroup{
        public $levelName;
        public $level;

        public function __construct($title,$num){
            $this->levelName  = $title;
            $this->levels     = $num;
        }
    }


?>