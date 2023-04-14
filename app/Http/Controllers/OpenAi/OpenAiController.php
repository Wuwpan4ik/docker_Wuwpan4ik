<?php

namespace App\Http\Controllers\OpenAi;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\Request;
use Orhanerday\OpenAi\OpenAi;

class OpenAiController extends Controller
{

    public function send__message(Request $request)
    {
        $message = new Message;
        $message->message = $request->message;
        $message->chat_id = $request->chat_id;
        $message->save();

        return response()->json($message->id);
    }

    public function event__stream()
    {

        $open_ai_key = "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";
        $open_ai = new OpenAi($open_ai_key);

            $results = Message::where('chat_id', 1)->orderByDesc('id')->take(2)->get()->sortBy("id");
        if (empty($results)) {
            $history[] = array("role" => "system", "content" => "You are a helpful assistant.");
        }

        foreach ($results as $result) {
            if ($result->is_bot) $history[] = ["role" => 'assistant', "content" => $result->message];
            if (!$result->is_bot) $history[] = ["role" => 'user', "content" => $result->message];
        }

        $opts = [
            'model' => 'gpt-3.5-turbo',
            'temperature' => 1.0,
            'max_tokens' => 500,
            'frequency_penalty' => 0,
            'presence_penalty' => 0
        ];
        $opts['messages'] = $history;
        Debugbar::log($history);

        $chat = $open_ai->chat($opts);
        $d = json_decode($chat);
        $message = new Message;
        $message->message = $d->choices[0]->message->content;
        $message->chat_id = 1;
        $message->is_bot = true;
        $message->save();
        Debugbar::log($d);
        echo $d->choices[0]->message->content;
    }
}
