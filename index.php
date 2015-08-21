<!DOCTYPE html>
<?php 
require_once('bin/battle.php');
?>
<html>
<head>
	<title>War game</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<link href="css/style.css" rel='stylesheet' type='text/css'/>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script type="text/javascript"
          src="https://www.google.com/jsapi?autoload={
            'modules':[{
              'name':'visualization',
              'version':'1',
              'packages':['corechart']
            }]
          }">
	</script>
  </head>
  <body>
	<?php

	$time_start = microtime(true); 

	if(isset($_GET['army1']) && isset($_GET['army2']) && is_numeric($_GET['army1']) && is_numeric($_GET['army2'])){
		
			
		$battle  =new battle(array($_GET['army1'],$_GET['army2'])); //start battle

		$time_end = microtime(true);
		$execution_time = (int)(($time_end - $time_start) * 1000 );
		?>
		<div id="score">
			<p class="title">
				Army<?php echo $battle->winner(); ?> won
			</p>
			<p class="text">
				<?php
					echo $battle->winnerCount();
				?> warriors survived
			</p>
			<p class="text">
				The battle lasted for <?php echo $execution_time; ?> milliseconds
			</p>
		</div>
		<form id="retry">
			<label>Army1: </label>
			<input name="army1"  placeholder="number of warriors" value="<?php 
				if(isset($_GET['army1'])) {
					echo $_GET['army1']; 
				}
			?>" type="text" />
			<label name="army2" >Army2: </label>
			<input name="army2"  placeholder="number of warriors" value="<?php 
				if(isset($_GET['army2'])) {
					echo $_GET['army2']; 
				}
				?>"  type="text" />
			<input type="submit" value="Restart battle" />
		</form>
		<div id="curve_chart"></div>
		<div id="fame">
			<p class="title">
				Best warriors
			</p>
			<?php 
				$colors=array(
					'6B9B83','E55259','9FF2C4','F9A181','AFAD5D','6B553F','38465B','F4E029','B1CE0A','DD480D'
				);
				foreach($battle->bestWarriors as $best){ 

					
					//pick player colors
					$color1=$colors[rand(0,count($colors))];

					$color2=$colors[rand(0,count($colors))];
					while($color2==$color1){
						$color2=$colors[rand(0,count($colors))];
					}
					
					$color3=$colors[rand(0,count($colors))];
					while($color3==$color1 || $color3==$color2){
						$color3=$colors[rand(0,count($colors))];
					}


					?> 
					<div class="best">
						<div class="bestPhoto">
							<div class="bestPhotoInner" style="background-color: #<?php echo $color1; ?>"></div>
							<div class="bestPhotoInner1" style="background-color: #<?php echo $color2; ?>"></div>
							<div class="bestPhotoInner2" style="background-color: #<?php echo $color3; ?>"></div>
						</div>
						<div class="bestName">
							<?php echo 'Warrior'.$best[5].'Army'.$best[4]; ?>
						</div>
						<div class="bestStats">
							<p>
								<label>Rounds survived</label>
								<span>
									<?php echo $best[3]; ?>
								</span>
							</p>
							<p>
								<label>Potions</label>
								<span>
									<?php echo $best[2]; ?>
								</span>
							</p>
							<p>
								<label>Energy</label>
								<span>
									<?php echo $best[0]; ?>
								</span>
							</p>
							<p>
								<label>Attack</label>
								<span>
									<?php echo $best[1]; ?>
								</span>
							</p>
						</div>
					</div>
			<?php } ?>
		</div>
		<?php
	}
	else{
		?>
		<div id="alert">
			<span>You need to set the number of warriors for Army1 and army2</span>
			<form id="retry">
				<label>Army1</label>
				<input name="army1" placeholder="number of warriors"  value="<?php 
					if(isset($_GET['army1'])) {
						echo $_GET['army1']; 
					}	
					?>" type="text" />
				<label>Army2</label>
				<input name="army2" placeholder="number of warriors" value="<?php 
					if(isset($_GET['army2'])) {
						echo $_GET['army2']; 
					}
				?>"  type="text" />
				<input type="submit" value="Restart battle" />
			</form>
		</div>
		<?php
	}
	?>
	
	  
	  
	  
	  
	<script type="text/javascript">
		$(document).ready(function(){
			if($('#score')){
				
				//create line chart
				
				google.setOnLoadCallback(drawChart);

				//add data
				var data = google.visualization.arrayToDataTable([
					["Round","Army1","Army2"],<?php 
					$i=1;
					foreach($battle->roundStats as $round){
						echo '["'.$i.'",'.$round[0].','.$round[1].']';
						if($i<count($battle->roundStats )){
							echo ',';
						}
						$i++;
					}
				?>]);

				var options = {
					title: 'Warrior number in rounds',
					curveType: 'function',
					legend: { position: 'bottom' },
					series: {
						<?php if($battle->winner()==2){  ?>
						0: { color: '#59C159' },
						1: { color: '#e2431e' }
						<?php } 
						else if($battle->winner()==1){  ?>
						0: { color: '#e2431e' },
						1: { color: '#59C159' }
						<?php } ?>
					}
				};
				
				function drawChart() {
					
						var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
						chart.draw(data, options);
				}
			
				window.onload = drawChart();
				window.onresize = drawChart;
			}
		});
	</script>
</body>

</html>
