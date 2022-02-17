<div class="container bootdey">
<div class="col-md-12 bootstrap snippets">
<div class="panel">
  <div class="panel-body">
  <form dir="rtl" method="POST" action="{{ route('news_comments.store') }}" >
        @csrf
        <input type="hidden" name="news_id" value="{{ $news->id }}">
        <!-- <input type="text" name="body" > -->
        <textarea name="body" class="form-control" rows="2" placeholder="بماذا تفكر ؟"></textarea>
        <!-- <button type="submit" class="card-text m-0"><i class="ri-discuss-fill"></i></button> -->
        <button class="btn btn-sm btn-primary pull-right" type="submit"><i class="ri-discuss-fill"></i> اضف تعليق</button>
    </form>
    <div class="mar-top clearfix">
      
    </div>
  </div>
</div>
<hr>
<div class="panel">
    <div class="panel-body">
    <!-- Newsfeed Content -->
    <!--===================================================-->
    <div class="media-block">
      

        <!-- Comments -->
        @foreach($news->comments as $comment)
            <div>
            <div class="media-block">
                <div class="media-body">
                <div class="mar-btm">
                    <a href="#" class="btn-link text-semibold media-heading box-inline">{{ $comment->owner->name }}</a>
                    <p class="text-muted text-sm"><i class="fa fa-mobile fa-lg"></i> - {{ date('Y-m-d | H:i', strtotime($comment->created_at)) }}</p>
                </div>
                <p>{{ $comment->body }}</p>
                <div class="pad-ver">
                </div>
                <hr>
                </div>
            </div>
        @endforeach
          
        </div>
      </div>
    </div>
    <!--===================================================-->
    <!-- End Newsfeed Content -->

  </div>
</div>
</div>
</div>