<?php

namespace App\Http\Controllers;

use App\Models\Transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Exception;

class UserController extends Controller
{
    public function wallet()
    {
        return response([
            "user_id" => auth()->id(),
            "balance" => auth()->user()->balance
        ], 200);
    }
    public function transfert(Request $request)
    {
        $request->validate([
            "receiver_id" => "required|integer|exists:users,id",
            "amount" => "required|numeric"
        ]);
        $amount = $request->amount;
        if ($request->receiver_id == auth()->id()) {
            return response([
                "error" => "can't transfer to yourself"
            ], 403);
        } else {
            if ($amount <= 0 || $amount > auth()->user()->balance) {
                return response([
                    "error" => "insufficient balance"
                ], 400);
            }
            //demarrer une transaction
            DB::beginTransaction();
            try {
                //retirer la somme du compte de celui qui envoie
                $user = auth()->user();
                User::where(["id" => auth()->id()])->update(["balance" => $user->balance - $amount]);
                //ajouter la somme au compte de celui qui recoit
                $receiver = User::where(["id" => $request->receiver_id])->first();
                User::where(["id" => $receiver->id])->update(["balance" => $receiver->balance + $amount]);
                //enregistrer la transaction
                $transfer = Transfer::create([
                    "user_id" => auth()->id(),
                    "receiver_id" => $request->receiver_id,
                    "amount" => $amount,
                    "status" => "success",
                ]);
            } catch (Exception $error) {
                DB::rollBack();
                $transfer = Transfer::create([
                    "user_id" => auth()->id(),
                    "receiver_id" => $request->receiver_id,
                    "amount" => $amount,
                    "status" => "failed",
                ]);
                return response([
                    "error" => "une erreur est survénue"
                ], 400);
            }
            DB::commit();
            return response([
                "transaction_id" => $transfer->id,
                "sender_id" => $transfer->user_id,
                "receiver_id" => $transfer->receiver_id,
                "amount" => $transfer->amount,
                "status" => $transfer->status,
                "created_at" => $transfer->created_at
            ], 201);
        }
    }

    public function topUp(Request $request)
    {
        $request->validate([
            "amount" => "required|numeric|max:10000"
        ]);
        if ($request->amount <= 0 || $request->amount > 10000) {
            return response([
                "error" => "can't transfer"
            ], 400);
        }
        try {
            $retour = User::where(["id" => auth()->id()])->update(['balance' => auth()->user()->balance + $request->amount]);
            if ($retour) {
                $user = User::where(["id" => auth()->id()])->first();
            }
            return response([
                "user_id" => $user->id,
                "balance" => $user->balance,
                "topup_amount" => $request->amount,
                "created_at" => $user->created_at
            ], 201);
        } catch (Exception $e) {
            return response([
                "error" => "can't transfer",
                $e->getMessage()
            ], 400);
        }
    }

    public function getTransactions()
    {
        $id = auth()->id();
        $transactions = Transfer::where(["user_id" => $id])->orWhere(["receiver_id" => $id])->get();
        return response([
            $transactions
        ], 200);
    }
}