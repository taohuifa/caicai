<?php


class DtLanguage
{
    const GameStart_Voice = "开始猜题, 答对一题获得一个贴纸, 打错不能获得贴纸, 明白请继续. ";
    const GameStart_Text = "开始猜题, 答对一题获得一个贴纸, 打错不能获得贴纸, 明白请继续. ";

    const GameNoTip_Voice = "所有提示都用完了 ";
    
    // 检测是否是提示意图
    public static function checkNeedTipInput($request)
    {
        $itemTexts = array(
            "给点提示",
            "提示",
            "不知道",
        );
        $index = Language::checkInputByTexts($request->queryText, $itemTexts);
        if ($index >= 0) {
            return true;
        }
        return false;
    }
    
    
    
    // 检测是否打开贴纸提示意图
    public static function checkOpenTieZhiInput($request)
    {
        // 判断是否带意图
        if ($request->type == "IntentRequest") {
            if ($request->intent->name == "tips") {
                return true;
            }
        }

        $itemTexts = array(
            "打开贴纸",
            "打开我的贴纸",
            "打开帖子",
        );
        $index = Language::checkInputByTexts($request->queryText, $itemTexts);
        if ($index >= 0) {
            return true;
        }
        return false;
    }
    
    // 检测是否继续意图
    public static function checkJiXuInput($request)
    {
        $itemTexts = array(
            "继续",
            "刷新",
            "再说一遍",
        );
        $index = Language::checkInputByTexts($request->queryText, $itemTexts);
        if ($index >= 0) {
            return true;
        }
        return false;
    }
};






?>