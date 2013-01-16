<?php
class Winkelwagen
{
    private $producten = array();

    function add($id)
    {
       $this->producten[$id] = 1;
    }
    
    function change_amount($id, $amount)
    {
       $this->producten[$id] = $amount;
    }
    
    function get_amount($id)
    {
       return $this->producten[$id];
    }
    
    function get_all()
    {
       return array_keys($this->producten);
    }
    
    function remove($id)
    {
       unset($this->producten[$id]);
    }
    
    function is_empty()
    {
       return count($this->producten) === 0;
    }
}
?>