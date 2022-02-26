<div class="container bootdey">
    <div class="col-md-12 bootstrap snippets">
        @can('comments.create')
        <div class="panel">
            <div class="panel-body">
                <form dir="rtl" method="POST" action="{{ route('news_comments.store') }}">
                    @csrf
                    <input type="hidden" name="news_id" value="{{ $news->id }}">
                    <div class="form-group has-validation">
                        <textarea name="body" class="form-control" rows="2" placeholder="اكتب تعليق" required oninvalid="this.setCustomValidity('اكتب تعليق هنا')"></textarea>
                    </div>
                    <button class="btn btn-sm btn-primary pull-right py-2 px-4" type="submit">
                        <i class="ri-discuss-fill"> </i>
                        اضف تعليق
                    </button>
                </form>
                <div class="mar-top clearfix"></div>
            </div>
        </div>
        @endcan
        <br>
        @can('comments.read')
        <div class="panel">
            <div class="panel-body">
                {{--    <!-- Newsfeed Content -->--}}
                <div class="media-block">

                    @foreach($news->comments as $comment)
                        <div class="media-block">
                            <div class="media-body">
                                <div class="mar-btm w-100 d-inline-flex justify-content-between">
                                    <a class="btn-link text-secondary font-size-16" href="#">
                                        {{ $comment->owner->name }}
                                    </a>
                                    <p class="text-muted text-sm"><i class="ri-calendar-event-line"> </i>
                                        : {{ date('Y-m-d', strtotime($comment->created_at)) }}
                                    </p>
                                </div>
                                <h5>{{ $comment->body }}</h5>
                                <div class="pad-ver"></div>
                                @if($loop->last)
                                    <br>
                                @else
                                    <hr>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                {{--    <!-- End Newsfeed Content -->--}}
            </div>
        </div>
        @endcan
    </div>
</div>

