@component('mail::message')


##Name: {{$name}}

##Email: {{$email}}

##Subject: {{$subject}}

## Message:
{{$message}}


##Check Mark
@if(!empty($project_owner)) {{$project_owner}}, @endif @if(!empty($project_backer)) {{$project_backer}}, @endif @if(!empty($other)) {{$other}}, @endif


<br>
Cordialement,<br>
L'équipe Startup Fund
@endcomponent
