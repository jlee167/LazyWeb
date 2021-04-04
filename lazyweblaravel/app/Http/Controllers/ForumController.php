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
        $num_pages = (int)ceil($num_rows/10);

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
                ->where('forum', '=', 'general')
                ->where('title', 'like', '%'.$keyword.'%')
                //->orWhere('contents', 'like', '%'.$keyword.'%')
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
        return ceil( (int)DB::table('posts')->where('forum', '=', $forum_name)->count() / 10);
    }


    public function create_post(Request $request, string $forum_name)
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


    public function post_comment(Request $request)
    {
        try {
            $result =  DB::table('comments')->insert([
                'author'        => (string)Auth::user()['username'],
                'contents'      => (string)$request->input('content'),
                'post_id'       => (int)$request->input('post_id')
            ]);
        }
        catch (Exception $e) {
            //return $e;
        }

        //return view('dashboard');
    }


    public function retrieve_post(string $forum_name, string $id)
    {
        try {
            $post = DB::table('posts')
                        ->where('id', '=', intval($id))
                        ->where('forum', '=', $forum_name)
                        ->get();
            $comments = DB::table('comments')
                        ->where('post_id', '=', intval($id))
                        ->get();
        }
        catch (Exception $e) {
            return $e;
        }
        /* Todo: Check if response is empty */


        /* Todo: Delete this test snippet */
        return json_encode(
            [
                'post'      => $post,
                'comments'  => $comments
            ]
        );
    }


    public function delete_post(string $id)
    {
        $post = DB::table('posts')->select('')->where('id', '=', intval($id));
        /* Todo: Check if response is empty */

        /* Todo: Delete this test snippet */
        return json_encode($post);
    }


    public function update_post(string $id)
    {
        $post = DB::table('posts')->where('id', '=', intval($id));
        /* Todo: Check if response is empty */

        /* Todo: Delete this test snippet */
        return json_encode($post);
    }


    public function request_support(Request $request)
    {
        $post = DB::table('support_request')->insert([
            'uid'       => Auth::id(),
            'type'      => $request->type,
            'status'    => 'PENDING',
            'contents'  => $request->contents
        ]);
        return json_encode($post);
    }

}
