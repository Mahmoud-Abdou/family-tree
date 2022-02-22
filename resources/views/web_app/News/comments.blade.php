<div class="container bootdey">
    <div class="col-md-12 bootstrap snippets">
        <div class="panel">
            <div class="panel-body">
                <form dir="rtl" method="POST" action="{{ route('news_comments.store') }}">
                    @csrf
                    <input type="hidden" name="news_id" value="{{ $news->id }}">
                    <div class="form-group has-validation">
                        <textarea name="body" class="form-control" rows="2" placeholder="اكتب تعليق" required oninvalid="this.setCustomValidity('اكتب تعليق هنا')"></textarea>
                    </div>
                    <br>
                    <button class="btn btn-sm btn-primary pull-right py-2 px-4" type="submit"><i class="ri-discuss-fill"></i> اضف
                        تعليق
                    </button>
                </form>
                <div class="mar-top clearfix">

                </div>
            </div>
        </div>
        @can('comments.read')
        <br>
        <div class="panel">
            <div class="panel-body">
                {{--    <!-- Newsfeed Content -->--}}
                <div class="media-block">

                    @foreach($news->comments as $comment)
                        <div>
                            <div class="media-block">
                                <div class="media-body">
                                    <div class="mar-btm">
                                        <p class="btn-link text-semibold media-heading box-inline">{{ $comment->owner->name }}</p>
                                        <p class="text-muted text-sm"><i class="fa fa-mobile fa-lg"></i>
                                            - {{ date('Y-m-d | H:i', strtotime($comment->created_at)) }}</p>
                                    </div>
                                    <h5>{{ $comment->body }}</h5>
                                    <div class="pad-ver">
                                    </div>
                                    <hr>
                                </div>
                            </div>
                            @endforeach

                        </div>
                </div>
            </div>
            {{--    <!-- End Newsfeed Content -->--}}
        @endcan
        </div>
    </div>
</div>

