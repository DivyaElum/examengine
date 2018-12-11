<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\CouncilMemberModel;

use Validator;
use Session;

class CouncilMemberController extends Controller
{
    private $concilMember;

    // use MultiModelTrait;

    public function __construct(

        CouncilMemberModel $CouncilMemberModel
    )
    {
        $this->CouncilMemberModel  = $CouncilMemberModel;

        $this->ViewData = [];
        $this->JsonData = [];

        $this->ModuleTitle = 'Council Member';
        $this->ModuleView  = 'admin.council-member.';
        $this->ModulePath = 'concil-member';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $this->ViewData['modulePath'] = $this->ModulePath;
        $this->ViewData['moduleTitle'] = $this->ModuleTitle;
        $this->ViewData['moduleAction'] = 'Manage '.str_plural($this->ModuleTitle);

        return view($this->ModuleView.'index', $this->ViewData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->ViewData['modulePath'] = $this->ModulePath;
        $this->ViewData['moduleTitle'] = $this->ModuleTitle;
        $this->ViewData['moduleAction'] = 'Manage '.str_plural($this->ModuleTitle);

        return view($this->ModuleView.'create', $this->ViewData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
         'txtName'        => 'required|email',
         'txtEmail'       => 'required|email',
         'txtDescription' => 'required|email',
         'txtDesignation' => 'required|min:3|max:20',
        ])->validate();
        
        $post = Post::find($id);

        if($request->hasFile('featured')){
            $strImage = $request->txtImage;
        
            $filename = Storage::put('avatars', $strImage);

            $featured_newName = time().$strImage->getClientOriginalName();
            $destinationPath = public_path().'/upload/council-member' ;
            $strImage->move($destinationPath, $featured_newName);

            $post->strImage = $featured_newName;
        }
        return response()->json($this->JsonData);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
