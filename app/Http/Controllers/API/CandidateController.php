<?php
     
namespace App\Http\Controllers\API;
     
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Candidate;
use App\Models\User;
use Validator;
use App\Http\Resources\CandidateResource;
use Illuminate\Support\Facades\Auth;
     
class CandidateController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        if($user->role == "manager") {
            $candidates = Candidate::all();
        } elseif($user->role == "agent") {
            $candidates = Candidate::where('owner', "=", $user->id)->get();
        }   
        
        return $this->sendResponse(CandidateResource::collection($candidates), 'candidates retrieved successfully.');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $user = User::find(Auth::user()->id);
        
        if($user->role !== "manager") {
            return $this->sendError('cannot create candidates.');
        }
     
        $validator = Validator::make($input, [
            'name' => 'required',
            'source' => 'required',
            'owner'  => 'required',
        ]);
     
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        
        $input['created_by'] = $user->id;
        $candidate = Candidate::create($input);
     
        return $this->sendResponse(new CandidateResource($candidate), 'candidate created successfully.');
    } 
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $candidate = Candidate::find($id);
    
        if (is_null($candidate)) {
            return $this->sendError('candidate not found.');
        }
     
        return $this->sendResponse(new CandidateResource($candidate), 'candidate retrieved successfully.');
    }
    
}