<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\instagramAccount;
use App\bookmark;
use App\themes;
use Auth;
use Response;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$account = instagramAccount::where('user_id', '=', Auth::user()->id)->first();
		if(is_null($account)) {
			return view(Auth::user()->themes.'.add');
		} else {		
			$username = $account->username;
			$password = $account->password;
			$debug = false;
			$i = new \InstagramAPI\Instagram($debug);
			$i->setUser($username, $password);
			/*try {
				$i->login();
			} catch (Exception $e) {
				echo 'something went wrong '.$e->getMessage()."\n";
			}*/
			try {
				$usernameinfo = $i->getSelfUsernameInfo();
				$timeline = $i->timelineFeed()->getFeedItems();
				$bookmark = bookmark::where('user_id', '=', Auth::user()->id)->get();
				return view(Auth::user()->themes.'.home', ['bookmark' => $bookmark, 'username' => $username, 'usernameinfo'=>$usernameinfo]);	
			} catch (\InstagramAPI\InstagramExceptionException $e) {
				echo $e->getMessage();
			}
		}
    }
	
	public function addBookmark(Request $request)
	{
		$bookmark = new bookmark;
		if($request->type == 1) {
			$bookmark->username = $request->username;
			$bookmark->user_id = Auth::user()->id;
			$bookmark->save();
			return 'OK';
		} else {
			$bookmark = bookmark::where('user_id', '=', Auth::user()->id)->where('username', '=', $request->username)->first();
			$bookmark->delete();
			return 'Bookmark dihapus';
		}
	}
	public function add(Request $request)
	{
		$name = $request->input('uname');
		$pass = $request->input('pass');
		$i = new \InstagramAPI\Instagram($name, $pass);
		try {
			$i->setUser($name, $pass);
			$i->login(true);
			$account = new instagramAccount;
			$account->username = $request->uname;
			$account->password = $request->pass;
			$account->user_id = Auth::user()->id;
			$account->save();
			echo 'Login Sukses<br />';
			echo '<a href="'.URL('home').'">Home</a><br />';
		} catch (\InstagramAPI\InstagramException $e) {
			echo 'something went wrong '.$e->getMessage()."\n";
			exit(0);
		}
	}
	
	public function search(Request $request)
	{
		$account = instagramAccount::where('user_id', '=', Auth::user()->id)->first();
		$username = $account->username;
		$password = $account->password;
		$debug = false;
		$i = new \InstagramAPI\Instagram($debug);
		$i->setUser($username, $password);
		try {
		$profil = $i->getProfileData();
		$usernameinfo = $i->getSelfUsernameInfo();
		$name = $request->input('uname');
		$users = $i->searchUsers($name)->getUsers();
		if(Auth::user()->themes == "modern") {
			return view(Auth::user()->themes.'.searchresultsajax', ['type'=>'user', 'users'=>$users, 'profil' => $profil, 'usernameinfo'=>$usernameinfo]);
		} else {
			return view(Auth::user()->themes.'.searchresults', ['type'=>'user', 'users'=>$users, 'profil' => $profil, 'usernameinfo'=>$usernameinfo]);
		}
		} catch (\InstagramAPI\InstagramException $e) {
			echo 'something went wrong '.$e->getMessage()."\n";
			exit(0);
		}
	}
	
	public function searchTags(Request $request)
	{
		$account = instagramAccount::where('user_id', '=', Auth::user()->id)->first();
		$username = $account->username;
		$password = $account->password;
		$debug = false;
		$i = new \InstagramAPI\Instagram($debug);
		$i->setUser($username, $password);
		$profil = $i->getProfileData();
		$usernameinfo = $i->getSelfUsernameInfo();
		$resultTags = $i->searchTags($request->input('hashtags'));
		if(Auth::user()->themes == "modern") {
			return view(Auth::user()->themes.'.searchresultsajax', ['type'=>'hashtag', 'results'=>$resultTags->getResults()]);
		} else {
			return view(Auth::user()->themes.'.searchresults', ['type'=>'hashtag', 'results'=>$resultTags->getResults(), 'profil' => $profil, 'usernameinfo'=>$usernameinfo]);
		}
	}
	
	public function liked()
	{
		$account = instagramAccount::where('user_id', '=', Auth::user()->id)->first();
		$username = $account->username;
		$password = $account->password;
		$debug = false;
		$i = new \InstagramAPI\Instagram($debug);
		$i->setUser($username, $password);
		try {
		$profil = $i->getProfileData();
		$usernameinfo = $i->getSelfUsernameInfo();
		$medias = $i->getLikedMedia();
		return view(Auth::user()->themes.'.liked', ['medias'=>$medias, 'profil' => $profil, 'usernameinfo'=>$usernameinfo]);
		} catch (\InstagramAPI\InstagramException $e) {
				echo 'something went wrong '.$e->getMessage()."\n";
				exit(0);
		}
	}
	
	public function userfeed($user, $maxid=null)
	{
		$account = instagramAccount::where('user_id', '=', Auth::user()->id)->first();
		$username = $account->username;
		$password = $account->password;
		$debug = false;
		$i = new \InstagramAPI\Instagram($debug);
		$i->setUser($username, $password);
		try {
			$usernameId = $i->searchUsername($user)->getUser()->getPk();
			$isprivate = $i->searchUsername($user)->getUser()->getIsPrivate();
			$friendship = $i->userFriendship($usernameId)->getFollowing();
			$profil = $i->getProfileData();
			$usernameinfo = $i->getSelfUsernameInfo();
			if($friendship == true | $isprivate == false) {
				$feeds = $i->getUserFeed($usernameId, $maxid, null);
			} else {
				$feeds = '';
			}
			//return $feeds->getItems();
			$bookmark = bookmark::where('user_id', '=', Auth::user()->id)->where('username', '=', $user)->first();
			if(is_null($maxid)) {
				return view(Auth::user()->themes.'.feeds', ['feeds' => $feeds, 'user'=>$user, 'userid'=>$usernameId, 'profil' => $profil, 'usernameinfo'=>$usernameinfo, 'private' =>$isprivate, 'friend'=>$friendship, 'ada' => $bookmark, 'maxid'=>$maxid, 'i'=>$i]);
			} else {
				return view(Auth::user()->themes.'.feedsnext', ['feeds' => $feeds, 'maxid' => $feeds->getNextMaxId(), 'i'=>$i]);
			}
		} catch (\InstagramAPI\InstagramException $e) {
			if($e == "login_required") {
				try {
					$i->login(true);
					echo 'Anda telah login ulang. Klik <a href="'.URL('home').'">di sini</a> untuk kembali ke beranda.';
				} catch (\InstagramAPI\InstagramException $e) {
					echo 'something went wrong '.$e->getMessage()."\n";
					exit(0);
				}
			} else {
				echo 'something went wrong '.$e->getMessage()."\n";
				exit(0);
			}
		}
	}
	
	public function follow(Request $request)
	{
		$account = instagramAccount::where('user_id', '=', Auth::user()->id)->first();
		$username = $account->username;
		$password = $account->password;
		$debug = false;
		$i = new \InstagramAPI\Instagram($debug);
		$i->setUser($username, $password);
		if($request->type == 1) {
			$userid = $request->userid;
			$i->follow($userid);
		} else {
			$userid = $request->userid;
			$i->unfollow($userid);
		}
	}
	
	public function viewComment($mediaid)
	{
		$account = instagramAccount::where('user_id', '=', Auth::user()->id)->first();
		$username = $account->username;
		$password = $account->password;
		$debug = false;
		$i = new \InstagramAPI\Instagram($debug);
		$i->setUser($username, $password);
		$comments = $i->getMediaComments($mediaid)->getComments();
		return view(Auth::user()->themes.'.comment', ['comments' => $comments, 'mediaid' => $mediaid]);
	}
	
	public function postComment(Request $request)
	{
		$account = instagramAccount::where('user_id', '=', Auth::user()->id)->first();
		$username = $account->username;
		$password = $account->password;
		$debug = true;
		$i = new \InstagramAPI\Instagram($debug);
		$i->setUser($username, $password);
		$mediaid = $request->mediaid;
		$text = $request->text;
		$i->comment($mediaid, $text);
	}
	
	public function likemedia(Request $request)
	{
		$account = instagramAccount::where('user_id', '=', Auth::user()->id)->first();
		$username = $account->username;
		$password = $account->password;
		$debug = false;
		$i = new \InstagramAPI\Instagram($debug);
		$i->setUser($username, $password);
		try {
			if($request->input('id'))
			{
				if($request->input('type') == 1){
					$i->like($request->input('id'));
				} else {
					$i->unlike($request->input('id'));
				}
				foreach($i->mediaInfo($request->input('id'))->getItems() as $count) {
					$mediacount = $count->getLikeCount();
					echo $mediacount;
				}
			}
		} catch (\InstagramAPI\InstagramException $e) {
				echo 'something went wrong '.$e->getMessage()."\n";
				exit(0);
		}
	}
	
	public function mediainfo() 
	{
		$account = instagramAccount::where('user_id', '=', Auth::user()->id)->first();
		$username = $account->username;
		$password = $account->password;
		$debug = false;
		$i = new \InstagramAPI\Instagram($debug);
		$i->setUser($username, $password);
		foreach($i->mediaInfo('1377601497130370493_33801695')->getItems() as $count) {
			echo $count->getLikeCount();
			echo '<br />';
			echo $count->getHasLiked();
		}
	}
	
	public function setting(Request $request=null)
	{
		$account = instagramAccount::where('user_id', '=', Auth::user()->id)->first();
		$username = $account->username;
		$password = $account->password;
		$debug = false;
		$i = new \InstagramAPI\Instagram($debug);
		$i->setUser($username, $password);
		$profil = $i->getProfileData();
		$usernameinfo = $i->getSelfUsernameInfo();
		$themes = themes::all();
		if(is_null($request->themes))
		{
			$pesan = '';
			return view(Auth::user()->themes.'.setting', ['akun' => $account, 'pesan' => $pesan, 'profil' => $profil, 'usernameinfo'=>$usernameinfo, 'themes' => $themes]);
		} else {
			$pesan = 'Setting berhasil disimpan';
			$themes_id = $request->themes;
			$images = $request->images;
			$theme = themes::where('id','=', $themes_id = $request->themes)->first();
			User::where('id', Auth::user()->id)
			  ->update(['themes' => $theme->path, 'theme_id' => $themes_id, 'images' => $images]);
			return view(Auth::user()->themes.'.setting', ['akun' => $account, 'pesan' => $pesan, 'profil' => $profil, 'usernameinfo'=>$usernameinfo, 'themes' => $themes]);
		}
		
	}
	
	public function settingSaved(Request $request)
	{
		$pesan = 'Setting berhasil disimpan';
		$themes_id = $request->themes;
		$images = $request->images;
		$theme = themes::where('id','=', $themes_id)->first();
		User::where('id', Auth::user()->id)
		  ->update(['themes' => $theme->path, 'theme_id' => $themes_id, 'images' => $images]);
		return response()->json($pesan);
	}
	
    public function delAccount()
    {
		$account = instagramAccount::where('user_id', '=', Auth::user()->id)->first();
		$username = $account->username;
		$password = $account->password;
		$debug = false;
		$i = new \InstagramAPI\Instagram($debug);
		$i->setUser($username, $password);
		$i->logout();
        instagramAccount::where('user_id', '=', Auth::user()->id)->delete();
        echo "Deleted";
    }
	
	public function inbox()
	{
		$account = instagramAccount::where('user_id', '=', Auth::user()->id)->first();
		$username = $account->username;
		$password = $account->password;
		$debug = false;
		$i = new \InstagramAPI\Instagram($debug);
		$i->setUser($username, $password);
		$inbox = $i->getv2Inbox();
		$inbox = $inbox->getInbox()->getThreads();
		//return $inbox;
		return view(Auth::user()->themes.'.inbox', ['inboxs' => $inbox]);
	}
	public function thread($threadId)
	{
		$account = instagramAccount::where('user_id', '=', Auth::user()->id)->first();
		$username = $account->username;
		$password = $account->password;
		$debug = false;
		$i = new \InstagramAPI\Instagram($debug);
		$i->setUser($username, $password);
		$threads = $i->directThread($threadId);
		//return $threads;
		return view(Auth::user()->themes.'.thread', ['threads' => $threads, 'i' => $i]);
		
	}
	
	public function pendingInbox()
	{
		$account = instagramAccount::where('user_id', '=', Auth::user()->id)->first();
		$username = $account->username;
		$password = $account->password;
		$debug = false;
		$i = new \InstagramAPI\Instagram($debug);
		$i->setUser($username, $password);
		$inbox = $i->getPendingInbox();
		$pending = $inbox->getInbox()->threads;
		return view(Auth::user()->themes.'.inbox', ['inboxs' => $pending]);
	}
	
	public function threadAction($threadAction, $threadId)
	{
		$account = instagramAccount::where('user_id', '=', Auth::user()->id)->first();
		$username = $account->username;
		$password = $account->password;
		$debug = false;
		$i = new \InstagramAPI\Instagram($debug);
		$i->setUser($username, $password);
		$i->directThreadAction($threadId, $threadAction);
		$threads = $i->directThread($threadId);
		return view(Auth::user()->themes.'.thread', ['threads' => $threads, 'i' => $i]);
	}
	
	public function directMessage(Request $request)
	{
		$userid = $request->userid;
		$text = $request->text;
		$threadid = $request->input('threadid');
		$account = instagramAccount::where('user_id', '=', Auth::user()->id)->first();
		$username = $account->username;
		$password = $account->password;
		$debug = false;
		$i = new \InstagramAPI\Instagram($debug);
		$i->setUser($username, $password);
		$i->direct_message($userid, $text);
		$threads = $i->directThread($threadid);
		return view(Auth::user()->themes.'.thread', ['threads' => $threads, 'i' => $i]);
	}
	
	
	public function noti()
	{
		$account = instagramAccount::where('user_id', '=', Auth::user()->id)->first();
		$username = $account->username;
		$password = $account->password;
		$debug = false;
		$i = new \InstagramAPI\Instagram($debug);
		$i->setUser($username, $password);
		$newnotis = $i->getRecentActivity()->getNewStories();
		$notis = $i->getRecentActivity()->getOldStories();
		return view(Auth::user()->themes.'.noti', ['notis' => $notis, 'newnotis' => $newnotis]);
	}

	public function relogin()
	{
		$account = instagramAccount::where('user_id', '=', Auth::user()->id)->first();
		$username = $account->username;
		$password = $account->password;
		$debug = false;
		$i = new \InstagramAPI\Instagram($debug);
		$i->setUser($username, $password);
		try {
			$i->login(true);
			echo 'Relogin Sukses<br />';
			echo '<a href="'.URL('home').'">Home</a><br />';
		} catch (\InstagramAPI\InstagramException $e) {
			echo 'something went wrong '.$e->getMessage()."\n";
			exit(0);
		}
	}
	
	public function backup()
	{
		$account = instagramAccount::where('user_id', '=', Auth::user()->id)->first();
		$username = $account->username;
		$password = $account->password;
		$debug = false;
		$i = new \InstagramAPI\Instagram($debug);
		$i->setUser($username, $password);
		try {
			$i->backup();
		} catch (\InstagramAPI\InstagramException $e) {
			echo 'something went wrong '.$e->getMessage()."\n";
			exit(0);
		}
	}
}
