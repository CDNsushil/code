<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//Variable for images to get uploaded

$config['blog_allowed_upload_image_size'] = '2048';
$config['blog_allowed_upload_image_size_unit'] = 'kb';
$config['blog_allowed_image_type'] = 'gif|jpg|jpeg|png';
$config['workProfile_allowed_upload_image_size'] = '2048';
$config['workProfile_allowed_upload_image_size_unit'] = 'kb';
$config['workProfile_allowed_image_type'] = 'gif|jpg|jpeg|png';

$config['gallery_thumb_version_folder'] = 'galversion';

$config['gallery_allowed_upload_img_orignal_suffix'] = '_orignal';

$config['gallery_allowed_upload_img_size'] = '2048';
$config['gallery_allowed_upload_img_big_width'] = '480';
$config['gallery_allowed_upload_img_big_height'] = '480';
$config['gallery_allowed_upload_img_big_suffix'] = '_big';

$config['gallery_allowed_upload_img_medium_width'] = '240';
$config['gallery_allowed_upload_img_medium_height'] = '240';
$config['gallery_allowed_upload_img_medium_suffix'] = '_medium';

$config['gallery_allowed_upload_img_small_width'] = '160';
$config['gallery_allowed_upload_img_small_height'] = '160';
$config['gallery_allowed_upload_img_small_suffix'] = '_small';

$config['gallery_allowed_upload_img_extra_small_width'] = '100';
$config['gallery_allowed_upload_img_extra_small_height'] = '100';
$config['gallery_allowed_upload_img_extra_small_suffix'] = '_xsmall';

$config['meta_author'] = "CDN";
/////////////////////////////////////////////////////////

$config['mediaTypeImages'] = "1";
$config['mediaTypeVideo'] = "2";
$config['mediaTypeAudio'] = "3";
$config['mediaTypeDoc'] = "4";

$config['mediaSize'] = '2048';
$config['mediaUnit'] = 'kb';

$config['mediaThumbVersionFolder'] = 'mediaversion';

$config['mediaOrignalSuffix'] = '_orignal';

$config['imageMimeType'] = 'gif|jpg|jpeg|png';

$config['imgThumbVersionFolder'] = 'thumb/';

$config['thumb_config'] = array(
    'sm'=>array('width'=>60,'height'=>60,'suffix'=>'_sm'),
    'xxs'=>array('width'=>75,'height'=>75,'suffix'=>'_xxs'),
    'xs'=>array('width'=>100,'height'=>100,'suffix'=>'_xs'),
    's'=>array('width'=>160,'height'=>160,'suffix'=>'_s'),
    'ms'=>array('width'=>275,'height'=>275,'suffix'=>'_ms'),
    'm'=>array('width'=>322,'height'=>322,'suffix'=>'_m'),
    'lp'=>array('width'=>418,'height'=>418,'suffix'=>'_lp'),
    'b'=>array('width'=>415,'height'=>415,'suffix'=>'_b'),
    'l'=>array('width'=>485,'height'=>485,'suffix'=>'_l'),
    'xl'=>array('width'=>560,'height'=>560,'suffix'=>'_xl'),
    'xxl'=>array('width'=>890,'height'=>890,'suffix'=>'_xxl')
);



$config['defaultMemberImg_xxl'] =  'images/default_thumb/members_l.jpg';
$config['defaultMemberImg_xl'] =  'images/default_thumb/members_l.jpg';
$config['defaultMemberImg_l'] =  'images/default_thumb/members_l.jpg';
$config['defaultMemberImg_b'] =  'images/default_thumb/members_b.jpg';
$config['defaultMemberImg_lp'] =  'images/default_thumb/members_m.jpg';
$config['defaultMemberImg_ms'] =  'images/default_thumb/members_m.jpg';
$config['defaultMemberImg_m'] =  'images/default_thumb/members_m.jpg';
$config['defaultMemberImg_s'] =  'images/default_thumb/members_s.jpg';
$config['defaultMemberImg_xs'] =  'images/default_thumb/members_xs.jpg';
$config['defaultMemberImg_xxs'] =  'images/default_thumb/members_xs.jpg';
$config['defaultMemberImg_sm'] =  'images/default_thumb/members_xs.jpg';

$config['defaultCreativeImg_xxl'] =  'images/default_thumb/creatives_l.jpg';
$config['defaultCreativeImg_xl'] =  'images/default_thumb/creatives_l.jpg';
$config['defaultCreativeImg_l'] =  'images/default_thumb/creatives_l.jpg';
$config['defaultCreativeImg_b'] =  'images/default_thumb/creatives_b.jpg';
$config['defaultCreativeImg_lp'] =  'images/default_thumb/creatives_m.jpg';
$config['defaultCreativeImg_ms'] =  'images/default_thumb/creatives_m.jpg';
$config['defaultCreativeImg_m'] =  'images/default_thumb/creatives_m.jpg';
$config['defaultCreativeImg_s'] =  'images/default_thumb/creatives_s.jpg';
$config['defaultCreativeImg_xs'] =  'images/default_thumb/creatives_xs.jpg';
$config['defaultCreativeImg_xxs'] =  'images/default_thumb/creatives_xs.jpg';
$config['defaultCreativeImg_sm'] =  'images/default_thumb/creatives_xs.jpg';

$config['defaultAssoProfImg_xxl'] = $config['defaultAssProfImg_xxl'] =  'images/default_thumb/associated_professionals_l.jpg';
$config['defaultAssoProfImg_xl'] = $config['defaultAssProfImg_xl'] =  'images/default_thumb/associated_professionals_l.jpg';
$config['defaultAssoProfImg_l'] = $config['defaultAssProfImg_l'] =  'images/default_thumb/associated_professionals_l.jpg';
$config['defaultAssoProfImg_b'] = $config['defaultAssProfImg_b'] =  'images/default_thumb/associated_professionals_b.jpg';
$config['defaultAssoProfImg_lp'] = $config['defaultAssProfImg_lp'] =  'images/default_thumb/associated_professionals_m.jpg';
$config['defaultAssoProfImg_ms'] = $config['defaultAssProfImg_ms'] =  'images/default_thumb/associated_professionals_m.jpg';
$config['defaultAssoProfImg_m'] = $config['defaultAssProfImg_m'] =  'images/default_thumb/associated_professionals_m.jpg';
$config['defaultAssoProfImg_s'] = $config['defaultAssProfImg_s'] =  'images/default_thumb/associated_professionals_s.jpg';
$config['defaultAssoProfImg_xs'] = $config['defaultAssProfImg_xs'] =  'images/default_thumb/associated_professionals_xs.jpg';
$config['defaultAssoProfImg_xxs'] = $config['defaultAssProfImg_xxs'] =  'images/default_thumb/associated_professionals_xs.jpg';
$config['defaultAssoProfImg_sm'] = $config['defaultAssProfImg_sm'] =  'images/default_thumb/associated_professionals_xs.jpg';

$config['defaultEnterpriseImg_xxl'] =  'images/default_thumb/enterprises_l.jpg';
$config['defaultEnterpriseImg_xl'] =  'images/default_thumb/enterprises_l.jpg';
$config['defaultEnterpriseImg_l'] =  'images/default_thumb/enterprises_l.jpg';
$config['defaultEnterpriseImg_b'] =  'images/default_thumb/enterprises_b.jpg';
$config['defaultEnterpriseImg_lp'] =  'images/default_thumb/enterprises_m.jpg';
$config['defaultEnterpriseImg_ms'] =  'images/default_thumb/enterprises_m.jpg';
$config['defaultEnterpriseImg_m'] =  'images/default_thumb/enterprises_m.jpg';
$config['defaultEnterpriseImg_s'] =  'images/default_thumb/enterprises_s.jpg';
$config['defaultEnterpriseImg_xs'] =  'images/default_thumb/enterprises_xs.jpg';
$config['defaultEnterpriseImg_xxs'] =  'images/default_thumb/enterprises_xs.jpg';
$config['defaultEnterpriseImg_sm'] =  'images/default_thumb/enterprises_xs.jpg';

$config['defaultFansImg_xxl'] =  'images/default_thumb/creatives_l.jpg';
$config['defaultFansImg_xl'] =  'images/default_thumb/creatives_l.jpg';
$config['defaultFansImg_l'] =  'images/default_thumb/creatives_l.jpg';
$config['defaultFansImg_b'] =  'images/default_thumb/creatives_b.jpg';
$config['defaultFansImg_lp'] =  'images/default_thumb/creatives_m.jpg';
$config['defaultFansImg_ms'] =  'images/default_thumb/creatives_m.jpg';
$config['defaultFansImg_m'] =  'images/default_thumb/creatives_m.jpg';
$config['defaultFansImg_s'] =  'images/default_thumb/creatives_s.jpg';
$config['defaultFansImg_xs'] =  'images/default_thumb/creatives_xs.jpg';
$config['defaultFansImg_xxs'] =  'images/default_thumb/creatives_xs.jpg';
$config['defaultFansImg_sm'] =  'images/default_thumb/creatives_xs.jpg';

$config['filmNvideoImage_xxl'] =  'images/default_thumb/film_video_l.jpg';
$config['filmNvideoImage_xl'] =  'images/default_thumb/film_video_l.jpg';
$config['filmNvideoImage_l'] =  'images/default_thumb/film_video_l.jpg';
$config['filmNvideoImage_b'] =  'images/default_thumb/film_video_b.jpg';
$config['filmNvideoImage_lp'] =  'images/default_thumb/film_video_m.jpg';
$config['filmNvideoImage_m'] =  'images/default_thumb/film_video_m.jpg';
$config['filmNvideoImage_ms'] =  'images/default_thumb/film_video_m.jpg';
$config['filmNvideoImage_s'] =  'images/default_thumb/film_video_s.jpg';
$config['filmNvideoImage_xs'] =  'images/default_thumb/film_video_xs.jpg';
$config['filmNvideoImage_xxs'] =  'images/default_thumb/film_video_xs.jpg';
$config['filmNvideoImage_sm'] =  'images/default_thumb/film_video_xs.jpg';

$config['musicNaudioImage_xxl'] =  'images/default_thumb/music_audio_l.jpg';
$config['musicNaudioImage_xl'] =  'images/default_thumb/music_audio_l.jpg';
$config['musicNaudioImage_l'] =  'images/default_thumb/music_audio_l.jpg';
$config['musicNaudioImage_b'] =  'images/default_thumb/music_audio_b.jpg';
$config['musicNaudioImage_lp'] =  'images/default_thumb/music_audio_m.jpg';
$config['musicNaudioImage_ms'] =  'images/default_thumb/music_audio_m.jpg';
$config['musicNaudioImage_m'] =  'images/default_thumb/music_audio_m.jpg';
$config['musicNaudioImage_s'] =  'images/default_thumb/music_audio_s.jpg';
$config['musicNaudioImage_xs'] =  'images/default_thumb/music_audio_xs.jpg';
$config['musicNaudioImage_xxs'] =  'images/default_thumb/music_audio_xs.jpg';
$config['musicNaudioImage_sm'] =  'images/default_thumb/music_audio_xs.jpg';

$config['photographyNartImage_xxl'] =  'images/default_thumb/photography_art_l.jpg';
$config['photographyNartImage_xl'] =  'images/default_thumb/photography_art_l.jpg';
$config['photographyNartImage_l'] =  'images/default_thumb/photography_art_l.jpg';
$config['photographyNartImage_b'] =  'images/default_thumb/photography_art_b.jpg';
$config['photographyNartImage_lp'] =  'images/default_thumb/photography_art_m.jpg';
$config['photographyNartImage_m'] =  'images/default_thumb/photography_art_m.jpg';
$config['photographyNartImage_ms'] =  'images/default_thumb/photography_art_m.jpg';
$config['photographyNartImage_s'] =  'images/default_thumb/photography_art_s.jpg';
$config['photographyNartImage_xs'] =  'images/default_thumb/photography_art_xs.jpg';
$config['photographyNartImage_xxs'] =  'images/default_thumb/photography_art_xs.jpg';
$config['photographyNartImage_sm'] =  'images/default_thumb/photography_art_xs.jpg';

$config['writingNpublishingImage_xxl'] =  'images/default_thumb/writing_publishing_l.jpg';
$config['writingNpublishingImage_xl'] =  'images/default_thumb/writing_publishing_l.jpg';
$config['writingNpublishingImage_l'] =  'images/default_thumb/writing_publishing_l.jpg';
$config['writingNpublishingImage_b'] =  'images/default_thumb/writing_publishing_b.jpg';
$config['writingNpublishingImage_lp'] =  'images/default_thumb/writing_publishing_m.jpg';
$config['writingNpublishingImage_m'] =  'images/default_thumb/writing_publishing_m.jpg';
$config['writingNpublishingImage_ms'] =  'images/default_thumb/writing_publishing_m.jpg';
$config['writingNpublishingImage_s'] =  'images/default_thumb/writing_publishing_s.jpg';
$config['writingNpublishingImage_xs'] =  'images/default_thumb/writing_publishing_xs.jpg';
$config['writingNpublishingImage_xxs'] =  'images/default_thumb/writing_publishing_xs.jpg';
$config['writingNpublishingImage_sm'] =  'images/default_thumb/writing_publishing_xs.jpg';

$config['educationMaterialImage_xxl'] =  'images/default_thumb/education_material_l.jpg';
$config['educationMaterialImage_xl'] =  'images/default_thumb/education_material_l.jpg';
$config['educationMaterialImage_l'] =  'images/default_thumb/education_material_l.jpg';
$config['educationMaterialImage_b'] =  'images/default_thumb/education_material_b.jpg';
$config['educationMaterialImage_lp'] =  'images/default_thumb/education_material_m.jpg';
$config['educationMaterialImage_m'] =  'images/default_thumb/education_material_m.jpg';
$config['educationMaterialImage_ms'] =  'images/default_thumb/education_material_m.jpg';
$config['educationMaterialImage_s'] =  'images/default_thumb/education_material_s.jpg';
$config['educationMaterialImage_xs'] =  'images/default_thumb/education_material_xs.jpg';
$config['educationMaterialImage_xxs'] =  'images/default_thumb/education_material_xs.jpg';
$config['educationMaterialImage_sm'] =  'images/default_thumb/education_material_xs.jpg';

$config['defaultNewsImg_xxl'] =  'images/default_thumb/news_l.jpg';
$config['defaultNewsImg_xl'] =  'images/default_thumb/news_l.jpg';
$config['defaultNewsImg_l'] =  'images/default_thumb/news_l.jpg';
$config['defaultNewsImg_b'] =  'images/default_thumb/news_b.jpg';
$config['defaultNewsImg_lp'] =  'images/default_thumb/news_m.jpg';
$config['defaultNewsImg_m'] =  'images/default_thumb/news_m.jpg';
$config['defaultNewsImg_ms'] =  'images/default_thumb/news_m.jpg';
$config['defaultNewsImg_s'] =  'images/default_thumb/news_s.jpg';
$config['defaultNewsImg_xs'] =  'images/default_thumb/news_xs.jpg';
$config['defaultNewsImg_xxs'] =  'images/default_thumb/news_xs.jpg';
$config['defaultNewsImg_sm'] =  'images/default_thumb/news_xs.jpg';

$config['defaultReviewsImg_xxl'] =  'images/default_thumb/reviews_l.jpg';
$config['defaultReviewsImg_xl'] =  'images/default_thumb/reviews_l.jpg';
$config['defaultReviewsImg_l'] =  'images/default_thumb/reviews_l.jpg';
$config['defaultReviewsImg_b'] =  'images/default_thumb/reviews_b.jpg';
$config['defaultReviewsImg_lp'] =  'images/default_thumb/reviews_m.jpg';
$config['defaultReviewsImg_m'] =  'images/default_thumb/reviews_m.jpg';
$config['defaultReviewsImg_ms'] =  'images/default_thumb/reviews_m.jpg';
$config['defaultReviewsImg_s'] =  'images/default_thumb/reviews_s.jpg';
$config['defaultReviewsImg_xs'] =  'images/default_thumb/reviews_xs.jpg';
$config['defaultReviewsImg_xxs'] =  'images/default_thumb/reviews_xs.jpg';
$config['defaultReviewsImg_sm'] =  'images/default_thumb/reviews_xs.jpg';

$config['defaultInterviewImg_xxl'] =  'images/default_thumb/interviews_l.jpg';
$config['defaultInterviewImg_xl'] =  'images/default_thumb/interviews_l.jpg';
$config['defaultInterviewImg_l'] =  'images/default_thumb/interviews_l.jpg';
$config['defaultInterviewImg_b'] =  'images/default_thumb/interviews_b.jpg';
$config['defaultInterviewImg_lp'] =  'images/default_thumb/interviews_m.jpg';
$config['defaultInterviewImg_m'] =  'images/default_thumb/interviews_m.jpg';
$config['defaultInterviewImg_ms'] =  'images/default_thumb/interviews_m.jpg';
$config['defaultInterviewImg_s'] =  'images/default_thumb/interviews_s.jpg';
$config['defaultInterviewImg_xs'] =  'images/default_thumb/interviews_xs.jpg';
$config['defaultInterviewImg_xxs'] =  'images/default_thumb/interviews_xs.jpg';
$config['defaultInterviewImg_sm'] =  'images/default_thumb/interviews_xs.jpg';

$config['defaultUpcomingImg_xxl'] =  'images/default_thumb/upcoming_l.jpg';
$config['defaultUpcomingImg_xl'] =  'images/default_thumb/upcoming_l.jpg';
$config['defaultUpcomingImg_l'] =  'images/default_thumb/upcoming_l.jpg';
$config['defaultUpcomingImg_b'] =  'images/default_thumb/upcoming_b.jpg';
$config['defaultUpcomingImg_lp'] =  'images/default_thumb/upcoming_m.jpg';
$config['defaultUpcomingImg_m'] =  'images/default_thumb/upcoming_m.jpg';
$config['defaultUpcomingImg_ms'] =  'images/default_thumb/upcoming_m.jpg';
$config['defaultUpcomingImg_s'] =  'images/default_thumb/upcoming_s.jpg';
$config['defaultUpcomingImg_xs'] =  'images/default_thumb/upcoming_xs.jpg';
$config['defaultUpcomingImg_xxs'] =  'images/default_thumb/upcoming_xs.jpg';
$config['defaultUpcomingImg_sm'] =  'images/default_thumb/upcoming_xs.jpg';

$config['defaultBlogImg_xxl'] =  'images/default_thumb/blog_default_image_l.jpg';
$config['defaultBlogImg_xl'] =  'images/default_thumb/blog_default_image_l.jpg';
$config['defaultBlogImg_l'] =  'images/default_thumb/blog_default_image_l.jpg';
$config['defaultBlogImg_b'] =  'images/default_thumb/blog_default_image_b.jpg';
$config['defaultBlogImg_lp'] =  'images/default_thumb/blog_default_image_m.jpg';
$config['defaultBlogImg_m'] =  'images/default_thumb/blog_default_image_m.jpg';
$config['defaultBlogImg_ms'] =  'images/default_thumb/blog_default_image_m.jpg';
$config['defaultBlogImg_s'] =  'images/default_thumb/blog_default_image_s.jpg';
$config['defaultBlogImg_xs'] =  'images/default_thumb/blog_default_image_xs.jpg';
$config['defaultBlogImg_xxs'] =  'images/default_thumb/blog_default_image_xs.jpg';
$config['defaultBlogImg_sm'] =  'images/default_thumb/blog_default_image_xs.jpg';

$config['defaultPostImg_xxl'] =  'images/default_thumb/post_default_image_l.jpg';
$config['defaultPostImg_xl'] =  'images/default_thumb/post_default_image_l.jpg';
$config['defaultPostImg_l'] =  'images/default_thumb/post_default_image_l.jpg';
$config['defaultPostImg_b'] =  'images/default_thumb/post_default_image_b.jpg';
$config['defaultPostImg_lp'] =  'images/default_thumb/post_default_image_m.jpg';
$config['defaultPostImg_m'] =  'images/default_thumb/post_default_image_m.jpg';
$config['defaultPostImg_ms'] =  'images/default_thumb/post_default_image_m.jpg';
$config['defaultPostImg_s'] =  'images/default_thumb/post_default_image_s.jpg';
$config['defaultPostImg_xs'] =  'images/default_thumb/post_default_image_xs.jpg';
$config['defaultPostImg_xxs'] =  'images/default_thumb/post_default_image_xs.jpg';
$config['defaultPostImg_sm'] =  'images/default_thumb/post_default_image_xs.jpg';

$config['defaultEventImg_xxl'] =  'images/default_thumb/events_l.jpg';
$config['defaultEventImg_xl'] =  'images/default_thumb/events_l.jpg';
$config['defaultEventImg_l'] =  'images/default_thumb/events_l.jpg';
$config['defaultEventImg_b'] =  'images/default_thumb/events_b.jpg';
$config['defaultEventImg_lp'] =  'images/default_thumb/events_m.jpg';
$config['defaultEventImg_m'] =  'images/default_thumb/events_m.jpg';
$config['defaultEventImg_ms'] =  'images/default_thumb/events_m.jpg';
$config['defaultEventImg_s'] =  'images/default_thumb/events_s.jpg';
$config['defaultEventImg_xs'] =  'images/default_thumb/events_xs.jpg';
$config['defaultEventImg_xxs'] =  'images/default_thumb/events_xs.jpg';
$config['defaultEventImg_sm'] =  'images/default_thumb/events_xs.jpg';

$config['defaultProductFree_xxl'] =  'images/default_thumb/free_products_l.jpg';
$config['defaultProductFree_xl'] =  'images/default_thumb/free_products_l.jpg';
$config['defaultProductFree_l'] =  'images/default_thumb/free_products_l.jpg';
$config['defaultProductFree_b'] =  'images/default_thumb/free_products_b.jpg';
$config['defaultProductFree_lp'] =  'images/default_thumb/free_products_m.jpg';
$config['defaultProductFree_m'] =  'images/default_thumb/free_products_m.jpg';
$config['defaultProductFree_ms'] =  'images/default_thumb/free_products_m.jpg';
$config['defaultProductFree_s'] =  'images/default_thumb/free_products_s.jpg';
$config['defaultProductFree_xs'] =  'images/default_thumb/free_products_xs.jpg';
$config['defaultProductFree_xxs'] =  'images/default_thumb/free_products_xs.jpg';
$config['defaultProductFree_sm'] =  'images/default_thumb/free_products_xs.jpg';

$config['defaultProductWanted_xxl'] =  'images/default_thumb/product_wanted_l.jpg';
$config['defaultProductWanted_xl'] =  'images/default_thumb/product_wanted_l.jpg';
$config['defaultProductWanted_l'] =  'images/default_thumb/product_wanted_l.jpg';
$config['defaultProductWanted_b'] =  'images/default_thumb/product_wanted_b.jpg';
$config['defaultProductWanted_lp'] =  'images/default_thumb/product_wanted_m.jpg';
$config['defaultProductWanted_m'] =  'images/default_thumb/product_wanted_m.jpg';
$config['defaultProductWanted_ms'] =  'images/default_thumb/product_wanted_m.jpg';
$config['defaultProductWanted_s'] =  'images/default_thumb/product_wanted_s.jpg';
$config['defaultProductWanted_xs'] =  'images/default_thumb/product_wanted_xs.jpg';
$config['defaultProductWanted_xxs'] =  'images/default_thumb/product_wanted_xs.jpg';
$config['defaultProductWanted_sm'] =  'images/default_thumb/product_wanted_xs.jpg';

$config['defaultProductOffered_xxl'] =  'images/default_thumb/product_offered_l.jpg';
$config['defaultProductOffered_xl'] =  'images/default_thumb/product_offered_l.jpg';
$config['defaultProductOffered_l'] =  'images/default_thumb/product_offered_l.jpg';
$config['defaultProductOffered_b'] =  'images/default_thumb/product_offered_b.jpg';
$config['defaultProductOffered_lp'] =  'images/default_thumb/product_offered_m.jpg';
$config['defaultProductOffered_m'] =  'images/default_thumb/product_offered_m.jpg';
$config['defaultProductOffered_ms'] =  'images/default_thumb/product_offered_m.jpg';
$config['defaultProductOffered_s'] =  'images/default_thumb/product_offered_s.jpg';
$config['defaultProductOffered_xs'] =  'images/default_thumb/product_offered_xs.jpg';
$config['defaultProductOffered_xxs'] =  'images/default_thumb/product_offered_xs.jpg';
$config['defaultProductOffered_sm'] =  'images/default_thumb/product_offered_xs.jpg';

$config['defaultProductForSale_xxl'] =  'images/default_thumb/product_for_sale_l.jpg';
$config['defaultProductForSale_xl'] =  'images/default_thumb/product_for_sale_l.jpg';
$config['defaultProductForSale_l'] =  'images/default_thumb/product_for_sale_l.jpg';
$config['defaultProductForSale_b'] =  'images/default_thumb/product_for_sale_b.jpg';
$config['defaultProductForSale_lp'] =  'images/default_thumb/product_for_sale_m.jpg';
$config['defaultProductForSale_m'] =  'images/default_thumb/product_for_sale_m.jpg';
$config['defaultProductForSale_ms'] =  'images/default_thumb/product_for_sale_m.jpg';
$config['defaultProductForSale_s'] =  'images/default_thumb/product_for_sale_s.jpg';
$config['defaultProductForSale_xs'] =  'images/default_thumb/product_for_sale_xs.jpg';
$config['defaultProductForSale_xxs'] =  'images/default_thumb/product_for_sale_xs.jpg';
$config['defaultProductForSale_sm'] =  'images/default_thumb/product_for_sale_xs.jpg';

$config['defaultWorkWanted_xxl'] =  'images/default_thumb/work wanted_l.jpg';
$config['defaultWorkWanted_xl'] =  'images/default_thumb/work wanted_l.jpg';
$config['defaultWorkWanted_l'] =  'images/default_thumb/work wanted_l.jpg';
$config['defaultWorkWanted_b'] =  'images/default_thumb/work wanted_b.jpg';
$config['defaultWorkWanted_lp'] =  'images/default_thumb/work wanted_m.jpg';
$config['defaultWorkWanted_m'] =  'images/default_thumb/work wanted_m.jpg';
$config['defaultWorkWanted_ms'] =  'images/default_thumb/work wanted_m.jpg';
$config['defaultWorkWanted_s'] =  'images/default_thumb/work wanted_s.jpg';
$config['defaultWorkWanted_xs'] =  'images/default_thumb/work wanted_xs.jpg';
$config['defaultWorkWanted_xxs'] =  'images/default_thumb/work wanted_xs.jpg';
$config['defaultWorkWanted_sm'] =  'images/default_thumb/work wanted_xs.jpg';

$config['defaultWorkOffered_xxl'] =  'images/default_thumb/work_offered_l.jpg';
$config['defaultWorkOffered_xl'] =  'images/default_thumb/work_offered_l.jpg';
$config['defaultWorkOffered_l'] =  'images/default_thumb/work_offered_l.jpg';
$config['defaultWorkOffered_b'] =  'images/default_thumb/work_offered_b.jpg';
$config['defaultWorkOffered_lp'] =  'images/default_thumb/work_offered_m.jpg';
$config['defaultWorkOffered_m'] =  'images/default_thumb/work_offered_m.jpg';
$config['defaultWorkOffered_ms'] =  'images/default_thumb/work_offered_m.jpg';
$config['defaultWorkOffered_s'] =  'images/default_thumb/work_offered_s.jpg';
$config['defaultWorkOffered_xs'] =  'images/default_thumb/work_offered_xs.jpg';
$config['defaultWorkOffered_xxs'] =  'images/default_thumb/work_offered_xs.jpg';
$config['defaultWorkOffered_sm'] =  'images/default_thumb/work_offered_xs.jpg';

//Others Image
$config['sectionIdImage1'] = 'Media1_110x73.jpg'; 
$config['sectionImage1'] = 'film_video_s.jpg'; 
$config['sectionIdImage2'] = 'Media1_110x73.jpg'; 
$config['sectionImage2'] = 'music_audio_s.jpg'; 
$config['sectionIdImage3'] = 'Media1_110x73.jpg';
$config['sectionImage3'] = 'writing_publishing_s.jpg';
$config['sectionIdImage3_1'] = 'News_110x73.jpg'; 
$config['sectionImage3_1'] = 'news_s.jpg';
$config['sectionIdImage3_2'] = 'Review_110x73.jpg';
$config['sectionImage3_2'] = 'reviews_s.jpg';
$config['sectionIdImage4'] = 'Media1_110x73.jpg'; 
$config['sectionImage4'] = 'photography_art_s.jpg'; 
$config['sectionIdImage9_1'] = 'Performances-and-Events_110x73.jpg'; 
$config['sectionIdImage9_2'] = 'Performances-and-Events_110x73.jpg'; 
$config['sectionIdImage9_3'] = 'Performances-and-Events_110x73.jpg'; 
$config['sectionIdImage9_4'] = 'Performances-and-Events_110x73.jpg'; 
$config['sectionIdImage10'] = 'Media1_110x73.jpg'; 
$config['sectionImage10'] = 'education_material_s.jpg'; 
$config['sectionIdImage11'] = 'Work_110x73.jpg';  
$config['sectionIdImage12'] = 'Products_110x73.jpg';
$config['sectionIdImage12_1'] = 'Products_110x73.jpg'; 
$config['sectionIdImage11'] = 'advertisewithus_icon.gif';
$config['sectionIdImage12_3'] = '73px-X-110px_Products-FREE_1.jpg';   
$config['sectionIdImage16'] = 'competition_73x110.jpg'; 
$config['sectionIdImage16_1'] = 'competitionentry_73x110.jpg'; 
$config['sectionIdImage17'] = 'Upcoming_110x73.jpg'; 
$config['sectionIdImage15'] = 'collaboration.jpg'; 

?>
