<?php
namespace App\Http\Controllers;
use App\Models\AcademicSetting;
use App\Models\AuditLog;
use Illuminate\Http\Request;
class AcademicSettingController extends Controller {
    public function edit() { $setting=AcademicSetting::first() ?? new AcademicSetting(); return view('settings.academic',compact('setting')); }
    public function update(Request $request) {
        $data=$request->validate(['school_year'=>'required|string|max:30','semester'=>'required|string|max:30','update_open'=>'required|boolean','update_deadline'=>'nullable|date']);
        $setting=AcademicSetting::first();
        if ($setting) $setting->update($data); else $setting=AcademicSetting::create($data);
        AuditLog::create(['user_id'=>auth()->id(),'action'=>'academic_settings_updated','target_type'=>'academic_setting','target_id'=>$setting->id,'details'=>$data]);
        return back()->with('success','Academic settings updated.');
    }
}
