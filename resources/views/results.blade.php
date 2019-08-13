@extends('layouts.admin')

@section('styles')
<style>

</style>
@endsection

@section('content')
<div id="vue" class="row no-gutter">
  {{-- @forelse ($judges as $judge)
    <div class="col-md-6 col-lg-6 col-sm-12 h-100 mb-4">
      <h6>{{ $judge->name }}</h6>
    @forelse ($judge->categories as $category)
      @forelse ($category->subcategories as $subcategory)
        @if($subcategory->id != @$final->id)
          <div class="" >
              <div class="table-responsive">
                <h5>{{ $subcategory->name }}</h5>
                <table class="table table-hover table-sm table-borderless" style="margin:0!important">
                  <form id="subcategory->{{ $subcategory->id }}" action="{{ route('score.index') }}" method="post">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}" form="subcategory->{{ $subcategory->id }}">
                      <input type="hidden" name="judge_id" value="{{ $judge->id }}" form="subcategory->{{ $subcategory->id }}">
                      <input type="hidden" name="subcategory_id" value="{{ $subcategory->id }}" form="subcategory->{{ $subcategory->id }}">
                    </form>
                  <thead class="bg-danger">
                    <tr>
                      <th class="text-center" scope="col" width="10%">
                        <i class="fa-fw far fa-hashtag"></i>
                      </th>
                      <th scope="col">
                        <i class="fa-fw far fa-user-alt"></i>
                        Name
                      </th>
                      <th scope="col" width="30%">
                        <i class="fa-fw far fa-star"> </i>
                        Score
                      </th>
                    </tr>
                    <tbody>
                  </thead>
                  @forelse ($category->contestants as $contestant)
                    <tr>
                      <th class="text-center align-middle">{{ $contestant->number }}</th>
                      <td class="align-middle">{{ $contestant->name }}</td>
                      <td class="" data-order="{{ $judge->score($subcategory->id, $contestant->id)}}">
                        {{ $judge->score($subcategory->id, $contestant->id) }}
                      </td>
                    </tr>
                  @empty
                  @endforelse

                  </tbody>
                </table>
              </div>
            </div>
        @endif
      @empty
      @endforelse
    @empty
    @endforelse
  </div>
  @empty
  @endforelse --}}
  <div class="col-md-6 col-lg-6 col-sm-12 h-100 mb-4">
    @forelse ($active->categories as $category)
      @forelse ($collection as $item)
        <h5>{{ $category->name }}</h5>
        <table class="table table-hovel table-sm table-borderless">
          <thead class="">
            <tr>
              <th class="text-left" scope="col" width="10%">
                <i class="fa-fw far fa-hashtag"></i>
                No.
              </th>
              @forelse ($judges as $judge)
              <th class="text-left" scoper="col" width="10%">
                  Judge {{$judge->id}}
              </th>
              @empty

              @endforelse
              <th class="text-left" scoper="col" width="20%">
                <i class="fa-fw far fa-medal"></i>
                Rank
              </th>
            </tr>
          </thead>
          <tbody>
            @forelse ($active->contestants as $contestant)
              <tr>
                <th class="text-left">
                  {{$contestant->id}}
                </th>
                <th class="text-left">
                    {{$contestant->id}}
                  </th>
                  <th class="text-left">
                      {{$contestant->id}}
                    </th>
                    <th class="text-left">
                        {{$contestant->id}}
                      </th>
                      <th class="text-left">
                          {{$contestant->id}}
                        </th>
                        <th class="text-left">
                            {{$contestant->id}}
                          </th>
                          <th class="text-left">
                              {{$contestant->id}}
                            </th>
              </tr>
            @empty

            @endforelse
        </tbody>
      </table>
    </div>
      @empty

      @endforelse

    @empty

    @endforelse

</div>
@endsection

@section('scripts')
<script>
$(() => {
  $('table').DataTable({'dom':'dtr'});
})
</script>
@endsection
