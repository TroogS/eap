<?php
$users = getUsers ();
?>
<div id="loginPage"
	style="margin-left: auto; margin-right: auto; width: 100%; max-width: 992px;">
	<h2>Benutzer</h2>
	<div
		style="margin-left: auto; margin-right: auto; width: 100%; max-width: 600px;">
		<?php
		foreach ( $users as $u ) :
			$created = new DateTime ( $u ["created"] );
			$modified = new DateTime ( $u ["modified"] );
			$agentList = getAgentsByUser ( $u ["id"] );
			
			$borderColor = ($u ["group"] == null ? "#F00" : "#FFF");
			$borderSize = ($u ["group"] == null ? "1" : "0");
			
			switch ($u ["group"]) {
				case "user" :
					$groupName = "User";
					break;
				case "admin" :
					$groupName = "Admin";
					break;
				case "mod" :
					$groupName = "Moderator";
					break;
				default :
					$groupName = "Gesperrt";
			}
			
			?>
		<div
			style="border: <?php echo $borderSize; ?>px solid <?php echo $borderColor; ?>; padding: 10px; margin-bottom: 20px; background-color: #222; position: relative;">
			<div>
				<h3 style="text-align: left;">
					<small>ID: <?php echo $u["id"]; ?></small> <span style="color: <?php echo $borderColor; ?>"><?php echo $u["name"]; ?></span>
					<small><a
						href="https://plus.google.com/<?php echo $u["googleid"]; ?>"
						target="_blank"><img
							src="<?php echo PROJECT_ROOT;?>/img/googleplus_16x16.png" /></a></small>
				</h3>
				<div style="width: 100%;">
					<div style="display: inline; margin-right: 10px;">
						<a href="https://plus.google.com/<?php echo $u["googleid"]; ?>"
							target="_blank"><img src="<?php echo $u["photo"]; ?>"
							style="height: 50px;" /></a>
					</div>
					<script
						src="https://enlightened.rocks/api/badge/<?php echo $u["googleid"]; ?>"></script>
				</div>
				<div class="row"
					style="position: absolute; bottom: 0px; right: 20px; top: 20px; text-align: right;">
					<br />
					<div class="col-sm-12">
					<?php
			if ($u ["group"]) :
				?>
						<p>
							<button class="btn btn-danger" data-toggle="modal"
								data-target="#freezeUser<?php echo $u["id"]; ?>">Sperren</button>
						</p>
					
			
			
			
			
			
			<?php
			else :
				?>
					<p>
							<button class="btn btn-success" data-toggle="modal"
								data-target="#unfreezeUser<?php echo $u["id"]; ?>">Entsperren</button>
						</p>
					
			
			
			<?php
				
				echo "";
			endif;
			?>
					<p>
							<a class="btn btn-warning"
								href="<?php echo PROJECT_ROOT;?>/admin/user/edit/<?php echo $u["id"]; ?>">Bearbeiten</a>
						</p>
					</div>
				</div>
			</div>
			<p>
				<strong>Gruppe: </strong><?php echo $groupName; ?><br /> <strong>Gebiet:
				</strong><?php echo $u["area"]; ?><br /> <strong>Angemeldet seit: </strong><?php echo $created->format("d.m.Y - H:i"); ?><br />
				<strong>Letzte Änderung: </strong><?php echo $modified->format("d.m.Y - H:i"); ?>
			</p>
			<?php
			foreach ( $agentList as $a ) :
				$agentModified = new DateTime ( $a ["modified"] );
				?>
			<hr />
			<h3 style="text-align: left;">
				<span style="font-weight: normal;">Agent</span> <?php echo $a["name"]; ?></h3>
			<p>
				<strong>Codename:</strong> <?php echo $a["name"]; ?><br /> <strong>Level:</strong> <?php echo $a["level"]; ?> (<?php echo $a["ap"]; ?> AP)<br />
				<strong>Letzte Änderung: </strong><?php echo $agentModified->format("d.m.Y - H:i"); ?>
			</p>
			<?php
			endforeach
			;
			?>
		</div>

		<!-- Freeze User Modal -->
		<div id="freezeUser<?php echo $u["id"]; ?>" class="modal fade"
			role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Benutzer sperren</h4>
					</div>
					<div class="modal-body" style="text-align: center;">
						<p>
							<img src="<?php echo $u["photo"]; ?>" style="height: 150px;" />
						</p>
						<p>
							<strong>User:</strong> <?php echo $u["name"]; ?></p>
						<p>
						
						
						<h4>Diesen Benutzer sperren?</h4>
						</p>
					</div>
					<div class="modal-footer">
						<form action="" method="POST" style="display: inline;">
							<input type="hidden" name="action" value="freezeUser" /> <input
								type="hidden" name="userId" value="<?php echo $u["id"]; ?>" /> <input
								type="submit" class="btn btn-danger" value="Sperren" />
						</form>
						<button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
					</div>
				</div>

			</div>
		</div>

		<!-- Unfreeze User Modal -->
		<div id="unfreezeUser<?php echo $u["id"]; ?>" class="modal fade"
			role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Benutzer entsperren</h4>
					</div>
					<div class="modal-body" style="text-align: center;">
						<p>
							<img src="<?php echo $u["photo"]; ?>" style="height: 150px;" />
						</p>
						<p>
							<strong>User:</strong> <?php echo $u["name"]; ?></p>
						<p>
						
						
						<h4>Diesen Benutzer entsperren?</h4>
						</p>
					</div>
					<div class="modal-footer">
						<form action="" method="POST" style="display: inline;">
							<input type="hidden" name="action" value="unfreezeUser" /> <input
								type="hidden" name="userId" value="<?php echo $u["id"]; ?>" /> <input
								type="submit" class="btn btn-success" value="Entsperren" />
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

</div>