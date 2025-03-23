<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Models
use App\Models\Votes;

// Requests
use App\Http\Requests\VotesCreateRequest;
use App\Http\Requests\VotesUpdateRequest;

// Exceptions
use App\Exceptions\BadRequestException;

class VotesController extends Controller
{
    public function getAll() {
        $votes = Votes::get();
        return response()->json(['message' => 'Success', 'data' => $votes], 200);
    }

    public function getById($id) {
        $votes = Votes::find($id);

        if(!isset($votes)) throw new BadRequestException('Votes does not exist.');

        return response()->json(['message' => 'Success', 'data' => $votes], 200);
    }

    public function create(VotesCreateRequest $request) {
        $parameters = $request->safe()->all();
        $parameters['is_candidate'] = 0;
        $votes = Votes::create($parameters);
        return response()->json(['message' => 'Success', 'data' => $votes], 201);
    }

    public function update(VotesUpdateRequest $request) {
        $parameters = $request->safe()->all();
        $votes = Votes::find($parameters['id']);

        if(!isset($votes)) throw new BadRequestException('Votes does not exist.');

        $votes->fill($parameters)->save();
        return response()->json(['message' => 'Success', 'data' => $votes], 200);
    }

    public function delete($id) {
        $votes = Votes::find($id);

        if(!isset($votes)) throw new BadRequestException('Votes does not exist.');

        $votes->delete();
        return response()->json(['message' => 'Success'], 200);
    }
}