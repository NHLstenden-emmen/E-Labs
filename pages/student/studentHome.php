<div class="container">
	<?php
		$selectAllNotifications = $db->selectAllNotifications();
		$selectCurrentUserNotifications = $db->selectCurrentUserNotifications(1);
	?>
	<div class="row">
		<div class="notificationsTable col-md-6">
			<h3>Mijn notifications</h3>
			<?php while ($thisResult = $selectCurrentUserNotifications->fetch_array(MYSQLI_ASSOC)){ ?>
				<p class="title"><?= $thisResult['title']?></p>
				<p class="message"><?= $thisResult['message']?></p>
				<p class="creater"><?= $thisResult['creater']?></p>
				<p class="date_time"><?= $thisResult['date_time']?></p>
			<?php }?>
		</div>
			
		<div class="notificationsTable col-md-6">
			<h3>Alle Meldingen</h3>
			<?php while ($allResults = $selectAllNotifications->fetch_array(MYSQLI_ASSOC)){ ?>
				<p class="title"><?= $allResults['title']?></p>
				<p class="message"><?= $allResults['message']?></p>
				<p class="creater"><?= $allResults['creater']?></p>
				<p class="date_time"><?= $allResults['date_time']?></p>
			<?php }?>
		</div>
	</div>
</div>