@extends('partials.footer')

@include('partials.header')

  <h1 class="text-center m-2">Создать статью</h1>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-11">
        <div class="card">
          <div class="card-header">Создание статьи</div>

          <div class="card-body">
            <form id="form" method="POST" action="{{ route('article.store') }}">
              @csrf

              <div class="form-group row">
                <label for="title" class="col-md-4 col-form-label text-md-right">Название статьи</label>

                <div class="col-md-7">
                  <input id="title" type="text" class="form-control" name="title" required>
                </div>
              </div>



              <div class="form-group row">
                <label for="editor" class="col-md-4 col-form-label text-md-right">Статья</label>

                <div class="col-md-7">
                    <textarea class="form-control" id="editor" name="body">
                    </textarea>
                </div>
              </div>

              <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                  <button type="submit" class="btn btn-primary">
                    Сохранить
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>


@include('partials.footer')

@section('script')
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js"></script>

    <script>
        $(document).ready(function() {
            $('#editor').summernote({
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['picture', 'link']]
                ],
            });
        });
    </script>
@endsection
