<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


$config['filmNvideo'] = 'film&video';
$config['filmvideo'] = 'film&video';
$config['writingNpublishing'] = 'writing&publishing';
$config['writingpublishing'] = 'writing&publishing';
$config['musicNaudio'] = 'music&audio';
$config['musicaudio'] = 'music&audio';
$config['photographyNart'] = 'photography&art';
$config['photographyart'] = 'photography&art';
$config['educationMaterial'] = 'educationalmaterial';
$config['educationmaterials'] = 'educationalmaterial';

$config['filmNvideoPrifix'] = 'Fv';
$config['filmvideoPrifix'] = 'Fv';
$config['musicNaudioPrifix'] = 'Ma';
$config['musicaudioPrifix'] = 'Ma';
$config['photographyNartPrifix'] = 'Pa';
$config['photographyartPrifix'] = 'Pa';
$config['writingNpublishingPrifix'] = 'Wp';
$config['writingpublishingPrifix'] = 'Wp';
$config['educationMaterialPrifix'] = 'Em';
$config['educationmaterialPrifix'] = 'Em';
$config['newsPrifix'] = 'News';
$config['reviewsPrifix'] = 'Reviews';
$config['filmNvideoFileConfig'] = array(
											'fileSizeBytes'=>'2147483648',
											'fileSizeMB'=>'2048mb',
											'fileType'=>'3gp|asf|avi|wmv|mp4|f4v|flv|mov|m2ts|mkv|mpg|ts|divx|ogv|m2v|m4v|vob',
											'defaultImage'=> 'images/default_thumb/film_video.jpg',
											'defaultImage_s'=> 'images/default_thumb/film_video_s.jpg',
											'defaultImage_b'=> 'images/default_thumb/film_video_b.jpg',
											'defaultImage_m'=> 'images/default_thumb/film_video_m.jpg',
											'defaultImage_l'=> 'images/default_thumb/film_video_l.jpg',
											'defaultImage_xl'=> 'images/default_thumb/film_video_l.jpg',
											'defaultImage_xxl'=> 'images/default_thumb/film_video_l.jpg',
											'defaultImage_xs'=> 'images/default_thumb/film_video_xs.jpg',
											'defaultImage_xxs'=> 'images/default_thumb/film_video_xxs.jpg',
											'typeOfFile'=>2
									   );
$config['musicNaudioFileConfig'] = array(
											'fileSizeBytes'=>'2147483648',
											'fileSizeMB'=>'2048mb',
											'fileType'=>'m4a|mp2|mp3|aac|wav|wma',
											'defaultImage'=>'images/default_thumb/music_audio.jpg',
											'defaultImage_xxl'=>'images/default_thumb/music_audio_l.jpg',
											'defaultImage_xl'=>'images/default_thumb/music_audio_l.jpg',
											'defaultImage_l'=>'images/default_thumb/music_audio_l.jpg',
											'defaultImage_b'=>'images/default_thumb/music_audio_b.jpg',
											'defaultImage_m'=>'images/default_thumb/music_audio_m.jpg',
											'defaultImage_s'=>'images/default_thumb/music_audio_s.jpg',
											'defaultImage_xs'=>'images/default_thumb/music_audio_xs.jpg',
											'defaultImage_xxs'=>'images/default_thumb/music_audio_xxs.jpg',
											'typeOfFile'=>3
									   );
$config['photographyNartFileConfig'] = array(
											'fileSizeBytes'=>'2147483648',
											'fileSizeMB'=>'2048mb',
											'fileType'=>'gif|jpeg|jpg|png|tiff|tif|raw|bmp|ppm|pgm|pmb|pnm|tga',
											'defaultImage'=>'images/default_thumb/photography_art.jpg',
											'defaultImage_xxl'=>'images/default_thumb/photography_art_l.jpg',
											'defaultImage_xl'=>'images/default_thumb/photography_art_l.jpg',
											'defaultImage_l'=>'images/default_thumb/photography_art_l.jpg',
											'defaultImage_b'=>'images/default_thumb/photography_art_b.jpg',
											'defaultImage_s'=>'images/default_thumb/photography_art_s.jpg',
											'defaultImage_m'=>'images/default_thumb/photography_art_m.jpg',
											'defaultImage_xs'=>'images/default_thumb/photography_art_xs.jpg',
											'defaultImage_xxs'=>'images/default_thumb/photography_art_xxs.jpg',
											'typeOfFile'=>1
									   );
$config['writingNpublishingFileConfig'] = array(
											'fileSizeBytes'=>'2147483648',
											'fileSizeMB'=>'2048mb',
											//'fileType'=>'txt|odt|text|doc|csv|ods|xls|pdf',
											'fileType'=>'pdf',
											'defaultImage'=>'images/default_thumb/writing_publishing.jpg',
											'defaultImage_xxl'=>'images/default_thumb/writing_publishing_l.jpg',
											'defaultImage_xl'=>'images/default_thumb/writing_publishing_l.jpg',
											'defaultImage_l'=>'images/default_thumb/writing_publishing_l.jpg',
											'defaultImage_b'=>'images/default_thumb/writing_publishing_b.jpg',
											'defaultImage_m'=>'images/default_thumb/writing_publishing_m.jpg',
											'defaultImage_s'=>'images/default_thumb/writing_publishing_s.jpg',
											'defaultImage_xs'=>'images/default_thumb/writing_publishing_xs.jpg',
											'defaultImage_xxs'=>'images/default_thumb/writing_publishing_xxs.jpg',
											'typeOfFile'=>4
									   );
$config['newsFileConfig'] = array(
											'fileSizeBytes'=>'2147483648',
											'fileSizeMB'=>'2048mb',
											//'fileType'=>'txt|odt|text|doc|csv|ods|xls|pdf',
											'fileType'=>'pdf',
											'defaultImage'=>'images/default_thumb/news.jpg',
											'defaultImage_xxl'=>'images/default_thumb/news_l.jpg',
											'defaultImage_xl'=>'images/default_thumb/news_l.jpg',
											'defaultImage_l'=>'images/default_thumb/news_l.jpg',
											'defaultImage_b'=>'images/default_thumb/news_b.jpg',
											'defaultImage_m'=>'images/default_thumb/news_m.jpg',
											'defaultImage_s'=>'images/default_thumb/news_s.jpg',
											'defaultImage_xs'=>'images/default_thumb/news_xs.jpg',
											'defaultImage_xxs'=>'images/default_thumb/news_xxs.jpg',
											'typeOfFile'=>4
									   );									   									   
$config['reviewsFileConfig'] = array(
											'fileSizeBytes'=>'2147483648',
											'fileSizeMB'=>'2048mb',
											'fileType'=>'txt|odt|text|doc|csv|ods|xls|pdf',
											'defaultImage'=>'images/default_thumb/reviews.jpg',
											'defaultImage_xxl'=>'images/default_thumb/reviews_l.jpg',
											'defaultImage_xl'=>'images/default_thumb/reviews_l.jpg',
											'defaultImage_l'=>'images/default_thumb/reviews_l.jpg',
											'defaultImage_b'=>'images/default_thumb/reviews_b.jpg',
											'defaultImage_m'=>'images/default_thumb/reviews_m.jpg',
											'defaultImage_s'=>'images/default_thumb/reviews_s.jpg',
											'defaultImage_xs'=>'images/default_thumb/reviews_xs.jpg',
											'defaultImage_xxs'=>'images/default_thumb/reviews_xxs.jpg',
											'typeOfFile'=>4
									   );
$config['educationMaterialFileConfig'] = array(
											'fileSizeBytes'=>'2147483648',
											'fileSizeMB'=>'2048mb',
											'fileType'=>'pdf',
											'defaultImage'=>'images/default_thumb/education_material.jpg',
											'defaultImage_l'=>'images/default_thumb/education_material_l.jpg',
											'defaultImage_b'=>'images/default_thumb/education_material_b.jpg',
											'defaultImage_m'=>'images/default_thumb/education_material_m.jpg',
											'defaultImage_s'=>'images/default_thumb/education_material_s.jpg',
											'defaultImage_xs'=>'images/default_thumb/education_material_xs.jpg',
											'defaultImage_xxs'=>'images/default_thumb/education_material_xxs.jpg',
											'typeOfFile'=>4
									   );
									   
									   
									   
/* Short Link Section */

$config['filmNvideoSl'] = 'filmvideo';
$config['writingNpublishingSl'] = 'writingpublishing';
$config['musicNaudioSl'] = 'musicaudio';
$config['photographyNartSl'] = 'photographyart';
$config['educationMaterialSl'] = 'educationmaterial';
$config['newsSl'] = 'news';
$config['reviewsSl'] = 'reviews';

$config['filmvideo_frntmathod'] = 'filmvideo';
$config['writingpublishing_frntmathod'] = 'writingpublishing';
$config['musicaudio_frntmathod'] = 'musicaudio';
$config['photographyart_frntmathod'] = 'photographyart';
$config['educationmaterials_frntmathod'] = 'educationmaterial';
$config['newscollection_frntmathod'] = 'news';
$config['reviewscollection_frntmathod'] = 'reviews';

$config['filmvideo_bkendmathod'] = 'filmNvideo';
$config['writingpublishing_bkendmathod'] = 'writingNpublishing';
$config['musicaudio_bkendmathod'] = 'musicNaudio';
$config['photographyart_bkendmathod'] = 'photographyNart';
$config['educationmaterials_bkendmathod'] = 'educationMaterial';
$config['newscollection_bkendmathod'] = 'news';
$config['reviewscollection_bkendmathod'] = 'reviews';


$config['filmNvideoLang'] =  $config['filmvideoLang'] = 'filmNvideo';
$config['writingNpublishingLang'] = $config['writingpublishingLang'] = 'writingNpublishing';
$config['musicNaudioLang'] = $config['musicaudioLang'] = 'musicNaudio';
$config['photographyNartLang'] = $config['photographyartLang'] = 'photographyNart';
$config['educationMaterialLang'] = $config['educationmaterialLang'] = 'educationMaterial';
$config['newsLang'] = 'news';
$config['reviewsLang'] = 'reviews';

$config['filmNvideoIndustry'] =  $config['filmvideoIndustry'] = 'filmNvideo';
$config['writingNpublishingIndustry'] = $config['writingpublishingIndustry'] = 'writingNpublishing';
$config['musicNaudioIndustry'] = $config['musicaudioIndustry'] = 'musicNaudio';
$config['photographyNartIndustry'] = $config['photographyartIndustry'] = 'photographyNart';
$config['educationMaterialIndustry'] = $config['educationmaterialIndustry'] = 'educationMaterial';
$config['newsIndustry'] = 'news';
$config['reviewsIndustry'] = 'reviews';


/*End */									   
