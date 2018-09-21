<?php

namespace Pvtl\VoyagerBlog\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;

class Controller extends VoyagerBaseController
{
    protected function makeResponse($request, $template, $data = [], $resource = null)
    {
        if ($request->ajax()) {
            if ($resource) {
                return $resource;
            }
            return response()->json($data);
        }

        return view($template, $data);
    }
}
