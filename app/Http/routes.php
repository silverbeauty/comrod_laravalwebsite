<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('gallery2', ['as' => 'gallery2', 'uses' => 'HomeController@index']);
Route::get('v3', ['as' => 'v3', 'uses' => 'HomeController@v3']);
Route::get('categories/{slug}', ['as' => 'getCategory', 'uses' => 'HomeController@getCategory']);
Route::get('contact-us', [ 'as' => 'contact-us', 'uses' => 'PagesController@contactUs']);
Route::get('about-us', [ 'as' => 'about-us', 'uses' => 'PagesController@aboutUs']);
Route::get('faq', [ 'as' => 'faq', 'uses' => 'PagesController@faq']);
Route::get('terms-and-conditions', [ 'as' => 'terms-and-conditions', 'uses' => 'PagesController@termsAndConditions']);
Route::get('uploading-guidelines', ['as' => 'uploading-rules', 'uses' => 'PagesController@uploadingRules']);
Route::get('explainervideo', ['as' => 'explainer-video', 'uses' => 'PagesController@explainerVideo']);
Route::get('dashcams', ['as' => 'dashcams', 'uses' => 'PagesController@dashcams']);
Route::get('dashcam-review/{model}', ['as' => 'dashcam-review', 'uses' => 'PagesController@dashcamreview']);
Route::get('gallery', ['as' => 'gallery', 'uses' => 'HomeController@index']);
Route::get('', [ 'as' => 'home', 'uses' => 'PagesController@lander']);
Route::get('blog', ['as' => 'blog', 'uses' => 'PagesController@blog']);
Route::get('photos', ['as' => 'photos', 'uses' => 'HomeController@photos']);
Route::get('videos', ['as' => 'videos', 'uses' => 'HomeController@videos']);
Route::get('categories/{slug}', ['as' => 'getCategory', 'uses' => 'HomeController@getCategory']);
Route::get('api-upload-test', ['as' => 'apiUploadTest', 'uses' => 'TestController@apiUploadTest']);
Route::get('switch-layout/{version}', ['as' => 'switchLayout', 'uses' => 'HomeController@switchLayout']);
Route::get('live-feed', ['as' => 'liveFeeds', 'uses' => 'HomeController@liveFeeds']);
Route::get('live-feed/{id}', ['as' => 'liveFeed', 'uses' => 'HomeController@liveFeed']);

Route::get('blog/{title}', ['as' => 'blogtitle', 'uses' => 'PagesController@blogpost']);
/*Route::get('/dashcam', function() {
  return File::get(public_path() . '/dashcams/index.html');
});*/

Route::group(['prefix' => '', 'as' => 'auth::'], function () {
    Route::get('login', ['as' => 'getLogin', 'uses' => 'Auth\AuthController@getLogin']);    
    Route::post('login', ['as' => 'postLogin', 'uses' => 'Auth\AuthController@postLogin']);
    Route::get('logout', ['as' => 'getLogout', 'uses' => 'Auth\AuthController@getLogout']);
    Route::get('signup', ['as' => 'getSignup', 'uses' => 'Auth\AuthController@getRegister']);
    Route::get('signup/thank-you', ['as' => 'getSignupThankYou', 'uses' => 'Auth\AuthController@getSignupThankYou']);
    Route::post('signup', ['as' => 'postSignup', 'uses' => 'Auth\AuthController@postRegister']);
    Route::get('social-signup', ['as' => 'getSocialSignup', 'uses' => 'Auth\AuthController@getSocialSignup']);
    Route::post('social-signup', ['as' => 'postSocialSignup', 'uses' => 'Auth\AuthController@postSocialSignup']);
    Route::get('password/email', ['as' => 'getPasswordEmail', 'uses' => 'Auth\PasswordController@getEmail']);
    Route::post('password/email', ['as' => 'postPasswordEmail', 'uses' => 'Auth\PasswordController@postEmail']);
    Route::get('password/reset/{token}', ['as' => 'getPasswordReset', 'uses' => 'Auth\PasswordController@getReset']);
    Route::post('password/reset', ['as' => 'postPasswordReset', 'uses' => 'Auth\PasswordController@postReset']);
    Route::get('auth/{driver}', ['as' => 'getSocialLogin', 'uses' => 'Auth\AuthController@getSocialLogin']);
    Route::get('auth/{driver}/callback', ['as' => 'getSocialLoginCallback', 'uses' => 'Auth\AuthController@getSocialLoginCallback']);

});

Route::group(['prefix' => 'account', 'as' => 'account::'], function () {
    Route::get('verify/{token}', ['as' => 'getVerifyEmail', 'uses' => 'AccountController@getVerifyEmail']);
    Route::post('resend-confirmation-email', ['as' => 'postResendConfirmationEmail', 'uses' => 'AccountController@postResendConfirmationEmail']);
    Route::post('change-email', ['as' => 'postChangeEmail', 'uses' => 'AccountController@postChangeEmail']);
    Route::get('settings', ['as' => 'getSettings', 'uses' => 'AccountController@getSettings']);
    Route::post('change-password', ['as' => 'postChangePassword', 'uses' => 'AccountController@postChangePassword']);
});

Route::resource('api/contents', 'Api\ContentsController');

Route::controller('api', 'ApiController', [
    'postLikeComment' => 'api::postLikeComment',
    'postDislikeComment' => 'api::postDislikeComment',
    'postLikeReply' => 'api::postLikeReply',
    'postDislikeReply' => 'api::postDislikeReply',
    'postLikeContent' => 'api::postLikeContent',
    'postDislikeContent' => 'api::postDislikeContent',
    'postWriteReply' => 'api::postWriteReply',
    'postWriteComment' => 'api::postWriteComment',
    'postSuggestLocation' => 'api::postSuggestLocation',
    'getSearchCityByCountry' => 'api::getSearchCityByCountry',
    'postReportContent' => 'api::postReportContent',
    'getRegionsByCountry' => 'api::getRegionsByCountry',
    'postDiscussionMarkRead' => 'api::postDiscussionMarkRead',
    'postDeleteTempUploadedVideo' => 'api::postDeleteTempUploadedVideo',
    'postDeleteTempUploadedPhoto' => 'api::postDeleteTempUploadedPhoto',
    'getVehicleMakeModels' => 'api::getVehicleMakeModels',
    'getSearchLicensePlate' => 'api::getSearchLicensePlate',
    'postEditUserProfile' => 'api::postEditUserProfile',
    'postEditContent' => 'api::postEditContent',
    'postDeleteVideo' => 'api::postDeleteVideo',
    'postDeletePhoto' => 'api::postDeletePhoto',
    'getAutocompleteUsers' => 'api::getAutocompleteUsers',
    'getMapContents' => 'api::getMapContents',
]);

Route::controller('admin', 'AdminController', [
    'getIndex' => 'admin::getIndex',
    'getUsers' => 'admin::getUsers',
    'getContents' => 'admin::getContents',
    'getContentsDeletedApi' => 'admin::getContentsDeletedApi',
    'getContentsPendingApi' => 'admin::getContentsPendingApi',
    'getContentsPublishedApi' => 'admin::getContentsPublishedApi',
    'getContentsPrivateApi' => 'admin::getContentsPrivateApi',
    'getContentsAppApi' => 'admin::getContentsAppApi',
    'getUsersActivity' => 'admin::getUsersActivity',
    'getUsersApi' => 'admin::getUsersApi',
    'postDeleteUser' => 'admin::postDeleteUser',
    'postRestoreUser' => 'admin::postRestoreUser',
    'getUserSettings' => 'admin::getUserSettings',
    'postEditUserRole' => 'admin::postEditUserRole',
    'getRolesPermissions' => 'admin::getRolesPermissions',
    'postEditRolePermission' => 'admin::postEditRolePermission',
    'getContentSettings' => 'admin::getContentSettings',
    'postDeleteContent' => 'admin::postDeleteContent',
    'postRestoreContent' => 'admin::postRestoreContent',
    'postPublishContent' => 'admin::postPublishContent',
    'postSetContentAsPending' => 'admin::postSetContentAsPending',
    'postForceDeleteContent' => 'admin::postForceDeleteContent',
    'postEditContent' => 'admin::postEditContent',
    'getComments' => 'admin::getComments',
    'getDatatablesComments' => 'admin::getDatatablesComments',
    'postEditComment' => 'admin::postEditComment',
    'postForceDeleteComment' => 'admin::postForceDeleteComment',
    'getTranslators' => 'admin::getTranslators',
    'getDatatablesTranslators' => 'admin::getDatatablesTranslators',
    'postDeleteTranslator' => 'admin::postDeleteTranslator',
    'postAssignLanguage' => 'admin::postAssignLanguage',
    'postAddTranslator' => 'admin::postAddTranslator',
    'getLocalization' => 'admin::getLocalization',
    'getDatatablesTranslations' => 'admin::getDatatablesTranslations',
    'getDatatablesContentTranslations' => 'admin::getDatatablesContentTranslations',
    'postUpdateTranslation' => 'admin::postUpdateTranslation',
    'postUpdateContentTranslation' => 'admin::postUpdateContentTranslation',
    'postAddTranslationItem' => 'admin::postAddTranslationItem',
    'getLanguages' => 'admin::getLanguages',
    'getDatatablesLanguages' => 'admin::getDatatablesLanguages',
    'postEditLanguage' => 'admin::postEditLanguage',
    'postDeleteLanguage' => 'admin::postDeleteLanguage',
    'postRestoreLanguage' => 'admin::postRestoreLanguage',
    'postAddLanguage' => 'admin::postAddLanguage',
    'postForceDeleteLanguage' => 'admin::postForceDeleteLanguage',
    'getSuggestedLocations' => 'admin::getSuggestedLocations',
    'getDatatablesSuggestedLocations' => 'admin::getDatatablesSuggestedLocations',
    'postApproveSuggestedLocation' => 'admin::postApproveSuggestedLocation',
    'postDeleteSuggestedLocation' => 'admin::postDeleteSuggestedLocation',
    'getMultipleViolations' => 'admin::getMultipleViolations',
    'getDatatablesMultipleViolations' => 'admin::getDatatablesMultipleViolations',
    'getInactiveEmbed' => 'admin::getInactiveEmbed',
    'getDatatablesInactiveEmbed' => 'admin::getDatatablesInactiveEmbed',
    'getDatatablesReportedContents' => 'admin::getDatatablesReportedContents',
    'getAds' => 'admin::getAds',
    'getDatatablesAds' => 'admin::getDatatablesAds',
    'getDatatablesPages' => 'admin::getDatatablesPages',
    'postAddAd' => 'admin::postAddAd',
    'postEditAd' => 'admin::postEditAd',
    'postDeleteAd' => 'admin::postDeleteAd',
    'postForceDeleteAd' => 'admin::postForceDeleteAd',
    'postRestoreAd' => 'admin::postRestoreAd',
    'getUnencodedContents' => 'admin::getUnencodedContents',
    'getDatatablesUnencodedContents' => 'admin::getDatatablesUnencodedContents',
    'postEncodeContent' => 'admin::postEncodeContent',
    'getImpersonate' => 'admin::getImpersonate',
    'postChangeUserPassword' => 'admin::postChangeUserPassword',
    'postEditUserProfile' => 'admin::postEditUserProfile',
    'getPages' => 'admin::getPages',
    'getFlushCache' => 'admin::getFlushCache',
    'postAddTranslatorFilters' => 'admin::postAddTranslatorFilters',
    'getReportedContents' => 'admin::getReportedContents',
    'postDeleteContentReport' => 'admin::postDeleteContentReport',
    'getNonIsraelVideos' => 'admin::getNonIsraelVideos',
    'getAddLiveFeed' => 'admin::getAddLiveFeed',
    'postAddLiveFeed' => 'admin::postAddLiveFeed',
    'getLiveFeeds' => 'admin::getLiveFeeds',
    'getDatatablesPublishedLiveFeeds' => 'admin::getDatatablesPublishedLiveFeeds',
    'getEditLiveFeed' => 'admin::getEditLiveFeed',
    'postUpdateLiveFeed' => 'admin::postUpdateLiveFeed',
    'postDeleteLiveFeed' => 'admin::postDeleteLiveFeed',
]);

Route::controller('zencoder', 'ZencoderController', [
    'postNotifications' => 'zencoder::postNotifications'
]);

Route::group(['prefix' => 'mobile/api', 'as' => 'mobile_api::'], function () {
    Route::post('login', ['as' => 'login', 'uses' => 'MobileApiController@login']);
    Route::post('signup', ['as' => 'signup', 'uses' => 'MobileApiController@signup']);
    Route::post('account', ['as' => 'account', 'uses' => 'MobileApiController@account']);
    Route::post('social-login', ['as' => 'socialLogin', 'uses' => 'MobileApiController@socialLogin']);
    Route::post('social-signup', ['as' => 'socialSignup', 'uses' => 'MobileApiController@socialSignup']);
    Route::post('search-by-plate', ['as' => 'searchByPlate', 'uses' => 'MobileApiController@searchByPlate']);
    Route::post('upload/video', ['as' => 'uploadVideo', 'uses' => 'MobileApiController@uploadVideo']);
    Route::post('upload/photo', ['as' => 'uploadPhoto', 'uses' => 'MobileApiController@uploadPhoto']);
    Route::post('upload/content', ['as' => 'uploadContent', 'uses' => 'MobileApiController@uploadContent']);
    Route::post('upload/available', ['as' => 'uploadAvailable', 'uses' => 'MobileApiController@uploadAvailable']);
});

Route::resource('mobile-api-test', 'MobileApiTestController');

Route::group(['prefix' => 'messages', 'as' => 'messages::'], function () {
    Route::get('/', ['as' => 'index', 'uses' => 'MessagesController@index']);
    Route::get('new', ['as' => 'new', 'uses' => 'MessagesController@create']);
    Route::post('/', ['as' => 'store', 'uses' => 'MessagesController@store']);
    Route::get('{id}', ['as' => 'show', 'uses' => 'MessagesController@show']);
    Route::put('{id}', ['as' => 'update', 'uses' => 'MessagesController@update']);
    Route::post('delete-thread', ['as' => 'deleteThread', 'uses' => 'MessagesController@deleteThread']);
    Route::post('delete-message', ['as' => 'deleteMessage', 'uses' => 'MessagesController@deleteMessage']);
});

Route::group(['prefix' => 'upload', 'as' => 'upload::'], function () {
    Route::get('video', ['as' => 'getVideo', 'uses' => 'UploadController@getVideo']);
    Route::get('photo', ['as' => 'getPhoto', 'uses' => 'UploadController@getPhoto']);
    Route::post('content', ['as' => 'postContent', 'uses' => 'UploadController@postContent']);
    Route::post('update-avatar', ['as' => 'postUpdateAvatar', 'uses' => 'UploadController@postUpdateAvatar']);
    Route::any('upload-video', ['as' => 'postUploadVideo', 'uses' => 'UploadController@postUploadVideo']);
    Route::post('upload-photo', ['as' => 'postUploadPhoto', 'uses' => 'UploadController@postUploadPhoto']);
    Route::post('change-thumbnail', ['as' => 'postChangeThumbnail', 'uses' => 'UploadController@postChangeThumbnail']);
    Route::get('thank-you/{id}', ['as' => 'getThankYou', 'uses' => 'UploadController@getThankYou']);    
});

Route::group(['prefix' => 'img', 'as' => 'images::'], function () {
    Route::get('', ['as' => 'url', 'uses' => 'PhotosController@show']);
});

Route::get('discussions', ['as' => 'getDiscussions', 'uses' => 'ProfileController@getDiscussions']);
Route::get('embed/{id}', ['as' => 'getEmbed', 'uses' => 'ProfileController@getEmbed']);
Route::get('video/{slug}', ['as' => 'getContentVideoProfile', 'uses' => 'ProfileController@getVideoProfile']);
Route::get('photo/{slug}', ['as' => 'getContentPhotoProfile', 'uses' => 'ProfileController@getPhotoProfile']);
Route::get('video/{slug}/edit', ['as' => 'getEditVideo', 'uses' => 'ProfileController@getVideoProfileEdit']);
Route::get('photo/{slug}/edit', ['as' => 'getEditPhoto', 'uses' => 'ProfileController@getPhotoProfileEdit']);
Route::get('user/{slug}', ['as' => 'getUserProfile', 'uses' => 'ProfileController@getUserProfile']);
Route::get('user/{slug}/uploads', ['as' => 'getUserUploads', 'uses' => 'ProfileController@getUserUploads']);
Route::get('user/{slug}/videos', ['as' => 'getUserVideos', 'uses' => 'ProfileController@getUserVideos']);
Route::get('user/{slug}/photos', ['as' => 'getUserPhotos', 'uses' => 'ProfileController@getUserPhotos']);
Route::get('user/{slug}/edit', ['as' => 'getUserEditProfile', 'uses' => 'ProfileController@getUserEditProfile']);
//Route::get('{slug}', ['as' => 'getCategoryProfile', 'uses' => 'ProfileController@getCategoryProfile'])

