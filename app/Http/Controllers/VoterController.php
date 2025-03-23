<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Models
use App\Models\Voter;

// Requests
use App\Http\Requests\VoterCreateRequest;
use App\Http\Requests\VoterUpdateRequest;

// Exceptions
use App\Exceptions\BadRequestException;

class VoterController extends Controller
{
    public function getAll() {
        $voters = Voter::notCandidate()->get();
        return response()->json(['message' => 'Success', 'data' => $voters], 200);
    }

    public function getById($id) {
        $voter = Voter::notCandidate()->find($id);

        if(!isset($voter)) throw new BadRequestException('Voter does not exist.');

        return response()->json(['message' => 'Success', 'data' => $voter], 200);
    }

    public function create(VoterCreateRequest $request) {
        $parameters = $request->safe()->all();
        $parameters['is_candidate'] = 0;
        $voter = Voter::create($parameters);
        return response()->json(['message' => 'Success', 'data' => $voter], 201);
    }

    public function update(VoterUpdateRequest $request) {
        $parameters = $request->safe()->all();
        $voter = Voter::find($parameters['id']);

        if(!isset($voter)) throw new BadRequestException('Voter does not exist.');

        $voter->fill($parameters)->save();
        return response()->json(['message' => 'Success', 'data' => $voter], 200);
    }

    public function delete($id) {
        $voter = Voter::find($id);

        if(!isset($voter)) throw new BadRequestException('Voter does not exist.');

        $voter->delete();
        return response()->json(['message' => 'Success'], 200);
    }
}