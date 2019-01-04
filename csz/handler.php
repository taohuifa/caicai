<?php

require_once "tsk/Skill.php";
require_once "tsk/SkillRsp.php";

define("GAMESTATE_CSZ_PLAY", 1);    // 问答

// 题库
$csz_problem = array(
    array(
        "problem" => "你觉得你帅吗 ",
        "selectItems" => array(
            "帅", "不帅",
        ),
        "answer" => 2,
    ),

    array(
        "problem" => "你觉得你丑吗 ",
        "selectItems" => array(
            "丑", "很丑", "灰常丑",
        ),
        "answer" => 3,
    ),
    array(
        "problem" => "信春哥就选1",
        "selectItems" => array(
            "1", "2", "3",
        ),
        "answer" => 1,
    ),
    array(
        "problem" => "随意选就好了",
        "selectItems" => array(
            "1", "2", "3",
        ),
        "answer" => 3,
    ),
);

// 下个问题
function csz_next_problem($body, $request_type, $cache, $problem_index)
{
    global $config;
    global $csz_problem;
    $dkconfig = $config['dkconfig'];
    // 随机问题
    $problem = $csz_problem[$problem_index - 1];
    if ($problem == null) {
        log_error("no find problem by index! index=" . $problem_index . '/' . count($csz_problem));
        return build_skill_failed_response($dkconfig, "error", true);
    }
    $cache->csz_problem_index = $problem_index;
    log_debug("csz_next_problem index: " . $problem_index . '/' . count($csz_problem));
      
    // 生成问题
    $text = $problem["problem"];
    for ($i = 0; $i < count($problem["selectItems"]); $i++) {
        $text = $text . " 选项" . ($i + 1) . " " . $problem["selectItems"][$i] . "";
    }
    log_debug("csz_next_problem 1 " . $text);
      
      // 开始文档 
    $speach = array(
        "type" => "PlainText",
        // "text" => $text,
        "text" => $problem["problem"],
    );
    $outText = array(
        'title' => "",		//显示标题
        // 'description' => $text, // 显示内容
        "description" => $problem["problem"],
    );
    return build_skill_success_response($dkconfig, $speach, $outText, false);
}

// 猜数字游戏接口
function request_game_hander_csz($body, $request_type, $cache)
{
    log_debug("request_game_hander_csz");
    global $config;
    global $csz_problem;
    $dkconfig = $config['dkconfig'];
    
    // 检测游戏状态
    if ($cache->state == STATE_START) {
        $cache->state = STATE_PLAYING;
        $cache->gameState = GAMESTATE_CSZ_PLAY;
        
        // 开始第一题
        $r = 1 + rand(0, count($csz_problem) - 1);
        return csz_next_problem($body, $request_type, $cache, $r);
    } else if ($cache->state == STATE_PLAYING) {
    
        // 提取问题
        if ($cache->csz_problem_index <= 0) {
            // 下一题
            $r = 1 + rand(0, count($csz_problem) - 1);
            return csz_next_problem($body, $request_type, $cache, $r);
        }
        
        // 提取问题
        $problem = $csz_problem[$cache->csz_problem_index - 1];
        if (!isset($problem)) {
            log_error("no find problem by index! index=" . $cache->csz_problem_index - 1);
            return build_skill_failed_response($dkconfig, "error", true);
        }
        // 遍历检测答案
        $selectIndex = 0;
        foreach ($problem["selectItems"] as $key => $value) {
            log_debug("check[" . $key . "] :" . $body->request->queryText . " -> " . $value);
            if ($body->request->queryText == $value) {
                $selectIndex = $key + 1;
                break;
            }
        }
        
        // 检测回答
        if ($selectIndex <= 0) {
            // 不在选项中
            return build_skill_failed_response($dkconfig, "skillIdInvalid", false);
        }
        log_debug("select index: " . $selectIndex);
        
        // 检测答案
        if ($problem["answer"] != $selectIndex) {
            $cache->state = STATE_EXIT;
            // 回答错误 
            $speach = array(
                "type" => "PlainText",
                "text" => "回答错误, 垃圾.",
            );
            $text = array(
                'title' => "",		//显示标题
                'description' => "回答错误, 垃圾. 继续下一题", // 显示内容
            );
            return build_skill_success_response($dkconfig, $speach, $text, false);
        }
        // 回答正确 
        $cache->csz_problem_index = 0;
        $cache->csz_score = $cache->csz_score + 10;
        log_debug("answer ok: " . $cache->csz_score);
        
        // 回复
        $speach = array(
            "type" => "PlainText",
            "text" => "恭喜回答正确",
        );
        $text = array(
            'title' => "",		//显示标题
            'description' => "恭喜回答正确, 当前分数:" . $cache->csz_score . ", 继续下一题.", // 显示内容
        );
        return build_skill_success_response($dkconfig, $speach, $text, false);
    }

    // 错误返回
    return build_skill_failed_response($dkconfig, "error", true);
}


?>