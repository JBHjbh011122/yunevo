@extends('layouts.app')

@section('title', 'responsabilite')

@section('head')
    <link rel="stylesheet" href="{{secure_asset('css/responsabilite.css') }}">
@endsection

@section('content')
    <div class="container-responsabilite">
        <h1>Responsabilité</h1>
        <section>
            <h2>Nature du Projet</h2>
            <p>Ce projet est un travail académique et a été créé exclusivement à des fins éducatives et de recherche. Il
                n'est pas destiné à une utilisation commerciale, à une diffusion publique ou à toute autre utilisation en
                dehors d'un contexte éducatif.</p>
        </section>
        <section>
            <h2>Garantie</h2>
            <p>L'auteur du projet ne fournit aucune garantie quant à l'exactitude, la fiabilité ou la pertinence des
                informations contenues dans le projet.</p>
        </section>
        <section>
            <h2>Droits</h2>
            <p>Toutes les informations et matériaux sont fournis "en l'état" sans aucune garantie. Toute utilisation des
                matériaux de ce projet sans autorisation appropriée ou en dehors d'un contexte éducatif peut enfreindre les
                droits d'auteur, les marques déposées ou d'autres lois applicables.</p>
        </section>
    </div>
@endsection
