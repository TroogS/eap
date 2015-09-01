<?php
$activeLeads = getActiveLeads ();
$inactiveLeads = getInactiveLeads ();
?>
<div id="loginPage"
	style="margin-left: auto; margin-right: auto; width: 100%; max-width: 992px;">
	<h2>Offene Anfragen</h2>
	<div
		style="margin-left: auto; margin-right: auto; margin-bottom: 75px; width: 100%; max-width: 600px;">
	        <?php
									if (count ( $activeLeads ) == 0) {
										echo "Aktuell keine Anfragen";
									}
									
									foreach ( $activeLeads as $key => $l ) :
										?>
										<div
			style="border: 0px solid red; padding: 10px; margin-bottom: 20px; background-color: #222;">
			<div>
				<h3 style="text-align: left;">
					User <small><?php echo $l["created"]; ?></small>
				</h3>
			</div>
			<div>
				<a href="https://plus.google.com/<?php echo $l["googleid"]; ?>"
					target="_blank"><img src="<?php echo $l["photo"]; ?>"
					style="height: 50px;" /></a>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<a href="https://plus.google.com/<?php echo $l["googleid"]; ?>"
						target="_blank"><?php echo $l["name"]; ?></a> <img
						src="<?php echo PROJECT_ROOT;?>/img/googleplus_16x16.png" />
				</div>

				<div class="col-sm-6"><?php echo $l["email"]; ?></div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					Gebiet: <?php echo $l["area"]; ?>
				</div>

				<div class="col-sm-6">Level <?php echo $l["agent_level"]; ?></div>
			</div>

			<div>
				<br />
				<h3 style="text-align: left;">Agent</h3>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<?php echo $l["agent_name"]; ?>
				</div>

				<div class="col-sm-6">Level <?php echo $l["agent_level"]; ?></div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					Verifikation: <?php echo $l["verification"]; ?>
				</div>

				<div class="col-sm-6"><?php echo $l["agent_ap"]; ?> AP</div>
			</div>
			<div class="row">
				<br />
				<div class="col-sm-6">
					<button class="btn btn-danger" data-toggle="modal"
						data-target="#denyLead<?php echo $l["id"]; ?>">Löschen</button>
				</div>

				<div class="col-sm-6">
					<button class="btn btn-success" data-toggle="modal"
						data-target="#acceptLead<?php echo $l["id"]; ?>">Annehmen</button>
				</div>
			</div>
		</div>


		<!-- Deny Lead Modal -->
		<div id="denyLead<?php echo $l["id"]; ?>" class="modal fade"
			role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Anfrage löschen</h4>
					</div>
					<div class="modal-body">
						<p>
							<img src="<?php echo $l["photo"]; ?>" style="height: 50px;" />
						</p>
						<p>
							<strong>User:</strong> <?php echo $l["name"]; ?></p>
						<p>
							<strong>Agent:</strong> <?php echo $l["agent_name"]; ?>, Level <?php echo $l["agent_level"]; ?></p>
						<p>
						
						
						<h3>Diese Anfrage löschen?</h3>
						</p>
					</div>
					<div class="modal-footer">
						<form action="" method="POST" style="display: inline;">
							<input type="hidden" name="action" value="removeLead" /> <input
								type="hidden" name="leadId" value="<?php echo $l["id"]; ?>" /> <input
								type="submit" class="btn btn-danger" value="Anfrage löschen" />
						</form>
						<button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
					</div>
				</div>

			</div>
		</div>

		<!-- Accept Lead Modal -->
		<div id="acceptLead<?php echo $l["id"]; ?>" class="modal fade"
			role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Anfrage annehmen</h4>
					</div>
					<div class="modal-body">
						<p>
							<img src="<?php echo $l["photo"]; ?>" style="height: 50px;" />
						</p>
						<p>
							<strong>User:</strong> <?php echo $l["name"]; ?></p>
						<p>
							<strong>Agent:</strong> <?php echo $l["agent_name"]; ?>, Level <?php echo $l["agent_level"]; ?></p>
						<p>
						
						
						<h3>Diese Anfrage annehmen?</h3>
						</p>
					</div>
					<div class="modal-footer">
						<form action="" method="POST" style="display: inline;">
							<input type="hidden" name="action" value="approveLead" /> <input
								type="hidden" name="leadId" value="<?php echo $l["id"]; ?>" /> <input
								type="submit" class="btn btn-success" value="Benutzer anlegen" />
						</form>
						<button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
					</div>
				</div>

			</div>
		</div>
	        <?php
									endforeach
									;
									?>
									
									
	</div>
	<div style="text-align:center; margin-bottom: 20px;"><button class="btn btn-success" type="button"
		data-toggle="collapse" data-target="#collapseOldLeads"
		aria-expanded="false" aria-controls="collapseOldLeads">
		Alte Anfragen einblenden
		</button>
	</div>
	<div class="collapse" id="collapseOldLeads">
		<div
			style="margin-left: auto; margin-right: auto; margin-bottom: 75px; width: 100%; max-width: 600px;">
		
<?php
foreach ( $inactiveLeads as $key => $l ) :
	$statusText = $l ["accepted"] == 1 ? "Angenommen" : "Gelöscht";
	$statusColor = $l ["accepted"] == 1 ? "#0F0" : "#F00";
	?>
<div
				style="border: 0px solid red; padding: 10px; margin-bottom: 20px; background-color: #222;">
				<div>
					<h3 style="text-align: left;">
						<span style="color: <?php echo $statusColor; ?>"><?php echo $statusText; ?></span>
						<small><?php echo $l["created"]; ?></small>
					</h3>
				</div>
				<div>
					<a href="https://plus.google.com/<?php echo $l["googleid"]; ?>"
						target="_blank"><img src="<?php echo $l["photo"]; ?>"
						style="height: 50px;" /></a>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<a href="https://plus.google.com/<?php echo $l["googleid"]; ?>"
							target="_blank"><?php echo $l["name"]; ?></a> <img
							src="<?php echo PROJECT_ROOT;?>/img/googleplus_16x16.png" />
					</div>

					<div class="col-sm-6"><?php echo $l["email"]; ?></div>
				</div>
				<div class="row">
					<div class="col-sm-6">
					Gebiet: <?php echo $l["area"]; ?>
				</div>

					<div class="col-sm-6">Level <?php echo $l["agent_level"]; ?></div>
				</div>

				<div>
					<br />
					<h3 style="text-align: left;">Agent</h3>
				</div>
				<div class="row">
					<div class="col-sm-6">
					<?php echo $l["agent_name"]; ?>
				</div>

					<div class="col-sm-6">Level <?php echo $l["agent_level"]; ?></div>
				</div>
				<div class="row">
					<div class="col-sm-6">
					Verifikation: <?php echo $l["verification"]; ?>
				</div>

					<div class="col-sm-6"><?php echo $l["agent_ap"]; ?> AP</div>
				</div>
			</div>
<?php
endforeach
;
?>

</div>
	</div>
</div>