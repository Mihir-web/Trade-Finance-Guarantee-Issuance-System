<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\guarantees;
use Illuminate\Support\Facades\Validator;
use App\Models\user;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\AddGuranteeRequest;
use App\Http\Requests\UpdateGuranteeRequest;

use Session;
use Illuminate\Support\Facades\Storage;

class GuaranteeController extends Controller
{
    

    public function index(Request $request)
    {
        $filter = $request->all();
        $guarantees = guarantees::where(function($q)use($filter){
                    if(isset($filter['search']) && !empty($filter['search'])){
                        $q->where('name','LIKE','%'.$filter['search'].'%');
                    }
                })->where(function($q)use($filter){
                    if(isset($filter['status']) ){
                        $q->where('is_active',$filter['status']);
                    }
                })->orderBy('created_at','asc')->get();
        $guarantees_total = guarantees::count();
        

        

        return view('guarantees.list',compact('guarantees','guarantees_total','filter'));
    }

    public function create()
    {
        
        return view('guarantees.create');
    }

    public function store(AddGuranteeRequest $request)
    {
        try{
                $all = $request->all();
                
                $guarantees = guarantees::create($all);
                return redirect()->route('guarantees')->with('success','New record added successfully!');
            }catch(\Exception $e){
                echo "<pre>"; print_r($e->getMessage()); exit;
                return redirect()->back()->with('error',$e->getMessage());
        }
    }

    public function edit($id)
    {
        
        $guarantee = guarantees::where('corporate_reference_number',$id)->first();
        
        return view('guarantees.edit',compact('guarantee'));
    }

    public function update(UpdateGuranteeRequest $request)
    {
        try{
            $all = $request->all();
      
           $crn = $all['bid'];
           unset($all['_token']);
           unset($all['bid']);
           unset($all['add_bill']);
           unset($all['author_id']);
           unset($all['proengsoft_jsvalidation']);
           
        guarantees::where('corporate_reference_number',$crn)->update($all);
            

            
                return redirect()->route('guarantees')->with('success','Record updated successfully');
           
        }catch(\Exception $e){
            
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    public function statuschange(Request $request)
    {
        try{
            $inputs = $request->all();
            $record = guarantees::find(base64_decode($inputs['id']));
            
          


            if(!empty($record)){
              
                    $record->update(['status'=>$inputs['status']]);
                    
                    if($inputs['status'] == 5){
                        $mps = user::where('role_id', 2)->get();
                       
                        foreach($mps as $mp_data){
                            $notification['user_id'] =  $mp_data->id;
                            $notification['message'] =  "Voting session started for the bill '".$record->title."'."; 
                            notifications::create($notification);
                        }   
                    }
                    
                
                return 'success';
            }
            return 'Record not found';
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    
    public function importForm()
    {
        return view('guarantees.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:json,xlsx',
        ]);

        $file = $request->file('file');
        $filePath = $file->getPathName();
        $extension = $file->getClientOriginalExtension();

        if ($extension === 'json') {
            $this->importFromJson($filePath);
        } elseif ($extension === 'xlsx') {
            $this->importFromExcel($filePath);
        }

        return redirect()->route('guarantees')->with('success', 'Data imported successfully.');
    }

    private function importFromJson($filePath)
    {
        $data = json_decode(file_get_contents($filePath), true);
       
        foreach ($data as $record) {
            $record_tobe_inserted = [
                'corporate_reference_number' => $record['Corporate Reference Number'],
                'guarantee_type' => $record['Guarantee Type'],
                'nominal_amount' => $record['Nominal Amount'],
                'nominal_amount_currency' => $record['Nominal Amount Currency'],
                'expiry_date' => $record['Expiry Date'],
                'applicant_name' => $record['Applicant Name'],
                'applicant_address' => $record['Applicant Address'],
                'beneficiary_name' => $record['Beneficiary Name'],
                'beneficiary_address' => $record['Beneficiary Address'],
            ];
            $record_tobe_inserted['expiry_date'] = date('Y-m-d', strtotime(str_replace('-', '/', $record_tobe_inserted['expiry_date'])));
            $this->validateAndInsert($record_tobe_inserted);
        }
    }

    private function importFromExcel($filePath)
    {
        $rows = Excel::toArray([], $filePath)[0];

     
        foreach ($rows as $index => $row) {
            if ($index === 0) continue; // Skip the header row
            $record = [
                'corporate_reference_number' => $row[0],
                'guarantee_type' => $row[1],
                'nominal_amount' => $row[2],
                'nominal_amount_currency' => $row[3],
                'expiry_date' => $row[4],
                'applicant_name' => $row[5],
                'applicant_address' => $row[6],
                'beneficiary_name' => $row[7],
                'beneficiary_address' => $row[8],
            ];
            $record['expiry_date'] = \Carbon\Carbon::createFromFormat('Y-m-d', '1900-01-01')->addDays($record['expiry_date'] - 2)->format('Y-m-d');
            $this->validateAndInsert($record);
        }
    }

    private function validateAndInsert(array $data)
    {
        $rules = [
            // 'corporate_reference_number' => 'required|unique:guarantees,corporate_reference_number',
            'guarantee_type' => 'required',
            'nominal_amount' => 'required',
            'nominal_amount_currency' => 'required',
            'expiry_date' => 'required',
            'applicant_name' => 'required',
            'applicant_address' => 'required',
            'beneficiary_name' => 'required',
            'beneficiary_address' => 'required',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            // Log validation errors if needed
            return;
        }
        // echo "<pre>"; print_r($data); exit;
        
        



        guarantees::updateOrCreate(
            ['corporate_reference_number' => $data['corporate_reference_number']],
            $data
        );
    }

    public function delete(Request $request)
    {
        try{
            $all = $request->all();
            if(isset($all['id']) && !empty($all['id'])){
                
                    $corporate_reference_number = base64_decode($all['id']);

                    $guarantees = guarantees::where('corporate_reference_number',$corporate_reference_number)->delete();
                    
                   
                    // $inventory->delete();

                Session::flash('error','A record has been deleted');
                return 'success';
            }
            return 'failed';
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
}
