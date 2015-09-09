<?php
$user = getUser ();
$group = getGroup ();
?>
<div id="loginPage"
	style="margin-left: auto; margin-right: auto; width: 100%; max-width: 992px;">
	<h2>Benutzer bearbeiten</h2>
	<div style="width: 100%; margin: auto; max-width: 400px;">
		<div style="width: 100%; text-align: center; margin-bottom: 10px;">
			<img src="<?php echo $user["photo"]; ?>" style="width: 150px;" />
			<p>
			
			
			<h4 style="margin-bottom: 40px;"><?php echo $user["name"]; ?></h4>
			</p>
		</div>

		<div class="button" style="text-align: left;">
			<form action="" method="POST">
				<input type="hidden" name="action" value="updateUser" />
				<p>
					<input type="text" value="Name: <?php echo $user["name"]; ?>"
						class="form-control" disabled />
				</p>
				<p>
					<input type="text" value="E-Mail: <?php echo $user["email"]; ?>"
						class="form-control" disabled />
				</p>

				<p>
					Gruppe: <select name="userGroup" class="form-control" required>
						<option value="-"
							<?php echo ($group["name"] == null ? " selected" : ""); ?>>Gesperrt</option>
						<option value="user"
							<?php echo ($group["name"] == "user" ? " selected" : ""); ?>>User</option>
						<option value="mod"
							<?php echo ($group["name"] == "mod" ? " selected" : ""); ?>>Moderator</option>
						<option value="admin"
							<?php echo ($group["name"] == "admin" ? " selected" : ""); ?>>Admin</option>
					</select>
				</p>

				<p>
					Haupt-Viertel/Ort: <input type="text" name="userArea"
						value="<?php echo $user["area"]; ?>"
						placeholder="Haupt-Viertel/Ort" class="form-control" required />
				</p>
				<p>
					<input type="submit" value="Speichern" class="btn-danger btn" />
					<a href="<?php echo PROJECT_ROOT."/admin/user"; ?>" class="btn btn-default">Zurück</a>
				</p>
			</form>
		</div>
	</div>
</div>
