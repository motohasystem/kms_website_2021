<?php get_template_part("header", "head"); ?>
<body>
	<style>
		html {
			height: 100%;
			margin-top: 0 !important;
		}
		body {
			height: 100%;
		}
		#top-wrap {
			background: url("<?php bloginfo('stylesheet_directory') ?>/images/daygomi/main_bg3.jpg");
			background-size: cover;
			min-height: 100%;
			position: relative;
		}
		.hero {
			position: absolute;
			top: 0;
			bottom: 0;
			right: 0;
			left: 0;
			margin: auto;
			width: 50%;
			min-width: 320px;
			height: 440px;
		}
		#g-logo {
			display: block;
			margin: 0 auto;
		}
		.title-text {
			font-weight: bold;
			font-size: 48px;
			text-align: center;
		}
		#btn-explain {
			font-size: 24px;
			padding: 10px 40px;
			background: rgb(0,147,68);
			border: none;
			color: #fff;
			margin: 20px auto;
			display: block;
			cursor: pointer;
		}
		#powered-by {
			position: absolute;
			bottom: 20px;
			right: 20px;
			width: 262px;
			height: 90px;
			line-height: 1.4em;
		}
		#explain {

		}
		.text {
			margin: 0 auto;
			width: 50%;
			min-width: 320px;
			line-height: 1.6em;
		}
		.diagram {
			width: 321px;
			margin: 40px auto;
			text-align: center;
		}
		.step, .material {
			border: 1px solid #3c3c3c;
			line-height: 1.6em;
			border-radius: 4px;
			background: #f8f8f8;
		}
		.step h3, .material h3 {
			margin: 0 auto 6px;
			padding: 0;
		}
		.step p {
			padding: 0 20px;
		}
		.arrow {
			padding: 20px;
		}
		.d-sign {
			display: block;
			margin: 20px auto;
			height: 82px;
		}
		.video {
			display: block;
			margin: 10px auto 40px;
			width: 50%;
			min-width: 320px;
		}
		.circle-diagram {
			display: block;
			margin: 40px auto 10px;
			width: 50%;
			min-width: 320px;	
		}
		h1, h2 {
			text-align: center;
			font-size: 24px;
			font-weight: bold;
			margin: 10px auto 20px;
		}
		h2 {
			font-size: 16px;
		}
		strong {
			font-weight: bold;
		}
		.column-wrapper {
			position: relative;
			overflow: hidden;
			display: flex;
			display: -webkit-flex;
			flex-wrap: wrap;
			-webkit-flex-wrap: wrap;
			width: 50%;
			min-width: 320px;
			margin: 0 auto;
		}
		.column {
			width: 321px;
		}
		.recipe {
			margin: 40px auto;
			text-align: center;
		}
		.material {
			margin-bottom: 20px;
			padding-bottom: 10px;
		}
		.material h3>a,
		.material h3>a:visited,
		.material h3>a:hover {
			color: #000;
			text-decoration: none;
		}
		@media (max-width: 1300px) {
			.title-text {
				font-size: 32px;
			}
		}
		@media (max-width: 600px) {
			.title-text {
				font-size: 22px;
			}
			#btn-explain {
				font-size: 16px;
				padding: 6px 20px;
			}
		}
	</style>
	<div id="top-wrap">
		<div class="hero">
			<img id="g-logo" src="<?php bloginfo('stylesheet_directory') ?>/images/daygomi/G_logo.png" width="260" />
			<p class="title-text">Welcome to the <br/>Kamiyama Daygomi Project</p>
			<button id="btn-explain">explain</button>
		</div>
		<div id="powered-by">
			<p style="text-align: center">
				powered by<br/>
				<a href="http://kamiyama.ms/">
				<img src="<?php bloginfo('stylesheet_directory') ?>/images/daygomi/kms_logo.png" width="200" />
				</a>
			</p>
		</div>
	</div>
	<div id="explain">
		<h1>だいゴミの活動</h1>
		
		<iframe class="video" src="https://player.vimeo.com/video/191418400" width="640" height="320" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
		
		<h2>神山メイカースペースから、新しい提案です。</h2>
		<p class="text">
		KMSでこの秋、リサイクルをテーマに5日間のワークショップを行いました。<br />
		神山町の最終埋立処分場、神山環境センターを見学させていただき、埋め立ての実態を知った私たちは、 埋め立てるゴミを少しでも減らせないかと考えました。<br/>
		普段捨てているゴミを、いいモノに変える事はできないかと実験を重ね、リサイクルとデジタルファブリケーションを組み合わせた新しい活動、神山だいゴミプロジェクトを始めました。<br/><br/>

		だいゴミは、<strong>ゴミを素材に、素材をプロダクトに変えるプロジェクトです。</strong>ノウハウはレシピとして公開します！
		</p>

		<img class="circle-diagram" src="<?php bloginfo('stylesheet_directory') ?>/images/daygomi/daygomi-circle.jpg" />

		<div class="column-wrapper">
			<div class="diagram column">
				<h2>仕組み</h2>
				<div class="step">
					<img src="<?php bloginfo('stylesheet_directory') ?>/images/daygomi/plastic-waste.jpg" width="320" />
					<h3>ゴミ</h3>
					<ul>
						<li>プラスチックゴミ</li>
						<li>紙ゴミ</li>
						<li>廃棄される電子機器</li>
					</ul>
				</div>
				<div class="arrow">
					<img src="<?php bloginfo('stylesheet_directory') ?>/images/daygomi/arrow.png" width="40px" />
				</div>
				<div class="step">
					<img src="<?php bloginfo('stylesheet_directory') ?>/images/daygomi/plastic-sheet.png"  width="320"/>
					<h3>ファブリケーション素材</h3>
					<ul>
						<li>ブラスチック板</li>
						<li>廃紙製の板</li>
						<li>電子部品</li>
					</ul>
				</div>
				<div class="arrow">
					<img src="<?php bloginfo('stylesheet_directory') ?>/images/daygomi/arrow.png" width="40px" />
				</div>
				<div class="step">
					<img src="<?php bloginfo('stylesheet_directory') ?>/images/daygomi/daygomi-sign.jpg" width="320" />					
					<h3>プロダクト</h3>
					<ul>
						<li>ランプ</li>
						<li>ネームプレートなど</li>
					</ul>
				</div>
			</div>
			<div class="recipe column">	
				<h2>レシピ</h2>
				<div class="material">
					<img src="<?php bloginfo('stylesheet_directory') ?>/images/daygomi/light.jpg"  width="320"/>
					<h3><a href="#">ゴミランプ</a></h3>
					<a href="#">→レシピを見る！</a>
				</div>
				<div class="material">
					<img src="<?php bloginfo('stylesheet_directory') ?>/images/daygomi/plastic-sheet.png"  width="320"/>
					<h3><a href="http://fabble.cc/sayakaabe/plasticpizza">プラスチックピザ</a></h3>
					<a href="http://fabble.cc/sayakaabe/plasticpizza">→レシピを見る！</a>
				</div>
				<div class="material">
					<img src="<?php bloginfo('stylesheet_directory') ?>/images/daygomi/taburoten.png"  width="320"/>
					<h3><a href="http://fabble.cc/sayakaabe/tabloten2">タブロテン</a></h3>
					<a href="http://fabble.cc/sayakaabe/tabloten2">→レシピを見る！</a>
				</div>
			</div>
		</div>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script>
	jQuery(document).ready(function ($) {
		$("#top-wrap").height($("body").height());
		$("body").css("height", "auto");
	});
	document.querySelector("#btn-explain").addEventListener("click", function () {
		$('html, body').animate({
      		scrollTop: $("#top-wrap").height()
    	}, 500);
	});
	</script>
</body>
</html>