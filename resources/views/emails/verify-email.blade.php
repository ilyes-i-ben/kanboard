@extends('layouts.email')

@section('content')
    <h1 style="text-align: center; margin-bottom: 24px;">Vérifiez votre adresse email</h1>

    <p>Salut {{ $name }},</p>

    <p>Merci de vous être inscrit sur Kanboard ! Avant de commencer, il ne vous reste plus qu’à confirmer votre adresse email.</p>

    <div style="text-align: center; margin: 32px 0;">
        <a href="{{ $url }}" class="btn">Vérifier mon adresse</a>
    </div>

    <p>Si vous n’êtes pas à l’origine de cette inscription, vous pouvez ignorer ce message.</p>

    <p>À très vite,<br>L’équipe Kanboard</p>
@endsection
