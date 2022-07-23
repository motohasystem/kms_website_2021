<?php get_template_part("header", "head"); ?>
<body>
	<div id="container">
		<header id="header">
			<h1 class="global-title"><a href="<?php bloginfo('url') ?>">Kamiyama Makerspace</a></h1>
			<nav class="nav">
				<?php wp_nav_menu( array(
	            'theme_location'=>'mainmenu',
	            'container'     =>'',
	            'menu_class'    =>'',
	            'items_wrap'    =>'<ul class="main-nav flex">%3$s</ul>'));
				?>
			</nav>
		</header>
