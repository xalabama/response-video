# Response Video Function 1.2.1
The Response Video Function will intigrate a full responsive video from plattforms like youtube, vimeo or dailymotion.

## Installation
Download the response_video.php and integrate it to your project like this:

```php
<?php require('/response_video.php'); ?>
```

## Usage
To use the response video function you only have to call the function like this:

```php
<?php echo response_video( array( 'plattform'=>'youtube', 'link'=>'http://youtube.com/watch?v=QILiHiTD3uc' ) ); ?>
```

You have to specify two settings to tell the function which video from what plattform you want to integrate. There are some other settings you can change. If you want to do that look to the section below.

## Settings
| Option        | Type          | Default | Description  |
| ------------- | ------------- | ------- | ------------ |
| `plattform` | **string** | `youtube` |enter your plattform. Possible are one of them: 'youtube', 'vimeo', 'dailymotion' |
| `link` | **string** | a youtube video | _enter the link to your video_ |
| `class` | **string** | `embed-container` | _enter the classes you want to add. leave it blank for no classes._ |
| `inline` | **boolean** | `true` | _set it true to input the styles directly into the elements. set fasle for don't do that_ |
| `adds` | **boolean** | `false` | _enable/disable adds after video has played (only works for youtube this time)_ |
| `controls` | **boolean** | `true` | _enable/disable player Control Elements (only works for youtube this time)_ |
| `info` | **boolean** | `true` | _enable/disable player Info (only works for youtube this time)_ |
