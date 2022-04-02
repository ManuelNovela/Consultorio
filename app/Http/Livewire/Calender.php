<?php

namespace App\Http\Livewire;

use App\Models\Event;
use Livewire\Component;
use Illuminate\Http\Request;


class Calender extends Component
{
    public $title;
    public function render(Request $request)
    {
        if($request->ajax()) {
            $events = event::whereDate('start_date', '>=', $request->start)->whereDate('end_date', '<=', $request->end)->get(['id', 'title', 'start_date', 'end_date']);
            return response()->json($events);
        }

        return view('livewire.calender');
    }

    /*
     * Gravar no banco de dados o novo evento.
     */
    public function event_create(){
        $event = event::create([
            'patient_id' => 1,
            'title' => $this.title,
            'start_date' => '2022-03-30 11:12:13',
            'end_date' => '2022-03-30 11:12:15',
        ]);
    }

    /*public function ajax(Request $request) {

        switch ($request->type) {
            case 'add':
                $event = event::create([
                    'patient_id' => $request->patient_id,
                    'title' => $this.title,
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
    }*/
}
