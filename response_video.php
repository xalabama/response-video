<?php 

/*
** Responsive video function
** @version: 1.3.2
** @author: Sandro Rümmler
** @license: GNU GENERAL PUBLIC LICENSE
**
** =============================================
** OPTIONS
** =============================================
** 1. plattform - enter your plattform. Possible are one of them: 'youtube', 'vimeo', 'dailymotion'
** 2. link 		- enter the link to your video 
** 3. class 	- enter the classes you want to add. leave it blank for no classes.
** 4. inline 	- set it true to input the styles directly into the elements. set fasle for don't do that
** 5. adds   	- enable/disable adds after video has played (youtube only)
** 6. controls  - enable/disable player Control Elements (not supported for vimeo)
** 7. info  	- enable/disable player Info
** 8. start  	- specifies the time (in seconds) from which the video should start playing
** 9. autoplay  - starts the playback of the video automatically after the player load
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
** 8. start 	= 0
** 9. autoplay 	= false
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
	//define defaults
	$defaults = array(
		'plattform'=>'youtube', 
		'link'=>'', 
		'class'=>'embed-container', 
		'inline'=>true, 
		'adds'=>false, 
		'controls'=>true, 
		'info'=>true,
		'start'=>0,
		'autoplay'=>false
	);

	//merge with custom options
	$options = array_merge($defaults, $options);

	//define classes
	if('' == $options['class']) { 
		$class_output = '';
	} else {
		$class_output = ' class="'.$options['class'].'"';
	}

	//define inline option 
	if(false == $options['inline']) {
		$inline_div = '';
		$inline_iframe = '';
	} else {
		$inline_div = ' style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; max-width: 100%;"';
		$inline_iframe = ' style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border:0"'; 
	}

	//definde url Tags
	if (false == $options['adds']) { 
		$urlTagYoutube['adds'] = 'rel=0'; 
	}

	if (false == $options['controls']) { 
		$urlTagYoutube['controls'] = 'controls=0'; 
		$urlTagDailymotion['controls'] = 'controls=0'; 
	}

	if (false == $options['info']) { 
		$urlTagYoutube['info'] = 'showinfo=0'; 
		$urlTagVimeo['info'] = 'title=0&amp;byline=0';
		$urlTagDailymotion['info'] = 'info=0';
	} 

	if (0 != $options['start']) {
		$urlTagYoutube['start'] = 'start='.$options['start']; 
		$urlHashVimeo['start'] = '#t='.$options['start'].'s';
		$urlTagDailymotion['start'] = 'start='.$options['start'];
	} else {
		$urlHashVimeo['start'] = '';
	}

	if (true == $options['autoplay']) {
		$urlTagYoutube['autoplay'] = 'autoplay=1'; 
		$urlTagVimeo['autoplay'] = 'autoplay=1';
		$urlTagDailymotion['autoplay'] = 'autoplay=1';
	}
	

	//check for plattform
	switch ($options['plattform']) {
		case 'youtube':

			//generate video code
			$video_code = str_replace(
				array(
					'https://www.youtube.com/watch?v=', 
					'https://youtu.be/', 
					'http://www.youtube.com/watch?v=', 
					'http://youtu.be/', 
					'http://youtube.com/watch?v=', 
					'https://www.youtube.com/embed/', 
					'http://www.youtube.com/embed/', 
					'https://www.youtube.com/', 
					'http://www.youtube.com/'
				), 
				'', 
				$options['link']
			);

			//generate urlTags
			if (empty($urlTagYoutube) == false) {
				$urlTags = '?';
				$i = 0;
				foreach ($urlTagYoutube as $key => $value) {
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

			//define videolink
			$new_link 	= 'http://www.youtube.com/embed/'.$video_code.$urlTags;

			//define attributes
			$attributes = ' allowfullscreen';
			break;

		case 'vimeo':
			//generate video code
			$video_code = str_replace(
				array(
					'https://www.vimeo.com/', 
					'http://www.vimeo.com/', 
					'http://vimeo.com/', 
					'https://vimeo.com/'
				), 
				'', 
				$options['link']
			);

			//generate urlTags
			if (empty($urlTagVimeo) == false) {
				$urlTags = '?';
				$i = 0;
				foreach ($urlTagVimeo as $key => $value) {
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

			//define videolink
			$new_link 	= 'http://player.vimeo.com/video/'.$video_code.$urlTags.$urlHashVimeo['start'];

			//define attributes
			$attributes = ' webkitAllowFullScreen mozallowfullscreen allowFullScreen';
			break;

		case 'dailymotion':
			//generate video code
			$video_code = str_replace(
				array(
					'https://www.dailymotion.com/video/', 
					'http://www.dailymotion.com/video/', 
					'http://dailymotion.com/video/'
				), 
				'', 
				$options['link']
			);

			//generate urlTags
			if (empty($urlTagDailymotion) == false) {
				$urlTags = '?';
				$i = 0;
				foreach ($urlTagDailymotion as $key => $value) {
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

			//define videolink
			$new_link 	= 'http://www.dailymotion.com/embed/video/'.$video_code.$urlTags;

			//define attributes
			$attributes = ' webkitAllowFullScreen mozallowfullscreen allowFullScreen';
	}

	//define output variable
	$output = '<div'.$class_output.$inline_div.'><iframe src="'.$new_link.'"'.$inline_iframe.$attributes.'></iframe></div>';

	return $output;
}
