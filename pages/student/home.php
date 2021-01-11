<div class="container">
	<?php
		$selectAllNotifications = $db->selectAllNotifications();
		$selectCurrentUserNotifications = $db->selectCurrentUserNotifications($_SESSION['user_id']);
	?>
	<div class="row">
		<div class="notificationsTable col-md-5">
			<h3><?php echo $lang["USERS_NOTIFICATIONS"];?></h3>
			<?php while ($thisResult = $selectCurrentUserNotifications->fetch_array(MYSQLI_ASSOC)){ ?>
					<hr>
				<div class="notifications">
					<p class="title"><?php echo $thisResult['title']?></p>
					<p class="message"><?php echo $thisResult['message']?></p>
					<p class="creater"><?php echo $lang['MADEBY'].' '. $thisResult['name'] ?></p>
					<p class="date_time"><?php echo $thisResult['date_time']?></p>
				</div>
			<?php }?>
		</div>
		<div class="col-md-2"></div>
		<div class="notificationsTable col-md-5">
			<h3><?php echo $lang["ALL_NOTIFICATIONS"];?></h3>
			<?php while ($allResults = $selectAllNotifications->fetch_array(MYSQLI_ASSOC)){ ?>
				<hr>
				<div class="notifications">
					<p class="title"><?php echo $allResults['title']?></p>
					<p class="message"><?php echo $allResults['message']?></p>
					<p class="creater"><?php echo $lang['MADEBY'].' '. $allResults['name'] ?></p>
					<p class="date_time"><?php echo $allResults['date_time']?></p>
				</div>
			<?php }?>
		</div>
	</div>
</div>