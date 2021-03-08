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
     * Retrieve posts in the specified page and forum
     */
    public static function get_posts_in_page(string $forum, int $page)
    {
        return DB::table('forum_' . $forum)->orderByDesc('id')->forPage($page, self::MAX_POSTS_PER_PAGE)->get();
    }


    public function create_post(Request $request, string $forum_name)
    {
        $result =  DB::table('forum_' . $forum_name)->insert([
            'uid'           => Auth::id(),
            'title'         => $request->input('title'),
            'author'        => Auth::user()['username'],
            'view_count'    => strval(0),
            'contents'      => $request->input('content'),
            'post_root'     => $request->input('post_root'),
            'post_parent'   => $request->input('post_parent'),
        ]);

        return view('dashboard');
    }


    public function retrieve_post(string $forum_name, string $id)
    {
        $post = DB::table('forum_' . $forum_name)->where('id', '=', intval($id));
        /* Todo: Check if response is empty */

        /* Todo: Delete this test snippet */
        return json_encode($post);
    }


    public function delete_post(string $forum_name, string $id)
    {
        $post = DB::table('forum_' . $forum_name)->select('')->where('id', '=', intval($id));
        /* Todo: Check if response is empty */

        /* Todo: Delete this test snippet */
        return json_encode($post);
    }


    public function update_post(string $forum_name, string $id)
    {
        $post = DB::table('forum_' . $forum_name)->where('id', '=', intval($id));
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
