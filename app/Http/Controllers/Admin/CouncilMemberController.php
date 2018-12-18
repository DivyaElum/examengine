<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CouncilMemberRequest;

use App\Models\CouncilMemberModel;
use Validator;
use Storage;
use Image;

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
        $this->ModuleView  = 'admin.councilMember.';
        $this->ModulePath = 'council-member';
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
    public function store(CouncilMemberRequest $request)
    {
        $CouncilMemberModel = new $this->CouncilMemberModel;

        if($request->hasFile('txtImage')){
            $strImage = $request->txtImage;
        
            //$filename = Storage::put('avatars', $strImage);

            //Store thumbnail image
            $strImgName = time().$strImage->getClientOriginalName();
            $strThumbdesignationPath = public_path().'/upload/council-member/thumb_img' ;
            $thumb_img = Image::make($strImage->getRealPath())->resize(125, 125);
            $thumb_img->save($strThumbdesignationPath.'/'.$strImgName,80);

            //Store orignal image
            $strImgName = time().$strImage->getClientOriginalName();
            $strOriginalImgdesignationPath = public_path().'/upload/council-member' ;
            $strImage->move($strOriginalImgdesignationPath, $strImgName);

            $CouncilMemberModel->image = $strImgName;
        }

        $CouncilMemberModel->name         = $request->txtName;
        $CouncilMemberModel->email        = $request->txtEmail;
        $CouncilMemberModel->description  = $request->txtDescription;
        $CouncilMemberModel->designation  = $request->txtDesignation;
        $CouncilMemberModel->status       = $request->txtStatus;
        
        if ($CouncilMemberModel->save()) 
        {
            $this->JsonData['status']   = 'success';
            $this->JsonData['url']      = '/admin/council-member/';
            $this->JsonData['msg']      = 'Concil member saved successfully.';
        }
        else
        {
            $this->JsonData['status']   ='error';
            $this->JsonData['msg']      ='Failed to save Concil member, Something went wrong.';
        } 

        return response()->json($this->JsonData);
    }

    public function changeStatus(Request $request)
    {
        $this->JsonData['status']   = 'error';
        $this->JsonData['msg']      = 'Failed to change status, Something went wrong.';

        if ($request->has('id') && $request->has('status') ) 
        {
            $id = base64_decode(base64_decode($request->id));
            $status = $request->status;

            if($this->CouncilMemberModel->where('id', $id)->update(['status' => $status]))
            {
                $this->JsonData['status'] = 'success';
                $this->JsonData['msg']    = 'Status changed successfully.';
            } 
        }
        
        return response()->json($this->JsonData);
    }

    /*-----------------------------------------------------
    |  Ajax Calls
    */
        public function getMembers(Request $request)
        {
            // dd('pass');
            
            /*--------------------------------------
            |  Variables
            ------------------------------*/
                
                // skip and limit
                $start = $request->start;
                $length = $request->length;

                // serach value
                $search = $request->search['value']; 

                // order
                $column = $request->order[0]['column'];
                $dir = $request->order[0]['dir'];

                // filter columns
                $filter = array(
                    0 => 'id',
                    1 => 'Name',
                    2 => 'Email',
                    2 => 'designation',
                    2 => 'status',
                    4 => 'created_at',
                    5 => 'id'
                );

            /*--------------------------------------
            |  Model query and filter
            ------------------------------*/

                // start model query
                $modelQuery = $this->CouncilMemberModel;

                // get total count 
                $countQuery = clone($modelQuery);            
                $totalData  = $countQuery->count();

                // filter options
                if (!empty($search)) 
                {
                
                    $modelQuery = $modelQuery->where(function ($query) use($search)
                        {
                            $query->orwhere('id', 'LIKE', '%'.$search.'%');   
                            $query->orwhere('Name', 'LIKE', '%'.$search.'%');   
                            $query->orwhere('Email', 'LIKE', '%'.$search.'%');   
                            $query->orwhere('designation', 'LIKE', '%'.$search.'%');   
                            $query->orwhere('created_at', 'LIKE', '%'.Date('Y-m-d', strtotime($search)).'%');   
                        });
                }

                // get total filtered
                $filteredQuery = clone($modelQuery);            
                $totalFiltered  = $filteredQuery->count();
                
                // offset and limit
                $object = $modelQuery->orderBy($filter[$column], $dir)
                                     ->skip($start)
                                     ->take($length)
                                     ->get();            

            /*--------------------------------------
            |  data binding
            ------------------------------*/
                $data = [];
                if (!empty($object) && sizeof($object) > 0) 
                {
                    foreach ($object as $key => $row) 
                    {
                        $data[$key]['id']           = ($key+$start+1);
                        $data[$key]['Name']        = '<span title="'.$row->name.'">'.str_limit($row->name, '55', '...').'</span>';
                        $data[$key]['Email']        = $row->email;
                        $data[$key]['Designation']  = $row->designation;

                        if (!empty($row->status)) 
                        {
                            $data[$key]['status'] = '<a title="Active" onclick="return rwChanceStatus(this)" data-rwid="'.base64_encode(base64_encode($row->id)).'" data-rwst="0"  class="btn btn-default btn-circle stsActiveClass" href="javascript:void(0)" ><i class="fa fa-check" aria-hidden="true"></i></a>&nbsp';
                        }
                        else
                        {
                            $data[$key]['status'] = '<a title="Inactive" onclick="return rwChanceStatus(this)" data-rwid="'.base64_encode(base64_encode($row->id)).'" data-rwst="1"  class="btn btn-default btn-circle stsInactiveClass" href="javascript:void(0)"><i class="fa fa-times" aria-hidden="true"></i></a>&nbsp';
                        }

                        $data[$key]['created_at']   = Date('d-m-Y', strtotime($row->created_at));
                        
                        $view   = '';
                        $edit   = '<a title="Edit" class="btn btn-default btn-circle" href="'.route('council-member.edit', [ base64_encode(base64_encode($row->id))]).'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;';
                        $delete = '<a title="Delete" onclick="return deleteMember(this)" data-qsnid="'.base64_encode(base64_encode($row->id)).'" class="btn btn-default btn-circle" href="javascript:void(0)"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
                        $data[$key]['actions'] = $view.$edit.$delete;
                    }
                }

                // wrapping up
                $this->JsonData['draw']             = intval($request->draw);
                $this->JsonData['recordsTotal']     = intval($totalData);
                $this->JsonData['recordsFiltered']  = intval($totalFiltered);
                $this->JsonData['data']             = $data;

            return response()->json($this->JsonData);
        }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $CouncilMemberModel = new $this->CouncilMemberModel;

        $intId = base64_decode(base64_decode($id));
        $this->ViewData['moduleTitle']  = $this->ModuleTitle;
        $this->ViewData['moduleAction'] = 'Edit '. $this->ModuleTitle;
        $this->ViewData['modulePath']   = $this->ModulePath;
        $this->ViewData['object']       = $this->CouncilMemberModel->find($intId);

        return view($this->ModuleView.'edit', $this->ViewData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CouncilMemberRequest $request, $id)
    {
        $CouncilMemberModel = new $this->CouncilMemberModel;

        $intId              = base64_decode(base64_decode($id));
        $CouncilMemberModel = $this->CouncilMemberModel->find($intId);

        if($request->hasFile('txtImage')){
            $strImage = $request->txtImage;

            //Store thumbnail image
            $strImgName = time().$strImage->getClientOriginalName();
            $strThumbdesignationPath = public_path().'/upload/council-member/thumb_img' ;
            $thumb_img = Image::make($strImage->getRealPath())->resize(125, 125);
            $thumb_img->save($strThumbdesignationPath.'/'.$strImgName,80);

            //Store orignal image
            $strOriginalImgdesignationPath = public_path().'/upload/council-member' ;
            $strImage->move($strOriginalImgdesignationPath, $strImgName);

            $CouncilMemberModel->image = $strImgName;
        }

        $CouncilMemberModel->name         = $request->txtName;
        $CouncilMemberModel->email        = $request->txtEmail;
        $CouncilMemberModel->description  = $request->txtDescription;
        $CouncilMemberModel->designation  = $request->txtDesignation;
        $CouncilMemberModel->status       = $request->txtStatus;
        
        if ($CouncilMemberModel->save()) 
        {
            $this->JsonData['status']   = 'success';
            $this->JsonData['url']      = '/admin/council-member/';
            $this->JsonData['msg']      = 'Concil member saved successfully.';
        }
        else
        {
            $this->JsonData['status']   ='error';
            $this->JsonData['msg']      ='Failed to save Concil member, Something went wrong.';
        } 
        return response()->json($this->JsonData);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $intId = base64_decode(base64_decode($id));

        if($this->CouncilMemberModel->where('id', $intId)->delete())
        {
            $this->JsonData['status'] = 'success';
            $this->JsonData['msg'] = 'Council member deleted successfully.';
        }
        else
        {
            $this->JsonData['status'] = 'error';
            $this->JsonData['msg'] = 'Failed to delete Council member, Something went wrong.';
        }
        
        return response()->json($this->JsonData);
    }
}
