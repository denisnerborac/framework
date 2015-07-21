<?php
/*
echo '<pre>';

// VINE
$vine_videos = API_Vine::getVideos('medeinfrance');
print_r($vine_videos);
foreach($vine_videos as $video) {
	$_video = API_Vine::getVideoUrl($video['id']);
	echo $_video;
}

// INSTAGRAM
$instagram_photos = API_Instagram::getPhotos('1823008731');
foreach($vine_videos as $video) {
	echo API_Youtube::getVideoUrl($video['id'], array('controls' => 0)).'<br>';
}
print_r($instagram_photos);

// YOUTUBE
$youtube_videos = API_Youtube::getChannelVideos('UCARTK-6spY4FeMGwUb4d-zQ');
foreach($youtube_videos as $video) {
	echo API_Youtube::getVideoUrl($video['id'], array('controls' => 0)).'<br>';
}
print_r($youtube_videos);

// FACEBOOK
$facebook_posts = API_Facebook::getPosts('christineandthequeens');
print_r($facebook_posts);

// TWITTER
$twitter_posts = API_Twitter::getPosts();
print_r($twitter_posts);

// FORM
$form = new Form('form_name', 'form_id', 'index.php', 'GET');
$form->addField('toto', 'Toto', 'text');
echo $form->render();

// IMAGE RESIZE/CROP
//Image::resize(IMG_PATH.'image.jpg', IMG_PATH.'image-thumbs.jpg', $width = 200, $height = 0, $percent = 0, $crop = true, IMAGETYPE_JPEG);

echo '</pre>';
*/