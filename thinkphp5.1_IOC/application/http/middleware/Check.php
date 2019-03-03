<?php

namespace app\http\middleware;

class Check
{
    public function handle($request, \Closure $next)
    {
        //获取请求中的参数
        $id = $request->param('id');
        if($id > 3){
            exit(json_encode(['code'=>1,'msg'=>'Interface_Pause_service','data'=>'']));
        }
        return $next($request);
    }
}