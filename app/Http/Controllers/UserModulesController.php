<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\UserModules;

class UserModulesController extends Controller
{
    public function activate($id)
    {
        //vérifier si le module existe
        $module = Module::where(['id' => $id])->first();
        if (!$module) {
            return response(["message" => "no module found"], 404);
        }
        //vérifier si l'user a déjà ce module activé
        $user_id = auth()->id();
        $user_module = UserModules::where(["user_id" => $user_id, "module_id" => $id])->first();
        if ($user_module) {
            if (!$user_module->active) {
                $user_module->update(["active" => true]);
            }
        } else {
            UserModules::create(["user_id" => $user_id, "module_id" => $id, "active" => true]);
        }
        return response([
            "message" => "Module activated"
        ], 200);
    }

    public function deactivate($id)
    {
        //vérifier si le module existe
        $module = Module::where(['id' => $id])->first();
        if (!$module) {
            return response(["message" => "no module found"], 404);
        }
        //vérifier si l'user a déjà ce module activé
        $user_id = auth()->id();
        $user_module = UserModules::where(["user_id" => $user_id, "module_id" => $id])->first();
        if ($user_module) {
            if ($user_module->active) {
                $user_module->update(["active" => false]);
            }
        } else {
            return response(["message" => "no module found"], 404);
        }
        return response([
            "message" => "Module deactivated"
        ], 200);
    }

    public function getUserModules()
    {
        $userModules = UserModules::where(['user_id' => auth()->id()])->get();
        return response([
            $userModules->load("module")
        ], 200);
    }
}
