@include('partials.header')

<h1 class="text-center m-2">Рейтинг<i title="фильтр" id="filter" style="font-size: 1.5rem; cursor: pointer" class="float-right text-primary ml-2 fa-xs fas fa-filter"></i></h1>

@auth
  @if (Auth::user()->is_admin)
    <h2 class="ml-2"><a href="{{ route('rating.create') }}"><i class="fas fa-plus mr-1"></i>Добавить рейтинг</a></h2>
  @endif
@endauth

@foreach($ratings as $rating)
    <h2 class="ml-2"><a href="{{ $rating->url }}">{{ $rating->name }}</a></h2>
@endforeach


<div class="modal fade" id="modal_filter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Фильтры</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="container">
                    <p><a href="{{ route('rating.index') }}?type=year">годовой</a> / <a href="{{ route('rating.index') }}?type=month">ежемесячный</a></p>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    $('#filter').on('click', function () {
        $('#modal_filter').modal('show');
    });
</script>

@include('partials.footer')
