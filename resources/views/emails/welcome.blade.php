@extends('layouts.email')

@section('content')
    <h1 style="text-align: center; margin-bottom: 24px;">Bienvenue sur Kanboard !</h1>

    <p>Salut {{ $name }},</p>

    <p>On est super contents de vous compter parmi nous sur Kanboard, votre nouvel espace pour organiser vos projets en toute simplicité et en équipe.</p>

    <div style="text-align: center; margin: 32px 0;">
        <a href="{{ url('/boards') }}" class="btn">Découvrir mon espace</a>
    </div>

    <div class="card">
        <h3>Pour bien démarrer :</h3>
        <ul>
            <li>Créez votre premier tableau</li>
            <li>Invitez vos collègues à rejoindre l’aventure</li>
            <li>Ajoutez vos premières listes et cartes</li>
            <li>Organisez vos tâches selon vos priorités</li>
        </ul>
    </div>

    <p>Kanboard vous aide à suivre facilement l’avancement de vos projets, fixer des priorités et des échéances, tout en facilitant la collaboration avec votre équipe.</p>

    <p>On vous souhaite une belle expérience sur la plateforme !</p>

    <p>À très vite,<br>L’équipe Kanboard</p>
@endsection
