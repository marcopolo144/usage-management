<?php
Abstract class Client{
    abstract public function F1();
    abstract public function F2();

    public function Togggeter(){
        return "DIEU EST BON";
    }

}


class F1 extends Client{
    public function F1(){
     echo "JES SUIS F1";
    }
     public function F2(){
        echo "JES SUIS F2";

    }
}



class F2 extends Client{
    public function F1($prefix=null,$signe="."){
    switch ($prefix) {
        case 'H':
            echo 'Ms'.$signe;
            break;
        
            case 'F':
                echo 'Mm'.$signe;
                break;
    }
    }
     public function F2(){
        echo "PELAGIE LA VIBREUSE";

    }
}
