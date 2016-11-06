@extends('layouts.master_admin')

@section('content')
<div class="container">
  <div class="row">
    <article class="data_hm">
      <div class="col-sm-8 col-sm-offset-2">
        <h1>Búsqueda avanzada</h1>
        <section>
          @if ($surveys->count() > 0)
          <!-- FILTRAR RESULTADOS -->
          <h2 class="toggle">Filtrar resultados</h2>
          <form id="fbp" name="filter-blueprints" method="get" action="{{url('dashboard/encuestas/buscar/avanzado')}}">
            <?php $category = $request->input('category') ? $categories->where("name", $request->input('category'))->first() : null; ?>
            {!! csrf_field() !!}
            <p>Buscar: <input type="text" name="title" value="{{$request->input('title')}}"></p>

            <p>
              <select name="category" id="survey-category">
                <option value="">Selecciona una categoría</option>
                @foreach($categories as $cat)
                <option value="{{$cat->name}}" {{$category && $category->name == $cat->name ? 'selected' : ''}}>{{$cat->name}}</option>
                @endforeach
              </select>
            </p>

            <!-- SUBCATEGORY -->
            <div>
              <p>Subcategoría</p>
              <ul id="sub-list">
              @if($category)
                @foreach($category->sub as $sub)
                <li><label><input type="checkbox" value="{{$sub}}" name="survey-subs[]" {{in_array($sub, $request->input('survey-subs', [])) ? 'checked' : ''}}> {{$sub}}</label></li>
                @endforeach
              @endif
              </ul>
              <!-- survey-tags-->
            </div>

             <!-- TAGS -->
            <div>
              <p>Etiquetas</p>
              <ul id="tag-list">
              @if($category)
                @foreach($category->tags as $tag)
                <li><label><input type="checkbox" value="{{$tag}}" name="survey-tags[]" {{in_array($tag, $request->input('survey-tags', [])) ? 'checked' : ''}}> {{$tag}}</label></li>
                @endforeach
              @endif
              </ul>
              <!-- survey-tags-->
            </div>
            <p><input type="submit" value="Filtrar resultados"></p>
          </form>

            @foreach($surveys as $survey)
              <h2><a href="{{ url('dashboard/encuesta/'. $survey->id)}}">{{ $survey->title}}</h2>
              <a href="{{url('dashboard/encuesta/'. $survey->id) }}">
                <figure>
                  <img src="{{url('img/programas/'.(empty($survey->banner) ? "default.jpg":$survey->banner))}}">
                </figure>
              </a>
            @endforeach

            <ul id="pagination">
              @for($i = 1; $i <= $pages; $i++)
              <li><a href="{{url('dashboard/encuestas/buscar/avanzado/' . $i) . '?' . http_build_query($request->all())}}" {{$page == $i ? 'class="current"' : ''}}>{{$i}}</a></li>
              @endfor
            </ul>
          @else 
            <h2>No hay encuestas con tu criterio de búsqueda, <a href="{{url('dashboard/encuestas/buscar/avanzado')}}">inténtalo de nuevo!</a></h2>
          @endif
        </section>
      </div>      
    </article>
  </div>
</div>

<script src="{{url('js/lib/jquery.min.js')}}"></script>
<script>
  $(document).ready(function(){
    var categories = <?php echo json_encode($categories); ?>;
    
    $('.toggle').on('click', function(e){
      $("#fbp").slideToggle();
    });

    $('#survey-category').on('change', function(e){
      var value = e.currentTarget.value, 
         category = categories.filter(function(cat){
           return cat.name == value;
         })[0];

      // CLEAR LISTS
      $("#sub-list").html("");
      $("#tag-list").html("");

      if(value){
        category.sub.forEach(function(sub){
          $("#sub-list").append('<li><label><input type="checkbox" value="' + sub + '" name="survey-subs[]"> ' + sub + '</label></li>');
        });
        category.tags.forEach(function(tag){
          $("#tag-list").append('<li><label><input type="checkbox" value="' + tag + '" name="survey-tags[]"> ' + tag + '</label></li>');
        });
      }
      else{
        $("#sub-list").append("<li>Selecciona una categoría</li>");
        $("#tag-list").append("<li>Selecciona una categoría</li>");
      }

    });

  });
</script>

@endsection