<?php
declare (strict_types = 1);

namespace app\xiaohua\middleware;

class AdminLogin{
    /**
     * 处理请求
     *
     * @param \think\Request $request
     * @param \Closure       $next
     * @return Response
     */
    public function handle($request, \Closure $next){
        // 判断是否赋值
        session('?admin_name');
        // 取值
        $user = session('admin_name');
        $isLogin = (!preg_match('/admin_login/', $request -> pathinfo()));

        if(!session('?admin_name') && $isLogin){
            //halt($user); //null
            return redirect('admin_login');
        }

        //要让请求继续传递到应用程序中，
        //只需使用 $request 作为参数去调用回调函数 $next
        return $next($request);
    }
}
