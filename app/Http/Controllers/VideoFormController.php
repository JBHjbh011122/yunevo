<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Video;
use Aws\S3\S3Client;

class VideoFormController extends Controller
{

    public function generatePresignedUrl(Request $request)
    {
        $request->validate([
            'filename' => 'required|string',
            'filetype' => 'required|string',
        ]);

        // 直接创建一个S3客户端实例
        $s3Client = new S3Client([
            'version' => 'latest',
            'region'  => env('AWS_DEFAULT_REGION'),
            'credentials' => [
                'key'    => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);

        $bucket = env('AWS_BUCKET');
        $cmd = $s3Client->getCommand('PutObject', [
            'Bucket' => $bucket,
            'Key'    => 'videos/' . $request->filename,
            'ContentType' => $request->filetype,
        ]);

        // 设置URL的过期时间
        $request = $s3Client->createPresignedRequest($cmd, '+20 minutes');

        $presignedUrl = (string) $request->getUri();

        return response()->json(['url' => $presignedUrl]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:50',
            'video_type' => 'required|in:Publique,Privee',
            'description' => 'required',
            's3_file_path' => 'required|string',
        ]);

        $user = Auth::user();
        if (!$user) {
            return redirect('login')->with('error', 'Vous devez être connecté pour ajouter une vidéo.');
        }

        $entraineur = $user->entraineur;
        if (!$entraineur) {
            return redirect()->back()->with('error', 'Utilisateur non associé à un entraineur.');
        }

        $video = new Video([
            'entraineur_id' => $entraineur->id,
            'est_public' => $request->video_type === 'Publique' ? 1 : 0,
            'description' => $request->description,
            'lien_aws' => $request->s3_file_path,
            'date_de_prise' => now(),
            'titre' => $request->titre,
            'date_publication' => now(),
        ]);
        $video->save();

        return redirect('/compte-entraineur')->with('success', 'La vidéo a été ajoutée avec succès.');
    }

    public function update(Request $request, $video_id)
    {
        $request->validate([
            'titre' => 'required|string|max:50',
            'video_type' => 'required|in:Publique,Privee',
            'description' => 'required',
            's3_file_path' => 'nullable|string', // 接收S3文件路径
        ]);

        $user = Auth::user();
        if (!$user) {
            return redirect('login')->with('error', 'Vous devez être connecté pour modifier une vidéo.');
        }

        $entraineur = $user->entraineur;
        if (!$entraineur) {
            return redirect()->back()->with('error', 'Utilisateur non associé à un entraineur.');
        }

        $video = Video::findOrFail($video_id);
        $video->titre = $request->titre;
        $video->est_public = $request->video_type === 'Publique' ? 1 : 0;
        $video->description = $request->description;

        // 检查是否有新视频文件路径
        if ($request->filled('s3_file_path')) {
            $video->lien_aws = $request->s3_file_path;
        }

        $video->save();

        return redirect('/compte-entraineur')->with('success', 'La vidéo a été modifiée avec succès.');
    }
}
