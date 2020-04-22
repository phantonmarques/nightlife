<?php

    namespace App\Http\Middleware;

    use Closure;
    use App\Models\Site\User;

    class CheckUserToken
    {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle($request, Closure $next)
        {
            $token = $request->header('Authorization');

            if ($token) {
                $token = str_replace('Bearer ', '', $token);
                $user = User::where('remember_token', $token)->first();
                if ($user) {
                    auth()->login($user);
                } else {
                    return response()->json([
                        'message' => 'Token inválido',
                        'status' => false
                    ]);
                }
            } else {
                return response()->json([
                    'message' => 'Token não encontrado',
                    'status' => false
                ]);
            }

            return $next($request);
        }
    }
