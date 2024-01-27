@component('mail::message')

Admins[team leader] has invited you to collaborate on this team project. 
you can see your team members by click View invitation
{{-- You are invite to join our team. please click the link below to join our team. --}}

@component('mail::button',['url' => 'http://127.0.0.1:8000/home'])
   View invitation 
@endcomponent

@endcomponent