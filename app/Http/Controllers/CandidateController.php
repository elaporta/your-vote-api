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

class CandidateController extends Controller
{
    public function getAll() {
        $candidates = Voter::candidate()->get();
        return response()->json(['message' => 'Success', 'data' => $candidates], 200);
    }

    public function getById($id) {
        $candidate = Voter::candidate()->find($id);

        if(!isset($candidate)) throw new BadRequestException('Candidate does not exist.');

        return response()->json(['message' => 'Success', 'data' => $candidate], 200);
    }

    public function create(VoterCreateRequest $request) {
        $parameters = $request->safe()->all();
        $parameters['is_candidate'] = 1;
        $candidate = Voter::create($parameters);
        return response()->json(['message' => 'Success', 'data' => $candidate], 201);
    }

    public function update(VoterUpdateRequest $request) {
        $parameters = $request->safe()->all();
        $candidate = Voter::find($parameters['id']);

        if(!isset($candidate)) throw new BadRequestException('Candidate does not exist.');

        $candidate->fill($parameters)->save();
        return response()->json(['message' => 'Success', 'data' => $candidate], 200);
    }

    public function delete($id) {
        $candidate = Voter::find($id);

        if(!isset($candidate)) throw new BadRequestException('Candidate does not exist.');

        $candidate->delete();
        return response()->json(['message' => 'Success'], 200);
    }

    public function getByVotes() {
        $candidates = Voter::candidate()->withCount('receivedVotes')->orderByDesc('received_votes_count')->get();
        return response()->json(['message' => 'Success', 'data' => $candidates], 200);
    }
}