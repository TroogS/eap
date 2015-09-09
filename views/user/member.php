<?php
global $userProfile;
global $user;

$members = getMemberList ();

?>
<div id="loginPage"
	style="margin-left: auto; margin-right: auto; width: 100%; max-width: 992px;">
	<h2>Mitgliederliste</h2>
	<p class="visible-xs text-center bg-info"
		style="padding: 5px; color: #000;">Für die mobile Ansicht wurden
		Fotos, Namen und AP ausgeblendet
	
	
	<p>
	
	
	<div style="width: 100%; margin: auto; max-width: 750px;">

		<div class="row">
			<div class="col-sm-1 hidden-xs"></div>
			<div class="col-sm-3 hidden-xs">
				<strong>Name</strong>
			</div>
			<div class="col-xs-4 col-sm-2">
				<strong>Codename</strong>
			</div>
			<div class="col-xs-2 col-sm-1 text-center">
				<strong>Level</strong>
			</div>
			<div class="col-sm-2 hidden-xs text-center">
				<strong>AP</strong>
			</div>
			<div class="col-xs-6 col-sm-3">
				<strong>Haupt-Viertel/Ort</strong>
			</div>
		</div>
			<?php
			foreach ( $members as $m ) :
				$cleanAp = ( int ) $m ["ap"];
				$cleanAp = number_format ( $cleanAp, 0, ',', '.' );
				
				$cleanDate = new DateTime ( $m ["modified"] );
				$cleanDate = $cleanDate->format ( "d.m.Y" );
				?>
			<div class="row memberListRow" style="margin-bottom: 5px;"
			data-toggle="tooltip" data-placement="left"
			data-delay='{"show":"10", "hide":"10"}'
			title="<?php echo $cleanDate; ?>">
			<div class="col-sm-1 hidden-xs">
				<img src="<?php echo $m["photo"]; ?>" style="width: 50px;" />
			</div>
			<div class="col-sm-3 hidden-xs memberListCell"><?php echo $m["user_name"]; ?></div>
			<div class="col-xs-4 col-sm-2 memberListCell"><?php echo $m["agent_name"]; ?></div>
			<div class="col-xs-2 col-sm-1 memberListCell text-center"><?php echo $m["level"]; ?></div>
			<div class="col-sm-2 hidden-xs memberListCell text-center"><?php echo $cleanAp; ?></div>
			<div class="col-xs-6 col-sm-3 memberListCell"><?php echo $m["area"]; ?></div>
		</div>

			<?php
			endforeach
			;
			?>
		</table>

	</div>
</div>
