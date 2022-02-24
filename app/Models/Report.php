<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Filters\TextFilter;
use App\Filters\IDFilter;
use App\Filters\BetweenFilter;
use App\Filters\InFilter;
use App\Filters\OwnerFilter;
use Pricecurrent\LaravelEloquentFilters\Filterable;
use App\Filters\DateFilter;
use App\Filters\OwnerRelativesFilter;

class Report extends Model
{
    use Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'owner_id',
        'type',
        'type_id',
        'body',
    ];

    protected $appends = ['short_body'];

    public function owner()
    {
        return $this->belongsTo('App\Models\User', 'owner_id', 'id');
    }

    public function getShortBodyAttribute()
    {
        $text = strip_tags($this->body);
        return substr($text, 0, 160) . ' ....';
    }


    public function filters($request_filter)
    {
        $filters = [];
        if(isset($request_filter['body'])){
            $filters[] = new TextFilter($request_filter['body'], 'body');
        }

        if(isset($request_filter['owner_name'])){
            $filters[] = new OwnerFilter($request_filter['owner_name'], 'name');
        }
        if(isset($request_filter['owner_phone'])){
            $filters[] = new OwnerFilter($request_filter['owner_phone'], 'mobile');
        }
        if(isset($request_filter['owner_email'])){
            $filters[] = new OwnerFilter($request_filter['owner_email'], 'email');
        }
        if(isset($request_filter['date'])){
            $filters[] = new DateFilter($request_filter['date'], 'created_at');
        }
        if(isset($request_filter['relatives'])){
            if(isset(auth()->user()->profile->belongsToFamily)){
                $relatives_famiy_id = auth()->user()->profile->belongsToFamily->gf_family_id;
                $filters[] = new OwnerRelativesFilter($relatives_famiy_id, 'gf_family_id');
            }
        }

        return $filters;
    }

    public function showReportData($report)
    {
        if($report->type == 'deaths'){
            $death = Death::where('id', $report->type_id)->first();
            if($death == null){
                return redirect()->back()->with('warning', 'الخبر غير موجود.');
            }
            return redirect()->route('admin.deaths.edit', $death);
        }
        if($report->type == 'newborns'){
            $newborn = Newborn::where('id', $report->type_id)->first();
            if($newborn == null){
                return redirect()->back()->with('warning', 'الخبر غير موجود.');
            }
            return redirect()->route('admin.newborns.edit', $newborn);
        }
        if($report->type == 'marriages'){
            $marriage = Marriage::where('id', $report->type_id)->first();
            if($marriage == null){
                return redirect()->back()->with('warning', 'الخبر غير موجود.');
            }
            return redirect()->route('admin.marriages.edit', $marriage);
        }
        if($report->type == 'events'){
            $event = Event::where('id', $report->type_id)->first();
            if($event == null){
                return redirect()->back()->with('warning', 'الخبر غير موجود.');
            }
            return redirect()->route('admin.events.edit', $event);
        }
        if($report->type == 'news'){
            $news = News::where('id', $report->type_id)->first();
            if($news == null){
                return redirect()->back()->with('warning', 'الخبر غير موجود.');
            }
            return redirect()->route('admin.news.edit', $news);
        }

    }
}
