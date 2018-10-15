<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;
use App\SettingGroup;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('allowed');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $settings = SettingGroup::with([
            'settings',
        ])->orderBy('order', 'ASC')->get();

        return view('settings.list')->with([
            'groups' => $settings,
        ]);
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        $setting = Setting::find($id);
        //die("s: ".$setting->label);

        if((bool)$setting->system === true) return abort(404);

        if (!is_null($setting)) {
            return view('settings.edit')->with([
                'setting' => $setting,
            ]);
        } else {
            $route = route('settings.list', [], false);
            return redirect($route) 
            ->with([
                'error' => __('app.alert.error.not_exist'),
            ]);
        }
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $setting = Setting::find($id);
        $user = $this->user();

        if (!is_null($setting)) {
            $data = Setting::getInput();

            if ($setting->type == 'image') {


                if($request->hasFile('value')) {
                    $path = $request->file('value')->store('backgrounds');
                    $setting_value = $path;
                }
            
            } else {
                $setting_value = $data->value;
            }

            $user->settings()->updateExistingPivot($setting->id, ['value' => $setting_value]);
            $route = route('settings.index', [], false);
            return redirect($route) 
            ->with([
                'success' => __('app.alert.success.setting_updated'),
            ]);
        } else {
            $route = route('settings.index', [], false);
            return redirect($route) 
            ->with([
                'error' => __('app.alert.error.not_exist'),
            ]);
        }
    }
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clear($id)
    {
        $setting = Setting::find($id);
        if((bool)$setting->system !== true) {
            $setting->value = '';
            $setting->save();
        }
        $route = route('settings.index', [], false);
        return redirect($route) 
        ->with([
            'success' => __('app.alert.success.setting_updated'),
        ]);
    
    }
}
