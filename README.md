# add-component-vue-as-shortcode-with-blade
Add component vue as shortcode of wordpress in Laravel

# Definimos la ruta

Editamos el fichero routes/web.php y añadimos la siguiente ruta

```php
<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::resource('/posts', 'PostController', ['only' => ['index', 'show']]);
```

# Definimos el controlador

app/Http/Controllers/PostController.php

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller {
	
	public function index(Request $request) {
	
		$posts = Post::paginate(10);
		
		return view('posts.index', compact('posts'));
		
	}
		
	public function show(Request $request, $slug) {
		
		$post = Post::where('slug', '=', $slug)->first();
		if (!is_null($post)) {		
			
			//<!--//<example-component name="example"></example-component>//--> 
			$post->body = str_replace("&lt;","<",str_replace("&gt;",">",preg_replace('/&lt;!--\\/\\/(.*)\\/\\/--&gt;/i', '${1}', $post->body, -1)));
			
			//[example-component name="example"][/example-component]
			$post->body = preg_replace('/\[(.*?)\]/i','<${1}>', $post->body, -1);
				
			return view('posts.single', compact('post'));		
		}
		
		return abort('404');
	}
}
```

# Creamos las respectivas vistas

resources/views/posts/index.blade.php

```php
@extends('master')

@section('content')
<div class="row">
	<div class="col-md-12">
		@foreach($posts as $post)
		<h1><a href="{{ route('posts.show', ['slug' => $post->slug]) }}">{{$post->title}}</a></h1>
		<hr />
		@endforeach
	</div>
</div>
@endsection
```

resources/views/posts/single.blade.php

```php
@extends('master')

@section('content')
<div class="row">
	<div class="col-md-12">
		<h1>{{$page->title}}</h1>
		{!! $page->body !!}
	</div>
</div>
@endsection
```

A partir de ahora cada vez que se añada en el campo body de la entrada post por uno de los siguientes códidos éste será remplazado por un componente de vue.

```php
<!--//<example-component name="example"></example-component>//-->
```

or

```php
[example-component name="example"][/example-componnet]
```
en ambos caso será remplazado por

```php
<example-component name="example"></example-component>
```

![edit](https://github.com/d3turnes/storage/blob/master/shortcode/edit.png)

# Resultado

![single](https://github.com/d3turnes/storage/blob/master/shortcode/single.png)
