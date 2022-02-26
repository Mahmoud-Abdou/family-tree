<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreReportRequest;
use App\Models\Death;
use App\Models\Report;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;
use App\Events\NotificationEvent;
use Pricecurrent\LaravelEloquentFilters\EloquentFilters;


class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:reports.read')->only(['index', 'show']);
        $this->middleware('permission:reports.create')->only(['create', 'store']);
        $this->middleware('permission:reports.update')->only(['edit', 'update']);
        $this->middleware('permission:reports.delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = auth()->id();
        $menuTitle = 'الشكاوي';
        $appMenu = config('custom.app_menu');
        $pageTitle = 'لوحة التحكم';
        $page_limit = 20;
        $reports = new Report;
        $filters_data = isset($request['filters']) ? $request['filters'] : [];

        $filters_array = $reports->filters($filters_data);
        $filters = EloquentFilters::make($filters_array);
        $reports = $reports->filter($filters);
        $reports = $reports->paginate($page_limit);

        return view('dashboard.reports.index', compact('appMenu', 'menuTitle', 'pageTitle', 'reports'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $menuTitle = 'اضافةشكوي';
        $pageTitle = 'القائمة الرئيسية';
        $type = $request->all();
        return view('web_app.reports.create', compact('menuTitle', 'pageTitle', 'type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreReportRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReportRequest $request)
    {
        $request['owner_id'] = auth()->id();
        $report = Report::create($request->all());

        \App\Helpers\AppHelper::AddLog('Report Create', class_basename($report), $report->id);
        return redirect()->back()->with('success', 'تم اضافة الشكوي.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show($report_id)
    {
        // dd("sda");
        $report = Report::where('id', $report_id)->first();
        return $report->showReportData($report);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        return redirect()->route('admin.Reports.index');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateReportRequest  $request
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReportRequest $request, Report $report)
    {
        return redirect()->route('admin.Reports.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        $report->delete();

        \App\Helpers\AppHelper::AddLog('Report Delete', class_basename($report), $report->id);
        return redirect()->back()->with('success', 'تم حذف بيانات الشكوي بنجاح.');
    }

}
