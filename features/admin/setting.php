<?php

namespace rocket_media_library_mime_type;

class Setting extends Feature {

	public function __construct() {
		
		$this->add_action( 'admin_menu', 'rocket_media_library_mime_type_menu' );
		
		if(isset($_GET['page']) && in_array($_GET['page'],array(PLUGIN_MENU_SLUG))):
			
			//업데이트 된 값이 있으면 반영
			self::detect_option_change();
			$this->add_action( 'admin_enqueue_scripts', 'enqueue' );

		endif;
		
		//파일 업로드시 확장자를 체크하는 filter
		$this->add_filter('upload_mimes', 'custom_add_upload_mimes');
    }
	
	public function custom_add_upload_mimes($wp_mime_types){
		
		$options = self::get_current_all_options();
		$mime_types = MimeType::get_mime_types();
		
		foreach($mime_types as $mime_type_key => $mime_type_info):
			
			if($options['rocket_upload_mime_type_' . $mime_type_key]=="yes"){
				
				if(!$wp_mime_types[$mime_type_info['extension']]){
					
					$wp_mime_types[$mime_type_info['extension']] = $mime_type_info['mime_type'];
					
				}
				
			}else{
				
				if($wp_mime_types[$mime_type_info['extension']]){
					
					unset($wp_mime_types[$mime_type_info['extension']]);

				}
				
			}
			
		endforeach;
		
		return $wp_mime_types;
	}
	
	//관리 메뉴 추가
	public function rocket_media_library_mime_type_menu(){
		add_options_page('Rocket Media Library Mime Type', '업로드  파일 타입', 'manage_options', PLUGIN_MENU_SLUG, array( &$this, 'setting_page' ));
		
		//wp-pointer 처리-----start
		$enqueue_pointer_script_style = false;
		$dismissed_pointers_values = get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true );
		
		if(is_array($dismissed_pointers_values)){
			
			$dismissed_pointers = $dismissed_pointers_values;
			
		}else{
			
			$dismissed_pointers = explode( ',', $dismissed_pointers_values );
			
		}
		
		if( !in_array( 'rocket_media_upload_file_settings_pointer', $dismissed_pointers ) ) {
			$enqueue_pointer_script_style = true;
			$this->add_action("admin_print_footer_scripts","show_post_pointer");
		}
		
		if( $enqueue_pointer_script_style ) {
			wp_enqueue_style( 'wp-pointer' );
			wp_enqueue_script( 'wp-pointer' );
		}
		//wp-pointer 처리-----end
	}
	
	function show_post_pointer(){
		
		$wp_pointer_content = __('post pointer message', PLUGIN_PREFIX);
		$wp_pointer_image_content = __('post image pointer message', PLUGIN_PREFIX);
		?>
		<style>
			.wp-pointer-content h3.rocket-icon:before{font-family:FontAwesome !important; content: '\f135';}
		</style>
		<script>
		jQuery(document).ready( function($) {
			
			if($("#menu-settings .menu-icon-settings").length > 0){
				
				var options = {"content":"<h3 class='rocket-icon'>"+'Rocket Media Library Mime Type'+"<\/h3>"+'<p>플러그인이 활성화 되었습니다.</p><p>[설정] > [이미지 파일 타입] 메뉴에서 허용할 파일 타입을 설정해 주세요</p>',"position":{"edge":"left","align":"center"}};
				if ( ! options ) return;
				
				options = $.extend( options, {
					close: function() {
						$.post( ajaxurl, {
							pointer: 'rocket_media_upload_file_settings_pointer', 
							action: 'dismiss-wp-pointer'
						});
					}
				});
				$('#menu-settings .menu-icon-settings').pointer( options ).pointer("open");
			}
		});
		</script>
		
		<?php
	}
	
	//관리 메뉴 랜더링
	public function setting_page(){
		
		$template = self::get_template();
		$current_allowed_mime_types = get_allowed_mime_types();
		$options = self::get_current_all_options();
		$template->set('current_allowed_mime_types',$current_allowed_mime_types);
		$template->set('rocket_plugin_mime_types',MimeType::get_mime_types());
		$template->set('post_max_size',size_format($this->format_size(ini_get( 'post_max_size' ))));
		$template->set('version',VERSION);
		$template->set('options',$options);
		
		echo $template->apply("admin/setting.php");

	}
	
	function format_size($filesize){
		$l   = substr( $filesize, - 1 );
        $ret = substr( $filesize, 0, - 1 );

        switch ( strtoupper( $l ) ) {
            case 'P':
                $ret *= 1024;
            case 'T':
                $ret *= 1024;
            case 'G':
                $ret *= 1024;
            case 'M':
                $ret *= 1024;
            case 'K':
                $ret *= 1024;
        }
        return $ret;
	}

	public function enqueue() {
		
		wp_enqueue_script("jquery-ui-sortable");
		
		wp_enqueue_script(
	        'rocket-media-library-upload-admin-setting',
	        PLUGIN_URL . 'assets/js/setting.js',
	        array( 'jquery' ),
	        true
	    );
		
		wp_enqueue_style(
	        'jsdelivr-group',
	        '//cdn.jsdelivr.net/g/foundation@5.5.1(css/foundation.min.css+css/normalize.css),fontawesome@4.3.0(css/font-awesome.min.css),jquery.powertip@1.2.0(css/jquery.powertip.min.css)'
	    );
		
		wp_enqueue_script(
	        'jsdelivr-group',
	        '//cdn.jsdelivr.net/g/modernizr@2.8.3(modernizr.min.js),foundation@5.5.1(js/foundation.min.js),jquery.powertip@1.2.0(jquery.powertip.min.js)',
	        array( 'jquery' ),
	        true
	    );
	}
}
add_action( 'rocket_media_library_mime_type_init' , array( 'rocket_media_library_mime_type\Setting' , 'init'  )  , 1 ,  1 );
?>