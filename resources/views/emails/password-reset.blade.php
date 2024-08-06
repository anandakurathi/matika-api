@component('mail::message')
    ### Hi {{$user->name}},

    @lang('email.password.reset.subcopy')

    **@lang('email.password.disclaimer')**
@endcomponent
