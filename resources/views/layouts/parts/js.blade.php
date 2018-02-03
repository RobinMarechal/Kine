<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=6dsidl73nkp1p71n04g9rr7dieh5e1whc8kp1ju40t4wzgn4"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.6.1/pikaday.min.js"></script>

@if($jsVars = Helpers\JsVar::getVars() != null && !empty($jsVars))
    <div id="js-vars-relayer">
        @foreach($jsVars as $var)
            <span hidden data-var-name="{{ $var->getName() }}"> {{ $var->getJson() }} </span>
        @endforeach
    </div>
@endif

<script src="{{ url('/js/app.js') }}"></script>