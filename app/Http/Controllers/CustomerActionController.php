<?php

namespace App\Http\Controllers;

use App\CustomerAction;
use App\Http\Requests\ActionRequest;


class CustomerActionController extends Controller
{
    public function actionName(ActionRequest $request) {

        $action = new CustomerAction();
        $action->action_name = $request->action_name;
        $action->customer_id = $request->customer_id;
        $action->record = $request->record;
        $action->save();

        return response()->json(['success'=>'Your action Created successfully.']);
    }
}
