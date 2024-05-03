<?php

namespace App\Http\Controllers;

use App\Calendar; 
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CalendarController extends Controller
{
    public function index()
    {
        $events = Calendar::all()->map(function ($booking) {
            $color = null;
            if ($booking->title == 'Test') {
                $color = '#924ACE';
            } elseif ($booking->title == 'Test 1') {
                $color = '#68B01A';
            }

            return [
                'id' => $booking->id,
                'title' => $booking->title,
                'start' => $booking->start_date,
                'end' => $booking->end_date,
                'color' => $color,
            ];
        });

        return view('calendar.index', ['events' => $events]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $booking = Calendar::create([
            'title' => $request->title,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        dd($booking);

        $color = null;
        if ($booking->title == 'Test') {
            $color = '#924ACE';
        }

        return response()->json([
            'id' => $booking->id,
            'start' => $booking->start_date,
            'end' => $booking->end_date,
            'title' => $booking->title,
            'color' => $color ?: '',
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $booking = Calendar::find($id);
        if (!$booking) {
            return response()->json([
                'error' => 'Unable to locate the event',
            ], 404);
        }

        $booking->update([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return response()->json('Event updated');
    }

    public function destroy($id)
    {
        $booking = Calendar::find($id);
        if (!$booking) {
            return response()->json([
                'error' => 'Unable to locate the event',
            ], 404);
        }

        $booking->delete();

        return response()->json(['id' => $id]);
    }
}
