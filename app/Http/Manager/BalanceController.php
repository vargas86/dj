<?php

namespace App\Http\Manager;

use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Http\Controllers\Traits\BreadRelationshipParser;

class BalanceController extends \TCG\Voyager\Http\Controllers\VoyagerBaseController
{

    use BreadRelationshipParser;

    public function index(Request $request)
    {

        $slug = 'balance';
        $view = 'voyager::bread.browse';

        if (view()->exists("voyager::$slug.browse")) {
            $view = "voyager::$slug.browse";
        }

        /**
         * Get subscriptions from Stripe
         */

        $dataType = null;
        $dataTypeContent = null;
        $isModelTranslatable = false;
        $search = null;
        $orderBy = null;
        $orderColumn = null;
        $sortOrder = null;
        $searchable = null;
        $isServerSide = false;
        $defaultSearchKey = null;
        $actions = [];
        $showCheckboxColumn = false;

        return Voyager::view($view, compact(
            'dataType',
            'dataTypeContent',
            'isModelTranslatable',
            'search',
            'orderBy',
            'orderColumn',
            'sortOrder',
            'searchable',
            'isServerSide',
            'defaultSearchKey',
            'actions',
            'showCheckboxColumn'
        ));
    }

}
