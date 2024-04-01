 @extends('layouts.app')

 @section('title', 'Videos Publiques Par Categorie')

 @section('head')
     <link rel="stylesheet" href="{{secure_asset('css/videos-publiques.css') }}">
     <link rel="stylesheet" href="{{ secure_asset('css/form.css') }}">
 @endsection

 @section('content')
     <h1 class="text-center titre-public">Vidéos publiques sélectionnée par categorie : <span
             class="font-weight-bold font-italic">{{ $category }}</span></h1>
     <div class="main-container  container mt-4 mb-4 ">
         <a href="{{ url('allvideos-publiques') }}" class="btn btn-light mb-4 font-weight-bold">&larr; Revenir</a>

         <div class="container-videos">
             @if ($videosByCategory->isEmpty())

                 <div class="container mt-5 form-inscrire">
                     <div class="row">
                         <div class="col-md-6 mx-auto" style="margin-top:40px;">
                             <div class="card">
                                 <div class="card-body">
                                     <h5 class="card-title">Il n'y a pas encore de vidéos pour cette catégorie.</h5>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             @else
                 @foreach ($videosByCategory as $video)
                     <div class="video-item">
                         <div class="video-wrapper">
                             <video controls>
                                 <source src="{{ $video->lien_aws }}" type="video/mp4">
                                 Votre navigateur ne supporte pas la vidéo.
                             </video>
                         </div>

                         @if ($video->entraineur && $video->entraineur->user)
                             <h5 class="font-weight-bold video-info">
                                 <img src="{{ $video->entraineur->user->lien_aws_photo_compte ?? secure_asset('images/profil.jpeg') }}"
                                     alt="Avatar Entraineur" title="Profil"
                                     style="height: 30px; width: 30px; border-radius: 50%;">
                                 {{ $video->entraineur->user->prenom }} {{ $video->entraineur->user->nom }}
                             </h5>
                         @else
                             <p>Entraîneur non disponible</p>
                         @endif
                         <h6 class="font-weight-bold video-info">
                             <img src="{{secure_asset('images/athletics.png') }}" class="logo"
                                 style="height: 25px; width: 25px;">
                             {{ $video->entraineur->categories_d_entraineur }}
                         </h6>
                         <h6 class="font-weight-bold font-italic video-info">{{ $video->titre }}</h6>
                         <p class="text-break">{{ Str::limit($video->description, 70) }}</p>
                         <a href="{{ route('detail-video', ['video_id' => $video->id]) }}" title="Lire la suite">Lire la
                             suite</a>
                     </div>
                 @endforeach
             @endif
         </div>
     </div>
 @endsection
