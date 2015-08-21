<?php 

require_once('warrior.php');

class army{
	private $warriorRunsAwayChance = 20;
	
	public $warriors = array();
	public $warriorPointer = 0;
	public $warriorStats = array();
	function __construct($warriorCount,$armyId) {
		
		for($i=0;$i<$warriorCount;$i++){
			
			//there is a small chance that the warrior runs away
			if(!$this->warriorRunsAway()){
				
				$tmp=new warrior();
				array_push( $this->warriors , $tmp);
				array_push( $this->warriorStats, array($tmp->energy,$tmp->attack,$tmp->potion,0,$armyId,$i) );
			
			}
		}
		
	}
	private function warriorRunsAway(){
		if(rand(0,$this->warriorRunsAwayChance) % $this->warriorRunsAwayChance==0){
			return true;
		}
		return false;
	}
}

?>