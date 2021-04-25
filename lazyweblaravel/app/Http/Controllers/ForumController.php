<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ForumController extends Controller
{

    const MAX_POSTS_PER_PAGE = 10;
    const DEFAULT_PAGE = 1;


    /**
     * Get a valid page in the specified forum.
     * A page can up to 10 posts in the forum to display.
     *
     * @param string $forum           // Forum name
     * @param int $page_requested     // Index of page to display (10 posts per page fixed)
     *
     * @return int $result            // Calculated page number
     */
    public static function get_page(int $page_requested, string $forum)
    {
        $forum = 'forum_' . trim($forum);
        $num_rows =  DB::table($forum)->count();
        $num_pages = (int)ceil($num_rows / 10);

        if (empty($page_requested))
            $result = self::DEFAULT_PAGE;
        else {
            if ($page_requested > $num_pages)
                $result = $num_pages;
            else if ($page_requested < 1)
                $result = self::DEFAULT_PAGE;
            else
                $result = $page_requested;
        }

        return $result;
    }


    /**
     * Todo
     * Retrieve posts in the specified page and forum
     */
    public static function get_posts_in_page(string $forum_name, int $page)
    {
        return DB::table('posts')
            ->where('forum', '=', $forum_name)
            ->orderByDesc('id')
            ->forPage($page, self::MAX_POSTS_PER_PAGE)
            ->get();
    }


    /**
     * Retrieve posts in the specified page and forum
     */
    public static function get_posts_by_search(string $forum_name, string $keyword)
    {
        try {
            return DB::table('posts')
                ->where('forum', '=', $forum_name)
                ->where('title', 'like', '%' . $keyword . '%')
                ->orderByDesc('id')
                ->forPage(1, self::MAX_POSTS_PER_PAGE)
                ->get();
        } catch (Exception $e) {
            return (string) $e;
        }
    }

    /**
     * Todo
     */
    public static function get_pagecount(string $forum_name)
    {
        return ceil((int)DB::table('posts')->where('forum', '=', $forum_name)->count() / 10);
    }



    public static function getTopPosts(Request $request)
    {
        try {
            return DB::select("CALL GetTopPosts()");
        } catch (Exception $e) {

        }
    }

    public static function getTrendingPosts(Request $request)
    {
        try {
            return DB::select("CALL GetTrendingPosts()");
        } catch (Exception $e) {

        }
    }


    /* -------------------------------------------------------------------------- */
    /*                               CRUD Functions                               */
    /* -------------------------------------------------------------------------- */

    public function createPost(Request $request, string $forum_name)
    {
        try {
            DB::table('posts')->insert([
                'title'         => $request->input('title'),
                'forum'         => $forum_name,
                'author'        => Auth::user()['username'],
                'view_count'    => strval(0),
                'contents'      => $request->input('content')
            ]);
        } catch (Exception $e) {
            return "Create Post Fail!";
        }
    }


    public function retrievePost(string $forum_name, string $post_id)
    {
        try {
            $post = DB::table('posts')
                ->where('id', '=', intval($post_id))
                ->where('forum', '=', $forum_name)
                ->get();
            $comments = DB::table('comments')
                ->where('post_id', '=', intval($post_id))
                ->get();
        } catch (Exception $e) {
            return $e;
        }

        DB::table('posts')
            ->where('id', '=', intval($post_id))
            ->increment('view_count');

        return json_encode(
            [
                'post'      => $post,
                'comments'  => $comments
            ]
        );
    }


    public function updatePost(Request $request, string $post_id)
    {
        try {
            $result = DB::table('posts')
                ->where('id', '=', intval($post_id))
                ->update([
                    'title'         => $request->input('title'),
                    'author'        => Auth::user()['username'],
                    'contents'      => $request->input('content')
                ]);
            return json_encode($result);
        } catch (Exception $e) {
            return json_encode($e);
        }
    }


    public function deletePost(string $post_id)
    {
        try {
            $post = DB::table('posts')->where('id', '=', intval($post_id))->delete();
            return json_encode($post);
        } catch (Exception $e) {
            return json_encode($e);
        }
    }


    public function postComment(Request $request)
    {
        try {
            $result =  DB::table('comments')->insert([
                'author'        => (string)Auth::user()['username'],
                'contents'      => (string)$request->input('content'),
                'post_id'       => (int)$request->input('post_id')
            ]);
        } catch (Exception $e) {
            //return $e;
        }

        //return view('dashboard');
    }


    public function retrieve_comment(Request $request)
    {
        // Void. retrive_post function also retrieves comments.
    }


    //@todo
    public function update_comment(Request $request, string $id)
    {
        try {
            $result =  DB::table('comments')
                        ->where('id', '=', intval($id))
                        ->update([
                            'author'        => (string)Auth::user()['username'],
                            'contents'      => (string)$request->input('content'),
                            'post_id'       => (int)$request->input('post_id')
                        ]);
        } catch (Exception $e) {
            //return $e;
        }
    }


    //@todo
    public function delete_comment(Request $request)
    {
        try {
            $result =  DB::table('comments')->insert([
                'author'        => (string)Auth::user()['username'],
                'contents'      => (string)$request->input('content'),
                'post_id'       => (int)$request->input('post_id')
            ]);
        } catch (Exception $e) {
            //return $e;
        }
    }

    /* -------------------------------------------------------------------------- */
    /*                               /CRUD Functions                              */
    /* -------------------------------------------------------------------------- */




    /**
     * requestSupport
     *
     * @param  mixed $request
     * @return void
     */
    public function requestSupport(Request $request)
    {
        try{
            $post = DB::table('support_request')->insert([
                'uid'       => Auth::id(),
                'type'      => $request->type,
                'status'    => 'PENDING',
                'contact'   => $request->contact,
                'contents'  => $request->contents
            ]);
            return json_encode($post);
        } catch (Exception $e) {
            return json_encode($e);
        }
    }
}
