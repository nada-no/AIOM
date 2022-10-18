<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Services\UploadPhotoService;
use App\Exceptions\UploadFileException;

class AccountController extends Controller
{
    private $uploadPhotoService;
    private $account;
    public function __construct()
    {
        $this->account = new Account();
    }
    public function updateAccount(Request $request, UploadPhotoService $UploadPhotoService) {
        $success = false;
        try {
            $this->account = Account::find(auth()->user()->id);
            // dd($this->account->email);
            
            if ($request->filled('nick')) {
                $this->account->nick = $request->nick;
            }

            $isValid = $request->validate([
                'cover' => 'mimes:png,jpg,jpeg,gif,png,svg|max:40048'
            ]);
            if ($isValid) {
                $this->uploadPhotoService = $UploadPhotoService;
                if ($request->hasFile('cover')) {
                    $photo = $this->account->photo = $request->cover->getClientOriginalName();
                    $this->uploadPhotoService->uploadFile($request->file('cover'));
                    auth()->user()->photo = $photo;
                }
            }
            if (!$request->filled('password') && !$request->filled('password')) {
                $success = $this->account->save();
            }else if ($request->password == $request->password2) {
                $this->account->password = bcrypt($request->password);
                $success = $this->account->save();
            }
        } catch (UploadFileException $exception) {
            //$this->error = $exception->getMessage();
            $this->error = $exception->customMessage(); 
        }catch ( \Illuminate\Database\QueryException $exception) {
            $this->error = "Error with information introduced on database";
        }
        return view('profile')
        ->with("success",$success);
    }
    public function deleteAccount() {
        $account = Account::find(auth()->user()->id);
        $account->forceDelete();
        return redirect('/register');
    }    
}
