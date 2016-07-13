@extends('layouts.master')

@section('content')
<!--breadcrumb-->
<div class="row">
	<div class="col-sm-8">
	  <ol class="breadcrumb">
	    <li><a href="https://www.gob.mx"><i class="icon icon-home"></i></a></li>
	    <li><a href="{{ url('')}}">Tú Evalúas</a></li>
        <li class="active">Datos Abiertos</li>
	  </ol>
	</div>
</div>
<div class="container vertical-buffer">
	<div class="col-md-8">
		<h2>Datos Abiertos</h2>
		<hr class="red">
	</div>

  <!-- El search comienza -->
  <div class="bottom-buffer">
  <div class="col-md-8">
    <form id="fbp" name="filter-blueprints" method="get" action="{{url('datos-abiertos')}}#lista-de-resultados" class="form_search">
      <?php $category = $request->input('category') ? $categories->where("name", $request->input('category'))->first() : null; ?>
      {!! csrf_field() !!}
        <div class="panel-group ficha-collapse" id="accordion">
        <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
              <a data-parent="#accordion" data-toggle="collapse" href="#panel-01" aria-expanded="true" aria-controls="panel-01">
              Filtrar
                </a>
              </h4>
            <button type="button" class="collpase-button collapsed" data-parent="#accordion" data-toggle="collapse" href="#panel-01"></button>
          </div>
        <div class="panel-collapse collapse in" id="panel-01">
          <div class="panel-body">
              <div class="row">
                <div class="col-md-2">Busca por atención: </div>
                <div class="col-md-10">

                  <input class="form-control" name="title" placeholder="Palabra clave" type="text" value="{{$request->input('title')}}" >
                </div>
                    </div>
            <hr>
            <div class="row">
              <div class="col-md-6">
                <select name="category" id="survey-category" class="form-control">
                  <option value="">Selecciona una categoría</option>
                  @foreach($categories as $cat)
                    <option value="{{$cat->name}}" {{$category && $category->name == $cat->name ? 'selected' : ''}}>
                      {{$cat->name}}
                    </option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-3">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Subcategoría<span class="caret"></span></a>
                <ul id="sub-list" class="dropdown-menu" role="menu">
                @if($category)
                  @foreach($category->sub as $sub)
                  <li><label><input type="checkbox" value="{{$sub}}" name="survey-subs[]" {{in_array($sub, $request->input('survey-subs', [])) ? 'checked' : ''}}> {{$sub}}</label></li>
                  @endforeach
                @endif
                </ul>
              </div>
              <div class="col-md-3">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Etiquetas<span class="caret"></span></a>
                <ul id="tag-list" class="dropdown-menu" role="menu">
                @if($category)
                  @foreach($category->tags as $tag)
                  <li><label><input type="checkbox" value="{{$tag}}" name="survey-tags[]" {{in_array($tag, $request->input('survey-tags', [])) ? 'checked' : ''}}> {{$tag}}</label></li>
                  @endforeach
                @endif
                </ul>
              </div>
            </div>        
            <hr>
            <div class="bottom-buffer" id="lista-de-resultados">
                            <div class="pull-left">
                              <input type="submit" value="Filtrar resultados" class="btn btn-primary">
                </div>
            </div>
          </div>
        </div>
      </div>
        </div>
    </form>
    <hr>
  </div>
</div>
 <!-- El search termina -->
	<div class="col-md-8">
        @if ($surveys->count() > 0)
        <table class="table table-striped">
            <thead clas="thead-default">
              <tr>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Descarga</th>
              </tr>
            </thead>
			<tbody>
			@foreach($surveys as $survey)
          	<tr onclick="location='{{ url('resultado/'. $survey->id)}}'">
	          	<td>{{ $survey->title}}</td>
			  	<td>{{ $survey->category }}</td>
			  	<td>
          @if($survey->type=="results")
				  	<a href="{{url('csv/' . $survey->csv_file)}}" class="btn btn-link btn-sm">Archivo de resultados</a>
          @else
            <a href="{{url('csv/' . $survey->csv_file . '.xlsx')}}" class="btn btn-link btn-sm">XLSX</a>
            <a href="{{url('csv/' . $survey->csv_file . '.csv')}}" class="btn btn-link btn-sm">CSV</a>
          @endif
			  	</td>
          	</tr>
  		  @endforeach
          </tbody>
        </table>
  		<ul id="pagination" class="pagination">
          @for($i = 1; $i <= $pages; $i++)
          <li>
            <a href="{{url('datos-abiertos/' . $i) . '?' . http_build_query($request->all())}}" {{$page == $i ? 'class="current"' : ''}}>{{$i}}</a>
          </li>
          @endfor
        </ul>
        @else
        <p>No hay datos abiertos disponibles :(</p>
        @endif
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
      console.log(e);
      var value = e.currentTarget.value, 
         category = categories.filter(function(cat){
           return cat.name == value;
         })[0];

      // CLEAR LISTS
      $("#sub-list").html("");
      $("#tag-list").html("");

      if(value){
        category.sub.forEach(function(sub){
          $("#sub-list").append('<li><label><input type="checkbox" value="' + sub + '" name="survey-tags[]"> ' + sub + '</label></li>');
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