<?php 
class warrior{
	
	private $maxAttack = 7;
	private $minAttack = 5;
	private $maxEnergy = 15;
	private $minEnergy = 10;
	private $forceLoss = 2;
	private $potionMax = 2;
	private $potionChance = 5;
	private $potionEnergy = 5;
	
	public $fullEnergy = 0;
	
	public $attack = 0;
	public $energy = 0;
	public $potion = 0;
	
	function __construct() {
		//set random attack and energy
		$this->attack = rand($this->maxAttack,$this->minAttack);
		$this->energy = rand($this->maxEnergy,$this->minEnergy);
		$this->fullEnergy = $this->energy;
		$this->potion = rand(0,$this->potionMax);
	}
	public function getHit($attacker){
		
		$this->energy-=$attacker;
		
		//if the warrior survives the attack he will try to drink a potion
		if($this->alive() && $this->potion>0){
			$this->usePotion();
		}
		
	}
	public function hitForce(){
		
		//attack gets lowwer as the warrior loses energy 
		if($this->fullEnergy > $this->energy)
			return $this->attack - ( ($this->fullEnergy - $this->energy) / $this->forceLoss );
		return $this->attack;
	}
	public function usePotion(){
		if(rand(0,$this->potionChance)%$this->potionChance==0){
			$this->potion--;
			$this->energy += $this->potionEnergy;
		}
	}
	public function alive(){
		
		if($this->energy>0){
			return true;
		}
		return false;
		
	}
}

?>
