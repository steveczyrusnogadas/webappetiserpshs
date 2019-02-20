<?php

namespace App\Http\Controllers;

use App\Passer;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PassersController extends Controller
{
    public function index() {
        $passers = Passer::paginate(50);
        return response()->json($passers, 200);
    }

    public function show($id) {
        $passer = Passer::find($id);

        if (is_null($passer)) {
            return response()->json(null, 404);
        }

        return response()->json(Passer::findOrFail($id), 200);
    }

    public function search(Request $request) {
        $q = $request->input('q');
        $passers = Passer::select()->whereRaw("MATCH(name_of_examinee,school,division) AGAINST('$q' IN NATURAL LANGUAGE MODE)")->paginate(50);

        if (is_null($passers['data']) || is_null($passers)) {
            $passers = Passer::where('name_of_examinee', 'LIKE', "%$q%")
            ->orWhere('school', 'LIKE', "%$q%")
            ->orWhere('division', 'LIKE', "%$q%")
            ->paginate(50);
        }

        return response()->json($passers, 200);
    }

    public function store(Request $request) {

        $rules = [
            'name_of_examinee' => 'required|max:100',
            'campus_eligibility' => 'required|max:100',
            'school' => 'required|max:100',
            'division' => 'required|max:100',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $passer = Passer::create($request->all());
        return response()->json($passer, 201);
    }

    public function update(Request $request, Passer $passer) {
        $passer->update($request->all());
        return response()->json($passer, 200);
    }

    public function delete(Request $request, Passer $passer) {
        $passer->delete();
        return response()->json(null, 204);
    }

    public function school() {
        $school = Passer::select(DB::raw('DISTINCT(school) as school'), DB::raw('COUNT(school) as passed'))->groupBy('school')->orderBy('passed', 'DESC')->get();
        return response()->json($school, 200);
    }
}
