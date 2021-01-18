<div class="container">
	<a href="addeditnotification">+ <?=$lang['ADDNEWNOTIFICATION'];?></a>
	<?php
		$selectAllNotifications = $db->selectAllNotifications();
		$selectCurrentCreaterNotifications = $db->selectCurrentCreatorNotifications($_SESSION['user_id']);
	?>
	<div class="row">
		<div class="notificationsTable col-md-5">
			<h3><?=$lang['PERSONALNOTIFICATIONS'];?></h3>
			<?php while ($thisResult = $selectCurrentCreaterNotifications->fetch_array(MYSQLI_ASSOC)){ ?>
					<hr>
				<div class="notifications">
					<p class="title"><?php echo $thisResult['title'] . '  '. $thisResult['date_time']?></p>
					<a href="addeditnotification?view=<?php echo $thisResult['notification_id']?>"><?=$lang['VIEW'];?></a>
					<a href="addeditnotification?delete=<?php echo $thisResult['notification_id']?>"><?=$lang['DELETE']?></a>
				</div>
			<?php }?>
		</div>
		<div class="col-md-2"></div>
		<div class="notificationsTable col-md-5">
			<h3><?=$lang['GENERALNOTIFICATIONS'];?></h3>
			<?php while ($allResults = $selectAllNotifications->fetch_array(MYSQLI_ASSOC)){ ?>
				<hr>
				<div class="notifications">
					<p class="title"><?php echo $allResults['title'] . '  '. $allResults['date_time']?></p>
					<a href="addeditnotification?view=<?php echo $allResults['notification_id']?>"><?=$lang['VIEW'];?></a>
					<a href="addeditnotification?delete=<?php echo $allResults['notification_id']?>"><?=$lang['DELETE']?></a>
				</div>
			<?php }?>
		</div>
	</div>
</div>