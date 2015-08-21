<?php

require_once('army.php');

class battle {
	
	private $armies = array();
	private $roundCounter = 0;
	public $roundStats = array();
	public $bestWarriors;
	
	function __construct($armieCount) {
		
		//create armies
		$i=1;
		foreach($armieCount as $warriors){
			array_push( $this->armies ,new army($warriors,$i) );
			$i++;
		}
		
		//In each round both players hit. 
		//If a warrior dies it is replaced with the next.
		//The rounds continue until one army has no more warriors
		while(count($this->armies[0]->warriors)>0 && count($this->armies[1]->warriors)>0){
			$this->fight();
			$this->roundCounter++;
		}
		
		//find best warriors
		$this->getBestWarriors();
	}
	private function fight(){
		
		//pick warrior with first hit
		$first=rand(0,1);
		$last = $first==0 ? 1 : 0;
		
		$this->hit($first,$last);
		$this->warriorStatsUpdate($first);
		
		//check if the second army has more warriors
		if(count($this->armies[$last]->warriors)>0){
			$this->hit($last,$first);
			$this->warriorStatsUpdate($last);
		}
		
		
		$this->updateRoundStats();
		
	}
	private function hit($first,$last){
		
		//get hit force
		$force=$this->armies[$first]->warriors[$this->armies[$first]->warriorPointer]->hitForce();
		
		//$first warrior hits $last warrior
		$this->armies[$last]->warriors[$this->armies[$last]->warriorPointer]->getHit($force);
		
		//remove if dead
		if(!$this->armies[$last]->warriors[$this->armies[$last]->warriorPointer]->alive()){		
			unset($this->armies[$last]->warriors[$this->armies[$last]->warriorPointer]);//remove dead warrior from array
			$this->armies[$last]->warriorPointer++;//move pointer to next warrior
		}
		
	}
	public function winner(){ //get the winner (1/2)
		if(count($this->armies[0]->warriors)==0){
			return 1;
		}
		else if(count($this->armies[1]->warriors)==0){
			return 2;
		}
		return 0;
	}
	public function winnerCount(){ 
		if(count($this->armies[0]->warriors)==0){
			return count($this->armies[1]->warriors);
		}
		else if(count($this->armies[1]->warriors)==0){
			return count($this->armies[0]->warriors);
		}
		return 0;
	}
	
	//STATISTICS METHODS
	private function warriorStatsUpdate($first){
		$this->armies[$first]->warriorStats[
			$this->armies[$first]->warriorPointer
		][3]++;
	}
	private function getBestWarriors(){
		//get best warriors from both armies
		//sort by rounds survived [3] DESC 
		usort($this->armies[0]->warriorStats, function($a, $b) {
			return $b[3] - $a[3];
		});
		usort($this->armies[1]->warriorStats, function($a, $b) {
			return $b[3] - $a[3];
		});
		
		$this->bestWarriors = array_merge( array_slice($this->armies[0]->warriorStats,0,18), array_slice($this->armies[1]->warriorStats,0,18) );
		
		usort($this->bestWarriors, function($a, $b) {
			return $b[3] - $a[3];
		});
	}
	private function updateRoundStats(){
		array_push($this->roundStats,array(
			count($this->armies[0]->warriors),count($this->armies[1]->warriors)
		));
	}
}
?>