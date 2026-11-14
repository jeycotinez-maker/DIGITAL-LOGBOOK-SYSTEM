<?php
namespace App\Http\Controllers;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
class ReportController extends Controller {
    public function index(Request $request) {
        $from = $request->input('from', now()->startOfMonth()->toDateString());
        $to = $request->input('to', now()->toDateString());
        $records = Attendance::with('student')->whereBetween('date',[$from,$to])->latest('date')->paginate(20)->withQueryString();
        return view('reports.index',compact('records','from','to'));
    }
    public function export(Request $request): StreamedResponse {
        $from = $request->input('from',now()->startOfMonth()->toDateString());
        $to = $request->input('to',now()->toDateString());
        $rows = Attendance::with('student')->whereBetween('date',[$from,$to])->orderBy('date')->get();
        return response()->streamDownload(function () use ($rows) {
            $out=fopen('php://output','w'); fputcsv($out,['Date','PN ID','Scholar','Batch','Block','Time In','Time Out','Status']);
            foreach($rows as $r) fputcsv($out,[$r->date->format('Y-m-d'),$r->student->pn_id,$r->student->name,$r->student->batch_year,$r->student->block_section,$r->time_in?->format('H:i:s'),$r->time_out?->format('H:i:s'),$r->status]);
            fclose($out);
        },'smartlog-attendance-'.$from.'-to-'.$to.'.csv',['Content-Type'=>'text/csv']);
    }
}
