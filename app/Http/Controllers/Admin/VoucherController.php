<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VoucherRequest;

use Session;
use DB;
use App\Models\voucherModel;

class VoucherController extends Controller
{
    private $voucherModel;

    public function __construct(

        voucherModel $voucherModel
    )
    {
        $this->voucherModel  = $voucherModel;

        $this->ViewData = [];
        $this->JsonData = [];

        $this->ModuleTitle = 'Voucher';
        $this->ModuleView  = 'admin.voucher.';
        $this->ModulePath  = 'voucher';
    }
    public function index()
    {
        $this->ViewData['moduleTitle']  = $this->ModuleTitle;
        $this->ViewData['moduleAction'] = 'Manage '.str_plural($this->ModuleTitle);
        $this->ViewData['modulePath']   = $this->ModulePath;

        return view($this->ModuleView.'index', $this->ViewData);
    }

    public function create()
    {
        $this->ViewData['moduleTitle']  = $this->ModuleTitle;
        $this->ViewData['moduleAction'] = 'Add '. $this->ModuleTitle;
        $this->ViewData['modulePath']   = $this->ModulePath;

       return view($this->ModuleView.'create', $this->ViewData);
    }

    public function store(VoucherRequest $request)
    {
        $voucherModel = new $this->voucherModel;

        DB::beginTransaction();

        //date differnce
        $date1 = date_create($request->start_date);
        $date2 = date_create($request->end_date);
        $diff  = date_diff($date1,$date2);

        $dateStart = date_create($request->start_date);
        $dateEnd = date_create($request->end_date);
        

        $voucherModel->voucher_code   = $request->voucher_code;
        $voucherModel->user_count     = $request->user_count;
        $voucherModel->user_type      = $request->user_type;
        $voucherModel->discount       = $request->discount;
        $voucherModel->discount_by    = $request->discount_by;
        $voucherModel->start_date     = date_format($dateStart, 'Y-m-d H:i:s');
        $voucherModel->end_date       = date_format($dateEnd, 'Y-m-d H:i:s');
        $voucherModel->days_diff      = $diff->d;
        $voucherModel->status         = '1';

        if ($voucherModel->save()) 
        {
            DB::commit();
            $this->JsonData['status']   = 'success';
            $this->JsonData['url']      = 'create';
            $this->JsonData['msg']      = __('messages.ERR_INTERNAL_SERVER_ERRO_MSG');
        }
        else
        {
            DB::rollBack();
        }
        return response()->json($this->JsonData);
    }

    public function edit($id)
    {
        $voucherModel = new $this->voucherModel;

        $intId = base64_decode(base64_decode($id));
        $this->ViewData['moduleTitle'] = $this->ModuleTitle;
        $this->ViewData['moduleAction'] = 'Edit '. $this->ModuleTitle;
        $this->ViewData['modulePath'] = $this->ModulePath;
        $this->ViewData['objectData'] = $this->voucherModel->find($intId);

        return view($this->ModuleView.'edit', $this->ViewData);
    }

    public function update(VoucherRequest $request, $id)
    {
        $voucherModel = new $this->voucherModel;

        $intId = base64_decode(base64_decode($id));
        
        $voucherModel = $this->voucherModel->find($intId);
        
        DB::beginTransaction();

        //date differnce
        $date1 = date_create($request->start_date);
        $date2 = date_create($request->end_date);
        $diff  = date_diff($date1,$date2);

        $dateStart  = date_create($request->start_date);
        $dateEnd    = date_create($request->end_date);
        

        $voucherModel->voucher_code   = $request->voucher_code;
        $voucherModel->user_count     = $request->user_count;
        $voucherModel->user_type      = $request->user_type;
        $voucherModel->discount       = $request->discount;
        $voucherModel->discount_by    = $request->discount_by;
        $voucherModel->start_date     = date_format($dateStart, 'Y-m-d H:i:s');
        $voucherModel->end_date       = date_format($dateEnd, 'Y-m-d H:i:s');
        $voucherModel->days_diff      = $diff->d;
        $voucherModel->status         = '1';

        if ($voucherModel->save()) 
        {
            DB::commit();
            $this->JsonData['status']   = 'success';
            $this->JsonData['url']      = '';
            $this->JsonData['msg']      = __('messages.ERR_VOUCHER_UPDATE_SUCCESS_MSG');
        }
        else
        {
            DB::rollBack();
        }
        return response()->json($this->JsonData);
    }

    public function destroy($enc_id)
    {
        $voucherModel = new $this->voucherModel;

        $intId = base64_decode(base64_decode($enc_id));

        if($this->voucherModel->where('id', $intId)->delete())
        {
            $this->JsonData['status']   = 'success';
            $this->JsonData['msg']      = __('messages.ERR_VOUCHER_DELETE_SUCCESS_MSG');
        }
        else
        {
            $this->JsonData['status']   = 'error';
            $this->JsonData['msg']      = __('messages.ERR_VOUCHER_DELETE_ERROR_MSG');
        }
        
        return response()->json($this->JsonData);
    }

    /*-----------------------------------------------------
    |  Ajax Calls
    */
    public function getVoucher(Request $request)
    {
        /*--------------------------------------
        |  Variables
        ------------------------------*/
            
            // skip and limit
            $start  = $request->start;
            $length = $request->length;

            // serach value
            $search = $request->search['value']; 

            // order
            $column = $request->order[0]['column'];
            $dir = $request->order[0]['dir'];

            // filter columns
            $filter = array(
                0 => 'id',
                1 => 'voucher_code',
                2 => 'user_count',
                2 => 'discount',
                2 => 'discount_by',
                3 => 'created_at',
                4 => 'id'
            );

        /*--------------------------------------
        |  Model query and filter
        ------------------------------*/

            // start model query
            $modelQuery =  $this->voucherModel;

            // get total count 
            $countQuery = clone($modelQuery);            
            $totalData  = $countQuery->count();

            // filter options
            if (!empty($search)) 
            {
            
                $modelQuery = $modelQuery->where(function ($query) use($search)
                        {
                            $query->orwhere('id', 'LIKE', '%'.$search.'%');   
                            $query->orwhere('voucher_code', 'LIKE', '%'.$search.'%');   
                            $query->orwhere('user_count', 'LIKE', '%'.$search.'%');   
                            $query->orwhere('discount', 'LIKE', '%'.$search.'%');   
                            $query->orwhere('discount_by', 'LIKE', '%'.$search.'%');   
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
                    $data[$key]['id']             = ($key+$start+1);
                    $data[$key]['voucher_code']   = '<span title="'.$row->voucher_code.'">'.str_limit($row->voucher_code, '55', '...').'</span>';
                    $data[$key]['user_count']     = $row->user_count;
                    $data[$key]['discount']       = $row->discount;
                    $data[$key]['discount_by']    = $row->discount_by;
                    $data[$key]['created_at']     = Date('d-m-Y', strtotime($row->created_at));
                    
                    $view   = '';
                    $edit   = '<a title="Edit" class="btn btn-default btn-circle" href="'.route('voucher.edit', [ base64_encode(base64_encode($row->id))]).'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;';
                    $delete = '<a title="Delete" onclick="return rwDelete(this)" data-rwid="'.base64_encode(base64_encode($row->id)).'" class="btn btn-default btn-circle" href="javascript:void(0)"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';

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
}
