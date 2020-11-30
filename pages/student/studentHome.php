<div class="notifications">
	<?php
		$selectAllNotifications = $db->selectAllNotifications();
		$selectCurrentUserNotifications = $db->selectCurrentUserNotifications(1);
	?>
	<div class="currentUserNotifications">
		<h3>Mijn notifications</h3>
		<hr>
		<ul>
			<?php while ($thisResult = $selectCurrentUserNotifications->fetch_array(MYSQLI_ASSOC)){ ?>
				<li class="title"><?= $thisResult['title']?></li>
				<li class="message"><?= $thisResult['message']?></li>
				<li class="creator"><?= $thisResult['creater']?></li>
				<li class="date"><?= $thisResult['date_time']?></li>
			<?php }?>
		</ul>
	</div>
		
	<div class="allNotifications">
		<h3>Alle notifications</h3>
		<hr>
		<ul>
			<?php while ($allResults = $selectAllNotifications->fetch_array(MYSQLI_ASSOC)){ ?>
				<li class="title"><?= $allResults['title']?></li>
				<li class="message"><?= $allResults['message']?></li>
				<li class="creator"><?= $allResults['creater']?></li>
				<li class="date"><?= $allResults['date_time']?></li>
			<?php }?>
		</ul>
	</div>
</div>