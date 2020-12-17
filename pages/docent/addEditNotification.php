<?php if (isset($_GET['view'])) {
		//this wil be loaded when you try to view a notification
		$viewNotification = $db->viewNotification($_GET['view']);
	} else if (isset($_GET['delete']))  {
		//this wil be loaded when you try to delete a notification
		$viewNotification = $db->viewNotification($_GET['delete']);
		if (isset($_POST['deletNotification'])) {
			$deleteNotification = $db->deleteNotification($_GET['delete']);
		}if (!isset($deleteNotification)){ ?> 
			<form method="POST">
				<input type="submit" name="deletNotification" value="deletNotification">
			</form>
			<p>Are you sure u want to delete this notification:</p>
		<?php } else {
			echo "<p>notification deleted</p>";
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
		<h1>Create a notification</h1>
		<form method="POST">
			<div>
				<label for="title">title</label>
				<input type="text" name="title" required>
			</div>
			<div>
				<label for="message">message</label>
				<textarea name="message" cols="50" rows="7" style="resize: none;" required></textarea>
			</div>
			<div>
				<label for="student">selecteerd een student of geen:</label>
				<select name="student">
				<option value='0'>ALLE studenten</option>
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
			<div>
				<input type="submit" name="postNotification" value="postNotification">
				<input type="reset" value="reset">
			</div>
			<div>
		</form>
<?php } else { echo 'gebruiker toegevoegd';}}
if (isset($_GET['view']) || isset($_GET['delete']) AND !isset($deleteNotification)) {
while ($notification = $viewNotification->fetch_array(MYSQLI_ASSOC)){ ?>
	<p class="title">title: <?php echo $notification['title']?></p>
	<p class="message">Message: <?php echo $notification['message']?></p>
	<?php if ($notification['Vname'] != NULL ) { ?>
		<p class="message">send to: <?php echo $notification['Vname']?></p>
	<?php }?>
	<p class="creater"><?php echo $lang['MADE_BY'].' '. $notification['Cname'] ?></p>
	<p class="date_time">Datum: <?php echo $notification['date_time']?></p>
<?php }}?>