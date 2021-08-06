@component('mail::message')
<h1>Seja bem vindo!!!</h1>

<p>Obrigado, por se interessar no bolo {{ $cake->cake_name }}</p>
<p>Para saber mais sobre o bolo, clique no botão abaixo:</p>

@component('mail::button', ['url' => 'http://127.0.0.1:8000/api/cake/' . $cake->cake_id])
    Mais informações
@endcomponent

<p>Atenciosamente.</p>
<p>João Victor.</p>
@endcomponent