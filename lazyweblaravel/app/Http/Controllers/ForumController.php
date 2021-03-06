<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ForumComment;
use App\Models\ForumPost;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class ForumController extends Controller
{
    const MAX_POSTS_PER_PAGE = 10;
    const DEFAULT_PAGE = 1;

    /**
     *
     * Searches posts from forum with search keyword and return
     *  1. posts of specified page of selected forum.
     *  2. Number of items in entire search result.
     *
     *  Page Size = 10 (Fixed)
     *
     * @Todo
     *  - Parametrize Page Size
     *
     * @param  string   $forum_name             // forum name
     * @param  int      $page                   // page index
     * @param  string   $keyword                // search keyword (search all posts if 'all' or empty string)
     * @return JSON     {$posts, $itemcount}    // post contents and number of posts in tis page
     *
     */
    public static function getPage(string $forum_name, int $page, string $keyword)
    {

        try {
            DB::beginTransaction();

            /* Get posts */
            if (($keyword === "all") || empty($keyword)) {
                $itemCount = ForumPost::where('forum', '=', $forum_name)
                    ->count();

                $posts = ForumPost::where('forum', '=', $forum_name)
                    ->orderByDesc('id')
                    ->forPage($page, self::MAX_POSTS_PER_PAGE)
                    ->get();
            } else {
                $itemCount = ForumPost::where('forum', '=', $forum_name)
                    ->where('title', 'like', '%' . $keyword . '%')
                    ->count();

                $posts = ForumPost::where('forum', '=', $forum_name)
                    ->where('title', 'like', '%' . $keyword . '%')
                    ->orderByDesc('id')
                    ->forPage($page, self::MAX_POSTS_PER_PAGE)
                    ->get();
            }

            /* Get post likes and user images */
            foreach ($posts as $post) {
                $likes = DB::table('post_likes')
                    ->where('post_id', '=', intval($post["id"]))
                    ->count();
                $imageUrl = DB::table('users')
                    ->where('username', '=', $post['author'])
                    ->get('image_url')->first()
                    ->image_url;
                $post['likes'] = $likes;
                $post['image_url'] = $imageUrl;
            }

            DB::commit();

            return json_encode([
                'itemCount' => $itemCount,
                'posts' => $posts,
            ]);
        } catch (QueryException | Exception $e) {
            DB::rollBack();
            return (string) $e;
        }
    }

    /**
     * Get 10 most viewed posts of all time.
     *
     * @param  Request $request
     * @return void
     */
    public static function getTopPosts(Request $request)
    {
        try {
            return DB::select("CALL GetTopPosts()");
        } catch (Exception $e) {
            return (string) $e;
        }
    }

    /**
     * Get 10 most viewed posts of most recent 7 days.
     *
     * @param  mixed $request
     * @return void
     */
    public static function getTrendingPosts(Request $request)
    {
        try {
            return DB::select("CALL GetTrendingPosts()");
        } catch (Exception $e) {
            return (string) $e;
        }
    }

    /* -------------------------------------------------------------------------- */
    /*                               CRUD Functions                               */
    /* -------------------------------------------------------------------------- */

    /**
     * Register a new post.
     *
     * @param  Request  $request
     * @param  string   $forum_name
     * @return void
     */
    public function createPost(Request $request, string $forum_name)
    {
        try {
            ForumPost::create([
                'title' => $request->input('title'),
                'forum' => $forum_name,
                'author' => Auth::user()['username'],
                'view_count' => strval(0),
                'contents' => $request->input('content'),
            ]);
        } catch (Exception $e) {
            return "Create Post Fail!";
        }
    }

    /**
     * Get and return specified post.
     *
     * @param  string   $forum_name     // Forum where the post belongs to
     * @param  string   $post_id        // Post's unique reference ID
     * @return JSON     {$post, $comments}  // Contents of the post and its comments
     */
    public function getPost(string $forum_name, string $post_id)
    {
        DB::beginTransaction();
        try {
            $post = ForumPost::where('id', '=', intval($post_id))
                ->where('forum', '=', $forum_name)
                ->get();
            $comments = ForumComment::where('post_id', '=', intval($post_id))
                ->get();

            $likes = DB::table('post_likes')
                ->where('post_id', '=', intval($post_id))
                ->count();
            $userImgUrl = DB::table('users')
                ->where('username', '=', $post[0]['author'])
                ->get('image_url')
                ->first()
                ->image_url;

            if (Auth::check()) {
                $myLike = (boolean) DB::table('post_likes')
                    ->where('post_id', '=', intval($post_id))
                    ->where('uid', '=', Auth::id())
                    ->count();
            } else {
                $myLike = false;
            }

            ForumPost::where('id', '=', intval($post_id))
                ->increment('view_count');
        } catch (Exception $e) {
            DB::rollback();
            return $e;
        }

        DB::commit();

        return json_encode(
            [
                'post' => $post,
                'comments' => $comments,
                'likes' => $likes,
                'myLike' => $myLike,
                'imageUrl' => $userImgUrl,
            ]
        );

    }

    /**
     * updatePost
     *
     * @param  Request  $request
     * @param  string   $post_id
     * @return JSON     {"result": (boolean) success(true)/fail(false)}
     */
    public function updatePost(Request $request, string $forum_name, string $post_id)
    {
        /* Null Check on title. Content is not null (some newline tags included by default). */
        if (empty($request->input('title'))) {
            return array(
                "result" => false,
                "message" => "Title is empty",
            );
        }

        try {
            $postAuthor = DB::table('posts')
                ->where('id', '=', intval($post_id))
                ->first();
            if ($postAuthor->author !== Auth::user()->username) {
                return json_encode(
                    array(
                        "result" => false,
                        "message" => "Only author can modify post",
                    )
                );
            }

            $result = DB::table('posts')
                ->where('id', '=', intval($post_id))
                ->update([
                    'title' => $request->input('title'),
                    'contents' => $request->input('content'),
                ]);
            return json_encode(array("result" => true));
        } catch (Exception $e) {
            return json_encode(
                array(
                    "result" => false,
                    "message" => $e,
                )
            );
        }
    }

    /**
     * deletePost
     *
     * @param  string $post_id
     * @return void
     */
    public function deletePost(string $forum_name, string $post_id)
    {

        $postAuthor = ForumPost::where('id', '=', intval($post_id))
            ->first();

        if ($postAuthor->author !== Auth::user()->username) {
            return json_encode(
                array(
                    "result" => false,
                    "message" => "Only author can delete post",
                )
            );
        }

        try {
            $post = ForumPost::where('id', '=', intval($post_id))
                ->delete();
            return json_encode(["result" => true]);
        } catch (Exception $e) {
            return json_encode($e);
        }
    }

    /**
     * postComment
     *
     * @todo   return codes/exception
     * @param  Request $request
     * @return void
     */
    public function postComment(Request $request)
    {
        try {
            $result = ForumComment::create([
                'author' => (string) Auth::user()['username'],
                'contents' => (string) $request->input('content'),
                'post_id' => (int) $request->input('post_id'),
            ]);
        } catch (Exception $e) {
        }
    }

    //@todo
    public function updateComment(Request $request, string $comment_id)
    {
        try {
            $result = ForumComment::where('id', '=', intval($comment_id))
                ->update([
                    'author' => (string) Auth::user()['username'],
                    'contents' => (string) $request->input('content'),
                    'post_id' => (int) $request->input('post_id'),
                ]);
        } catch (Exception $e) {
            return $e;
        }
    }

    //@todo
    public function deleteComment(Request $request, string $comment_id)
    {
        try {
            $result = ForumComment::where('id', '=', intval($comment_id))
                ->delete();
        } catch (Exception $e) {
            return $e;
        }
    }

    /* -------------------------------------------------------------------------- */
    /*                               /CRUD Functions                              */
    /* -------------------------------------------------------------------------- */

    public function togglePostLike(string $forum_name, string $post_id)
    {
        /* Need to login to like a post */
        if (!Auth::check()) {
            return json_encode(['result' => false]);
        }

        /* True if current user already liked the post */
        $duplicateLike = (boolean) count(DB::table('post_likes')
                ->where('post_id', '=', intval($post_id))
                ->where('uid', '=', Auth::id())
                ->get());

        if ($duplicateLike) {
            DB::table('post_likes')
                ->where('post_id', '=', intval($post_id))
                ->where('uid', '=', Auth::id())
                ->delete();
            $newCount = DB::table('post_likes')
                ->where('post_id', '=', intval($post_id))
                ->count();
            return json_encode(['result' => true, 'myLike' => false, 'likes' => $newCount]);
        } else {
            DB::table('post_likes')
                ->insert([
                    'post_id' => $post_id,
                    'uid' => Auth::id(),
                ]);
            $newCount = DB::table('post_likes')
                ->where('post_id', '=', intval($post_id))
                ->count();
            return json_encode(['result' => true, 'myLike' => true, 'likes' => $newCount]);
        }
    }
}
