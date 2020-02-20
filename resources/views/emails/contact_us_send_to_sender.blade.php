@component('mail::message')

Bonjour,

Nous vous confirmons la réception de votre message. Notre équipe vous contactera dans les meilleurs délais.

Voici une copie de votre message :

##Nom: {{$name}}

##Sujet: {{$subject}}

##Message:
{{$message}}


<br>
Cordialement,<br>
L'équipe Startup Fund

@endcomponent
