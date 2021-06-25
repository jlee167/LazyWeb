<?php

namespace App\Http\Controllers;

use App\Models\SupportRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Redirector;
use APP\Models\User;

class SupportController extends BaseController
{
    /**
     * Register a support request into the main database.
     *
     * @param   Request     $request
     * @return  JSON
     */
    static public function requestSupport(Request $request)
    {
        try {
            SupportRequest::create([
                'uid'       => Auth::id(),
                'type'      => $request->type,
                'status'    => 'PENDING',
                'contact'   => $request->contact,
                'contents'  => $request->contents
            ]);
            return json_encode(['result' => true]);
        } catch (Exception $e) {
            return json_encode($e);
        }
    }
}
