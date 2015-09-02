<?php
global $userProfile;
$lead = leadExists();
?>
<div id="loginPage"
	style="margin-left: auto; margin-right: auto; width: 100%; max-width: 992px;">
	<h2>Zugang beantragen</h2>
	<div style="width: 100%; margin: auto; max-width: 400px;">
		<p>Hallo <?php echo $userProfile->displayName; ?>,</p>
		<?php 
		if($lead):
			$time = new DateTime($lead["created"]);
		$time = $time->format("d.m.Y");
		?>
		<p style="margin-bottom: 40px;">
			dein Antrag auf Zugang vom <strong><?php echo $time; ?></strong>
			wurde gespeichert. Bitte poste den unten aufgeführten Text im
			Faction-Chat:
		</p>
		<p><?php echo $lead["verification"]; ?></p>
		<?php 
		else:
		?>
		<p style="margin-bottom: 40px;">um deine Zugehörigkeit zur
			Enlightened-Fraktion zu bestätigen, teile uns bitte dein aktuelles
			Level, Nickname, Viertel und deine E-Mail-Adresse mit:</p>
		<div class="button">
			<form action="" method="POST">
				<input type="hidden" name="action" value="performRegister" />
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

				<p>
				
				
				<table style="width: 100%;">
					<tr>
						<td style="width: 20%; max-width: 1px;"><select name="agentLevel"
							class="form-control" required>
								<option value="" selected disabled>--</option>
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
						</select>
						
						<td style="padding-left: 2px;"><input type="text" name="agentName"
							value="" class="form-control" placeholder="Ingress Nickname"
							required /></td>
					</tr>
				</table>
				</p>

				<p>
					<input type="text" name="agentArea" value=""
						placeholder="Haupt-Viertel/Ort" class="form-control" required />
				</p>
				<p>
					<input type="submit" value="Anmelden" class="btn-danger btn" />
				</p>
			</form>
		</div>
		<?php 
		endif;
		?>
	</div>
</div>
