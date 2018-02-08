<?php $jsVars = Helpers\JsVar::getVars() ?>
@if(!empty($jsVars))
    <div id="js-vars-relayer">
        @foreach($jsVars as $var)
            <span hidden data-var-name="{{ $var->getName() }}"> {{ $var->getJson() }} </span>
        @endforeach
    </div>
@endif

<script src="{{ url('/js/app.js') }}"></script>