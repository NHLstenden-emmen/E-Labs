<?php if (isset($_GET['view'])) {
		//this wil be loaded when you try to view a notification
		$viewNotification = $db->viewNotification($_GET['view']);
	} else if (isset($_GET['delete'])) {
		//this wil be loaded when you try to delete a notification
		$viewNotification = $db->viewNotification($_GET['delete']);
		if (isset($_POST['deletNotification'])) {
			$deleteNotification = $db->deleteNotification($_GET['delete']);
		}
		if (!isset($deleteNotification)) { 
?> 		
		<div class="deleteNotificationButton">
			<form method="POST">
				<p><?=$lang['AREYOUSURE'];?></p>
				<input type="submit" name="deletNotification" value="<?=$lang['DELETENOTIFICATION'];?>">
			</form>	
		</div>
		<?php 
		} else {
			echo "<p>".$lang['NOTIFICATIONDELETED']."</p>";
		}
	} else {
		//this wil be loaded when there is no get set so you can add a new notification
		$userId = $_SESSION['user_id'];
		if(isset($_POST['postNotification'])){
			$title =  $_POST['title'];
			$message =  $_POST['message'];
			$date_time =  date('Y-m-d H:i:s');
			$viewer = $_POST['student'];
			$addNewNotification = $db->addNewNotification($userId, $viewer, $title, $message, $date_time);
		}
		if (!isset($addNewNotification)) {
		?> 
		<div class="addEditNotificationContainer">
			<h1><?=$lang['CREATENOTIFICATION'];?></h1>
			<form method="POST">
				<div>
					<label for="title"><?=$lang['TITLE'];?></label>
					<input type="text" class="textInputNotification" name="title" required>
				</div>
				<div>
					<label for="message"><?=$lang['MESSAGE'];?></label>
					<textarea name="message" class="textAreaNotification" required></textarea>
				</div>
				<div>
					<label for="student"><?=$lang['SELECTSTUDENTS'];?></label>
					<select name="student">
					<option value='0'><?=$lang['ALLSTUDENTS'];?></option>
					<?php
						$selectStudents = $db->selectStudents();
						while ($user = $selectStudents->fetch_array(MYSQLI_ASSOC)){
							if($user['user_id'] !== $_SESSION['user_id']){
								echo "<option value='".$user["user_id"]."'>".$user['name']."</option>";
							}
						}
					?>
					</select>
				</div>
				<div class="formButtons">
					<input type="submit" name="postNotification" value="<?=$lang['SEND'];?>">
					<input type="reset" value="reset">
				</div>
				<div>
			</form>
		</div>
		<?php 	
		} else { 
		echo $lang['ADDEDNOTIFICATION'];
		}
	}
	if (isset($_GET['view']) || isset($_GET['delete']) AND !isset($deleteNotification)) {
		while ($notification = $viewNotification->fetch_array(MYSQLI_ASSOC)){ 
		?>
			<div class="viewNotificationContainer">
				<table>
					<tr>
						<td class="notificationHeader"><?php echo $lang['TITLE']?>:</td>
						<td><?php echo $notification['title']?></td>
					</tr>
					<tr>
					<?php 
						if ($notification['Vname'] != NULL ) { 
					?>		
							<td class="notificationHeader"><?php echo $lang['SENDTO']?>:</td>
							<td><?php echo $notification['Vname']?></td>
					<?php 
						}
					?>
					</tr>
					<tr>
						<td class="notificationHeader"><?php echo $lang['MADEBY']?>:</td>
						<td><?php echo $notification['Cname']?></td>
					</tr>
					<tr>
						<td class="notificationHeader"><?php echo $lang['DATE']?>:</td>
						<td><?php echo $notification['date_time']?></td>
					</tr>
				</table>
			</div>
		<?php 	
		}
	}
		?>