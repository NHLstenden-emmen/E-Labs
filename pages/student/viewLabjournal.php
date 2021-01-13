<?php
	$getLabjournaal = $db->getLabjournal($_GET['id'], $_SESSION['user_id']);
	while ($result = $getLabjournaal->fetch_array(MYSQLI_ASSOC)){ 
		?>
	<form method="post" class="newlabjournaalcontainer">
		<div>
			<label for="title"><?php echo $lang["TITLE"];?>:</label> </br>
			<p class="groteretextarealabjournaal" name="title"><?php echo $result['title'];?></p>
		</div>
		<div></div>
		<div>
			<label for="Goal"><?php echo $lang["GOAL"];?>:</label> </br>
			<p class="groteretextarealabjournaal" name="Goal"><?php echo $result['Goal'];?></p>
		</div>
		<div>
			<label for="Hypothesis"><?php echo $lang["HYPOTHESIS"];?>:</label> </br>
			<p class="groteretextarealabjournaal" name="Hypothesis" value="<?php echo $result['Hypothesis'];?>"><?php echo $result['Hypothesis'];?></p>
		</div>
		<div>
			<label for="theory"><?php echo $lang["THEORY"];?>:</label> </br>
			<p class="groteretextarealabjournaal" name="theory" value="<?php echo $result['theory'];?>"><?php echo $result['theory'];?></p>
		</div>
		<div>
			<label for="safety"><?php echo $lang["SAFETY"];?>:</label> </br>
			<p class="groteretextarealabjournaal" name="safety" value="<?php echo $result['safety'];?>"><?php echo $result['safety'];?></p>
		</div>
		<div>
			<label for="logboek"><?php echo $lang["LOG"];?>:</label> </br>
			<p class="groteretextarealabjournaal" name="logboek" value="<?php echo $result['log'];?>"><?php echo $result['log'];?></p>
		</div>
		<div>
			<label for="method_materials"><?php echo $lang["METHOD_MATERIALS"];?>:</label> </br>
			<p class="groteretextarealabjournaal" name="method_materials" value="<?php echo $result['method_materials'];?>"><?php echo $result['method_materials'];?></p>
		</div>
		<div>
			<label for="year"><?php echo $lang["YEAR"];?>:</label> </br>
			<p class='groteretextarealabjournaal'><?php echo $result["year"];?></p>
		</div>
	</form>
<?php  }?>