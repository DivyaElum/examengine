<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SiteSettingRequest;
use Illuminate\Support\Facades\Hash;

use App\User;
use Validator;
use Session;
use App\SiteSetting;

class SiteSettingController extends Controller
{
    private $SiteSetting;

    // use MultiModelTrait;

    public function __construct(

        SiteSetting $SiteSetting
    )
    {
        $this->SiteSetting  = $SiteSetting;

        $this->ViewData = [];
        $this->JsonData = [];

        $this->ModuleTitle = 'Site Setting';
        $this->ModuleView  = 'admin.siteSetting.';
    }
    public function index()
    {
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
        $this->ViewData['moduleTitle'] = $this->ModuleTitle;
        $this->ViewData['moduleAction'] = 'Add '. $this->ModuleTitle;

       return view($this->ModuleView.'create', $this->ViewData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(SiteSettingRequest $request)
    // {
    //     $SiteSetting = new $this->SiteSetting;

    //     $SiteSetting->user_id           = auth()->id();
    //     $SiteSetting->site_name         = $request->txtSitename;
    //     $SiteSetting->address           = $request->txtAddress;
    //     $SiteSetting->phone             = $request->txtPhone;
    //     $SiteSetting->email_id          = $request->txtEmail;
    //     $SiteSetting->admin_email_id    = $request->txtAdminEmail;
    //     $SiteSetting->api               = $request->txtApi ?? NULL;;
    //     $SiteSetting->meta_keyword      = $request->txtMetaKey ?? NULL;;
    //     $SiteSetting->meta_description  = $request->txtMetaDesc ?? NULL;;
        

    //     if ($SiteSetting->save()) 
    //     {
    //         $this->JsonData['status']   = 'success';
    //         $this->JsonData['url']      = '/admin/siteSetting/create';
    //         $this->JsonData['msg']      = 'Site setting saved successfully.';
    //     }
    //     else
    //     {
    //         $this->JsonData['status']   ='error';
    //         $this->JsonData['msg']      ='Failed to save Site setting, Something went wrong.';
    //     }  
    //     return response()->json($this->JsonData);
    // }

    public function store(Request $request)
    {
        $SiteSetting = new $this->SiteSetting;

        $SiteSetting->title   = $request->txtTitle;
        $SiteSetting->value   = $request->txtValue;
        $SiteSetting->status  = $request->txtStatus;
        
        if ($SiteSetting->save()) 
        {
            $this->JsonData['status']   = 'success';
            $this->JsonData['url']      = '/admin/siteSetting/create';
            $this->JsonData['msg']      = 'Site setting saved successfully.';
        }
        else
        {
            $this->JsonData['status']   ='error';
            $this->JsonData['msg']      ='Failed to save Site setting, Something went wrong.';
        }  
        return response()->json($this->JsonData);
    }
    
    /*-----------------------------------------------------
    |  Ajax Calls
    */
        public function getSettings(Request $request)
        {
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
                    1 => 'title',
                    2 => 'value',
                    4 => 'created_at',
                    5 => 'id'
                );

            /*--------------------------------------
            |  Model query and filter
            ------------------------------*/

                // start model query
                $modelQuery =  $this->SiteSetting;

                // get total count 
                $countQuery = clone($modelQuery);            
                $totalData  = $countQuery->count();

                // filter options
                if (!empty($search)) 
                {
                
                    $modelQuery = $modelQuery->where(function ($query) use($search)
                            {
                                $query->orwhere('id', 'LIKE', '%'.$search.'%');   
                                $query->orwhere('title', 'LIKE', '%'.$search.'%');   
                                $query->orwhere('value', 'LIKE', '%'.$search.'%');   
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
                        $data[$key]['id']           = ($key+$start+1).'.';
                        $data[$key]['title']        = '<span title="'.$row->title.'">'.str_limit($row->title, '55', '...').'</span>';
                        $data[$key]['value']        = $row->value;
                        $data[$key]['created_at']   = Date('d-m-Y', strtotime($row->created_at));
                        
                        $view   = '';
                        $edit   = '<a title="Edit" class="btn btn-default btn-circle" href="'.route('siteSetting.edit', [ base64_encode(base64_encode($row->id))]).'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;';

                        $data[$key]['actions'] = $view.$edit;
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
        $SiteSetting = new $this->SiteSetting;

        $intId = base64_decode(base64_decode($id));
        $this->ViewData['moduleTitle'] = $this->ModuleTitle;
        $this->ViewData['moduleAction'] = 'Edit '. $this->ModuleTitle;
        $this->ViewData['object'] = $this->SiteSetting->find($intId);

        return view($this->ModuleView.'edit', $this->ViewData);
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
        $SiteSetting = new $this->SiteSetting;

        $intId = base64_decode(base64_decode($id));
        $SiteSetting = $this->SiteSetting->find($intId);

        $SiteSetting->title   = $request->txtTitle;
        $SiteSetting->value   = $request->txtValue;
        $SiteSetting->status  = $request->txtStatus;
        
        if ($SiteSetting->save()) 
        {
            $this->JsonData['status']   = 'success';
            $this->JsonData['url']      = '/admin/siteSetting';
            $this->JsonData['msg']      = 'Site setting Updated successfully.';
        }
        else
        {
            $this->JsonData['status']   ='error';
            $this->JsonData['msg']      ='Failed to Updated Site setting, Something went wrong.';
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
        //
    }

}
