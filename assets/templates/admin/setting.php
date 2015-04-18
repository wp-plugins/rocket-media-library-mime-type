<?php
?>

<style>
	.fa-question-circle{color:#1E8CBE;}
	.fa-c2x{font-size:1.1em;}
	.rocket-wrap{margin:10px 20px 0px 2px;}
	
	/* foundation */
	ul li ul, ul li ol{margin-left:0px;}
	ul{margin-left:0px;}
	.row{max-width:none;}
	table{width:100%;}
	.custom-label{font-size:1.5rem;}
	body{background:inherit;}
</style>

<div class="row">
	<div class="rocket-wrap">
		<h1><i class="fa fa-rocket fa-2x"></i>업로드 파일 타입 설정</h1>
		
		<?php
		if($_POST['action']=="update"):
		?>
		<div data-alert class="alert-box success radius">
			저장 완료! 설정이 변경되었습니다.
			<a href="#" class="close">&times;</a>
		</div>
		<?php
		endif;
		?>
		
		<div class="row">
			<div class="large-12 columns">
				<div class="panel callout radius">
					<h5>참고 : <span class="radius secondary label custom-label"><?php echo site_url();?></span> 사이트의 업로드 관련 설정값</h5>
					Max Upload Size <i class="fa fa-question-circle fa-c2x tooltips" title="<b>한번에 업로드 가능한 파일의 최대 사이즈</b>입니다.<br><span class='round info label'>php.ini</span>파일에서 <span class='round info label'>upload_max_filesize</span>항목으로 값을 조정할 수 있습니다.<br>설정을 변경했다면 서버를 재시작해야 적용되며<br>아래의 <span class='round info label'>post_max_size</span> 값과 같게 설정하면 됩니다."></i> : <?php echo size_format( wp_max_upload_size() );?>
					<p>PHP Post Max Size <i class="fa fa-question-circle fa-c2x tooltips" title="<b>한번에 전송 가능한 폼값의 최대 사이즈</b>입니다.<br><span class='round info label'>php.ini</span>파일에서 <span class='round info label'>post_max_size</span>항목으로 값을 조정할 수 있습니다.<br>설정을 변경했다면 서버를 재시작해야 적용되며<br>위의 <span class='round info label'>upload_max_size</span> 값과 같게 설정하면 됩니다."></i> : <?php echo $post_max_size;?></p>
					<p>wordpress 업로드 용량 설정하는 법에 대해 더 자세히 알고 싶으면 <a href="http://rocketpress.kr/wordpress-tips/5886/" target="_blank">이곳</a> 을 클릭하세요.</p>
				</div>
			</div>
		</div>
		
		<form action="#" method="post" id="rocketfont_form" role="form">
			
			<button type="submit" class="button-primary dnp-plugin-submit">저장</button>
			<p></p>
			
			<table class="">
				<thead>
					<tr>
						<th>확장자 </th>
						<th>MIME Type</th>
						<th>설명 (<i class="fa fa-wordpress"></i>:워드프레스 디폴트 허용 파일)</th>
						<th>업로드 허용 여부</th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach($rocket_plugin_mime_types as $extension => $mime_type):
					?>
					<tr>
						<td>
							<?php
							$extension_arr = explode("|", $mime_type["extension"]);
							foreach($extension_arr as $extension_name):
								?>
								<span class="radius secondary label custom-label"><?php echo $extension_name?></span>
								<?php
							endforeach;
							?>
						</td>
						<td><?php echo $mime_type["mime_type"]?></td>
						<td><?php echo $mime_type["description"]?></td>
						<td>
							<div class="switch round">
								<input id="switch_<?php echo $extension?>" name="rocket_upload_mime_type_<?php echo $extension;?>" type="checkbox" value="yes" <?php checked( $options['rocket_upload_mime_type_'.$extension], "yes" ); ?>>
								<label for="switch_<?php echo $extension?>"></label> 
							</div>
						</td>
					</tr>
					<?php
					endforeach;
					?>
				</tbody>
			</table>
			
			<input type="hidden" name="action" value="update">
			<p></p>
			<button type="submit" class="button-primary dnp-plugin-submit">저장</button>
			
		</form>
		<p></p>
		<div class="row">
			<div class="large-9 columns">
				<div class="panel callout radius">
					<h2><i class="fa fa-rocket"></i> Rocket Media Library Mime Type - 플러그인 정보</h2>
					<h3>플러그인 버전: <?php echo $version;?></h3>
					<h4><i class="fa fa-coffee"></i> 개발자: <a href="http://in-web.co.kr" target="_blank">Qwerty23</a></h4>
					<h4><i class="fa fa-rocket"></i> 디자인: <a href="http://rocketpress.kr" target="_blank">Rocketpress</a></h4>
					<ol>
						<li>현재 총 <?php echo sizeof($rocket_plugin_mime_types) ?>개의 선택할 수 있는 파일 타입이 있습니다.</li>
						<li>이 외에도 파일 확장자는 많지만, 주로 많이 사용하는 파일 위주로 넣었습니다.</li>
						<li>추가하고 싶은 파일 확장자가 있다면 <a href="http://rocketpress.kr/forums/" target="_blank">이곳</a> 에서 요청하시면 검토 후 업데이트 하겠습니다.</li>
					</ol>
					기타 플러그인에 관한 문의 및 건의사항은 <a href="http://rocketpress.kr/forums/forum/%EB%A1%9C%EC%BC%93%ED%8F%B0%ED%8A%B8-%ED%94%8C%EB%9F%AC%EA%B7%B8%EC%9D%B8-rocket-font-plugin/" target="_blank"><i class="fa fa-rocket"></i>Rocketpress 문의 게시판</a> 을 확인해 주세요.
				</div>
			</div>
			<div class="large-3 columns">
				<ul class="pricing-table">
					<li class="title">
						<i class="fa fa-heartbeat"></i> 기부금
					</li>
					<li class="description">
						이 플러그인을 유용하게 사용하셨다면 
						<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
							<input type="hidden" name="cmd" value="_s-xclick">
							<input type="hidden" name="hosted_button_id" value="XE589QNSSM8LU">
							<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
							<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
						</form>
						또 다른 유용한 wordpress plugin 제작 및 유지보수에 사용됩니다.
					</li>
				</ul>
			</div>
		</div>
		
	</div>
</div>