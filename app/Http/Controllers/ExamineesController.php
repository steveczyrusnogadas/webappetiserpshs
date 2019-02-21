<?php

namespace App\Http\Controllers;

use App\Examinee;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ExamineesController extends Controller
{
    public function index() {
        $examinees = Examinee::paginate(50);
        return response()->json($examinees, 200);
    }

    public function show($id) {
        $examinee = Examinee::find($id);

        if (is_null($examinee)) {
            return response()->json(null, 404);
        }

        return response()->json(Examinee::findOrFail($id), 200);
    }

    public function search(Request $request) {
        $q = $request->input('q');
        $examinees = Examinee::select()->whereRaw("MATCH(name_of_examinee,school,division) AGAINST('$q' IN NATURAL LANGUAGE MODE)")->paginate(50);

        if (is_null($examinees['data']) || is_null($examinees)) {
            $examinees = Examinee::where('name_of_examinee', 'LIKE', "%$q%")
                ->orWhere('school', 'LIKE', "%$q%")
                ->orWhere('division', 'LIKE', "%$q%")
                ->paginate(50);
        }

        return response()->json($examinees, 200);
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

        $examinee = Examinee::create($request->all());
        return response()->json($examinee, 201);
    }

    public function update(Request $request, Examinee $examinee) {
        $examinee->update($request->all());
        return response()->json($examinee, 200);
    }

    public function delete(Request $request, Examinee $examinee) {
        $examinee->delete();
        return response()->json(null, 204);
    }

    public function school() {
        $school = Examinee::select(DB::raw('DISTINCT(school) as school'), DB::raw('COUNT(school) as passed'))->groupBy('school')->orderBy('passed', 'DESC')->orderBy('school', 'ASC')->paginate(50);
        return response()->json($school, 200);
    }
}
