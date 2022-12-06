<?php

namespace App\Http\Controllers;

use Artisan;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;

class UtilController extends Controller
{
    public function deploy(Request $request)
    {
        $githubPayload = $request->getContent();
        $githubHash    = $request->header('X-Hub-Signature');

        $localToken = config('app.deploy_secret');
        $localHash  = 'sha1=' . hash_hmac('sha1', $githubPayload, $localToken, false);

        if (hash_equals($githubHash, $localHash)) {
            $root_path = base_path();
            $process   = new Process('cd ' . $root_path . '; ./deploy.sh');
            $process->run(function ($type, $buffer) {
                echo $buffer;
            });
        }
    }
    public function clearCache(Request $request)
    {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        Artisan::call('lada-cache:flush');
        Artisan::call('telescope:prune --hours=0');
        echo "Cache is cleared";
    }
}
