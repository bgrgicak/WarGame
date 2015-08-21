# WarGame

<b>index.php</b> runs the HTML interface

<b>simple.php</b> is a basic working example

<b>/bin</b> files are classes for the war game
<ul>
  <li>
    <b>/bin/battle.php</b> contains variables and methods to run the game. 
    Run by creating a new instance of <i>battle</i>. 
    Give parameter array(Army1 number of warriors, Army2 number of warriors)
    Get result from battle instance with <i>winner</i> method
  </li>
  <li>
    <b>/bin/army.php</b> contains variables and methods to create a army of warriors. 
    Give parameters <i>$warriorCount</i> (first) number of warriors and <i>$armyId</i> (second) unique identificator
  </li>
  <li>
    <b>/bin/warrior.php</b> contains variables and methods to create a warrior. 
  </li>
</ul>


<b>/css</b> stylesheet (not important) 

<b>Working example:</b> http://testing.bero.info/
