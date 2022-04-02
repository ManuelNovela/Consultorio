<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Event;

class CalenderController extends Controller
{
    public function index(Request $request) {

        if($request->ajax()) {
            $events = event::whereDate('start_date', '>=', $request->start)->whereDate('end_date', '<=', $request->end)->get(['id', 'title', 'start_date', 'end_date']);
            return response()->json($events);
        }
        return view('calender');
    }
    public function ajax(Request $request) {

        switch ($request->type) {
            case 'add':
                $event = event::create([
                    'patient_id' => $request->patient_id,
                    'title' => $request->title,
                    'start_date' => $request->start,
                    'end_date' => $request->end,
                ]);
                return response()->json($event);
                break;
            case 'update':
                $event = event::find($request->id)->update([
                    'patient_id' => $request->patient_id,
                    'title' => $request->title,
                    'start_date' => $request->start,
                    'end_date' => $request->end,
                ]);
                return response()->json($event);
                break;
            case 'delete':
                $event = event::find($request->id)->delete();
                return response()->json($event);
                break;
            default:
                break;
        }
    }
}
