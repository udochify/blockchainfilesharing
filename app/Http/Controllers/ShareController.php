<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Share;
use App\Models\File;
use App\Models\User;
use App\Services\CurlNode;

class ShareController extends Controller
{
    
    public function share(Request $request, File $file) 
    {
        try {
            if($file->address) {
                $response = Curlnode::post('/sharefilewithsome', [
                    'owner' => auth()->user()->address,
                    'address' => $file->address,
                    'users' => $request->contacts,
                ]);
                if(!session('connect_error')) {
                    $shares = [];
                    foreach (json_decode($request->contacts) as $contact) {
                        if(Share::where(['user_address' => $contact, 'file_id' => $file->id])->count() < 1) {
                            $user = User::firstWhere('address', $contact);
                            $share = new Share;
                            $share->file_id = $file->id;
                            $share->file_address = $file->address;
                            $share->file_name = $file->get_fullname();
                            $share->file_size = $file->getFileSize();
                            $share->owner = auth()->user()->address;
                            $share->user_id = $user->id;
                            $share->user_address = $contact;
                            $share->user_name = $user->name;
                            $share->save();
                            array_push($shares, $share);
                        }
                    }
                    return response()->json([
                        'view' => view('ajax.share.index', ['shares' => $shares])->render(),
                        'status' => view('ajax.success', ['success' => 'File (' . $file->get_fullname() . ') has been shared successfully.'])->render(),
                        'success' => true
                    ]);
                } else {
                    throw new Exception("Error: " . session('connect_error_message'));
                }
            } else {
                throw new Exception("Error: File not in blockchain. Contact admin.");
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => view('ajax.error', ['error' => $e->getMessage()])->render(),
                'error' => true
            ]);
        }
    }

    public function unshare(Request $request, File $file) 
    {
        try {
            if($file->address) {
                $response = Curlnode::post('/unsharefilewithsome', [
                    'owner' => auth()->user()->address,
                    'address' => $file->address,
                    'users' => $request->contacts,
                ]);
                if(!session('connect_error')) {
                    foreach (json_decode($request->contacts) as $contact) {
                        Share::where(['user_address' => $contact, 'file_id' => $file->id])->delete();
                    }
                    $shares = Share::where(['file_id' => $file->id])->get();
                    return response()->json([
                        'view' => view('ajax.share.index', ['shares' => $shares])->render(),
                        'status' => view('ajax.success', ['success' => 'File (' . $file->get_fullname() . ') has been unshared successfully.'])->render(),
                        'success' => true
                    ]);
                } else {
                    throw new Exception("Error: " . session('connect_error_message'));
                }
            } else {
                throw new Exception("Error: File not in blockchain. Contact admin.");
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => view('ajax.error', ['error' => $e->getMessage()])->render(),
                'error' => true
            ]);
        }
    }

    public function unshare_reverse(Request $request, File $file) 
    {
        try {
            if($file->address) {
                $response = Curlnode::post('/unsharefilewithone', [
                    'owner' => $request->contact,
                    'address' => $file->address,
                    'user' => auth()->user()->address,
                ]);
                if(!session('connect_error')) {
                    Share::where(['user_address' => auth()->user()->address, 'file_id' => $file->id])->delete();
                    $shares = Share::where(['file_id' => $file->id])->get();
                    return response()->json([
                        'status' => view('ajax.success', ['success' => 'File (' . $file->get_fullname() . ') has been unshared successfully.'])->render(),
                        'success' => true
                    ]);
                } else {
                    throw new Exception("Error: " . session('connect_error_message'));
                }
            } else {
                throw new Exception("Error: File not in blockchain. Contact admin.");
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => view('ajax.error', ['error' => $e->getMessage()])->render(),
                'error' => true
            ]);
        }
    }

    public function check() {
        try {
            $msg = "";
            $shared = auth()->user()->shares();
            if(session('shared_count') != $shared->count()) {
                if(session('shared_count') > $shared->count()) $msg = "A file is no longer shared with you.";
                if(session('shared_count') < $shared->count()) $msg = "New file(s) recieved.";
                session(['shared_count' => $shared->count()]);
                return response()->json([
                    'view' => view('ajax.shared.index', ['shared' => $shared->orderBy('created_at', 'desc')->get()])->render(),
                    'status' => view('ajax.success', ['success' => $msg])->render(),
                    'success' => true
                ]);
            } else {
                return response()->json([
                    'state' => 'unchanged'
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => view('ajax.error', ['error' => $e->getMessage()])->render(),
                'error' => true
            ]);
        }
    }
}
