<?php

namespace App\Http\Controllers;

use App\Models\Shorten;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShortenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shortens = Shorten::where(["user_id" => auth()->id()])->get();
        return response([
            $shortens
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "original_url" => "required|string|url",
            "custom_code" => "string|max:10|unique:shorten,custom_code",
        ]);
        $custom_code = $request->custom_code;
        if (!$request->filled("custom_code")) {
            //if no custom_code, gen and check if it' unique in DB
            do {
                $custom_code = Str::random(10);
            } while ($this->checkUniqueCode($custom_code) == false);
        } else {
            if (!$this->checkUniqueCode($custom_code)) {
                return response([
                    "message" => "code already used"
                ], 403);
            }
        }
        $shorten = Shorten::create([
            "original_url" => $request->original_url,
            "custom_code" => $custom_code,
            "user_id" => auth()->id()
        ]);
        return response([
            $shorten
        ], 201);
    }

    public function redirect($code)
    {
        $shorten = Shorten::where(['custom_code' => $code])->first();
        if (!$shorten) {
            return response([
                "message" => "No URL found"
            ], 400);
        }
        Shorten::where(['custom_code' => $code])->update(["clicks" => $shorten->clicks + 1]);
        return redirect()->away($shorten->original_url, 302);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $shorten = Shorten::where(['id' => $id])->first();
        if ($shorten) {
            if (auth()->id() == $shorten->user_id) {
                $shorten->delete();
                return response([
                    "message" => "Link deleted successfully"
                ], 200);
            } else {
                return response([
                    "error" => "not allowed to delete this link"
                ], 403);
            }
        } else {
            return response([
                "error" => "not found"
            ], 400);
        }
    }
    private function checkUniqueCode($code)
    {
        $retour = Shorten::where(['custom_code' => $code])->count();
        return ($retour == 0) ? true : false;
    }
}