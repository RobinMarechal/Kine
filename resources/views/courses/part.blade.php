<div class="col-lg-6">
	<div class="course-block row" data-id="{{ $course->id }}">

		@if($course->hasClient(Auth::user()))
			<div class="top-left course-is-followed" title="Vous êtes inscrits à ce cours">
				<i class="fa fa-graduation-cap" aria-hidden="true"></i>
			</div>
		@endif

		<h4 align="center" class="course-block-title no-margin-top">
			<a href="{{ url('courses/' . $course->id) }}">{{ $course->name }}</a>
		</h4>
		<div class="col-xs-3 course-block-img-container no-padding">
			<img class="course-block-img" src="https://sandrine-guerin-masseur-kinesitherapeute
			.fr/sites/S_O4DQXOZIVRHIDK4BHRT3JBWNYI/files/12/recherche-kinesitherapeute-collaborateurtrice-95200_1
			.jpg">
		</div>
		<div class="col-xs-9 course-block-description">
			<p class="text-justify">
				Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores dignissimos ipsum laudantium, maiores nobis
			</p>

			<div class="course-infos">
				<div class="course-clients">
					<span class="course-clients">
						<i class="fa fa-users" aria-hidden="true" title="Inscrits au cours"></i>
						{{ $course->clients->count() }}
					</span>
				</div>

				<div class="course-doctors">
					<span class="course-doctors">
						<i class="fa fa-user-md" aria-hidden="true" title="Kinés responsables du cours"></i>

						@if($course->doctors->count() > 0)
							<span class="course-doctors--doctor">
									{{ $course->doctors[0]->name }}
							</span>
							@for($i = 0; $i < $course->doctors->count(); $i++)
								<span class="course-doctors--doctor">
									{{ ', ' . $course->doctors[$i]->name }}
								</span>
							@endfor
						@else
							{{ $course->creator ? $course->creator->name : '' }}
						@endif
					</span>
				</div>
				<div class="tags-block">
					@if($course->tags->count() > 0)
						<i class="fa fa-tags" aria-hidden="true" title="Tags"></i>
						@foreach($course->tags as $tag)
							<a href="{{url('articles/tag/'.$tag->name)}}" class="tag" title="Cliquez pour voir tous les articles possédant ce tag">{{$tag->name}}</a>
						@endforeach
						@foreach($course->tags as $tag)
						<a href="{{url('articles/tag/'.$tag->name)}}" class="tag" title="Cliquez pour voir tous les articles possédant ce tag">{{$tag->name}}</a>
						@endforeach
						@foreach($course->tags as $tag)
						<a href="{{url('articles/tag/'.$tag->name)}}" class="tag" title="Cliquez pour voir tous les articles possédant ce tag">{{$tag->name}}</a>
						@endforeach
						@foreach($course->tags as $tag)
						<a href="{{url('articles/tag/'.$tag->name)}}" class="tag" title="Cliquez pour voir tous les articles possédant ce tag">{{$tag->name}}</a>
						@endforeach
						@foreach($course->tags as $tag)
						<a href="{{url('articles/tag/'.$tag->name)}}" class="tag" title="Cliquez pour voir tous les articles possédant ce tag">{{$tag->name}}</a>
						@endforeach
						{{--@foreach($course->tags as $tag)--}}
						{{--<a href="{{url('articles/tag/'.$tag->name)}}" class="tag" title="Cliquez pour voir tous les articles possédant ce tag">{{$tag->name}}</a>--}}
						{{--@endforeach--}}
						{{--@foreach($course->tags as $tag)--}}
						{{--<a href="{{url('articles/tag/'.$tag->name)}}" class="tag" title="Cliquez pour voir tous les articles possédant ce tag">{{$tag->name}}</a>--}}
						{{--@endforeach--}}
						{{--@foreach($course->tags as $tag)--}}
						{{--<a href="{{url('articles/tag/'.$tag->name)}}" class="tag" title="Cliquez pour voir tous les articles possédant ce tag">{{$tag->name}}</a>--}}
						{{--@endforeach--}}
						{{--@foreach($course->tags as $tag)--}}
						{{--<a href="{{url('articles/tag/'.$tag->name)}}" class="tag" title="Cliquez pour voir tous les articles possédant ce tag">{{$tag->name}}</a>--}}
						{{--@endforeach--}}
						{{--@foreach($course->tags as $tag)--}}
						{{--<a href="{{url('articles/tag/'.$tag->name)}}" class="tag" title="Cliquez pour voir tous les articles possédant ce tag">{{$tag->name}}</a>--}}
						{{--@endforeach--}}
						{{--@foreach($course->tags as $tag)--}}
						{{--<a href="{{url('articles/tag/'.$tag->name)}}" class="tag" title="Cliquez pour voir tous les articles possédant ce tag">{{$tag->name}}</a>--}}
						{{--@endforeach--}}
						{{--@foreach($course->tags as $tag)--}}
						{{--<a href="{{url('articles/tag/'.$tag->name)}}" class="tag" title="Cliquez pour voir tous les articles possédant ce tag">{{$tag->name}}</a>--}}
						{{--@endforeach--}}
						{{--@foreach($course->tags as $tag)--}}
						{{--<a href="{{url('articles/tag/'.$tag->name)}}" class="tag" title="Cliquez pour voir tous les articles possédant ce tag">{{$tag->name}}</a>--}}
						{{--@endforeach--}}
						{{--@foreach($course->tags as $tag)--}}
						{{--<a href="{{url('articles/tag/'.$tag->name)}}" class="tag" title="Cliquez pour voir tous les articles possédant ce tag">{{$tag->name}}</a>--}}
						{{--@endforeach--}}
					@endif
				</div>
			</div>
		</div>
	</div>
</div>