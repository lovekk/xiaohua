<?php
// 全局中间件定义文件
return [
    // 全局请求缓存
    // \think\middleware\CheckRequestCache::class,
    // 多语言加载
    // \think\middleware\LoadLangPack::class,
    // Session初始化
     \think\middleware\SessionInit::class,
    // 全局缓存
    // \think\middleware\CheckRequestCache,

    //登录权限
    //前端
    //app\index\middleware\UserLogin::class,
    //app\xiaohua\middleware\AdminLogin::class,
];
