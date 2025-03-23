<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Models
use App\Models\Voter;
use App\Models\Vote;

// Requests
use App\Http\Requests\VoteCreateRequest;

// Exceptions
use App\Exceptions\BadRequestException;

class VoteController extends Controller
{
    public function getAll() {
        $votes = Vote::with(['voter', 'candidate'])->get();
        return response()->json(['message' => 'Success', 'data' => $votes], 200);
    }

    public function getById($id) {
        $vote = Vote::with(['voter', 'candidate'])->find($id);

        if(!isset($vote)) throw new BadRequestException('Vote does not exist.');

        return response()->json(['message' => 'Success', 'data' => $vote], 200);
    }

    public function create(VoteCreateRequest $request) {
        $parameters = $request->safe()->all();
        $voter = Voter::notCandidate()->where('document', $parameters['document'])->first();

        if(!isset($voter)) throw new BadRequestException('Voter document is not valid.');
        if($voter->votes()->exists()) throw new BadRequestException('Voter has already voted.');

        $parameters['candidate_id'] = $voter->id; 
        $vote = Vote::create($parameters);
        return response()->json(['message' => 'Success', 'data' => $vote], 201);
    }
}