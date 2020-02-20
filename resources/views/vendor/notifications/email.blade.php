@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('app.whoops')
@else
{{--# <div class="mail-hello"></div>@lang('app.hello')--}}
@endif
@endif
<div class="mail-body">

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{!! $line !!}

@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
    switch ($level) {
        case 'success':
        case 'error':
            $color = $level;
            break;
        default:
            $color = 'primary';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{!! $line !!}

@endforeach

</div>
<br/>
{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
@lang('app.regards'),<br>L'équipe {{ config('app.name') }}
@endif

{{-- Subcopy --}}
@isset($actionText)
@component('mail::subcopy')
@lang(
    "app.mail_trouble_clicking",
    [
        'actionText' => $actionText,
        'actionURL' => $actionUrl,
    ]
)
@endcomponent
@endisset
@endcomponent
