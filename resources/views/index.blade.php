@extends('layouts.' . (Auth::check() ? 'admin' : 'guest'))

@section('content')
<div class="row">
    @forelse($posts as $post)
    @php
        // $renderer = new \DBlackborough\Quill\Renderer\Html();
        // $parser = new \DBlackborough\Quill\Parser\Html();
        // if($post->type == 'article') {
            // $parser->load($post->content)->parse();
        // }
    @endphp
    <div class="">
        <!-- Box Comment -->
        <div class="card card-widget">
          <div class="card-header">
            <div class="user-block">
              <img class="img-circle" src="{{ Auth::user()->icon }}" alt="User Image">
              <span class="username"><a href="#"> {{ Auth::user()->email }}</a></span>
              <span class="description">Shared publicly - {{ date('m-d-y', strtotime($post->created_at)) }}</span>
            </div>
            <!-- /.user-block -->
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-toggle="tooltip" title="Mark as read">
                <i class="fa fa-circle-o"></i></button>
              <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-widget="remove"><i class="fa fa-times"></i>
              </button>
            </div>
            <!-- /.card-tools -->
          </div>
          <!-- /.card-header -->
          <div class="card-body" style="display: block;">
            {{-- <a class="text-dark" href="{{ url('posts/'.$post->id) }}">
                <img class="img-fluid pad" src="{{ Auth::user()->icon }}" alt="Photo">
            </a> --}}
            @if($post->type == 'article')
                <div class="">
                    {{-- {!! $renderer->load($parser->deltas())->render() !!} --}}
                </div>
            @else`
                <p> {{ $post->content }} </p>
            @endif
            {{-- <button type="button" class="btn btn-default btn-sm"><i class="fa fa-share"></i> Share</button>
            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-thumbs-o-up"></i> Like</button>
            <span class="float-right text-muted">127 likes - 3 comments</span> --}}
          </div>
          <!-- /.card-body -->
          <div class="card-footer card-comments" style="display: block;">
            <div class="card-comment">
              <!-- User image -->
              <img class="img-circle img-sm" src="{{ Auth::user()->icon }}" alt="User Image">

              <div class="comment-text">
                <span class="username">
                  Maria Gonzales
                  <span class="text-muted float-right">8:03 PM Today</span>
                </span><!-- /.username -->
                It is a long established fact that a reader will be distracted
                by the readable content of a page when looking at its layout.
              </div>
              <!-- /.comment-text -->
            </div>
            <!-- /.card-comment -->
            <div class="card-comment">
              <!-- User image -->
              <img class="img-circle img-sm" src="{{ Auth::user()->icon }}" alt="User Image">

              <div class="comment-text">
                <span class="username">
                  Luna Stark
                  <span class="text-muted float-right">8:03 PM Today</span>
                </span><!-- /.username -->
                It is a long established fact that a reader will be distracted
                by the readable content of a page when looking at its layout.
              </div>
              <!-- /.comment-text -->
            </div>
            <!-- /.card-comment -->
          </div>
          <!-- /.card-footer -->
          <div class="card-footer" style="display: block;">
            <form action="#" method="post">
              <img class="img-fluid img-circle img-sm" src="{{ Auth::user()->icon }}" alt="Alt Text">
              <!-- .img-push is used to add margin to elements next to floating images -->
              <div class="img-push">
                <input type="text" class="form-control form-control-sm" placeholder="Press enter to post comment">
              </div>
            </form>
          </div>
          <!-- /.card-footer -->
        </div>
        <!-- /.card -->
    </div>
    @empty
        No posts found
    @endforelse
</div>
{{ $posts->links() }}
@endsection
