<?php
require_once dirname(__FILE__) . '/' . "Const.php";

// 语言
class Language
{
    const GameStart_Voice = "请问想玩什么游戏?  ";
    const GameStart_Text = "请问想玩什么游戏?  ";

    const GameExit_Voice = "再见少年，我已拉黑你了。";
    const GameExit_Text = "再见少年，什么人啊。";

    const GameUnknow_Voice = "对不起, 我不是很理解你说什么. ";
    const GameUnknow_Text = "对不起, 我不是很理解你说什么. ";

    const AppError_Voice = "服务器打了个盹, 不好意思. ";
    const AppError_Text = "服务器打了个盹, 不好意思. ";
    
    // 创建游戏选择文本
    public static function createGameSelectText($selectTexts, $selectItemFormat = "第%d个是%s")
    {
        if (empty($selectTexts)) {
            return "";
        }
        log_debug("select list:" . json_encode($selectTexts));
        // 遍历选项列表
        $text = "";
        for ($i = 0; $i < count($selectTexts); $i++) {
            $selectText = $selectTexts[$i];
            log_debug("select list:" . $i . " " . $selectText);
            // 格式化拼接
            $str = sprintf($selectItemFormat, ($i + 1), $selectText);
            $text = $text . $str;
        }
        return $text;
    }               
    
    // 获取游戏列表文本
    public static function getGameListText()
    {
        $text = self::createGameSelectText(GameConst::$GAMETYPE_NAMES);
        log_info("getGameListText: " . $text);
        return $text;
    }
    
    // 检测选择题, 返回选项[0~N], -1为无
    public static function checkSelectInput($request, $count)
    {
        $noNames = array("一", "二", "三", "四", "五", "六", "七");
        // 遍历选项
        for ($i = 0; $i < $count; $i++) {
            $itemTexts = array(
                "第" . ($i + 1) . "个",
                "" . ($i + 1),
                "选" . ($i + 1),
                "第" . $noNames[$i] . "个", $noNames[$i],
                "选" . $noNames[$i],
            );

            log_debug("check select input: " . $i . " " . $request->queryText . " -> " . json_encode($itemTexts));
            $index = self::checkInputByTexts($request->queryText, $itemTexts);
            if ($index >= 0) {
                log_debug("is select input: " . $i . " -> " . $index);
                return $i;
            }
        }
        return -1;
    }
    
    // 检测退出意图
    public static function checkExitInput($request)
    {
        $exitTexts = array("不玩了", "退出", "不想玩了");
        return self::checkInputByTexts($request->queryText, $exitTexts) >= 0;
    }
    
    // 遍历检测是否符合文本列表, 返回索引[0~N], -1为失败
    public static function checkInputByTexts($text, $texts)
    {
        foreach ($texts as $key => $value) {
            log_debug("check input: " . $key . " " . $text . " -> " . json_encode($value));
            if ($text == $value) {
                return $key;
            }
        }
        return -1;
    }
}
?>
