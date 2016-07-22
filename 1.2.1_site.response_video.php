<?php 

/*
** Responsive video function
** version: 1.2.1
** author: Sandro Rümmler
**
** =============================================
** OPTIONS
** =============================================
** 1. plattform - enter your plattform. Possible are one of them: 'youtube', 'vimeo', 'dailymotion'
** 2. link 		- enter the link to your video 
** 3. class 	- enter the classes you want to add. leave it blank for no classes.
** 4. inline 	- set it true to input the styles directly into the elements. set fasle for don't do that
** 5. adds   	- enable/disable adds after video has played (only works in for youtube this time)
** 6. controls  - enable/disable player Control Elements (only works in for youtube this time)
** 7. info  	- enable/disable player Info (only works in for youtube this time)
**
** =============================================
** DEFAULTS
** =============================================
** 1. plattform = youtube
** 2. link 		= ''
** 3. class 	= embed-container
** 4. inline  	= false
** 5. adds 		= false
** 6. controls 	= true
** 7. info 		= true
**
** =============================================
** EXAMPLE FOR USAGE
** =============================================
** echo response_video(array('plattform'=>'youtube', 'link'=>'http://youtube.com/watch?v=QILiHiTD3uc', 'inline'=>false));
**
** =============================================
** NOTE
** =============================================
** if you set inline to false use this css styles and add them to your stylesheet:
** .embed-container { position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; max-width: 100%; } 
** .embed-container iframe, .embed-container object, .embed-container embed { position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;}
**
** =============================================
** CHANGELOG
** =============================================
** Please read the changelog.txt
**
*/

function response_video($options=array()) {
	$defaults = array('plattform'=>'youtube', 'link'=>'', 'class'=>'embed-container', 'inline'=>true, 'adds'=>false, 'controls'=>true, 'info'=>true);
	$options = array_merge($defaults, $options);

	if('' == $options['class']) { 
		$class_output = '';
	} else {
		$class_output = ' class="'.$options['class'].'"';
	}

	if(false == $options['inline']) {
		$inline_div = '';
		$inline_iframe = '';
	} else {
		$inline_div = ' style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; max-width: 100%;"';
		$inline_iframe = ' style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border:0"'; 
	}

	if (false == $options['adds']) 		{ $urlTag['adds'] = 'rel=0'; }
	if (false == $options['controls']) 	{ $urlTag['controls'] = 'controls=0'; }
	if (false == $options['info']) 		{ $urlTag['info'] = 'showinfo=0'; }

	switch ($options['plattform']) {
		case 'youtube':
			$video_code = str_replace(array('https://www.youtube.com/watch?v=', 'https://youtu.be/', 'http://www.youtube.com/watch?v=', 'http://youtu.be/', 'http://youtube.com/watch?v=', 'https://www.youtube.com/embed/', 'http://www.youtube.com/embed/', 'https://www.youtube.com/', 'http://www.youtube.com/'), '', $options['link']);

			if (empty($urlTag) == false) {
				$urlTags = '?';
				$i = 0;
				foreach ($urlTag as $key => $value) {
					if (0 == $i) {
						$urlTags .= $value;
					} else {
						$urlTags .= '&amp;'.$value;
					}
					$i++;
				}
			} else {
				$urlTags = '';
			}

			$new_link 	= 'http://www.youtube.com/embed/'.$video_code.$urlTags;
			$attributes = ' allowfullscreen';
			break;
		case 'vimeo':
			$video_code = str_replace(array('https://www.vimeo.com/', 'http://www.vimeo.com/', 'http://vimeo.com/'), '', $options['link']);
			$new_link 	= 'http://player.vimeo.com/video/'.$video_code;
			$attributes = ' webkitAllowFullScreen mozallowfullscreen allowFullScreen';
			break;
		case 'dailymotion':
			$video_code = str_replace(array('https://www.dailymotion.com/video/', 'http://www.dailymotion.com/video/', 'http://dailymotion.com/video/'), '', $options['link']);
			$new_link 	= 'http://www.dailymotion.com/embed/video/'.$video_code;
			$attributes = ' webkitAllowFullScreen mozallowfullscreen allowFullScreen';
	}

	$output = '<div'.$class_output.$inline_div.'><iframe src="'.$new_link.'"'.$inline_iframe.$attributes.'></iframe></div>';

	return $output;
}