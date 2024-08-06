@component('mail::message')
    <h3>Hi User,</h3>
    <h1>We have received your request to reset your account password</h1>
    <p>You can use the following code to recover your account:</p>
    @lang('email.password.code.subcopy')

    @component('mail::panel')
        CODE: {{ $data->code }}
    @endcomponent

    **@lang('email.password.disclaimer')**
@endcomponent
