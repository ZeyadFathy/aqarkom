<div class="{{$viewClass['form-group']}} {!! !$errors->has($errorKey) ? '' : 'has-error' !!}">

    <label for="{{$id['lat']}}" class="{{$viewClass['label']}} control-label">{{$label}}</label>

    <div class="{{$viewClass['field']}}">

        @include('admin::form.error')

        <div id="map_{{$id['lat'].$id['lng']}}" style="width: 100%;height: 300px"></div>
        <input type="hidden" id="{{$id['lat']}}" name="{{$name['lat']}}" value="{{ 42.92461881414056,23.906945007456475 }}" {!! $attributes !!} />
        <input type="hidden" id="{{$id['lng']}}" name="{{$name['lng']}}" value="{{ 42.92461881414056,23.906945007456475 }}" {!! $attributes !!} />

       
        @include('admin::form.help-block')

    </div>
</div>
