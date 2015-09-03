<?php
global $userProfile;
global $user;
$agent = getAgent ();
?>
<div id="loginPage"
	style="margin-left: auto; margin-right: auto; width: 100%; max-width: 992px;">
	<h2>Mein Profil</h2>
	<div style="width: 100%; margin: auto; max-width: 400px;">
		<p>Hallo <?php echo $userProfile->displayName; ?>,</p>

		<div class="button">
			<form action="" method="POST">

				<p>
					<input type="text"
						value="Name: <?php echo $userProfile->displayName; ?>"
						class="form-control" disabled />
				</p>
				<p>
					<input type="text"
						value="E-Mail: <?php echo $userProfile->email; ?>"
						class="form-control" disabled />
				</p>

				<hr />
				<?php
				if ($agent) :
					?>
				
				<input type="hidden" name="action" value="updateAgent" /> <input
					type="hidden" name="agentId" value="<?php echo $agent["id"]; ?>" />

				<p>
					<input type="text" class="form-control"
						placeholder="Ingress Nickname"
						value="<?php echo $agent["name"]; ?>" disabled />
				</p>

				<table style="width: 100%;">

					<tr>
						<td style="width: 20%; max-width: 1px;"><select name="agentLevel"
							class="form-control" required>
								<option value="">--</option>
								<option value="1"
									<?php echo ($agent["level"] == "1" ? " selected" : ""); ?>>1</option>
								<option value="2"
									<?php echo ($agent["level"] == "2" ? " selected" : ""); ?>>2</option>
								<option value="3"
									<?php echo ($agent["level"] == "3" ? " selected" : ""); ?>>3</option>
								<option value="4"
									<?php echo ($agent["level"] == "4" ? " selected" : ""); ?>>4</option>
								<option value="5"
									<?php echo ($agent["level"] == "5" ? " selected" : ""); ?>>5</option>
								<option value="6"
									<?php echo ($agent["level"] == "6" ? " selected" : ""); ?>>6</option>
								<option value="7"
									<?php echo ($agent["level"] == "7" ? " selected" : ""); ?>>7</option>
								<option value="8"
									<?php echo ($agent["level"] == "8" ? " selected" : ""); ?>>8</option>
								<option value="9"
									<?php echo ($agent["level"] == "9" ? " selected" : ""); ?>>9</option>
								<option value="10"
									<?php echo ($agent["level"] == "10" ? " selected" : ""); ?>>10</option>
								<option value="11"
									<?php echo ($agent["level"] == "11" ? " selected" : ""); ?>>11</option>
								<option value="12"
									<?php echo ($agent["level"] == "12" ? " selected" : ""); ?>>12</option>
								<option value="13"
									<?php echo ($agent["level"] == "13" ? " selected" : ""); ?>>13</option>
								<option value="14"
									<?php echo ($agent["level"] == "14" ? " selected" : ""); ?>>14</option>
								<option value="15"
									<?php echo ($agent["level"] == "15" ? " selected" : ""); ?>>15</option>
								<option value="16"
									<?php echo ($agent["level"] == "16" ? " selected" : ""); ?>>16</option>
						</select></td>

						<td style="padding-left: 2px;"><input type="text" name="agentAp"
							value="<?php echo $agent["ap"]; ?>" class="form-control"
							placeholder="AP" required /></td>
					</tr>
				</table>

				<p style="margin-top: 20px;">
					<input type="text" name="userArea"
						value="<?php echo $user["area"]; ?>"
						placeholder="Haupt-Viertel/Ort" class="form-control" required />
				</p>
				<p>Deinen Ingress Nicknamen kannst du nicht selbst verändern.
					Solltest du dich hier verschrieben haben, wende dich bitte an einen
					Mod.</p>
				
				
				
				
				
				
				
				
				
				
				
				
				<?php
				else :
					?>
					<input type="hidden" name="action" value="createAgent" />

				<p>
					<input type="text" class="form-control"
						placeholder="Ingress Nickname" name="agentName" />
				</p>

				<table style="width: 100%;">

					<tr>
						<td style="width: 20%; max-width: 1px;"><select name="agentLevel"
							class="form-control" required>
								<option selected disabled>--</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
								<option value="11">11</option>
								<option value="12">12</option>
								<option value="13">13</option>
								<option value="14">14</option>
								<option value="15">15</option>
								<option value="16">16</option>
						</select></td>

						<td style="padding-left: 2px;"><input type="text" name="agentAp"
							value="<?php echo $agent["ap"]; ?>" class="form-control"
							placeholder="AP" required /></td>
					</tr>
				</table>

				<p style="margin-top: 20px;">
					<input type="text" name="userArea" placeholder="Haupt-Viertel/Ort"
						class="form-control" value="<?php echo $user["area"]; ?>" />
				</p>
				
				
				
				
				
				
				
				<?php
					
echo "";
				endif;
				?>
				<p>
					<input type="submit" value="Speichern" class="btn-success btn" />
				</p>
			</form>
		</div>
	</div>
</div>
