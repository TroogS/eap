<?php 

?>
<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
	<div class="container">
		<div class="navbar-header page-scroll">
			<button type="button" class="navbar-toggle" data-toggle="collapse"
				data-target=".navbar-main-collapse">
				<i class="fa fa-bars"></i>
			</button>
			<span class="navbar-brand" style="margin-top: -5px;">
				<?php if(isLoggedIn()):?>
				<h1 class="navbar-displayname">
					<img src="<?php echo getPicture(); ?>" style="height: 50px;" />
					<div class="visible-inline-xs"><?php echo getName(15); ?></div>
					<div class="visible-inline-sm"><?php echo getName(15); ?></div>
					<div class="visible-inline-md"><?php echo getName(25); ?></div>
					<div class="visible-inline-lg"><?php echo getName(30); ?></div>
				</h1>
				<?php else:
				$communityName = "Enlightened Siegen-Wittgenstein";
				?>
				<h1 class="navbar-displayname">
					<div class="visible-inline-xs"><?php echo trunc($communityName, 20); ?></div>
					<div class="visible-inline-sm"><?php echo trunc($communityName, 40); ?></div>
					<div class="visible-inline-md"><?php echo trunc($communityName, 45); ?></div>
					<div class="visible-inline-lg"><?php echo trunc($communityName, 50); ?></div>
				</h1>
				<?php endif; ?>
			</span>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div
			class="collapse navbar-collapse navbar-right navbar-main-collapse">
			<?php
			echo $nav->build ();
			?>
		</div>
		<!-- /.navbar-collapse -->
	</div>
	<!-- /.container -->
</nav>