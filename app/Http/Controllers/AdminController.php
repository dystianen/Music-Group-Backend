<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin;
use Ramsey\Uuid\Uuid;

class AdminController extends Controller
{
    public $response;
    public function __construct(){
        $this->response = new ResponseHelper();
    }
    

    // GETALL
    public function getAll($limit = NULL, $offset = NULL)
    {   
        if($limit == NULL && $offset == NULL){
            $data["admin"] = Admin::get();
        } else {
            $data["admin"] = Admin::take($limit)->skip($offset)->get();
        }

		$data["total_data"] = Admin::count();

        return $this->response->successData($data);
    }

    public function getById($id)
    {   
        $data["admin"] = Admin::where('id', $id)->get();

        return $this->response->successData($data);
    }

    public function insert(Request $request)
    {
        $validator = Validator::make($request->all(), [
			'artistName' => 'required|string',
			'email' => 'required|string',
			'firstName' => 'required|string',
			'lastName' => 'required|string',
			'bankName' => 'required|string',
			'accountNumber' => 'required|string',
			'accountName' => 'required|string',
			'amount' => 'required|string',
			'phone' => 'required|string',
			'status' => 'required|string',
		]);

		if($validator->fails()){
            return $this->response->errorResponse($validator->errors());
		}

		$admin = new Admin();
		$admin->artist_name = $request->artistName;
		$admin->email = $request->email;
		$admin->firstname = $request->firstName;
		$admin->lastname = $request->lastName;
		$admin->bank_name = $request->bankName;
		$admin->bank_account_number = $request->accountNumber;
		$admin->bank_account_holder_name = $request->accountName;
		$admin->amount = $request->amount;
		$admin->phone_number = $request->phone;
		$admin->status = $request->status;
		$admin->save();

        $data = Admin::where('email','=', $admin->email)->first();
        return $this->response->successResponseData('Data Admin berhasil ditambahkan', $data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'artistName' => 'required|string',
			'email' => 'required|string',
			'firstName' => 'required|string',
			'lastName' => 'required|string',
			'bankName' => 'required|string',
			'accountNumber' => 'required|string',
			'accountName' => 'required|string',
			'amount' => 'required|string',
			'phone' => 'required|string',
			'status' => 'required|string',
		]);

		if($validator->fails()){
            return $this->response->errorResponse($validator->errors());
		}

		$admin = Admin::where('id', $id)->first();
		$admin->artist_name = $request->artistName;
		$admin->email = $request->email;
		$admin->firstname = $request->firstName;
		$admin->lastname = $request->lastName;
		$admin->bank_name = $request->bankName;
		$admin->bank_account_number = $request->accountNumber;
		$admin->bank_account_holder_name = $request->accountName;
		$admin->amount = $request->amount;
		$admin->phone_number = $request->phone;
		$admin->status = $request->status;

		$admin->save();

        return $this->response->successResponse('Data Admin berhasil diubah');
    }

    public function delete($id)
    {
        $delete = Admin::where('id', $id)->delete();

        if($delete){
            return $this->response->successResponse('Data Admin berhasil dihapus');
        } else {
            return $this->response->errorResponse('Data Admin gagal dihapus');
        }
    }
}
